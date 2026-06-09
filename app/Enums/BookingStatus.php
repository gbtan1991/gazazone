<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending   = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow    = 'no_show';

    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Ausstehend',
            self::Confirmed => 'Bestätigt',
            self::Completed => 'Abgeschlossen',
            self::Cancelled => 'Abgesagt',
            self::NoShow    => 'Nicht erschienen',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending   => 'bg-yellow-100 text-yellow-800',
            self::Confirmed => 'bg-blue-100 text-blue-800',
            self::Completed => 'bg-green-100 text-green-800',
            self::Cancelled => 'bg-red-100 text-red-800',
            self::NoShow    => 'bg-slate-100 text-slate-600',
        };
    }
}
