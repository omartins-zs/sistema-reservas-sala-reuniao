<?php

use App\Models\Usuario;

test('pode listar todos os usuarios', function () {
    Usuario::factory()->count(3)->create();

    $response = $this->getJson('/api/usuarios');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => ['id', 'nome', 'email', 'departamento', 'telefone']
            ]
        ]);
});

test('pode criar um novo usuario', function () {
    $dados = [
        'nome' => 'João Silva',
        'email' => 'joao@teste.com',
        'departamento' => 'TI',
        'telefone' => '(11) 99999-9999',
    ];

    $response = $this->postJson('/api/usuarios', $dados);

    $response->assertStatus(201)
        ->assertJson([
            'status' => 'success',
            'message' => 'Usuário criado com sucesso.',
        ]);

    $this->assertDatabaseHas('usuarios', [
        'email' => 'joao@teste.com',
    ]);
});

test('nao pode criar usuario com email duplicado', function () {
    Usuario::factory()->create(['email' => 'teste@teste.com']);

    $response = $this->postJson('/api/usuarios', [
        'nome' => 'Outro Usuário',
        'email' => 'teste@teste.com',
        'departamento' => 'TI',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('pode buscar usuario por id', function () {
    $usuario = Usuario::factory()->create();

    $response = $this->getJson("/api/usuarios/{$usuario->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'email' => $usuario->email,
            ]
        ]);
});

test('retorna 404 quando usuario nao existe', function () {
    $response = $this->getJson('/api/usuarios/999');

    $response->assertStatus(404);
});

test('pode atualizar usuario', function () {
    $usuario = Usuario::factory()->create();

    $response = $this->putJson("/api/usuarios/{$usuario->id}", [
        'nome' => 'Nome Atualizado',
        'email' => $usuario->email,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
        ]);

    $this->assertDatabaseHas('usuarios', [
        'id' => $usuario->id,
        'nome' => 'Nome Atualizado',
    ]);
});

test('pode deletar usuario', function () {
    $usuario = Usuario::factory()->create();

    $response = $this->deleteJson("/api/usuarios/{$usuario->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('usuarios', [
        'id' => $usuario->id,
    ]);
});

