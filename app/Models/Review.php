<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'livro_id',
        'user_id',
        'requisicao_id',
        'rating',
        'comentario',
        'estado',
        'justificacao',
        'moderado_em',
    ];
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requisicao()
    {
        return $this->belongsTo(\App\Models\Requisicao::class, 'requisicao_id');
    }

}
