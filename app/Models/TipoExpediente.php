<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoExpediente extends Model
{
    protected $table = 'tipo_expediente';

    protected $fillable = [
        'descricao',
        'ordenacao',
        'observacao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}
