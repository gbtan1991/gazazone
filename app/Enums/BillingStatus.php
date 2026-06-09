<?php

namespace App\Enums;

enum BillingStatus: string
{
    case Active    = 'active';
    case PastDue   = 'past_due';
    case Cancelled = 'cancelled';
    case Trialing  = 'trialing';

    public function label(): string
    {
        return match ($this) {
            self::Active    => 'Aktiv',
            self::PastDue   => 'Überfällig',
            self::Cancelled => 'Gekündigt',
            self::Trialing  => 'Testphase',
        };
    }
}
