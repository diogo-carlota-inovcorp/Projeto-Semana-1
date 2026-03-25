<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'livro_id',
        'nome',
        'preco',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function livro()
{
    return $this->belongsTo(Livro::class, 'livro_id');
}
}
