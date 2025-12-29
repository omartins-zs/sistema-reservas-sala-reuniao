<?php

use App\Models\Reserva;
use App\Models\Usuario;

test('usuario pode ter muitas reservas', function () {
    $usuario = Usuario::factory()->create();
    Reserva::factory()->count(3)->create(['usuario_id' => $usuario->id]);

    expect($usuario->reservas)->toHaveCount(3);
});

test('usuario tem atributos fillable corretos', function () {
    $usuario = new Usuario();
    $fillable = ['nome', 'email', 'departamento', 'telefone'];

    expect($usuario->getFillable())->toBe($fillable);
});

test('email deve ser unico', function () {
    Usuario::factory()->create(['email' => 'teste@teste.com']);

    expect(fn() => Usuario::factory()->create(['email' => 'teste@teste.com']))
        ->toThrow(Illuminate\Database\QueryException::class);
});

