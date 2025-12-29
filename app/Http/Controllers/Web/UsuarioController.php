<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct(
        private UsuarioService $usuarioService
    ) {
    }

    public function index()
    {
        $usuarios = $this->usuarioService->listarUsuarios();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(StoreUsuarioRequest $request)
    {
        try {
            $this->usuarioService->criarUsuario($request->validated());

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar usuário.');
        }
    }

    public function show(Usuario $usuario)
    {
        $reservas = $usuario->reservas()
            ->with('sala')
            ->orderBy('data_reserva', 'desc')
            ->orderBy('horario_inicio', 'desc')
            ->get();

        return view('usuarios.show', compact('usuario', 'reservas'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        try {
            $this->usuarioService->atualizarUsuario($usuario->id, $request->validated());

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar usuário.');
        }
    }

    public function destroy(Usuario $usuario)
    {
        try {
            $usuario->delete();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuário removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover usuário.');
        }
    }
}
