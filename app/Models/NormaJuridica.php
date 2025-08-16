<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormaJuridica extends Model
{
    use HasFactory;

    protected $table = 'norma_juridica';

    protected $fillable = [
        'tipo',
        'numero',
        'ano',
        'ementa',
        'texto_integral',
        'data_publicacao',
    ];

    protected $casts = [
        'data_publicacao' => 'date',
    ];

    public function tipoNorma()
    {
        return $this->belongsTo(TipoNorma::class, 'tipo');
    }
}
