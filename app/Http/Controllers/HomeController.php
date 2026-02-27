<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
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
            ->paginate(9)
            ->withQueryString();

        $autores = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();

        return view('livros.index', compact('livros', 'autores', 'editoras', 'q', 'autorId', 'editoraId'));
    }
}
