<?php

namespace App\Services;

use App\Models\Sala;
use Illuminate\Support\Facades\Log;

class SalaService
{
    /**
     * Cria uma nova sala
     *
     * @param array $dados
     * @return Sala
     */
    public function criarSala(array $dados): Sala
    {
        $sala = Sala::create($dados);

        Log::info('Sala criada com sucesso', [
            'sala_id' => $sala->id,
            'nome' => $sala->nome,
        ]);

        return $sala;
    }

    /**
     * Atualiza uma sala existente
     *
     * @param int $salaId
     * @param array $dados
     * @return Sala
     */
    public function atualizarSala(int $salaId, array $dados): Sala
    {
        $sala = Sala::findOrFail($salaId);
        $sala->update($dados);
        $sala->refresh();

        Log::info('Sala atualizada com sucesso', [
            'sala_id' => $sala->id,
        ]);

        return $sala;
    }

    /**
     * Lista todas as salas
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listarSalas()
    {
        return Sala::withCount('reservas')->get();
    }
}

