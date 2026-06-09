<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Planning   = 'planning';
    case Active     = 'active';
    case OnHold     = 'on_hold';
    case Completed  = 'completed';
    case Cancelled  = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Planning  => 'Planung',
            self::Active    => 'Aktiv',
            self::OnHold    => 'Pausiert',
            self::Completed => 'Abgeschlossen',
            self::Cancelled => 'Abgebrochen',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Planning  => 'bg-blue-100 text-blue-700',
            self::Active    => 'bg-green-100 text-green-700',
            self::OnHold    => 'bg-yellow-100 text-yellow-700',
            self::Completed => 'bg-slate-100 text-slate-700',
            self::Cancelled => 'bg-red-100 text-red-700',
        };
    }
}
