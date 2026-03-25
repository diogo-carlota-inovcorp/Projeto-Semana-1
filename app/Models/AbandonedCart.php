<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'cart_data',
        'total',
        'email',
        'name',
        'last_activity',
        'notified_at',
        'recovered',
        'notification_count',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'last_activity' => 'datetime',
        'notified_at' => 'datetime',
        'recovered' => 'boolean',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsNotified()
    {
        $this->update([
            'notified_at' => now(),
            'notification_count' => $this->notification_count + 1,
        ]);
    }

    public function markAsRecovered()
    {
        $this->update(['recovered' => true]);
    }
}
