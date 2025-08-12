<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vereador extends Model
{
    use HasFactory;

    // 👇 força o nome correto da tabela
    protected $table = 'vereadores';

    protected $fillable = [
        'nome_parlamentar', 'nome_completo', 'partido_id', 'foto', 'ativo',
    ];

    protected $casts = [
        'ativo' => 'bool',
    ];

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? asset('storage/'.$this->foto)
            : asset('images/avatar-vereador.svg');
    }
}
