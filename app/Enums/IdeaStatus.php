<?php

namespace App\Enums;

enum IdeaStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendente',
            self::IN_PROGRESS => 'Em Processamento',
            self::COMPLETED => 'Concluído',
        };
    }

    // public function __toString(): string
    // {
    //     return $this->label();
    // }
}