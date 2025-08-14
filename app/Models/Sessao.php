<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sessao extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada ao modelo.
     */
    protected $table = 'sessoes';

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'numero',
        'ano',
        'tipo',
        'data',
        'status',
        'aberta_em',
        'encerrada_em',
        'publicada_em',
        'observacoes',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     */
    protected $casts = [
        'data' => 'date',
        'aberta_em' => 'datetime',
        'encerrada_em' => 'datetime',
        'publicada_em' => 'datetime',
        'status' => 'string',
        'tipo' => 'string',
    ];

    /* ================================================================== */
    /* |                      RELACIONAMENTOS                           | */
    /* ================================================================== */

    /**
     * Define o relacionamento "um-para-muitos" com os itens da Ordem do Dia.
     */
    public function ordemDoDia()
    {
        // Assumindo que o seu model se chama OrdemItem
        return $this->hasMany(OrdemItem::class)->orderBy('posicao');
    }

    /**
     * Define o relacionamento "um-para-muitos" com as presenças.
     */
    public function presencas()
    {
        // Assumindo que o seu model se chama Presenca
        return $this->hasMany(Presenca::class);
    }


    /* ================================================================== */
    /* |                  ACCESSORS (LÓGICA DE APRESENTAÇÃO)            | */
    /* ================================================================== */
    
    protected function statusClass(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'aberta' => 'bg-yellow-100 text-yellow-800',
                'encerrada' => 'bg-emerald-100 text-emerald-800',
                'publicada' => 'bg-gray-200 text-gray-700',
                'cancelada' => 'bg-red-100 text-red-700',
                default => 'bg-blue-100 text-blue-800', // planejada
            },
        );
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->status),
        );
    }

    protected function tipoLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->tipo),
        );
    }
}
