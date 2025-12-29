<?php

namespace Database\Seeders;

use App\Models\Sala;
use Illuminate\Database\Seeder;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salas = [
            [
                'nome' => 'Sala de Reunião A',
                'capacidade' => 10,
                'localizacao' => '1º Andar - Ala Norte',
                'horario_abertura' => '08:00:00',
                'horario_fechamento' => '18:00:00',
            ],
            [
                'nome' => 'Sala de Reunião B',
                'capacidade' => 8,
                'localizacao' => '1º Andar - Ala Sul',
                'horario_abertura' => '08:00:00',
                'horario_fechamento' => '18:00:00',
            ],
            [
                'nome' => 'Sala Executiva',
                'capacidade' => 15,
                'localizacao' => '2º Andar - Ala Leste',
                'horario_abertura' => '08:00:00',
                'horario_fechamento' => '18:00:00',
            ],
            [
                'nome' => 'Sala de Treinamento',
                'capacidade' => 20,
                'localizacao' => '2º Andar - Ala Oeste',
                'horario_abertura' => '08:00:00',
                'horario_fechamento' => '18:00:00',
            ],
            [
                'nome' => 'Sala de Videoconferência',
                'capacidade' => 6,
                'localizacao' => '3º Andar - Centro',
                'horario_abertura' => '08:00:00',
                'horario_fechamento' => '18:00:00',
            ],
        ];

        foreach ($salas as $sala) {
            Sala::create($sala);
        }
    }
}
