<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemItem extends Model
{
    protected $table = 'ordem_itens';

    protected $fillable = [
        'sessao_id','materia_id','posicao','situacao','justificativa',
    ];

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
