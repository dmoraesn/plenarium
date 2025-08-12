<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = [
        'tipo_materia_id','numero','ano','ementa','status','ativo'
    ];

    // Estados aceitos (como constantes – PHP 8.0 não tem enum nativo)
    public const STATUS = [
        'rascunho','protocolada','em_comissoes','pronta_pauta',
        'adiada','retirada','aprovada','rejeitada','arquivada',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoMateria::class, 'tipo_materia_id');
    }

    public function autores()   // inclui autores e coautores
    {
        return $this->belongsToMany(Vereador::class, 'materia_autores')
                    ->withPivot('papel')
                    ->withTimestamps();
    }

    public function anexos()
    {
        return $this->hasMany(MateriaAnexo::class);
    }


    public function sessoes()
{
    return $this->belongsToMany(Sessao::class, 'ordem_itens')
                ->withPivot(['posicao','situacao','justificativa'])
                ->withTimestamps();
}

}
