@extends('layouts.app')

@section('title', 'Editar Reserva')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Editar Reserva</h1>
        <p class="mt-2 text-sm text-gray-600">Atualize os dados da reserva</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('reservas.update', $reserva) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="usuario_id">
                        <span class="text-sm font-medium text-gray-700">Usuário *</span>
                        <select name="usuario_id" id="usuario_id" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $reserva->usuario_id == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nome }} - {{ $usuario->email }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    @error('usuario_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sala_id">
                        <span class="text-sm font-medium text-gray-700">Sala *</span>
                        <select name="sala_id" id="sala_id" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                            @foreach($salas as $sala)
                                <option value="{{ $sala->id }}" {{ $reserva->sala_id == $sala->id ? 'selected' : '' }}>
                                    {{ $sala->nome }} (Capacidade: {{ $sala->capacidade }})
                                </option>
                            @endforeach
                        </select>
                    </label>
                    @error('sala_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_reserva">
                        <span class="text-sm font-medium text-gray-700">Data da Reserva *</span>
                        <input type="date" name="data_reserva" id="data_reserva" value="{{ old('data_reserva', $reserva->data_reserva->format('Y-m-d')) }}" required min="{{ date('Y-m-d') }}" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('data_reserva')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario_inicio">
                        <span class="text-sm font-medium text-gray-700">Horário de Início *</span>
                        <input type="time" name="horario_inicio" id="horario_inicio" value="{{ old('horario_inicio', $reserva->horario_inicio) }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('horario_inicio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario_fim">
                        <span class="text-sm font-medium text-gray-700">Horário de Término *</span>
                        <input type="time" name="horario_fim" id="horario_fim" value="{{ old('horario_fim', $reserva->horario_fim) }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('horario_fim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('reservas.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Atualizar Reserva
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

