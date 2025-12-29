<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservaRequest extends FormRequest
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
            'usuario_id' => ['sometimes', 'integer', 'exists:usuarios,id'],
            'sala_id' => ['sometimes', 'integer', 'exists:salas,id'],
            'data_reserva' => ['sometimes', 'date', 'after_or_equal:today'],
            'horario_inicio' => ['sometimes', 'date_format:H:i'],
            'horario_fim' => ['sometimes', 'date_format:H:i', 'after:horario_inicio'],
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
            'usuario_id.exists' => 'O usuário informado não existe.',
            'sala_id.exists' => 'A sala informada não existe.',
            'data_reserva.date' => 'A data da reserva deve ser uma data válida.',
            'data_reserva.after_or_equal' => 'A data da reserva não pode ser anterior a hoje.',
            'horario_inicio.date_format' => 'O horário de início deve estar no formato HH:mm.',
            'horario_fim.date_format' => 'O horário de término deve estar no formato HH:mm.',
            'horario_fim.after' => 'O horário de término deve ser posterior ao horário de início.',
        ];
    }
}
