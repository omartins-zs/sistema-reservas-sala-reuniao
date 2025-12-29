@extends('layouts.app')

@section('title', 'Detalhes da Reserva')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detalhes da Reserva</h1>
            <p class="mt-2 text-sm text-gray-600">Informações completas da reserva</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('reservas.edit', $reserva) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                Editar
            </a>
            <a href="{{ route('reservas.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Voltar
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Informações da Reserva</h2>
        </div>
        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Sala</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->sala->nome }}</dd>
                    <dd class="mt-1 text-sm text-gray-500">{{ $reserva->sala->localizacao }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Capacidade</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->sala->capacidade }} pessoas</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Usuário</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->usuario->nome }}</dd>
                    <dd class="mt-1 text-sm text-gray-500">{{ $reserva->usuario->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->usuario->departamento ?? 'Não informado' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Data da Reserva</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->data_reserva->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Horário</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->horario_inicio }} - {{ $reserva->horario_fim }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Criada em</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Última atualização</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $reserva->updated_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection

