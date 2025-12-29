<?php

use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;

test('reserva pertence a um usuario', function () {
    $usuario = Usuario::factory()->create();
    $reserva = Reserva::factory()->create(['usuario_id' => $usuario->id]);

    expect($reserva->usuario)->toBeInstanceOf(Usuario::class);
    expect($reserva->usuario->id)->toBe($usuario->id);
});

test('reserva pertence a uma sala', function () {
    $sala = Sala::factory()->create();
    $reserva = Reserva::factory()->create(['sala_id' => $sala->id]);

    expect($reserva->sala)->toBeInstanceOf(Sala::class);
    expect($reserva->sala->id)->toBe($sala->id);
});

test('reserva tem atributos fillable corretos', function () {
    $reserva = new Reserva();
    $fillable = ['usuario_id', 'sala_id', 'data_reserva', 'horario_inicio', 'horario_fim'];

    expect($reserva->getFillable())->toBe($fillable);
});

test('pode criar reserva via factory', function () {
    $reserva = Reserva::factory()->create();

    expect($reserva)->toBeInstanceOf(Reserva::class);
    expect($reserva->usuario_id)->not->toBeNull();
    expect($reserva->sala_id)->not->toBeNull();
    expect($reserva->data_reserva)->not->toBeNull();
});

