<?php

namespace Database\Factories;

use App\Models\Livro;
use App\Models\Editora;
use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    protected $model = Livro::class;

    public function definition(): array
    {
        return [
            'isbn' => $this->faker->isbn13(),
            'nome' => $this->faker->sentence(3),
            'editoras_id' => Editora::factory(),
            'bibliografia' => $this->faker->paragraph(),
            'imagem_capa' => $this->faker->imageUrl(),
            'preco' => $this->faker->randomFloat(2, 5, 50),
            'stock' => $this->faker->numberBetween(0, 20), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
