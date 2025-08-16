<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoMesa extends Model
{
    protected $table = 'cargo_mesa';

    protected $fillable = [
        'descricao',
        'posicao_ordenacao',
        'cargo_unico',
        'observacao',
        'ativo',
    ];

    protected $casts = [
        'cargo_unico' => 'boolean',
        'ativo'       => 'boolean',
    ];
}
