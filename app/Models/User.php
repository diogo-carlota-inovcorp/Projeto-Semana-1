<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_perfil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }

    public function getFotoPerfilUrlAttribute()
    {
        if ($this->foto_perfil) {
            return asset('storage/' . $this->foto_perfil);
        }

        return asset('images/default-avatar.png');
    }
}
