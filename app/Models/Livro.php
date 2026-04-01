<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Livro extends Model
{
    use HasFactory;
    use LogsActivity;

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
    public function requisicoes()
    {
        return $this->hasMany(\App\Models\Requisicao::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewsAtivas()
    {
        return $this->hasMany(Review::class)->where('estado', 'ativo');
    }

    public function alertas()
    {
        return $this->hasMany(AlertaLivro::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
