<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegislaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'numero'        => ['nullable', 'integer', 'min:1'],
            'data_eleicao'  => ['nullable', 'date'],
            'data_inicio'   => ['required', 'date'],
            'data_fim'      => ['required', 'date', 'after:data_inicio'],
            'observacao'    => ['nullable', 'string'],
            'ativo'         => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('ativo') === false) {
            $this->merge(['ativo' => false]);
        }
    }
}
