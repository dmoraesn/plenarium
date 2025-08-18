<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoMateriaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Pega o ID do modelo da rota (ex: /tipos-materia/5)
        $modelId = $this->route('model')->id;

        return [
            'sigla' => ['required', 'string', 'max:10', Rule::unique('tipo_materias')->ignore($modelId)],
            'nome'  => 'required|string|max:255',
            'ativo' => 'nullable|boolean',
        ];
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'ativo' => $this->has('ativo'),
        ]);
    }
}