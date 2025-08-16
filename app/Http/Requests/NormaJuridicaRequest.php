<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NormaJuridicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tipo'            => ['required', 'exists:tipo_norma,id'],
            'numero'          => ['required', 'integer', 'min:1'],
            'ano'             => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'ementa'          => ['nullable', 'string'],
            'texto_integral'  => ['nullable'],
            'data_publicacao' => ['nullable', 'date'],
        ];
    }
}
