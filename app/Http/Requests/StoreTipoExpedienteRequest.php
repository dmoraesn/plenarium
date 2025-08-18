<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoExpedienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste com Policies se necessário
    }

    public function rules(): array
    {
        return [
            'descricao'  => ['required','string','max:150','unique:tipo_expediente,descricao'],
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
