<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ConflitoHorarioException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use App\Models\Reserva;
use App\Services\ReservaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
{
    public function __construct(
        private ReservaService $reservaService
    ) {
    }

    /**
     * Lista todas as reservas
     */
    public function index(): JsonResponse
    {
        try {
            $reservas = Reserva::with(['usuario', 'sala'])
                ->orderBy('data_reserva')
                ->orderBy('horario_inicio')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservas listadas com sucesso.',
                'data' => $reservas,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar reservas', ['erro' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao listar reservas.',
            ], 500);
        }
    }

    /**
     * Cria uma nova reserva
     */
    public function store(StoreReservaRequest $request): JsonResponse
    {
        try {
            $reserva = $this->reservaService->criarReserva($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Reserva criada com sucesso.',
                'data' => $reserva,
            ], 201);
        } catch (ConflitoHorarioException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 409);
        } catch (\Exception $e) {
            Log::error('Erro ao criar reserva', [
                'erro' => $e->getMessage(),
                'dados' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Exibe uma reserva específica
     */
    public function show(string $id): JsonResponse
    {
        try {
            $reserva = Reserva::with(['usuario', 'sala'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Reserva encontrada.',
                'data' => $reserva,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar reserva', [
                'erro' => $e->getMessage(),
                'reserva_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Reserva não encontrada.',
            ], 404);
        }
    }

    /**
     * Atualiza uma reserva existente
     */
    public function update(UpdateReservaRequest $request, string $id): JsonResponse
    {
        try {
            $reserva = $this->reservaService->atualizarReserva($id, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Reserva atualizada com sucesso.',
                'data' => $reserva,
            ], 200);
        } catch (ConflitoHorarioException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 409);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar reserva', [
                'erro' => $e->getMessage(),
                'reserva_id' => $id,
                'dados' => $request->all(),
            ]);

            $statusCode = str_contains($e->getMessage(), 'não encontrada') ? 404 : 400;

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Remove uma reserva
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();

            Log::info('Reserva removida com sucesso', ['reserva_id' => $id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Reserva removida com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao remover reserva', [
                'erro' => $e->getMessage(),
                'reserva_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Reserva não encontrada.',
            ], 404);
        }
    }

    /**
     * Lista todas as reservas de uma sala específica
     */
    public function listarPorSala(string $salaId): JsonResponse
    {
        try {
            $reservas = $this->reservaService->listarReservasPorSala($salaId);

            return response()->json([
                'status' => 'success',
                'message' => 'Reservas da sala listadas com sucesso.',
                'data' => $reservas,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar reservas da sala', [
                'erro' => $e->getMessage(),
                'sala_id' => $salaId,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Sala não encontrada.',
            ], 404);
        }
    }

    /**
     * Lista todas as reservas de um usuário específico
     */
    public function listarPorUsuario(string $usuarioId): JsonResponse
    {
        try {
            $reservas = $this->reservaService->listarReservasPorUsuario($usuarioId);

            return response()->json([
                'status' => 'success',
                'message' => 'Reservas do usuário listadas com sucesso.',
                'data' => $reservas,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar reservas do usuário', [
                'erro' => $e->getMessage(),
                'usuario_id' => $usuarioId,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado.',
            ], 404);
        }
    }

    /**
     * Verifica disponibilidade de uma sala em um período específico
     */
    public function verificarDisponibilidade(Request $request): JsonResponse
    {
        $request->validate([
            'sala_id' => ['required', 'integer', 'exists:salas,id'],
            'data_reserva' => ['required', 'date'],
            'horario_inicio' => ['required', 'date_format:H:i'],
            'horario_fim' => ['required', 'date_format:H:i', 'after:horario_inicio'],
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

            // Normaliza formatos para comparação (remove segundos se houver)
            $horarioAberturaFormatado = substr($horarioAbertura, 0, 5);
            $horarioFechamentoFormatado = substr($horarioFechamento, 0, 5);
            $horarioInicioFormatado = substr($request->horario_inicio, 0, 5);
            $horarioFimFormatado = substr($request->horario_fim, 0, 5);

            // Verifica se está dentro do horário de funcionamento
            $mensagem = 'Sala disponível no período solicitado.';
            if (!$disponivel) {
                if ($horarioInicioFormatado < $horarioAberturaFormatado) {
                    $mensagem = "A sala está disponível apenas a partir das {$horarioAberturaFormatado}.";
                } elseif ($horarioFimFormatado > $horarioFechamentoFormatado) {
                    $mensagem = "A sala está disponível apenas até às {$horarioFechamentoFormatado}.";
                } else {
                    $mensagem = 'A sala já está reservada neste horário.';
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $mensagem,
                'data' => [
                    'disponivel' => $disponivel,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao verificar disponibilidade', [
                'erro' => $e->getMessage(),
                'dados' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
