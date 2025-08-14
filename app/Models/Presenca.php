<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Presenca extends Model
{
    use LogsActivity;

    protected $table = 'presencas';

    protected $fillable = [
        'sessao_id',
        'vereador_id',
        'status',
        'marcado_em',
        'alterado_em',
        'justificativa',
        'marcado_por_user_id',
        'alterado_por_user_id',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'marcado_em' => 'datetime',
        'alterado_em' => 'datetime',
        'status' => 'string', // Garante que o enum do banco seja tratado como string
    ];

    /**
     * Configura as opções para o log de atividades (API v4).
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('presenca')
            ->logOnly([
                'status',
                'justificativa',
                'marcado_por_user_id',
                'alterado_por_user_id',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "O registro de presença foi {$eventName}");
    }

    /* ================================================================== */
    /* |                      RELACIONAMENTOS                           | */
    /* ================================================================== */

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }

    public function vereador()
    {
        return $this->belongsTo(Vereador::class);
    }

    public function marcadoPor()
    {
        return $this->belongsTo(User::class, 'marcado_por_user_id');
    }

    public function alteradoPor()
    {
        return $this->belongsTo(User::class, 'alterado_por_user_id');
    }
}
