<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;
use App\Services\ReservaService;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function __construct(
        private ReservaService $reservaService
    ) {
    }

    public function index(Request $request)
    {
        $query = Reserva::with(['usuario', 'sala']);

        // Filtros
        if ($request->filled('sala_id')) {
            $query->where('sala_id', $request->sala_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        if ($request->filled('data_reserva')) {
            $query->where('data_reserva', $request->data_reserva);
        }

        $reservas = $query->orderBy('data_reserva', 'desc')
            ->orderBy('horario_inicio', 'desc')
            ->paginate(15);

        $salas = Sala::all();
        $usuarios = Usuario::all();

        return view('reservas.index', compact('reservas', 'salas', 'usuarios'));
    }

    public function create()
    {
        $salas = Sala::all();
        $usuarios = Usuario::all();

        return view('reservas.create', compact('salas', 'usuarios'));
    }

    public function store(StoreReservaRequest $request)
    {
        try {
            $reserva = $this->reservaService->criarReserva($request->validated());

            return redirect()->route('reservas.index')
                ->with('success', 'Reserva criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(Reserva $reserva)
    {
        $reserva->load(['usuario', 'sala']);

        return view('reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        $salas = Sala::all();
        $usuarios = Usuario::all();

        return view('reservas.edit', compact('reserva', 'salas', 'usuarios'));
    }

    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        try {
            $this->reservaService->atualizarReserva($reserva->id, $request->validated());

            return redirect()->route('reservas.index')
                ->with('success', 'Reserva atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(Reserva $reserva)
    {
        try {
            $reserva->delete();

            return redirect()->route('reservas.index')
                ->with('success', 'Reserva removida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover reserva.');
        }
    }

    public function verificarDisponibilidade(Request $request)
    {
        $request->validate([
            'sala_id' => 'required|exists:salas,id',
            'data_reserva' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        try {
            $disponivel = $this->reservaService->verificarDisponibilidade(
                $request->sala_id,
                $request->data_reserva,
                $request->horario_inicio,
                $request->horario_fim
            );

            $sala = \App\Models\Sala::findOrFail($request->sala_id);
            $horarioAbertura = $sala->horario_abertura ?? '08:00:00';
            $horarioFechamento = $sala->horario_fechamento ?? '18:00:00';

            // Verifica se está dentro do horário de funcionamento
            $mensagem = 'Sala disponível no período solicitado.';
            if (!$disponivel) {
                if ($request->horario_inicio < $horarioAbertura) {
                    $mensagem = "A sala está disponível apenas a partir das {$horarioAbertura}.";
                } elseif ($request->horario_fim > $horarioFechamento) {
                    $mensagem = "A sala está disponível apenas até às {$horarioFechamento}.";
                } else {
                    $mensagem = 'A sala já está reservada neste horário.';
                }
            }

            return response()->json([
                'disponivel' => $disponivel,
                'message' => $mensagem
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'disponivel' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
