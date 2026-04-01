<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Order extends Model
{
       use LogsActivity;
       
    protected $fillable = [
        'user_id',
        'livro_id',
        'morada',
        'estado',
        'total',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
    return $this->hasMany(OrderItem::class);
    }


    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

public function livro()
{
    return $this->belongsTo(Livro::class, 'livro_id');
}
}
