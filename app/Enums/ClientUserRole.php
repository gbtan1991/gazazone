<?php

namespace App\Enums;

enum ClientUserRole: string
{
    case Owner = 'owner';
    case Staff = 'staff';

    public function label(): string
    {
        return match ($this) {
            self::Owner => 'Inhaber',
            self::Staff => 'Mitarbeiter',
        };
    }
}
