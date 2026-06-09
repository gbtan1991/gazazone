<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Todo       = 'todo';
    case InProgress = 'in_progress';
    case Review     = 'review';
    case Done       = 'done';
    case Cancelled  = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Todo       => 'Offen',
            self::InProgress => 'In Arbeit',
            self::Review     => 'In Prüfung',
            self::Done       => 'Erledigt',
            self::Cancelled  => 'Abgebrochen',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Todo       => 'bg-slate-100 text-slate-700',
            self::InProgress => 'bg-blue-100 text-blue-700',
            self::Review     => 'bg-yellow-100 text-yellow-700',
            self::Done       => 'bg-green-100 text-green-700',
            self::Cancelled  => 'bg-red-100 text-red-700',
        };
    }
}
