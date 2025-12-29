@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Novo Usuário</h1>
        <p class="mt-2 text-sm text-gray-600">Preencha os dados para criar um novo usuário</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="nome">
                        <span class="text-sm font-medium text-gray-700">Nome *</span>
                        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('nome')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email">
                        <span class="text-sm font-medium text-gray-700">Email *</span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="departamento">
                        <span class="text-sm font-medium text-gray-700">Departamento</span>
                        <input type="text" name="departamento" id="departamento" value="{{ old('departamento') }}" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('departamento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telefone">
                        <span class="text-sm font-medium text-gray-700">Telefone</span>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('telefone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('usuarios.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Criar Usuário
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

