<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@empresa.com',
                'departamento' => 'TI',
                'telefone' => '(11) 99999-1111',
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@empresa.com',
                'departamento' => 'Recursos Humanos',
                'telefone' => '(11) 99999-2222',
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@empresa.com',
                'departamento' => 'Vendas',
                'telefone' => '(11) 99999-3333',
            ],
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.costa@empresa.com',
                'departamento' => 'Marketing',
                'telefone' => '(11) 99999-4444',
            ],
            [
                'nome' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@empresa.com',
                'departamento' => 'Financeiro',
                'telefone' => '(11) 99999-5555',
            ],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }
    }
}
