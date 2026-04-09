<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';

    protected $fillable = ['user_id', 'conversavel_id', 'conversavel_type', 'conteudo', 'lida', 'lida_em'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversavel()
    {
        return $this->morphTo();
    }
}
