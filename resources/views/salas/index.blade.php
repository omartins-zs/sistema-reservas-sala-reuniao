@extends('layouts.app')

@section('title', 'Salas')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Salas</h1>
            <p class="mt-2 text-sm text-gray-600">Gerencie todas as salas disponíveis</p>
        </div>
        <a href="{{ route('salas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Sala
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($salas as $sala)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">{{ $sala->nome }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $sala->localizacao }}</p>
                            <p class="mt-1 text-xs text-gray-400">{{ $sala->horario_abertura ?? '08:00' }} - {{ $sala->horario_fechamento ?? '18:00' }}</p>
                        </div>
                        <div class="ml-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                {{ $sala->capacidade }} pessoas
                            </span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">{{ $sala->reservas_count ?? 0 }}</span> reservas
                        </p>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <button type="button" onclick="window.location.href='{{ route('salas.show', $sala) }}'" class="flex-1 text-center inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Ver
                        </button>
                        <button type="button" onclick="window.location.href='{{ route('salas.edit', $sala) }}'" class="flex-1 text-center inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                            Editar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($salas->count() == 0)
        <div class="bg-white shadow rounded-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma sala cadastrada</h3>
            <p class="mt-1 text-sm text-gray-500">Comece criando uma nova sala.</p>
            <div class="mt-6">
                <a href="{{ route('salas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Nova Sala
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

