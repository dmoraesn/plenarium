<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislatura extends Model
{
    use HasFactory;

    protected $table = 'legislaturas';

    protected $fillable = [
        'numero',
        'data_eleicao',
        'data_inicio',
        'data_fim',
        'observacao',
        'ativo',
    ];

    protected $casts = [
        'data_eleicao' => 'date',
        'data_inicio'  => 'date',
        'data_fim'     => 'date',
        'ativo'        => 'boolean',
    ];
}
