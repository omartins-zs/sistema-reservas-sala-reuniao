<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ReservaController;
use App\Http\Controllers\Web\SalaController;
use App\Http\Controllers\Web\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('reservas', ReservaController::class);
Route::post('reservas/verificar-disponibilidade', [ReservaController::class, 'verificarDisponibilidade'])->name('reservas.verificar-disponibilidade');

Route::resource('salas', SalaController::class);
Route::resource('usuarios', UsuarioController::class);
