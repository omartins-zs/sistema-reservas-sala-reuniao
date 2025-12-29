<?php

use App\Models\Usuario;
use App\Services\UsuarioService;

beforeEach(function () {
    $this->usuarioService = new UsuarioService();
});

test('pode criar um usuario', function () {
    $dados = [
        'nome' => 'João Silva',
        'email' => 'joao@teste.com',
        'departamento' => 'TI',
        'telefone' => '(11) 99999-9999',
    ];

    $usuario = $this->usuarioService->criarUsuario($dados);

    expect($usuario)->toBeInstanceOf(Usuario::class);
    expect($usuario->nome)->toBe('João Silva');
    expect($usuario->email)->toBe('joao@teste.com');
});

test('pode atualizar um usuario', function () {
    $usuario = Usuario::factory()->create();

    $usuarioAtualizado = $this->usuarioService->atualizarUsuario($usuario->id, [
        'nome' => 'Nome Atualizado',
    ]);

    expect($usuarioAtualizado->nome)->toBe('Nome Atualizado');
});

test('pode listar todos os usuarios', function () {
    Usuario::factory()->count(5)->create();

    $usuarios = $this->usuarioService->listarUsuarios();

    expect($usuarios)->toHaveCount(5);
});

