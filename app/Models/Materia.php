<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'tipo_materia_id',
        'numero',
        'ano',
        'ementa',
        'status',
    ];

    /** Casts úteis para evitar surpresas com strings */
    protected $casts = [
        'numero' => 'integer',
        'ano'    => 'integer',
    ];

    /** (Opcional) default para novos registros */
    protected $attributes = [
        'status' => 'rascunho',
    ];

    /** Status permitidos para filtros/UI */
    public const STATUS = [
        'rascunho',
        'pronta_pauta',
        'arquivada',
        'aprovada',
        'rejeitada',
        'retirada',
    ];

    /* ============================
     |  Relacionamentos
     * ============================ */

    public function tipo()
    {
        return $this->belongsTo(TipoMateria::class, 'tipo_materia_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Vereador::class, 'materia_vereador', 'materia_id', 'vereador_id')
            ->withTimestamps();
    }

    /* ============================
     |  Acessors
     * ============================ */

    /** Helper para exibir "numero/ano" na view */
    public function getNumeroAnoAttribute(): string
    {
        return "{$this->numero}/{$this->ano}";
    }
    
    /** Acessor para exibir os nomes dos autores (Autor + Coautores) */
    public function getAutoresDisplayAttribute(): string
    {
        return $this->autores->pluck('nome_parlamentar')->implode(', ');
    }

    /* ============================
     |  Query Scopes
     * ============================ */

    /**
     * Busca por termo na ementa e (opcionalmente) por número/ano.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        return $query->where(function ($w) use ($term) {
            $w->where('ementa', 'like', "%{$term}%");

            if (preg_match('#^(\d{1,5})(?:/(\d{4}))?$#', $term, $m)) {
                $w->orWhere('numero', (int) $m[1]);

                if (!empty($m[2])) {
                    $w->orWhere(fn ($x) => $x
                        ->where('numero', (int) $m[1])
                        ->where('ano', (int) $m[2]));
                }
            } else {
                $w->orWhere('numero', 'like', "%{$term}%")
                    ->orWhere('ano', 'like', "%{$term}%");
            }
        });
    }

    /**
     * Filtra por tipo_materia_id.
     */
    public function scopeTipo(Builder $query, ?int $tipoId): Builder
    {
        if (!$tipoId) {
            return $query;
        }
        return $query->where('tipo_materia_id', $tipoId);
    }

    /**
     * Filtra por um status específico.
     * Só aplica o filtro se um status válido for fornecido.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status) || !in_array($status, self::STATUS)) {
            return $query;
        }
        return $query->where('status', $status);
    }
    
    /**
     * Atalho para status 'pronta_pauta' (conveniência para alimentar a Ordem do Dia).
     */
    public function scopeProntaPauta(Builder $query): Builder
    {
        return $query->where('status', 'pronta_pauta');
    }
}