<?php

namespace App\Enums;

enum ActivityType: string
{
    case Note       = 'note';
    case Call       = 'call';
    case Email      = 'email';
    case Whatsapp   = 'whatsapp';
    case Visit      = 'visit';
    case QuoteSent  = 'quote_sent';

    public function label(): string
    {
        return match ($this) {
            self::Note      => 'Notiz',
            self::Call      => 'Anruf',
            self::Email     => 'E-Mail',
            self::Whatsapp  => 'WhatsApp',
            self::Visit     => 'Besuch',
            self::QuoteSent => 'Angebot gesendet',
        };
    }
}
