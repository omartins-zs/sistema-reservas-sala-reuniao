<?php

use App\Models\Reserva;
use App\Models\Sala;

test('sala pode ter muitas reservas', function () {
    $sala = Sala::factory()->create();
    Reserva::factory()->count(3)->create(['sala_id' => $sala->id]);

    expect($sala->reservas)->toHaveCount(3);
});

test('sala tem atributos fillable corretos', function () {
    $sala = new Sala();
    $fillable = ['nome', 'capacidade', 'localizacao', 'horario_abertura', 'horario_fechamento'];

    expect($sala->getFillable())->toBe($fillable);
});

test('sala tem valores padrao para horarios', function () {
    $sala = Sala::factory()->create();

    // Verifica se os valores padrão da factory são aplicados
    expect($sala->horario_abertura)->not->toBeNull();
    expect($sala->horario_fechamento)->not->toBeNull();
});

test('pode criar sala via factory', function () {
    $sala = Sala::factory()->create();

    expect($sala)->toBeInstanceOf(Sala::class);
    expect($sala->nome)->not->toBeEmpty();
    expect($sala->capacidade)->toBeGreaterThan(0);
});

