<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SessaoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // A policy é verificada no controller
    }

    public function rules(): array
    {
        $sessaoId = $this->route('sessao')->id;

        return [
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('sessoes')->ignore($sessaoId)->where(function ($query) {
                    return $query->where('ano', $this->ano)
                                 ->where('tipo', $this->tipo);
                }),
            ],
            'ano' => ['required', 'integer', 'digits:4'],
            'tipo' => ['required', Rule::in(['ordinaria', 'extraordinaria', 'solene', 'especial'])],
            'data' => ['required', 'date'],
            'observacoes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'numero.unique' => 'Já existe uma sessão com este número, ano e tipo.',
        ];
    }
}
