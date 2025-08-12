<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vereador extends Model
{
    use HasFactory;

    /**
     * Nome explícito da tabela.
     *
     * @var string
     */

protected $table = 'vereadores';
protected $fillable = ['nome_parlamentar','nome_completo','partido_id','foto','ativo'];

    /**
     * Casts de atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamentos.
     */
    public function partido()
    {
        // Chave estrangeira explícita por clareza
        return $this->belongsTo(Partido::class, 'partido_id');
    }

    /**
     * Escopo auxiliar (opcional).
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
}
