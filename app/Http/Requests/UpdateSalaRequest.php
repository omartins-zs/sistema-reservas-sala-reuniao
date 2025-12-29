<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalaRequest extends FormRequest
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
            'nome' => ['sometimes', 'string', 'max:100'],
            'capacidade' => ['sometimes', 'integer', 'min:1'],
            'localizacao' => ['nullable', 'string', 'max:200'],
            'horario_abertura' => ['sometimes', 'date_format:H:i'],
            'horario_fechamento' => ['sometimes', 'date_format:H:i', 'after:horario_abertura'],
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
            'nome.max' => 'O nome da sala não pode ter mais de 100 caracteres.',
            'capacidade.integer' => 'A capacidade deve ser um número inteiro.',
            'capacidade.min' => 'A capacidade deve ser no mínimo 1 pessoa.',
            'localizacao.max' => 'A localização não pode ter mais de 200 caracteres.',
            'horario_abertura.date_format' => 'O horário de abertura deve estar no formato HH:mm.',
            'horario_fechamento.date_format' => 'O horário de fechamento deve estar no formato HH:mm.',
            'horario_fechamento.after' => 'O horário de fechamento deve ser posterior ao horário de abertura.',
        ];
    }
}
