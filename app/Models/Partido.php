<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $fillable = ['sigla','nome','ativo'];

    public function vereadores()
    {
        return $this->hasMany(Vereador::class);
    }
}
