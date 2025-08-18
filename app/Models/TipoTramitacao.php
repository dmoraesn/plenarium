<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTramitacao extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Corrige a pluralização automática (tipo_tramitacaos → tipos_tramitacao)
     */
    protected $table = 'tipos_tramitacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'prazo_dias',
        'ativo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ativo' => 'boolean',
        'prazo_dias' => 'integer',
    ];
}
