<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sessao extends Model
{
    /** Tabela do modelo */
    protected $table = 'sessoes';

    /** Casts nativos */
    protected $casts = [
        'data'         => 'datetime',
        'aberta_em'    => 'datetime',
        'encerrada_em' => 'datetime',
        'publicada_em' => 'datetime',
        'status'       => 'string',
    ];

    /** Campos atribuíveis em massa */
    protected $fillable = [
        'numero',
        'ano',
        'tipo',
        'data',
        'status',
        'aberta_em',
        'encerrada_em',
        'publicada_em',
        'observacoes',
    ];

    // ------------------------------------------------------------------
    // Status canônicos
    // ------------------------------------------------------------------
    public const ST_PLANEJADA = 'planejada';
    public const ST_ABERTA    = 'aberta';
    public const ST_ENCERRADA = 'encerrada';
    public const ST_PUBLICADA = 'publicada';

    /** Normaliza qualquer variação para um canônico */
    public static function normalizeStatus(?string $value): string
    {
        $v = strtolower(trim((string) $value));
        $v = str_replace([' ', '-'], '_', $v);

        return match ($v) {
            'agendada', 'agenda', 'scheduled'      => self::ST_PLANEJADA,
            'em_andamento', 'aberto', 'abertos'    => self::ST_ABERTA,
            'finalizada', 'fechada', 'finalizado'  => self::ST_ENCERRADA,
            default => in_array($v, [
                self::ST_PLANEJADA, self::ST_ABERTA, self::ST_ENCERRADA, self::ST_PUBLICADA,
            ], true) ? $v : self::ST_PLANEJADA,
        };
    }

    /** Mutator: sempre grava normalizado */
    public function setStatusAttribute($value): void
    {
        $this->attributes['status'] = self::normalizeStatus($value);
    }

    /** Accessor: sempre lê normalizado ($sessao->normalized_status) */
    public function getNormalizedStatusAttribute(): string
    {
        return self::normalizeStatus($this->attributes['status'] ?? null);
    }

    // ------------------------------------------------------------------
    // Relações
    // ------------------------------------------------------------------
    public function presencas(): HasMany
    {
        return $this->hasMany(Presenca::class, 'sessao_id');
    }

    public function ordemDoDia(): HasMany
    {
        return $this->hasMany(OrdemItem::class, 'sessao_id')->orderBy('posicao');
    }

    /** Alias opcional para compatibilidade com código antigo */
    public function ordemItens(): HasMany
    {
        return $this->ordemDoDia();
    }

    // ------------------------------------------------------------------
    // Accessors de apresentação (usados em views)
    // ------------------------------------------------------------------
    protected function statusClass(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->normalized_status) {
                self::ST_PLANEJADA => 'bg-blue-100 text-blue-800',
                self::ST_ABERTA    => 'bg-yellow-100 text-yellow-800',
                self::ST_ENCERRADA => 'bg-green-100 text-green-800',
                self::ST_PUBLICADA => 'bg-green-100 text-green-800',
                default            => 'bg-gray-100 text-gray-800',
            },
        );
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->normalized_status) {
                self::ST_PLANEJADA => 'Agendada',
                self::ST_ABERTA    => 'Em andamento',
                self::ST_ENCERRADA => 'Encerrada',
                self::ST_PUBLICADA => 'Publicada',
                default            => ucfirst((string) ($this->status ?? '')),
            },
        );
    }

    protected function tipoLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst((string) ($this->tipo ?? '')),
        );
    }
}
