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
    public function verificarHorarioFuncionamento(
        Sala $sala,
        string $horarioInicio,
        string $horarioFim
    ): bool {
        $horarioAbertura = $sala->horario_abertura ?? '08:00:00';
        $horarioFechamento = $sala->horario_fechamento ?? '18:00:00';

        $horarioAberturaFormatado = substr($horarioAbertura, 0, 5);
        $horarioFechamentoFormatado = substr($horarioFechamento, 0, 5);
        $horarioInicioFormatado = substr($horarioInicio, 0, 5);
        $horarioFimFormatado = substr($horarioFim, 0, 5);

        if ($horarioInicioFormatado < $horarioAberturaFormatado) {
            throw new \Exception("A sala está disponível apenas a partir das {$horarioAberturaFormatado}.");
        }

        if ($horarioFimFormatado > $horarioFechamentoFormatado) {
            throw new \Exception("A sala está disponível apenas até às {$horarioFechamentoFormatado}.");
        }

        if ($horarioInicioFormatado >= $horarioFimFormatado) {
            throw new \Exception("O horário de início deve ser anterior ao horário de término.");
        }

        return true;
    }

    public function verificarConflitoHorario(
        int $salaId,
        string $dataReserva,
        string $horarioInicio,
        string $horarioFim,
        ?int $reservaIdExcluir = null
    ): bool {
        $horarioInicioNormalizado = strlen($horarioInicio) === 5 ? $horarioInicio . ':00' : $horarioInicio;
        $horarioFimNormalizado = strlen($horarioFim) === 5 ? $horarioFim . ':00' : $horarioFim;
        $query = Reserva::where('sala_id', $salaId)
            ->where('data_reserva', $dataReserva)
            ->where(function($q) use ($horarioInicioNormalizado, $horarioFimNormalizado) {
                $q->whereRaw('CAST(horario_inicio AS CHAR) < ?', [$horarioFimNormalizado])
                  ->whereRaw('CAST(horario_fim AS CHAR) > ?', [$horarioInicioNormalizado]);
            });

        if ($reservaIdExcluir) {
            $query->where('id', '!=', $reservaIdExcluir);
        }

        return $query->exists();
    }

    public function criarReserva(array $dados): Reserva
    {
        DB::beginTransaction();

        try {
            $sala = Sala::findOrFail($dados['sala_id']);
            $usuario = Usuario::findOrFail($dados['usuario_id']);
            $this->verificarHorarioFuncionamento(
                $sala,
                $dados['horario_inicio'],
                $dados['horario_fim']
            );

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

                throw new ConflitoHorarioException('A sala já está reservada neste horário.');
            }

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

    public function atualizarReserva(int $reservaId, array $dados): Reserva
    {
        DB::beginTransaction();

        try {
            $reserva = Reserva::findOrFail($reservaId);

            $salaId = $dados['sala_id'] ?? $reserva->sala_id;
            $sala = Sala::findOrFail($salaId);

            if (isset($dados['usuario_id'])) {
                Usuario::findOrFail($dados['usuario_id']);
            }
            $dataReserva = $dados['data_reserva'] ?? $reserva->data_reserva;
            $horarioInicio = $dados['horario_inicio'] ?? $reserva->horario_inicio;
            $horarioFim = $dados['horario_fim'] ?? $reserva->horario_fim;

            $this->verificarHorarioFuncionamento(
                $sala,
                $horarioInicio,
                $horarioFim
            );

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

                throw new ConflitoHorarioException('A sala já está reservada neste horário.');
            }

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

    public function listarReservasPorSala(int $salaId)
    {
        $sala = Sala::findOrFail($salaId);

        return Reserva::where('sala_id', $salaId)
            ->with(['usuario', 'sala'])
            ->orderBy('data_reserva')
            ->orderBy('horario_inicio')
            ->get();
    }

    public function listarReservasPorUsuario(int $usuarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);

        return Reserva::where('usuario_id', $usuarioId)
            ->with(['usuario', 'sala'])
            ->orderBy('data_reserva')
            ->orderBy('horario_inicio')
            ->get();
    }

    public function verificarDisponibilidade(
        int $salaId,
        string $dataReserva,
        string $horarioInicio,
        string $horarioFim
    ): bool {
        $sala = Sala::findOrFail($salaId);
        
        try {
            $this->verificarHorarioFuncionamento($sala, $horarioInicio, $horarioFim);
        } catch (\Exception $e) {
            return false;
        }
        
        return !$this->verificarConflitoHorario($salaId, $dataReserva, $horarioInicio, $horarioFim);
    }
}

