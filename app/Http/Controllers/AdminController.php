<?php

namespace App\Http\Controllers;

use App\Models\Editora;
use App\Models\Autor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $editoras = Editora::orderBy('nome')->get();
        $autores  = Autor::orderBy('nome')->get();

        return view('admin.admin', compact('editoras', 'autores'));
    }


    public function adicionar_livro()
    {
        $editoras = Editora::orderBy('nome')->get();
        $autores  = Autor::orderBy('nome')->get();

        return view('admin.adicionar_livro', compact('editoras', 'autores'));
    }

    public function adicionar_autor()
    {
        return view('admin.adicionar_autor');
    }

    public function adicionar_editora()
    {
        return view('admin.adicionar_editora');
    }

    public function store_editora(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $editora = new Editora();
        $editora->nome = $request->nome;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('editoras', 'public');
            $editora->logo = $path;
        }

        $editora->save();

        return redirect()
            ->route('livros.editora')
            ->with('success', 'Editora adicionada!');
    }

    public function store_autor(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $autor = new Autor();
        $autor->nome = $request->nome;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('autores', 'public');
            $autor->foto = $path;
        }

        $autor->save();

        return redirect()->route('livros.autor')->with('success', 'Autor adicionado!');
    }

}
