<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoMateriaRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação para criação/atualização de Tipo de Matéria.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sigla' => ['sometimes', 'required', 'string', 'max:10'],
            'nome'  => ['sometimes', 'required', 'string', 'max:100'],
            'ativo' => ['nullable', 'boolean'], // ← ajuste para o toggle
        ];
    }
}
