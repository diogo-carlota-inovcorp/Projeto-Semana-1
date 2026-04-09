<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensagemNaoLida extends Model
{
    protected $table = 'mensagens_nao_lidas';

    protected $fillable = ['user_id', 'conversavel_id', 'conversavel_type', 'quantidade'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversavel()
    {
        return $this->morphTo();
    }
}
