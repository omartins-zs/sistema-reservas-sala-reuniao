@extends('layouts.app')

@section('title', 'Editar Sala')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Editar Sala</h1>
        <p class="mt-2 text-sm text-gray-600">Atualize os dados da sala</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
        <form action="{{ route('salas.update', $sala) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="nome">
                        <span class="text-sm font-medium text-gray-700">Nome da Sala *</span>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', $sala->nome) }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('nome')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacidade">
                        <span class="text-sm font-medium text-gray-700">Capacidade *</span>
                        <input type="number" name="capacidade" id="capacidade" value="{{ old('capacidade', $sala->capacidade) }}" required min="1" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('capacidade')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="localizacao">
                        <span class="text-sm font-medium text-gray-700">Localização</span>
                        <input type="text" name="localizacao" id="localizacao" value="{{ old('localizacao', $sala->localizacao) }}" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('localizacao')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario_abertura">
                        <span class="text-sm font-medium text-gray-700">Horário de Abertura *</span>
                        <input type="time" name="horario_abertura" id="horario_abertura" value="{{ old('horario_abertura', $sala->horario_abertura ?? '08:00') }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('horario_abertura')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario_fechamento">
                        <span class="text-sm font-medium text-gray-700">Horário de Fechamento *</span>
                        <input type="time" name="horario_fechamento" id="horario_fechamento" value="{{ old('horario_fechamento', $sala->horario_fechamento ?? '18:00') }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('horario_fechamento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('salas.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Atualizar Sala
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

