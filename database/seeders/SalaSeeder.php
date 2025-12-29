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
            ],
            [
                'nome' => 'Sala de Reunião B',
                'capacidade' => 8,
                'localizacao' => '1º Andar - Ala Sul',
            ],
            [
                'nome' => 'Sala Executiva',
                'capacidade' => 15,
                'localizacao' => '2º Andar - Ala Leste',
            ],
            [
                'nome' => 'Sala de Treinamento',
                'capacidade' => 20,
                'localizacao' => '2º Andar - Ala Oeste',
            ],
            [
                'nome' => 'Sala de Videoconferência',
                'capacidade' => 6,
                'localizacao' => '3º Andar - Centro',
            ],
        ];

        foreach ($salas as $sala) {
            Sala::create($sala);
        }
    }
}
