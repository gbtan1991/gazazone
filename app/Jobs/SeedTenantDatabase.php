<?php

namespace App\Jobs;

use App\Models\Service;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class SeedTenantDatabase
{
    public function handle(TenantWithDatabase $tenant): void
    {
        tenancy()->initialize($tenant);

        Service::insert([
            [
                'id'               => \Illuminate\Support\Str::uuid()->toString(),
                'name'             => 'Beratungsgespräch',
                'duration_minutes' => 60,
                'price_chf'        => 0,
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'id'               => \Illuminate\Support\Str::uuid()->toString(),
                'name'             => 'Standardservice',
                'duration_minutes' => 90,
                'price_chf'        => 150.00,
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'id'               => \Illuminate\Support\Str::uuid()->toString(),
                'name'             => 'Notfallservice',
                'duration_minutes' => 120,
                'price_chf'        => 250.00,
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);

        tenancy()->end();
    }
}
