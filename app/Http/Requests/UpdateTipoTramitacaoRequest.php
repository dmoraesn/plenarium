<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoTramitacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // O Laravel injeta o model da rota automaticamente.
        $tipoTramitacaoId = $this->route('tipos_tramitacao')->id;

        return [
            'nome' => [
                'required',
                'string',
                'max:150',
                Rule::unique('tipos_tramitacao')->ignore($tipoTramitacaoId),
            ],
            'descricao' => 'nullable|string',
            'prazo_dias' => 'required|integer|min:0',
            'ativo' => 'nullable|boolean',
        ];
    }
}