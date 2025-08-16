<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CargoMesaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $id = $this->route('cargoMesa')?->id;

        return [
            'descricao'         => ['required', 'string', 'max:100', 'unique:cargo_mesa,descricao,' . $id],
            'posicao_ordenacao' => ['nullable', 'integer'],
            'cargo_unico'       => ['boolean'],
            'observacao'        => ['nullable', 'string'],
            'ativo'             => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cargo_unico' => (bool) $this->boolean('cargo_unico'),
            'ativo'       => (bool) $this->boolean('ativo'),
        ]);
    }
}
