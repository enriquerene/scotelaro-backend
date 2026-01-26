<?php

namespace FightGym\Domain\Model;

enum PosicaoTurmaTipo: string
{
    case TATAME_ENTRADA = 'tatame_entrada';
    case TATAME_FUNDO = 'tatame_fundo';
    case OCTOGONO = 'octogono';
    
    public function label(): string
    {
        return match ($this) {
            self::TATAME_ENTRADA => 'Tatame (Entrada)',
            self::TATAME_FUNDO => 'Tatame (Fundo)',
            self::OCTOGONO => 'Octógono',
        };
    }
}