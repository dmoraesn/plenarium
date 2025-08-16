<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TipoNormaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // nome do parâmetro conforme as rotas: ->parameters(['tipo-normas' => 'tipoNorma'])
        $id = $this->route('tipoNorma')?->id;

        return [
            'descricao' => ['required', 'string', 'max:150', Rule::unique('tipo_norma','descricao')->ignore($id)],
            'sigla'     => ['nullable', 'string', 'max:20', Rule::unique('tipo_norma','sigla')->ignore($id)],
            'ativo'     => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ativo' => (bool) $this->boolean('ativo'),
            'sigla' => $this->filled('sigla') ? mb_strtoupper($this->input('sigla')) : null,
        ]);
    }
}
