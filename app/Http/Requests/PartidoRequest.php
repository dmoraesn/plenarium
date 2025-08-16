<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $id = $this->route('partido')?->id; // para unique no update

        return [
            'sigla' => ['required', 'string', 'max:10', 'unique:partidos,sigla,' . $id],
            'nome'  => ['required', 'string', 'max:150'],
            'ativo' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // checkbox ausente => false
        if ($this->has('ativo') === false) {
            $this->merge(['ativo' => false]);
        }

        // normaliza sigla
        if ($this->filled('sigla')) {
            $this->merge(['sigla' => mb_strtoupper($this->input('sigla'))]);
        }
    }
}
