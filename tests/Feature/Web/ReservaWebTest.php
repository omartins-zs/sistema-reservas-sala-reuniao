<?php

use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;

test('pode acessar pagina de listagem de reservas', function () {
    $response = $this->get('/reservas');

    $response->assertStatus(200)
        ->assertSee('Reservas');
});

test('pode acessar pagina de criacao de reserva', function () {
    $response = $this->get('/reservas/create');

    $response->assertStatus(200)
        ->assertSee('Nova Reserva');
});

test('pode criar reserva via formulario web', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    $response = $this->post('/reservas', [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '15:00',
    ]);

    $response->assertRedirect('/reservas')
        ->assertSessionHas('success');

    $this->assertDatabaseHas('reservas', [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
    ]);
});

test('mostra erro ao criar reserva com conflito via formulario web', function () {
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
        'horario_inicio' => '14:00:00',
        'horario_fim' => '16:00:00',
    ]);

    $response = $this->post('/reservas', [
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '15:00',
        'horario_fim' => '17:00',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('error');
});

test('pode acessar pagina de detalhes da reserva', function () {
    $reserva = Reserva::factory()->create();

    $response = $this->get("/reservas/{$reserva->id}");

    $response->assertStatus(200)
        ->assertSee($reserva->sala->nome);
});

test('pode acessar pagina de edicao da reserva', function () {
    $reserva = Reserva::factory()->create();

    $response = $this->get("/reservas/{$reserva->id}/edit");

    $response->assertStatus(200)
        ->assertSee('Editar Reserva');
});

test('pode atualizar reserva via formulario web', function () {
    $reserva = Reserva::factory()->create();
    $sala = $reserva->sala;

    $response = $this->put("/reservas/{$reserva->id}", [
        'usuario_id' => $reserva->usuario_id,
        'sala_id' => $sala->id,
        'data_reserva' => $reserva->data_reserva->format('Y-m-d'),
        'horario_inicio' => '16:00',
        'horario_fim' => '17:00',
    ]);

    $response->assertRedirect('/reservas')
        ->assertSessionHas('success');
});

test('pode deletar reserva via formulario web', function () {
    $reserva = Reserva::factory()->create();

    $response = $this->delete("/reservas/{$reserva->id}");

    $response->assertRedirect('/reservas')
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('reservas', [
        'id' => $reserva->id,
    ]);
});

