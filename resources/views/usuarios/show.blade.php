@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $usuario->nome }}</h1>
            <p class="mt-2 text-sm text-gray-600">Informações completas do usuário</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Informações do Usuário</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nome</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $usuario->nome }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $usuario->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $usuario->departamento ?? 'Não informado' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $usuario->telefone ?? 'Não informado' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total de Reservas</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reservas->count() }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Reservas</h2>
            @if($reservas->count() > 0)
                <div class="space-y-4">
                    @foreach($reservas as $reserva)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $reserva->sala->nome }}</p>
                                    <p class="text-sm text-gray-500">{{ $reserva->data_reserva->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $reserva->horario_inicio }} - {{ $reserva->horario_fim }}</p>
                                </div>
                                <a href="{{ route('reservas.show', $reserva) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Ver
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">Nenhuma reserva para este usuário.</p>
            @endif
        </div>
    </div>
</div>
@endsection

