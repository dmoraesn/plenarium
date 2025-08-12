<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VereadorUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nome_parlamentar' => 'required|string|max:120',
            'nome_completo'    => 'required|string|max:150',
            'partido_id'       => 'nullable|exists:partidos,id',
            'foto'             => 'nullable|image|max:2048',
            'ativo'            => 'sometimes|boolean',
        ];
    }
}
