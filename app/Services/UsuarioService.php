<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Log;

class UsuarioService
{
    /**
     * Cria um novo usuário
     *
     * @param array $dados
     * @return Usuario
     */
    public function criarUsuario(array $dados): Usuario
    {
        $usuario = Usuario::create($dados);

        Log::info('Usuário criado com sucesso', [
            'usuario_id' => $usuario->id,
            'email' => $usuario->email,
        ]);

        return $usuario;
    }

    /**
     * Atualiza um usuário existente
     *
     * @param int $usuarioId
     * @param array $dados
     * @return Usuario
     */
    public function atualizarUsuario(int $usuarioId, array $dados): Usuario
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $usuario->update($dados);
        $usuario->refresh();

        Log::info('Usuário atualizado com sucesso', [
            'usuario_id' => $usuario->id,
        ]);

        return $usuario;
    }

    /**
     * Lista todos os usuários
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listarUsuarios()
    {
        return Usuario::withCount('reservas')->get();
    }
}

