<?php

namespace Database\Factories;

use App\Models\Requisicao;
use App\Models\User;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequisicaoFactory extends Factory
{
    protected $model = Requisicao::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'livro_id' => Livro::factory(),
            'requisitado_em' => now(),
            'fim_previsto' => now()->addDays(14),
            'status' => $this->faker->randomElement(['pendente', 'aprovado', 'rejeitado', 'devolvido']),
            'numero' => $this->faker->unique()->numberBetween(1000, 9999),
            'reminder_enviado_em' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
