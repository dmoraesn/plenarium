<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMateria extends Model
{
    protected $fillable = ['sigla','nome','ativo'];

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
}
