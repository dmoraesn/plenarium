<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriaAnexo extends Model
{
    protected $table = 'materia_anexos';

    protected $fillable = [
        'materia_id','arquivo','nome_original','mime','tamanho_bytes'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
