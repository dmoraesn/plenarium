<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoNormaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $id = $this->route('tipoNorma')?->id;

        return [
            'descricao' => ['required', 'string', 'max:150', 'unique:tipo_norma,descricao,' . $id],
            'sigla'     => ['nullable', 'string', 'max:20', 'unique:tipo_norma,sigla,' . $id],
            'ativo'     => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('ativo') === false) {
            $this->merge(['ativo' => false]);
        }
    }
}
