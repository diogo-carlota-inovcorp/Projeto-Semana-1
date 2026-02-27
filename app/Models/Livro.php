<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livros';

    protected $fillable = [
        'isbn',
        'nome',
        'editoras_id',
        'bibliografia',
        'imagem_capa',
        'preco',
    ];

    public function editora()
    {
        return $this->belongsTo(Editora::class, 'editoras_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro', 'livro_id', 'autor_id');
    }
}
