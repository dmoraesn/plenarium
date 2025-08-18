<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoVotacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'      => 'required|string|max:150|unique:tipos_votacao,nome',
            'descricao' => 'nullable|string',
            'criterio'  => 'required|in:maioria_simples,maioria_absoluta,maioria_qualificada,personalizado',
            'percentual'=> 'nullable|integer|min:1|max:100',
            'min_votos' => 'nullable|integer|min:1',
            'condicoes_adicionais' => 'nullable|string',
            'ativo'     => 'boolean',
        ];
    }
}
