<?php

namespace App\Models\Platform;

use App\Enums\BillingCycle;
use App\Enums\BillingStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientBilling extends Model
{
    use HasUuids;

    protected $connection = 'mysql';
    protected $table = 'client_billing';

    protected $fillable = [
        'client_id',
        'plan_id',
        'billing_cycle',
        'status',
        'next_billing_at',
    ];

    protected function casts(): array
    {
        return [
            'billing_cycle'   => BillingCycle::class,
            'status'          => BillingStatus::class,
            'next_billing_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
