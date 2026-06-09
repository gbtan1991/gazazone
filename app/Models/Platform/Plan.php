<?php

namespace App\Models\Platform;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasUuids;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'has_crm',
        'has_pm',
        'booking_limit',
        'user_limit',
        'price_chf',
    ];

    protected function casts(): array
    {
        return [
            'has_crm'       => 'boolean',
            'has_pm'        => 'boolean',
            'booking_limit' => 'integer',
            'user_limit'    => 'integer',
            'price_chf'     => 'decimal:2',
        ];
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
