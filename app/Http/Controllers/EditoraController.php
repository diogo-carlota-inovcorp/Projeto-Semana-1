<?php

namespace App\Http\Controllers;


use App\Models\Editora;
use Illuminate\Http\Request;

class EditoraController extends Controller
{
    public function index(Request $request)
    {
        $query = Editora::query();

        if ($request->filled('q')) {
            $query->where('nome', 'like', '%' . $request->q . '%');
        }

        $editoras = $query->orderBy('nome')->paginate(3);

        return view('livros.editora', compact('editoras'));
    }

}
