<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdemItem extends Model
{
    /**
     * O nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'ordem_itens'; // Verifique se este é o nome da sua tabela na migration

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sessao_id',
        'materia_id',
        'posicao',
        'situacao', // Ex: 'em_pauta', 'aprovada', 'rejeitada'
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'posicao' => 'integer',
    ];

    /* ================================================================== */
    /* |                      RELACIONAMENTOS                           | */
    /* ================================================================== */

    /**
     * Obtém a sessão à qual este item da pauta pertence.
     */
    public function sessao(): BelongsTo
    {
        return $this->belongsTo(Sessao::class, 'sessao_id');
    }

    /**
     * Obtém a matéria associada a este item da pauta.
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
