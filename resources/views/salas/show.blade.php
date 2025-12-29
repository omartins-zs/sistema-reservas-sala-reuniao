@extends('layouts.app')

@section('title', 'Detalhes da Sala')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $sala->nome }}</h1>
            <p class="mt-2 text-sm text-gray-600">Informações completas da sala</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('salas.edit', $sala) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                Editar
            </a>
            <a href="{{ route('salas.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Informações da Sala</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nome</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $sala->nome }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Capacidade</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $sala->capacidade }} pessoas</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Localização</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $sala->localizacao ?? 'Não informado' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Horário de Funcionamento</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $sala->horario_abertura ?? '08:00' }} - {{ $sala->horario_fechamento ?? '18:00' }}</dd>
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
                                    <p class="text-sm font-medium text-gray-900">{{ $reserva->usuario->nome }}</p>
                                    <p class="text-sm text-gray-500">{{ $reserva->data_reserva->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $reserva->horario_inicio }} - {{ $reserva->horario_fim }}</p>
                                </div>
                                <a href="{{ route('reservas.show', $reserva) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Ver
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">Nenhuma reserva para esta sala.</p>
            @endif
        </div>
    </div>
</div>
@endsection

