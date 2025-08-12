<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVereadorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('vereadore')?->id ?? $this->route('vereador')?->id; // compatível com pluralização

        return [
            'nome_parlamentar' => [
                'required','string','max:120',
                Rule::unique('vereadores','nome_parlamentar')->ignore($id),
            ],
            'nome_completo'    => ['required','string','max:150'],
            'partido_id'       => ['nullable','exists:partidos,id'],
            'foto'             => ['nullable','image','max:2048'],
            'ativo'            => ['nullable','boolean'],
        ];
    }
}
