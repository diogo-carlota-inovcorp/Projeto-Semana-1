<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{
    protected $table = 'requisicoes';

    protected $fillable = [
        'user_id','livro_id','requisitado_em','fim_previsto','status'
    ];

    protected $casts = [
        'requisitado_em' => 'datetime',
        'fim_previsto' => 'date',
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($req) {

            $nextId = (static::max('id') ?? 0) + 1;
            $req->numero = 'Requisição-' . str_pad((string)$nextId, 6, '0', STR_PAD_LEFT);
        });
    }
}
