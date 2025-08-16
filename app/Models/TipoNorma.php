<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNorma extends Model
{
    use HasFactory;

    protected $table = 'tipo_norma';

    protected $fillable = [
        'descricao',
        'sigla',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function normas()
    {
        return $this->hasMany(NormaJuridica::class, 'tipo');
    }
}
