<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalaRequest;
use App\Http\Requests\UpdateSalaRequest;
use App\Models\Sala;
use App\Services\SalaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SalaController extends Controller
{
    public function __construct(
        private SalaService $salaService
    ) {
    }

    /**
     * Lista todas as salas
     */
    public function index(): JsonResponse
    {
        try {
            $salas = $this->salaService->listarSalas();

            return response()->json([
                'status' => 'success',
                'message' => 'Salas listadas com sucesso.',
                'data' => $salas,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar salas', ['erro' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao listar salas.',
            ], 500);
        }
    }

    /**
     * Cria uma nova sala
     */
    public function store(StoreSalaRequest $request): JsonResponse
    {
        try {
            $sala = $this->salaService->criarSala($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Sala criada com sucesso.',
                'data' => $sala,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar sala', [
                'erro' => $e->getMessage(),
                'dados' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao criar sala.',
            ], 500);
        }
    }

    /**
     * Exibe uma sala específica
     */
    public function show(string $id): JsonResponse
    {
        try {
            $sala = Sala::withCount('reservas')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Sala encontrada.',
                'data' => $sala,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar sala', [
                'erro' => $e->getMessage(),
                'sala_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Sala não encontrada.',
            ], 404);
        }
    }

    /**
     * Atualiza uma sala existente
     */
    public function update(UpdateSalaRequest $request, string $id): JsonResponse
    {
        try {
            $sala = $this->salaService->atualizarSala($id, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Sala atualizada com sucesso.',
                'data' => $sala,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar sala', [
                'erro' => $e->getMessage(),
                'sala_id' => $id,
                'dados' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Sala não encontrada.',
            ], 404);
        }
    }

    /**
     * Remove uma sala
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $sala = Sala::findOrFail($id);
            $sala->delete();

            Log::info('Sala removida com sucesso', ['sala_id' => $id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Sala removida com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao remover sala', [
                'erro' => $e->getMessage(),
                'sala_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Sala não encontrada.',
            ], 404);
        }
    }
}
