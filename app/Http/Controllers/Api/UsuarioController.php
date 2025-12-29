<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    public function __construct(
        private UsuarioService $usuarioService
    ) {
    }

    /**
     * Lista todos os usuários
     */
    public function index(): JsonResponse
    {
        try {
            $usuarios = $this->usuarioService->listarUsuarios();

            return response()->json([
                'status' => 'success',
                'message' => 'Usuários listados com sucesso.',
                'data' => $usuarios,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar usuários', ['erro' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao listar usuários.',
            ], 500);
        }
    }

    /**
     * Cria um novo usuário
     */
    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        try {
            $usuario = $this->usuarioService->criarUsuario($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário criado com sucesso.',
                'data' => $usuario,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário', [
                'erro' => $e->getMessage(),
                'dados' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao criar usuário.',
            ], 500);
        }
    }

    /**
     * Exibe um usuário específico
     */
    public function show(string $id): JsonResponse
    {
        try {
            $usuario = Usuario::withCount('reservas')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário encontrado.',
                'data' => $usuario,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar usuário', [
                'erro' => $e->getMessage(),
                'usuario_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado.',
            ], 404);
        }
    }

    /**
     * Atualiza um usuário existente
     */
    public function update(UpdateUsuarioRequest $request, string $id): JsonResponse
    {
        try {
            $usuario = $this->usuarioService->atualizarUsuario($id, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário atualizado com sucesso.',
                'data' => $usuario,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário', [
                'erro' => $e->getMessage(),
                'usuario_id' => $id,
                'dados' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado.',
            ], 404);
        }
    }

    /**
     * Remove um usuário
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();

            Log::info('Usuário removido com sucesso', ['usuario_id' => $id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuário removido com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao remover usuário', [
                'erro' => $e->getMessage(),
                'usuario_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não encontrado.',
            ], 404);
        }
    }
}
