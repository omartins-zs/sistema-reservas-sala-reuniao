<?php

namespace Database\Factories;

use App\Models\Sala;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sala>
 */
class SalaFactory extends Factory
{
    protected $model = Sala::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Sala ' . fake()->randomLetter() . ' - ' . fake()->word(),
            'capacidade' => fake()->numberBetween(5, 30),
            'localizacao' => fake()->randomElement(['1º Andar', '2º Andar', '3º Andar']) . ' - ' . fake()->word(),
            'horario_abertura' => '08:00:00',
            'horario_fechamento' => '18:00:00',
        ];
    }
}
