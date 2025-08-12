<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReordenarOrdemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null; // TODO: aplicar policy
    }

    public function rules(): array
    {
        $sessaoId = $this->route('sessao'); // pode ser ID ou model; Laravel cuida

        return [
            'itens' => ['required','array','min:1'],
            'itens.*.id' => [
                'required','integer',
                Rule::exists('ordem_itens','id')->where('sessao_id', $sessaoId),
            ],
            'itens.*.posicao' => ['required','integer','min:1','distinct'],
        ];
    }

    public function messages(): array
    {
        return [
            'itens.required' => 'Envie a lista de itens para reordenar.',
            'itens.*.id.exists' => 'Item inválido para esta sessão.',
        ];
    }
}
