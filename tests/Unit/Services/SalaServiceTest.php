<?php

use App\Models\Sala;
use App\Services\SalaService;

beforeEach(function () {
    $this->salaService = new SalaService();
});

test('pode criar uma sala', function () {
    $dados = [
        'nome' => 'Sala de Teste',
        'capacidade' => 10,
        'localizacao' => '1º Andar',
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ];

    $sala = $this->salaService->criarSala($dados);

    expect($sala)->toBeInstanceOf(Sala::class);
    expect($sala->nome)->toBe('Sala de Teste');
    expect($sala->capacidade)->toBe(10);
});

test('pode atualizar uma sala', function () {
    $sala = Sala::factory()->create();

    $salaAtualizada = $this->salaService->atualizarSala($sala->id, [
        'nome' => 'Sala Atualizada',
    ]);

    expect($salaAtualizada->nome)->toBe('Sala Atualizada');
});

test('pode listar todas as salas', function () {
    Sala::factory()->count(5)->create();

    $salas = $this->salaService->listarSalas();

    expect($salas)->toHaveCount(5);
});

