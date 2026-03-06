<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Requisicao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\RequisicaoConfirmadaNotification;
use App\Notifications\AdminNovaRequisicaoNotification;

class RequisicaoController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $livros = Livro::query()
            ->when($q, fn($query) =>
            $query->where('nome', 'like', "%{$q}%")
                ->orWhere('isbn', 'like', "%{$q}%")
            )
            ->withCount([
                'requisicoes as requisicoes_ativas_count' => fn($qq) =>
                $qq->whereIn('status', ['pendente', 'ativa', 'por_confirmar'])
            ])
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        $ativas = Requisicao::whereIn('status', ['pendente', 'ativa'])->count();
        $ultimos30 = Requisicao::where('requisitado_em', '>=', now()->subDays(30))->count();
        $entreguesHoje = Requisicao::whereDate('updated_at', now()->toDateString())
            ->where('status', 'entregue')
            ->count();

        $porConfirmar = collect();

        if ((auth()->user()->role ?? null) === 'admin') {
            $porConfirmar = Requisicao::with(['livro', 'user'])
                ->where('status', 'por_confirmar')
                ->latest('updated_at')
                ->get();
        }

        return view('requisicoes.index', compact(
            'livros',
            'q',
            'ativas',
            'ultimos30',
            'entreguesHoje',
            'porConfirmar'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'livro_id' => ['required', 'integer', 'exists:livros,id'],
        ]);

        $user = auth()->user();
        $livroId = (int) $validated['livro_id'];

        $ativasUser = Requisicao::where('user_id', $user->id)
            ->whereIn('status', ['pendente', 'ativa', 'por_confirmar'])
            ->count();

        if ($ativasUser >= 3) {
            return back()->with('error', 'Só podes ter 3 livros requisitados em simultâneo.');
        }

        $ocupado = Requisicao::where('livro_id', $livroId)
            ->whereIn('status', ['pendente', 'ativa', 'por_confirmar'])
            ->exists();

        if ($ocupado) {
            return back()->with('error', 'Este livro já está em processo de requisição.');
        }

        $requisicao = Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $livroId,
            'fim_previsto' => now()->addDays(5),
            'status' => 'pendente',
        ]);

        $requisicao->load(['user', 'livro']);

        $user->notify(new RequisicaoConfirmadaNotification($requisicao));

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new AdminNovaRequisicaoNotification($requisicao));
        }

        return redirect()->route('requisicoes.minhas')
            ->with('success', 'Requisição criada com sucesso!');
    }


    public function show(Requisicao $requisicao)
    {
        $requisicao->load(['user', 'livro']);

        return view('requisicoes.show', compact('requisicao'));
    }

    public function userRequisicoes(User $user)
    {
        $requisicoes = $user->requisicoes()
            ->with('livro')
            ->latest()
            ->get();

        return view('admin.user_requisicoes', compact('user', 'requisicoes'));
    }

    public function minhas()
    {
        $requisicoes = auth()->user()
            ->requisicoes()
            ->with('livro')
            ->whereIn('status', ['pendente', 'ativa'])
            ->latest()
            ->get();

        return view('requisicoes.minhas', compact('requisicoes'));
    }

    public function entregar(Requisicao $requisicao)
    {
        if ($requisicao->user_id !== auth()->id()) {
            abort(403);
        }

        $requisicao->status = 'entregue';
        $requisicao->save();

        return back()->with('success', 'Livro entregue com sucesso.');
    }

    public function pedirDevolucao(Requisicao $requisicao)
    {
        if ($requisicao->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($requisicao->status, ['pendente', 'ativa'])) {
            return back()->with('error', 'Esta requisição não pode ser devolvida agora.');
        }

        $requisicao->status = 'por_confirmar';
        $requisicao->save();

        return back()->with('success', 'Pedido de devolução enviado. Aguarda confirmação do Admin.');
    }

    public function confirmarDevolucao(Requisicao $requisicao)
    {
        if ($requisicao->status !== 'por_confirmar') {
            return back()->with('error', 'Esta requisição não está por confirmar.');
        }

        $requisicao->status = 'entregue';
        $requisicao->save();

        return back()->with('success', 'Devolução confirmada. Livro disponível.');
    }
}
