<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVereadorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nome_parlamentar' => ['required','string','max:120','unique:vereadores,nome_parlamentar'],
            'nome_completo'    => ['required','string','max:150'],
            'partido_id'       => ['nullable','exists:partidos,id'],
            'foto'             => ['nullable','image','max:2048'], // 2MB
            'ativo'            => ['nullable','boolean'],
        ];
    }
}
