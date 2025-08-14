<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importamos a classe Rule para uma sintaxe mais limpa

class MateriaUpdateRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        // Boa prática: centralizar a autorização aqui usando Policies.
        // Isso pressupõe que você tenha uma MateriaPolicy com um método 'update'.
        return $this->user()->can('update', $this->route('materia'));
    }

    /**
     * Obtém as regras de validação que se aplicam à requisição.
     */
    public function rules(): array
    {
        // Pegamos o ID da matéria diretamente da rota para usar na regra 'unique'.
        $materiaId = $this->route('materia')->id;

        return [
            'tipo_materia_id' => ['required', 'exists:tipo_materias,id'],
            
            // Regra de unicidade corrigida e mais legível usando Rule::unique
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('materias')->ignore($materiaId)->where(function ($query) {
                    return $query->where('ano', $this->ano)
                                 ->where('tipo_materia_id', $this->tipo_materia_id);
                }),
            ],

            'ano'             => ['required', 'integer', 'digits:4'],
            'ementa'          => ['required', 'string', 'max:5000'],
            'status'          => ['required', Rule::in(['rascunho', 'pronta_pauta', 'arquivada', 'aprovada', 'rejeitada', 'retirada'])],
            
            // 'nullable' permite que o campo 'autores' não seja enviado se estiver vazio.
            'autores'         => ['nullable', 'array'], 
            'autores.*'       => ['integer', 'exists:vereadores,id'],
        ];
    }

    /**
     * Mensagens de erro personalizadas para a validação.
     */
    public function messages(): array
    {
        return [
            'numero.unique' => 'Já existe uma matéria com este tipo, número e ano cadastrada.',
        ];
    }
}