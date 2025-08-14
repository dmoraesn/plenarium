<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // importante!
    }

    public function rules(): array
    {
        return [
            'tipo_materia_id' => ['required', 'exists:tipo_materias,id'],
            'numero'          => ['required', 'integer', 'min:1'],
            'ano'             => ['required', 'integer', 'digits:4'],
            'ementa'          => ['required', 'string', 'max:5000'],
            'status'          => ['required', 'in:rascunho,pronta_pauta,arquivada,aprovada,rejeitada,retirada'],
            'autores'         => ['array'],
            'autores.*'       => ['exists:vereadores,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_materia_id.required' => 'Selecione o tipo.',
            'ementa.required'          => 'A ementa é obrigatória.',
        ];
    }
}
