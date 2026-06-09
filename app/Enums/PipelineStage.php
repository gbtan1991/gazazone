<?php

namespace App\Enums;

enum PipelineStage: string
{
    case Lead      = 'lead';
    case Contacted = 'contacted';
    case Quoted    = 'quoted';
    case Booked    = 'booked';
    case Completed = 'completed';
    case Repeat    = 'repeat';

    public function label(): string
    {
        return match ($this) {
            self::Lead      => 'Interessent',
            self::Contacted => 'Kontaktiert',
            self::Quoted    => 'Angeboten',
            self::Booked    => 'Gebucht',
            self::Completed => 'Abgeschlossen',
            self::Repeat    => 'Stammkunde',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Lead      => 'bg-slate-100 text-slate-700',
            self::Contacted => 'bg-blue-100 text-blue-700',
            self::Quoted    => 'bg-yellow-100 text-yellow-700',
            self::Booked    => 'bg-indigo-100 text-indigo-700',
            self::Completed => 'bg-green-100 text-green-700',
            self::Repeat    => 'bg-emerald-100 text-emerald-700',
        };
    }
}
