<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LivrosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return \App\Models\Livro::with(['editora', 'autores'])->get()->map(function ($livro) {
            return [
                $livro->isbn,
                $livro->nome,
                number_format($livro->preco, 2, ',', '.') . ' €',
                $livro->editora->nome ?? 'Sem editora',
                $livro->autores->pluck('nome')->implode(', '),
                $livro->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ISBN',
            'Nome',
            'Preço',
            'Editora',
            'Autores',
            'Criado em'
        ];
    }
}
