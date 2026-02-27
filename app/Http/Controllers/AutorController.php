<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index(Request $request)
    {
        $query = Autor::query();

        if ($request->filled('q')) {
            $query->where('nome', 'like', '%' . $request->q . '%');
        }

        $autores = $query->orderBy('nome')->paginate(10);

        return view('livros.autor', compact('autores'));
    }
}
