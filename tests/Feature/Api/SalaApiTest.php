<?php

use App\Models\Sala;

test('pode listar todas as salas', function () {
    Sala::factory()->count(3)->create();

    $response = $this->getJson('/api/salas');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => ['id', 'nome', 'capacidade', 'localizacao', 'horario_abertura', 'horario_fechamento']
            ]
        ]);
});

test('pode criar uma nova sala', function () {
    $dados = [
        'nome' => 'Sala de Teste',
        'capacidade' => 10,
        'localizacao' => '1º Andar',
        'horario_abertura' => '08:00',
        'horario_fechamento' => '18:00',
    ];

    $response = $this->postJson('/api/salas', $dados);

    $response->assertStatus(201)
        ->assertJson([
            'status' => 'success',
            'message' => 'Sala criada com sucesso.',
        ]);

    $this->assertDatabaseHas('salas', [
        'nome' => 'Sala de Teste',
    ]);
});

test('nao pode criar sala sem horario de abertura', function () {
    $response = $this->postJson('/api/salas', [
        'nome' => 'Sala de Teste',
        'capacidade' => 10,
        'horario_fechamento' => '18:00',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['horario_abertura']);
});

test('nao pode criar sala com horario de fechamento antes do abertura', function () {
    $response = $this->postJson('/api/salas', [
        'nome' => 'Sala de Teste',
        'capacidade' => 10,
        'horario_abertura' => '18:00',
        'horario_fechamento' => '08:00',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['horario_fechamento']);
});

test('pode buscar sala por id', function () {
    $sala = Sala::factory()->create();

    $response = $this->getJson("/api/salas/{$sala->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $sala->id,
                'nome' => $sala->nome,
            ]
        ]);
});

test('pode atualizar sala', function () {
    $sala = Sala::factory()->create();

    // Normaliza horários para formato HH:mm
    $horarioAbertura = substr($sala->horario_abertura, 0, 5);
    $horarioFechamento = substr($sala->horario_fechamento, 0, 5);

    $response = $this->putJson("/api/salas/{$sala->id}", [
        'nome' => 'Sala Atualizada',
        'capacidade' => $sala->capacidade,
        'horario_abertura' => $horarioAbertura,
        'horario_fechamento' => $horarioFechamento,
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('salas', [
        'id' => $sala->id,
        'nome' => 'Sala Atualizada',
    ]);
});

test('pode deletar sala', function () {
    $sala = Sala::factory()->create();

    $response = $this->deleteJson("/api/salas/{$sala->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('salas', [
        'id' => $sala->id,
    ]);
});

