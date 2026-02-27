<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{

    protected $table = 'editoras';
    protected $fillable = ['nome', 'logo'];

    public function livros()
    {
        return $this->hasMany(Livro::class, 'editoras_id');
    }

}
