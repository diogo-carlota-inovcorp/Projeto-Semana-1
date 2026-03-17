<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Requisicao;
use App\Models\User;
use App\Notifications\NovaReviewCriadaNotification;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Requisicao $requisicao)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:2000',
        ]);

        if ($requisicao->user_id !== auth()->id()) {
            abort(403);
        }

        if ($requisicao->status !== 'entregue') {
            return back()->with('error', 'Só pode fazer review depois da devolução ser confirmada.');
        }

        if ($requisicao->review()->exists()) {
            return back()->with('error', 'Esta requisição já tem review.');
        }

        $review = \App\Models\Review::create([
            'livro_id' => $requisicao->livro_id,
            'user_id' => auth()->id(),
            'requisicao_id' => $requisicao->id,
            'rating' => $request->rating,
            'comentario' => $request->comentario,
            'estado' => 'suspenso',
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\NovaReviewCriadaNotification($review));
        }

        return redirect()
            ->route('requisicoes.minhas')
            ->with('success', 'Review submetida com sucesso e aguarda moderação.');
    }
}
