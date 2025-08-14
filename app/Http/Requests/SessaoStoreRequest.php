<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SessaoStoreRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        // A autorização é delegada para a policy chamada no controller.
        return true;
    }

    /**
     * Obtém as regras de validação que se aplicam ao pedido.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'numero' => [
                'required',
                'integer',
                'min:1',
                // Garante que a combinação de número, ano e tipo seja única.
                Rule::unique('sessoes')->where(function ($query) {
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

    /**
     * Mensagens de erro personalizadas para a validação.
     */
    public function messages(): array
    {
        return [
            'numero.unique' => 'Já existe uma sessão com este número, ano e tipo.',
        ];
    }
}
