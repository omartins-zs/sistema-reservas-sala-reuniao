<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalaRequest;
use App\Http\Requests\UpdateSalaRequest;
use App\Models\Sala;
use App\Services\SalaService;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    public function __construct(
        private SalaService $salaService
    ) {
    }

    public function index()
    {
        $salas = $this->salaService->listarSalas();

        return view('salas.index', compact('salas'));
    }

    public function create()
    {
        return view('salas.create');
    }

    public function store(StoreSalaRequest $request)
    {
        try {
            $this->salaService->criarSala($request->validated());

            return redirect()->route('salas.index')
                ->with('success', 'Sala criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar sala.');
        }
    }

    public function show(Sala $sala)
    {
        $reservas = $sala->reservas()
            ->with('usuario')
            ->orderBy('data_reserva')
            ->orderBy('horario_inicio')
            ->get();

        return view('salas.show', compact('sala', 'reservas'));
    }

    public function edit(Sala $sala)
    {
        return view('salas.edit', compact('sala'));
    }

    public function update(UpdateSalaRequest $request, Sala $sala)
    {
        try {
            $this->salaService->atualizarSala($sala->id, $request->validated());

            return redirect()->route('salas.index')
                ->with('success', 'Sala atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar sala.');
        }
    }

    public function destroy(Sala $sala)
    {
        try {
            $sala->delete();

            return redirect()->route('salas.index')
                ->with('success', 'Sala removida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover sala.');
        }
    }
}
