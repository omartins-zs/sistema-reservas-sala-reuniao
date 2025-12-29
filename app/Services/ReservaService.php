<?php

namespace App\Services;

use App\Exceptions\ConflitoHorarioException;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservaService
{
    /**
     * Verifica se existe conflito de horário para uma reserva
     *
     * @param int $salaId
     * @param string $dataReserva
     * @param string $horarioInicio
     * @param string $horarioFim
     * @param int|null $reservaIdExcluir (para atualização, excluir a própria reserva da verificação)
     * @return bool
     */
    public function verificarConflitoHorario(
        int $salaId,
        string $dataReserva,
        string $horarioInicio,
        string $horarioFim,
        ?int $reservaIdExcluir = null
    ): bool {
        // Verifica sobreposição de intervalos de tempo
        // Dois intervalos se sobrepõem se:
        // inicio_novo < fim_existente AND fim_novo > inicio_existente
        $query = Reserva::where('sala_id', $salaId)
            ->where('data_reserva', $dataReserva)
            ->where('horario_inicio', '<', $horarioFim)
            ->where('horario_fim', '>', $horarioInicio);

        if ($reservaIdExcluir) {
            $query->where('id', '!=', $reservaIdExcluir);
        }

        return $query->exists();
    }

    /**
     * Cria uma nova reserva após validar disponibilidade
     *
     * @param array $dados
     * @return Reserva
     * @throws \Exception
     */
    public function criarReserva(array $dados): Reserva
    {
        DB::beginTransaction();

        try {
            // Valida se a sala existe
            $sala = Sala::findOrFail($dados['sala_id']);

            // Valida se o usuário existe
            $usuario = Usuario::findOrFail($dados['usuario_id']);

            // Verifica conflito de horário
            if ($this->verificarConflitoHorario(
                $dados['sala_id'],
                $dados['data_reserva'],
                $dados['horario_inicio'],
                $dados['horario_fim']
            )) {
                Log::warning('Tentativa de reserva com conflito de horário', [
                    'sala_id' => $dados['sala_id'],
                    'data_reserva' => $dados['data_reserva'],
                    'horario_inicio' => $dados['horario_inicio'],
                    'horario_fim' => $dados['horario_fim'],
                ]);

                throw new ConflitoHorarioException();
            }

            // Cria a reserva
            $reserva = Reserva::create($dados);

            Log::info('Reserva criada com sucesso', [
                'reserva_id' => $reserva->id,
                'sala_id' => $reserva->sala_id,
                'usuario_id' => $reserva->usuario_id,
            ]);

            DB::commit();

            return $reserva->load(['usuario', 'sala']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar reserva', [
                'erro' => $e->getMessage(),
                'dados' => $dados,
            ]);
            throw $e;
        }
    }

    /**
     * Atualiza uma reserva existente após validar disponibilidade
     *
     * @param int $reservaId
     * @param array $dados
     * @return Reserva
     * @throws \Exception
     */
    public function atualizarReserva(int $reservaId, array $dados): Reserva
    {
        DB::beginTransaction();

        try {
            $reserva = Reserva::findOrFail($reservaId);

            // Valida se a sala existe (se foi alterada)
            if (isset($dados['sala_id'])) {
                Sala::findOrFail($dados['sala_id']);
            }

            // Valida se o usuário existe (se foi alterado)
            if (isset($dados['usuario_id'])) {
                Usuario::findOrFail($dados['usuario_id']);
            }

            // Verifica conflito de horário (excluindo a própria reserva)
            $salaId = $dados['sala_id'] ?? $reserva->sala_id;
            $dataReserva = $dados['data_reserva'] ?? $reserva->data_reserva;
            $horarioInicio = $dados['horario_inicio'] ?? $reserva->horario_inicio;
            $horarioFim = $dados['horario_fim'] ?? $reserva->horario_fim;

            if ($this->verificarConflitoHorario(
                $salaId,
                $dataReserva,
                $horarioInicio,
                $horarioFim,
                $reservaId
            )) {
                Log::warning('Tentativa de atualização de reserva com conflito de horário', [
                    'reserva_id' => $reservaId,
                    'sala_id' => $salaId,
                    'data_reserva' => $dataReserva,
                    'horario_inicio' => $horarioInicio,
                    'horario_fim' => $horarioFim,
                ]);

                throw new ConflitoHorarioException();
            }

            // Atualiza a reserva
            $reserva->update($dados);
            $reserva->refresh();

            Log::info('Reserva atualizada com sucesso', [
                'reserva_id' => $reserva->id,
            ]);

            DB::commit();

            return $reserva->load(['usuario', 'sala']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar reserva', [
                'erro' => $e->getMessage(),
                'reserva_id' => $reservaId,
                'dados' => $dados,
            ]);
            throw $e;
        }
    }

    /**
     * Lista todas as reservas de uma sala
     *
     * @param int $salaId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listarReservasPorSala(int $salaId)
    {
        $sala = Sala::findOrFail($salaId);

        return Reserva::where('sala_id', $salaId)
            ->with(['usuario', 'sala'])
            ->orderBy('data_reserva')
            ->orderBy('horario_inicio')
            ->get();
    }

    /**
     * Lista todas as reservas de um usuário
     *
     * @param int $usuarioId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listarReservasPorUsuario(int $usuarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);

        return Reserva::where('usuario_id', $usuarioId)
            ->with(['usuario', 'sala'])
            ->orderBy('data_reserva')
            ->orderBy('horario_inicio')
            ->get();
    }

    /**
     * Verifica disponibilidade de uma sala em um período específico
     *
     * @param int $salaId
     * @param string $dataReserva
     * @param string $horarioInicio
     * @param string $horarioFim
     * @return bool
     */
    public function verificarDisponibilidade(
        int $salaId,
        string $dataReserva,
        string $horarioInicio,
        string $horarioFim
    ): bool {
        return !$this->verificarConflitoHorario($salaId, $dataReserva, $horarioInicio, $horarioFim);
    }
}

