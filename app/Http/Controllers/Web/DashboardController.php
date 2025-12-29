<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSalas = Sala::count();
        $totalUsuarios = Usuario::count();
        $totalReservas = Reserva::count();
        $reservasHoje = Reserva::whereDate('data_reserva', today())->count();
        
        $reservasRecentes = Reserva::with(['usuario', 'sala'])
            ->orderBy('data_reserva', 'desc')
            ->orderBy('horario_inicio', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalSalas',
            'totalUsuarios',
            'totalReservas',
            'reservasHoje',
            'reservasRecentes'
        ));
    }
}
