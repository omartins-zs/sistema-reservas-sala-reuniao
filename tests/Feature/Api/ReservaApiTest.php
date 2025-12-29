<?php

use App\Exceptions\ConflitoHorarioException;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;

test('pode listar todas as reservas', function () {
    Reserva::factory()->count(3)->create();

    $response = $this->getJson('/api/reservas');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => ['id', 'usuario_id', 'sala_id', 'data_reserva', 'horario_inicio', 'horario_fim']
            ]
        ]);
});

test('pode criar uma nova reserva', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    $dados = [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '15:00',
    ];

    $response = $this->postJson('/api/reservas', $dados);

    $response->assertStatus(201)
        ->assertJson([
            'status' => 'success',
            'message' => 'Reserva criada com sucesso.',
        ]);

    $this->assertDatabaseHas('reservas', [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
    ]);
    
    // Verifica a data separadamente devido ao formato
    $reserva = Reserva::where('usuario_id', $usuario->id)
        ->where('sala_id', $sala->id)
        ->first();
    expect($reserva->data_reserva->format('Y-m-d'))->toBe('2025-12-29');
});

test('nao pode criar reserva com conflito de horario', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    // Cria primeira reserva
    Reserva::factory()->create([
        'sala_id' => $sala->id,
        'usuario_id' => $usuario->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '16:00',
    ]);

    // Tenta criar reserva sobreposta
    $response = $this->postJson('/api/reservas', [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '15:00',
        'horario_fim' => '17:00',
    ]);

    $response->assertStatus(409)
        ->assertJson([
            'status' => 'error',
        ]);
});

test('nao pode criar reserva fora do horario de funcionamento', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    // Tenta criar reserva das 17:00 às 19:00 (fecha às 18:00)
    $response = $this->postJson('/api/reservas', [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '17:00',
        'horario_fim' => '19:00',
    ]);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
        ]);
});

test('pode buscar reserva por id', function () {
    $reserva = Reserva::factory()->create();

    $response = $this->getJson("/api/reservas/{$reserva->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $reserva->id,
            ]
        ]);
});

test('pode atualizar reserva', function () {
    $reserva = Reserva::factory()->create();
    $sala = $reserva->sala;

    $response = $this->putJson("/api/reservas/{$reserva->id}", [
        'usuario_id' => $reserva->usuario_id,
        'sala_id' => $sala->id,
        'data_reserva' => $reserva->data_reserva->format('Y-m-d'),
        'horario_inicio' => '16:00',
        'horario_fim' => '17:00',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('reservas', [
        'id' => $reserva->id,
        'horario_inicio' => '16:00',
        'horario_fim' => '17:00',
    ]);
});

test('pode deletar reserva', function () {
    $reserva = Reserva::factory()->create();

    $response = $this->deleteJson("/api/reservas/{$reserva->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('reservas', [
        'id' => $reserva->id,
    ]);
});

test('pode listar reservas por sala', function () {
    $sala = Sala::factory()->create();
    Reserva::factory()->count(3)->create(['sala_id' => $sala->id]);

    $response = $this->getJson("/api/reservas/sala/{$sala->id}");

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('pode listar reservas por usuario', function () {
    $usuario = Usuario::factory()->create();
    Reserva::factory()->count(2)->create(['usuario_id' => $usuario->id]);

    $response = $this->getJson("/api/reservas/usuario/{$usuario->id}");

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

test('pode verificar disponibilidade - sala disponivel', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);

    $response = $this->postJson('/api/reservas/verificar-disponibilidade', [
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '15:00',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'disponivel' => true,
            ]
        ]);
});

test('pode verificar disponibilidade - sala nao disponivel por conflito', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    // Cria reserva
    Reserva::factory()->create([
        'sala_id' => $sala->id,
        'usuario_id' => $usuario->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '16:00',
    ]);

    $response = $this->postJson('/api/reservas/verificar-disponibilidade', [
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '15:00',
        'horario_fim' => '17:00',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'disponivel' => false,
            ]
        ]);
});

test('pode verificar disponibilidade - sala nao disponivel por horario de funcionamento', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);

    $response = $this->postJson('/api/reservas/verificar-disponibilidade', [
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '17:00',
        'horario_fim' => '19:00',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'disponivel' => false,
            ]
        ])
        ->assertJsonFragment([
            'message' => 'A sala está disponível apenas até às 18:00'
        ]);
});

