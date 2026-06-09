<?php

namespace App\Models\Platform;

use App\Enums\ClientUserRole;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Client extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $connection = 'mysql'; // always uses the central/platform connection

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'trade',
        'plan_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getTenantKeyName(): string
    {
        return 'id';
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'phone',
            'trade',
            'plan_id',
            'is_active',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(ClientUser::class, 'client_id');
    }

    public function billing(): HasOne
    {
        return $this->hasOne(ClientBilling::class, 'client_id');
    }

    public function clientDomains(): HasMany
    {
        return $this->hasMany(ClientDomain::class, 'client_id');
    }

    public function owner(): HasOne
    {
        return $this->hasOne(ClientUser::class, 'client_id')
            ->where('role', ClientUserRole::Owner->value);
    }

    public function getDatabaseName(): string
    {
        return 'meisterflow_' . str_replace('-', '_', $this->id);
    }
}
