<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoMateriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Altere para a lógica de permissão real se necessário (ex: $this->user()->can('create', TipoMateria::class))
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sigla' => 'required|string|max:10|unique:tipo_materias,sigla',
            'nome'  => 'required|string|max:255',
            'ativo' => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * Adiciona o campo 'ativo' com valor false se o checkbox não for enviado.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'ativo' => $this->has('ativo'),
        ]);
    }
}