<?php

namespace App\Enums;

enum TipoSessao: string
{
    case ORDINARIA = 'ordinaria';
    case EXTRAORDINARIA = 'extraordinaria';
    case SOLENE = 'solene';
    case ESPECIAL = 'especial';

    public function getLabel(): string
    {
        return match ($this) {
            self::ORDINARIA => 'Ordinária',
            self::EXTRAORDINARIA => 'Extraordinária',
            self::SOLENE => 'Solene',
            self::ESPECIAL => 'Sessão Especial',
        };
    }
}