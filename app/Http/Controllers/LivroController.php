<?php

namespace App\Http\Controllers;


use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Http\Request;

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
            'editora',
            'autores',
            'requisicoes.user' => fn($q) => $q->latest('requisitado_em'),
        ]);

        return view('livros.show', compact('livro'));
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



        // ✅ Validate
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


}
