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

    public function badgeClasses(): string
    {
        return match($this) {
        self::PENDING => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
        self::IN_PROGRESS => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
        self::COMPLETED => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
        };
    }

    public function inactiveClasses(): string
    {
        return 'bg-neutral-900/40 text-neutral-400 border-neutral-800 hover:bg-neutral-800/50 hover:text-neutral-200';
    }
}
