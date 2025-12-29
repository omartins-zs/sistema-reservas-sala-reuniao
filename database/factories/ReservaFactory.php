<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horarioInicio = fake()->time('H:i', '16:00');
        $horarioFim = date('H:i', strtotime($horarioInicio . ' +1 hour'));

        return [
            'usuario_id' => Usuario::factory(),
            'sala_id' => Sala::factory(),
            'data_reserva' => fake()->dateTimeBetween('today', '+30 days')->format('Y-m-d'),
            'horario_inicio' => $horarioInicio . ':00', // Garante formato HH:MM:SS
            'horario_fim' => $horarioFim . ':00', // Garante formato HH:MM:SS
        ];
    }
}
