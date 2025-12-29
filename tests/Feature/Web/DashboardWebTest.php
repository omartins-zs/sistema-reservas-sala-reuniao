<?php

use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;

test('pode acessar dashboard', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Dashboard');
});

test('dashboard mostra estatisticas corretas', function () {
    $salas = Sala::factory()->count(5)->create();
    $usuarios = Usuario::factory()->count(3)->create();
    Reserva::factory()->count(10)->create();

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('5') // Total de salas
        ->assertSee('3') // Total de usuários
        ->assertSee('10'); // Total de reservas
});

test('dashboard mostra reservas recentes', function () {
    $reservas = Reserva::factory()->count(5)->create();

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Reservas Recentes');
});

