<?php

namespace App\Http\Controllers;

use App\Exports\LivrosExport;
use Maatwebsite\Excel\Facades\Excel;

class LivroExportController extends Controller
{
    public function export()
    {
        // segurança extra (mesmo se tentarem abrir a rota direta)
        if (!auth()->check() || auth()->user()->id !== 1) {
            abort(403, 'Acesso negado.');
        }

        return Excel::download(new LivrosExport, 'livros.xlsx');
    }
}
