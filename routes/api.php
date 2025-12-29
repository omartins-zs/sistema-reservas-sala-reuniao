<?php

use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\SalaController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui estão todas as rotas da API do sistema de reservas de salas.
|
*/

// Rotas de Usuários
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::post('/', [UsuarioController::class, 'store']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::put('/{id}', [UsuarioController::class, 'update']);
    Route::delete('/{id}', [UsuarioController::class, 'destroy']);
});

// Rotas de Salas
Route::prefix('salas')->group(function () {
    Route::get('/', [SalaController::class, 'index']);
    Route::post('/', [SalaController::class, 'store']);
    Route::get('/{id}', [SalaController::class, 'show']);
    Route::put('/{id}', [SalaController::class, 'update']);
    Route::delete('/{id}', [SalaController::class, 'destroy']);
});

// Rotas de Reservas
Route::prefix('reservas')->group(function () {
    Route::get('/', [ReservaController::class, 'index']);
    Route::post('/', [ReservaController::class, 'store']);
    Route::get('/{id}', [ReservaController::class, 'show']);
    Route::put('/{id}', [ReservaController::class, 'update']);
    Route::delete('/{id}', [ReservaController::class, 'destroy']);
    
    // Rotas específicas
    Route::get('/sala/{salaId}', [ReservaController::class, 'listarPorSala']);
    Route::get('/usuario/{usuarioId}', [ReservaController::class, 'listarPorUsuario']);
    Route::post('/verificar-disponibilidade', [ReservaController::class, 'verificarDisponibilidade']);
});

