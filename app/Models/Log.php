<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'data_hora',
        'user_id',
        'modulo',
        'objeto_id',
        'alteracao',
        'ip',
        'browser'
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
