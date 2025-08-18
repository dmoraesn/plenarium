<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMateria extends Model
{
    use HasFactory;

    // Correção: garantir que o Laravel use a tabela certa
    protected $table = 'tipo_materias';

    protected $fillable = [
        'sigla',
        'nome',
        'ativo',
    ];
}
