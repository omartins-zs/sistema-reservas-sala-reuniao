<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'sala_id' => ['required', 'integer', 'exists:salas,id'],
            'data_reserva' => ['required', 'date', 'after_or_equal:today'],
            'horario_inicio' => ['required', 'date_format:H:i'],
            'horario_fim' => ['required', 'date_format:H:i', 'after:horario_inicio'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'usuario_id.required' => 'O ID do usuário é obrigatório.',
            'usuario_id.exists' => 'O usuário informado não existe.',
            'sala_id.required' => 'O ID da sala é obrigatório.',
            'sala_id.exists' => 'A sala informada não existe.',
            'data_reserva.required' => 'A data da reserva é obrigatória.',
            'data_reserva.date' => 'A data da reserva deve ser uma data válida.',
            'data_reserva.after_or_equal' => 'A data da reserva não pode ser anterior a hoje.',
            'horario_inicio.required' => 'O horário de início é obrigatório.',
            'horario_inicio.date_format' => 'O horário de início deve estar no formato HH:mm.',
            'horario_fim.required' => 'O horário de término é obrigatório.',
            'horario_fim.date_format' => 'O horário de término deve estar no formato HH:mm.',
            'horario_fim.after' => 'O horário de término deve ser posterior ao horário de início.',
        ];
    }
}
