<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Presenca extends Model
{
    use LogsActivity;

    protected $table = 'presencas';

    protected $fillable = [
        'sessao_id','vereador_id','status','marcado_em','alterado_em',
        'justificativa','marcado_por_user_id','alterado_por_user_id',
    ];

    // Spatie Activitylog: auditar apenas mudanças
    protected static $logAttributes = [
        'status','justificativa','marcado_por_user_id','alterado_por_user_id',
    ];
    protected static $logOnlyDirty = true;
    protected static $logName = 'presenca';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Presença {$eventName}";
    }

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
        return $this->belongsTo(\App\Models\User::class, 'marcado_por_user_id');
    }

    public function alteradoPor()
    {
        return $this->belongsTo(\App\Models\User::class, 'alterado_por_user_id');
    }
}
