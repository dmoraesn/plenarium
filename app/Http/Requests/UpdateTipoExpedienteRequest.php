<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoExpedienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste com Policies se necessário
    }

    public function rules(): array
    {
        $id = $this->route('tipoExpediente')?->id ?? $this->route('tipoExpediente');

        return [
            'descricao'  => [
                'required','string','max:150',
                Rule::unique('tipo_expediente', 'descricao')->ignore($id),
            ],
            'ordenacao'  => ['nullable','integer','min:0'],
            'observacao' => ['nullable','string'],
            'ativo'      => ['sometimes','boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'descricao'  => 'descrição',
            'ordenacao'  => 'ordenação',
            'observacao' => 'observação',
            'ativo'      => 'ativo',
        ];
    }
}
