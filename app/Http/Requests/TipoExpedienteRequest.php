<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoExpedienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $id = $this->route('tipoExpediente')?->id;

        return [
            'descricao'  => ['required', 'string', 'max:150', 'unique:tipo_expediente,descricao,' . $id],
            'ordenacao'  => ['nullable', 'integer'],
            'observacao' => ['nullable', 'string'],
            'ativo'      => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('ativo') === false) {
            $this->merge(['ativo' => false]);
        }
    }
}
