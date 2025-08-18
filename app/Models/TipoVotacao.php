<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoVotacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_votacao';

    protected $fillable = [
        'nome',
        'descricao',
        'criterio',
        'percentual',
        'min_votos',
        'condicoes_adicionais',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'percentual' => 'integer',
        'min_votos' => 'integer',
    ];
}
