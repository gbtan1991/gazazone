<?php

namespace App\Enums;

enum Priority: string
{
    case Low    = 'low';
    case Medium = 'medium';
    case High   = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Low    => 'Niedrig',
            self::Medium => 'Mittel',
            self::High   => 'Hoch',
            self::Urgent => 'Dringend',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Low    => 'bg-slate-100 text-slate-600',
            self::Medium => 'bg-blue-100 text-blue-700',
            self::High   => 'bg-orange-100 text-orange-700',
            self::Urgent => 'bg-red-100 text-red-700',
        };
    }
}
