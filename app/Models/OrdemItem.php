<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrdemItem extends Model
{
    protected $table = 'ordem_itens';

    protected $fillable = [
        'sessao_id',
        'materia_id',
        'posicao',
        'situacao',
        'justificativa',
    ];

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    // Acessor para classes Tailwind conforme a situação
    protected function situacaoClass(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->situacao) {
                'aprovada' => 'bg-green-100 text-green-800',
                'rejeitada' => 'bg-red-100 text-red-800',
                default => 'bg-blue-100 text-blue-800', // em_pauta (ou outras)
            },
        );
    }

    // Acessor para rótulo legível da situação
    protected function situacaoLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(str_replace('_', ' ', (string) $this->situacao)),
        );
    }
}
