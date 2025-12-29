<?php

use App\Exceptions\ConflitoHorarioException;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;
use App\Services\ReservaService;

beforeEach(function () {
    $this->reservaService = new ReservaService();
});

test('verifica conflito de horario quando existe reserva sobreposta', function () {
    $sala = Sala::factory()->create();
    $usuario = Usuario::factory()->create();

    // Cria reserva das 14:00 às 16:00
    Reserva::factory()->create([
        'sala_id' => $sala->id,
        'usuario_id' => $usuario->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '16:00',
    ]);

    // Tenta criar reserva das 15:00 às 17:00 (sobrepõe)
    $temConflito = $this->reservaService->verificarConflitoHorario(
        $sala->id,
        '2025-12-29',
        '15:00',
        '17:00'
    );

    expect($temConflito)->toBeTrue();
});

test('nao verifica conflito quando nao existe reserva sobreposta', function () {
    $sala = Sala::factory()->create();
    $usuario = Usuario::factory()->create();

    // Cria reserva das 14:00 às 16:00
    Reserva::factory()->create([
        'sala_id' => $sala->id,
        'usuario_id' => $usuario->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '16:00',
    ]);

    // Tenta criar reserva das 17:00 às 18:00 (não sobrepõe)
    $temConflito = $this->reservaService->verificarConflitoHorario(
        $sala->id,
        '2025-12-29',
        '17:00',
        '18:00'
    );

    expect($temConflito)->toBeFalse();
});

test('verifica horario de funcionamento - inicio antes do horario de abertura', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);

    expect(fn() => $this->reservaService->verificarHorarioFuncionamento($sala, '07:00', '09:00'))
        ->toThrow(Exception::class, 'A sala está disponível apenas a partir das');
});

test('verifica horario de funcionamento - fim depois do horario de fechamento', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);

    expect(fn() => $this->reservaService->verificarHorarioFuncionamento($sala, '17:00', '19:00'))
        ->toThrow(Exception::class, 'A sala está disponível apenas até às');
});

test('permite reserva dentro do horario de funcionamento', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);

    $resultado = $this->reservaService->verificarHorarioFuncionamento($sala, '14:00', '15:00');

    expect($resultado)->toBeTrue();
});

test('cria reserva com sucesso quando nao ha conflito', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    $reserva = $this->reservaService->criarReserva([
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '14:00',
        'horario_fim' => '15:00',
    ]);

    expect($reserva)->toBeInstanceOf(Reserva::class);
    expect($reserva->usuario_id)->toBe($usuario->id);
    expect($reserva->sala_id)->toBe($sala->id);
});

test('lanca excecao ao criar reserva com conflito de horario', function () {
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

    // Tenta criar reserva sobreposta
    expect(fn() => $this->reservaService->criarReserva([
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '15:00',
        'horario_fim' => '17:00',
    ]))->toThrow(ConflitoHorarioException::class);
});

test('lanca excecao ao criar reserva fora do horario de funcionamento', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);
    $usuario = Usuario::factory()->create();

    // Tenta criar reserva das 17:00 às 19:00 (fecha às 18:00)
    expect(fn() => $this->reservaService->criarReserva([
        'usuario_id' => $usuario->id,
        'sala_id' => $sala->id,
        'data_reserva' => '2025-12-29',
        'horario_inicio' => '17:00',
        'horario_fim' => '19:00',
    ]))->toThrow(Exception::class, 'A sala está disponível apenas até às');
});

test('verifica disponibilidade retorna true quando sala esta disponivel', function () {
    $sala = Sala::factory()->create([
        'horario_abertura' => '08:00:00',
        'horario_fechamento' => '18:00:00',
    ]);

    $disponivel = $this->reservaService->verificarDisponibilidade(
        $sala->id,
        '2025-12-29',
        '14:00',
        '15:00'
    );

    expect($disponivel)->toBeTrue();
});

test('verifica disponibilidade retorna false quando sala nao esta disponivel', function () {
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

    $disponivel = $this->reservaService->verificarDisponibilidade(
        $sala->id,
        '2025-12-29',
        '15:00',
        '17:00'
    );

    expect($disponivel)->toBeFalse();
});

