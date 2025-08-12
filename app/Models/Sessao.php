<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    protected $table = 'sessoes';

    protected $fillable = [
        'numero','ano','tipo','status','aberta_em','encerrada_em','publicada_em','data','observacoes'
    ];

    // Relacionamentos serão ligados nos próximos blocos:
    // ordem_itens() e presencas()


    public function ordemItens()
{
    return $this->hasMany(OrdemItem::class, 'sessao_id')->orderBy('posicao');
}

}
