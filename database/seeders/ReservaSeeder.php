<?php

namespace Database\Seeders;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reservas para hoje
        $hoje = Carbon::today();

        // Reserva 1: Sala A - 09:00 às 10:00
        Reserva::create([
            'usuario_id' => 1,
            'sala_id' => 1,
            'data_reserva' => $hoje->format('Y-m-d'),
            'horario_inicio' => '09:00',
            'horario_fim' => '10:00',
        ]);

        // Reserva 2: Sala A - 14:00 às 15:30
        Reserva::create([
            'usuario_id' => 2,
            'sala_id' => 1,
            'data_reserva' => $hoje->format('Y-m-d'),
            'horario_inicio' => '14:00',
            'horario_fim' => '15:30',
        ]);

        // Reserva 3: Sala B - 10:00 às 11:00
        Reserva::create([
            'usuario_id' => 3,
            'sala_id' => 2,
            'data_reserva' => $hoje->format('Y-m-d'),
            'horario_inicio' => '10:00',
            'horario_fim' => '11:00',
        ]);

        // Reserva 4: Sala Executiva - 15:00 às 16:00
        Reserva::create([
            'usuario_id' => 4,
            'sala_id' => 3,
            'data_reserva' => $hoje->format('Y-m-d'),
            'horario_inicio' => '15:00',
            'horario_fim' => '16:00',
        ]);

        // Reservas para amanhã
        $amanha = Carbon::tomorrow();

        // Reserva 5: Sala A - 09:00 às 10:00
        Reserva::create([
            'usuario_id' => 1,
            'sala_id' => 1,
            'data_reserva' => $amanha->format('Y-m-d'),
            'horario_inicio' => '09:00',
            'horario_fim' => '10:00',
        ]);

        // Reserva 6: Sala de Videoconferência - 11:00 às 12:00
        Reserva::create([
            'usuario_id' => 5,
            'sala_id' => 5,
            'data_reserva' => $amanha->format('Y-m-d'),
            'horario_inicio' => '11:00',
            'horario_fim' => '12:00',
        ]);
    }
}
