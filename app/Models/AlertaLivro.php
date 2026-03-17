<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertaLivro extends Model
{
    protected $fillable = [
        'user_id',
        'livro_id',
        'notificado_em',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
