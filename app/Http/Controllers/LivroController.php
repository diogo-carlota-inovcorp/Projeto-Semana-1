<?php

namespace App\Http\Controllers;

use App\Models\AlertaLivro;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    public function livro(Request $request)
    {
        $q = $request->query('q');
        $autorId = $request->query('autor');
        $editoraId = $request->query('editora');

        $livros = Livro::query()
            ->with(['editora', 'autores'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('nome', 'like', "%{$q}%")
                        ->orWhere('isbn', 'like', "%{$q}%");
                });
            })
            ->when($editoraId, fn ($query) => $query->where('editoras_id', $editoraId))
            ->when($autorId, fn ($query) =>
            $query->whereHas('autores', fn ($aq) => $aq->where('autores.id', $autorId))
            )
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $autores = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();

        return view('livros.livro', compact('livros', 'autores', 'editoras', 'q', 'autorId', 'editoraId'));
    }


        public function autor()
        {
            $autores = Autor::orderBy('nome')->get();
            return view('livros.autor', compact('autores'));
        }


    public function editora()
    {
        $editoras = Editora::orderBy('nome')->get();

        return view('livros.editora', compact('editoras'));
    }

    public function index() {
        $livros = Livro::latest()->take(3)->get();
        return view('livros.index', compact('livros'));
    }

    public function admin() {
        return view('admin.admin');
    }

    public function store(Request $request)
    {


        $data = $request->validate([
            'isbn' => 'required|string|max:20|unique:livros,isbn',
            'nome' => 'required|string|max:255',
            'editoras_id' => 'required|exists:editoras,id',
            'autor_id' => 'required|exists:autores,id',
            'bibliografia' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem_capa' => 'nullable|image|max:2048',
        ]);

        $capaPath = null;
        if ($request->hasFile('imagem_capa')) {
            $capaPath = $request->file('imagem_capa')->store('capas', 'public');
        }

        $livro = Livro::create([
            'isbn' => $data['isbn'],
            'nome' => $data['nome'],
            'editoras_id' => $data['editoras_id'],
            'bibliografia' => $data['bibliografia'] ?? null,
            'preco' => $data['preco'],
            'imagem_capa' => $capaPath,
        ]);



        $livro->autores()->sync([$data['autor_id']]);

        return back()->with('success', 'Livro adicionado!');




    }

    public function show(Livro $livro)
    {
        $livro->load([
            'autores',
            'editora',
        ]);

        $textoBase = $this->textoLivro($livro);
        $palavrasBase = $this->normalizarTexto($textoBase);

        $autorIds = $livro->autores->pluck('id')->toArray();
        $editoraId = $livro->editora?->id;

        $candidatos = Livro::with(['autores', 'editora'])
            ->where('id', '!=', $livro->id)
            ->get();

        $relacionados = $candidatos->map(function ($candidato) use ($palavrasBase, $autorIds, $editoraId) {
            $textoCandidato = $this->textoLivro($candidato);
            $palavrasCandidatas = $this->normalizarTexto($textoCandidato);

            $scorenome = $this->calcularSimilaridade($palavrasBase, $palavrasCandidatas);
            $scoreAutor = $candidato->autores->pluck('id')->intersect($autorIds)->count() > 0 ? 20 : 0;
            $scoreEditora = ($editoraId && $candidato->editora?->id === $editoraId) ? 10 : 0;

            $candidato->score_relacao = $scorenome + $scoreAutor + $scoreEditora;

            return $candidato;
        })
            ->sortByDesc('score_relacao')
            ->take(4)
            ->values();

        if ($relacionados->every(fn ($item) => $item->score_relacao == 0)) {
            $relacionados = Livro::with(['autores', 'editora'])
                ->where('id', '!=', $livro->id)
                ->latest()
                ->take(4)
                ->get();
        }

        $reviewsAtivas = $livro->reviews()
            ->with('user')
            ->where('estado', 'ativo')
            ->latest()
            ->take(3)
            ->get();

        $mediaReviews = $livro->reviews()
            ->where('estado', 'ativo')
            ->avg('rating');

        $totalReviews = $livro->reviews()
            ->where('estado', 'ativo')
            ->count();

        return view('livros.show', compact(
            'livro',
            'relacionados',
            'reviewsAtivas',
            'mediaReviews',
            'totalReviews'
        ));
    }
    public function destroy(Livro $livro)
    {

        if ($livro->imagem_capa) {
            \Storage::delete($livro->imagem_capa);
        }

        $livro->delete();

        return redirect()
            ->route('livros.livro')
            ->with('success', 'Livro apagado com sucesso.');
    }

    public function update(Request $request, Livro $livro)
    {




        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'isbn' => 'required|string|max:50',
            'bibliografia' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem_capa' => 'nullable|image|max:2048', // max 2MB
        ]);


        if ($request->hasFile('imagem_capa')) {


            if ($livro->imagem_capa && Storage::exists($livro->imagem_capa)) {
                Storage::delete($livro->imagem_capa);
            }


            $validated['imagem_capa'] = $request
                ->file('imagem_capa')
                ->store('capas', 'public');
        }


        $livro->update($validated);


        return redirect()
            ->route('livros.show', $livro->id)
            ->with('success', 'Livro atualizado com sucesso!');
    }


    public function editar(Livro $livro)
    {
        ;

        $autores  = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();


        $livro->load('autores', 'editora');

        return view('admin.editar_livro', compact('livro', 'autores', 'editoras'));
    }
    public function editarEditora($id)
    {
        $editora = Editora::findOrFail($id);
        return view('admin.editar_editora', compact('editora'));
    }

    public function updateEditora(Request $request, $id)
    {
        $editora = Editora::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $dados = [
            'nome' => $request->nome,
        ];

        if ($request->hasFile('logo')) {
            $dados['logo'] = $request->file('logo')->store('editoras', 'public');
        }

        $editora->update($dados);

        return redirect()->route('livros.editora')->with('success', 'Editora atualizada com sucesso.');
    }

    public function editarAutor($id)
    {
        $autor = Autor::findOrFail($id);
        return view('admin.editar_autor', compact('autor'));
    }

    public function updateAutor(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $dados = [
            'nome' => $request->nome,
        ];

        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')->store('autores', 'public');
        }

        $autor->update($dados);

        return redirect()->route('livros.autor')->with('success', 'Autor atualizado com sucesso.');
    }

    private function textoLivro($livro): string
    {
        return trim($livro->nome ?? '');
    }

    private function normalizarTexto(?string $texto): array
    {
        $texto = mb_strtolower($texto ?? '');
        $texto = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $texto);
        $texto = preg_replace('/\s+/', ' ', trim($texto));

        $stopWords = [
            'a', 'o', 'e', 'de', 'do', 'da', 'dos', 'das', 'um', 'uma',
            'uns', 'umas', 'em', 'no', 'na', 'nos', 'nas', 'por', 'para',
            'com', 'sem', 'sobre', 'que', 'se', 'ao', 'à', 'às', 'os', 'as'
        ];

        $palavras = explode(' ', $texto);

        $palavras = array_filter($palavras, function ($palavra) use ($stopWords) {
            return mb_strlen($palavra) > 2 && !in_array($palavra, $stopWords);
        });

        return array_values($palavras);
    }
    private function calcularSimilaridade(array $palavrasBase, array $palavrasComparadas): int
    {
        if (empty($palavrasBase) || empty($palavrasComparadas)) {
            return 0;
        }

        return count(array_intersect($palavrasBase, $palavrasComparadas));
    }



    public function alerta(Livro $livro)
    {
        $user = auth()->user();

        $existe = AlertaLivro::where('user_id', $user->id)
            ->where('livro_id', $livro->id)
            ->whereNull('notificado_em')
            ->exists();

        if ($existe) {
            return back()->with('error', 'Já pediste alerta para este livro.');
        }

        AlertaLivro::create([
            'user_id' => $user->id,
            'livro_id' => $livro->id,
        ]);

        return back()->with('success', 'Vais ser avisado quando o livro estiver disponível.');
    }

}
