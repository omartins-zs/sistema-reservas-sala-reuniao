@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reservas</h1>
            <p class="mt-2 text-sm text-gray-600">Gerencie todas as reservas de salas</p>
        </div>
        <a href="{{ route('reservas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Reserva
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('reservas.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div>
                <label for="sala_id">
                    <span class="text-sm font-medium text-gray-700">Sala</span>
                    <select name="sala_id" id="sala_id" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                        <option value="">Todas</option>
                        @foreach($salas as $sala)
                            <option value="{{ $sala->id }}" {{ request('sala_id') == $sala->id ? 'selected' : '' }}>
                                {{ $sala->nome }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div>
                <label for="usuario_id">
                    <span class="text-sm font-medium text-gray-700">Usuário</span>
                    <select name="usuario_id" id="usuario_id" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                        <option value="">Todos</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nome }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div>
                <label for="data_reserva">
                    <span class="text-sm font-medium text-gray-700">Data</span>
                    <input type="date" name="data_reserva" id="data_reserva" value="{{ request('data_reserva') }}" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                </label>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        @if($reservas->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sala</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horário</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reservas as $reserva)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $reserva->sala->nome }}</div>
                                <div class="text-sm text-gray-500">{{ $reserva->sala->localizacao }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reserva->usuario->nome }}</div>
                                <div class="text-sm text-gray-500">{{ $reserva->usuario->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $reserva->data_reserva->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $reserva->horario_inicio }} - {{ $reserva->horario_fim }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('reservas.show', $reserva) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        Ver
                                    </a>
                                    <a href="{{ route('reservas.edit', $reserva) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                        Editar
                                    </a>
                                    <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover esta reserva?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                            Remover
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reservas->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma reserva encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">Comece criando uma nova reserva.</p>
                <div class="mt-6">
                    <a href="{{ route('reservas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Nova Reserva
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

