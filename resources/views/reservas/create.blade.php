@extends('layouts.app')

@section('title', 'Nova Reserva')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Nova Reserva</h1>
        <p class="mt-2 text-sm text-gray-600">Preencha os dados para criar uma nova reserva</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('reservas.store') }}" method="POST" id="reservaForm">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="usuario_id">
                        <span class="text-sm font-medium text-gray-700">Usuário *</span>
                        <select name="usuario_id" id="usuario_id" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                            <option value="">Selecione um usuário</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
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
                            <option value="">Selecione uma sala</option>
                            @foreach($salas as $sala)
                                <option value="{{ $sala->id }}" 
                                    data-horario-abertura="{{ $sala->horario_abertura ?? '08:00' }}"
                                    data-horario-fechamento="{{ $sala->horario_fechamento ?? '18:00' }}"
                                    {{ old('sala_id') == $sala->id ? 'selected' : '' }}>
                                    {{ $sala->nome }} (Capacidade: {{ $sala->capacidade }}) - {{ $sala->horario_abertura ?? '08:00' }} às {{ $sala->horario_fechamento ?? '18:00' }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <p id="horario-funcionamento" class="mt-1 text-sm text-gray-500 hidden"></p>
                    @error('sala_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_reserva">
                        <span class="text-sm font-medium text-gray-700">Data da Reserva *</span>
                        <input type="date" name="data_reserva" id="data_reserva" value="{{ old('data_reserva') }}" required min="{{ date('Y-m-d') }}" class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('data_reserva')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario_inicio">
                        <span class="text-sm font-medium text-gray-700">Horário de Início *</span>
                        <input type="time" name="horario_inicio" id="horario_inicio" value="{{ old('horario_inicio') }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('horario_inicio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario_fim">
                        <span class="text-sm font-medium text-gray-700">Horário de Término *</span>
                        <input type="time" name="horario_fim" id="horario_fim" value="{{ old('horario_fim') }}" required class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                    </label>
                    @error('horario_fim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <div id="disponibilidade" class="hidden p-4 rounded-md"></div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('reservas.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Criar Reserva
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const salaSelect = document.getElementById('sala_id');
    const dataInput = document.getElementById('data_reserva');
    const horarioInicioInput = document.getElementById('horario_inicio');
    const horarioFimInput = document.getElementById('horario_fim');
    const disponibilidadeDiv = document.getElementById('disponibilidade');
    const horarioFuncionamentoP = document.getElementById('horario-funcionamento');

    // Mostra horário de funcionamento quando seleciona uma sala
    salaSelect.addEventListener('change', function() {
        const selectedOption = salaSelect.options[salaSelect.selectedIndex];
        if (selectedOption.value) {
            const horarioAbertura = selectedOption.getAttribute('data-horario-abertura');
            const horarioFechamento = selectedOption.getAttribute('data-horario-fechamento');
            horarioFuncionamentoP.textContent = `Horário de funcionamento: ${horarioAbertura} às ${horarioFechamento}`;
            horarioFuncionamentoP.classList.remove('hidden');
        } else {
            horarioFuncionamentoP.classList.add('hidden');
        }
        verificarDisponibilidade();
    });

    function verificarDisponibilidade() {
        if (!salaSelect.value || !dataInput.value || !horarioInicioInput.value || !horarioFimInput.value) {
            disponibilidadeDiv.classList.add('hidden');
            return;
        }

        fetch('{{ route("reservas.verificar-disponibilidade") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                sala_id: salaSelect.value,
                data_reserva: dataInput.value,
                horario_inicio: horarioInicioInput.value,
                horario_fim: horarioFimInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            disponibilidadeDiv.classList.remove('hidden');
            if (data.disponivel) {
                disponibilidadeDiv.className = 'p-4 rounded-md bg-green-50 border border-green-200';
                disponibilidadeDiv.innerHTML = '<p class="text-sm text-green-800">✓ ' + data.message + '</p>';
            } else {
                disponibilidadeDiv.className = 'p-4 rounded-md bg-red-50 border border-red-200';
                disponibilidadeDiv.innerHTML = '<p class="text-sm text-red-800">✗ ' + data.message + '</p>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            disponibilidadeDiv.classList.remove('hidden');
            disponibilidadeDiv.className = 'p-4 rounded-md bg-red-50 border border-red-200';
            disponibilidadeDiv.innerHTML = '<p class="text-sm text-red-800">✗ Erro ao verificar disponibilidade.</p>';
        });
    }

    // Inicializa horário de funcionamento se já houver sala selecionada
    if (salaSelect.value) {
        salaSelect.dispatchEvent(new Event('change'));
    }

    dataInput.addEventListener('change', verificarDisponibilidade);
    horarioInicioInput.addEventListener('change', verificarDisponibilidade);
    horarioFimInput.addEventListener('change', verificarDisponibilidade);
});
</script>
@endsection

