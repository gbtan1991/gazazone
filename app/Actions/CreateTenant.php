<?php

namespace App\Actions;

use App\Enums\BillingCycle;
use App\Enums\BillingStatus;
use App\Enums\ClientUserRole;
use App\Models\Platform\Client;
use App\Models\Platform\ClientBilling;
use App\Models\Platform\ClientUser;
use App\Models\Platform\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateTenant
{
    public function execute(
        string $clientId,
        string $businessName,
        string $ownerName,
        string $ownerEmail,
        string $ownerPassword,
        string $trade,
        ?string $planId = null,
    ): Client {
        $plan = $planId
            ? Plan::findOrFail($planId)
            : Plan::first();

        // Create the client (tenant) record
        $client = Client::create([
            'id'     => $clientId,
            'name'   => $businessName,
            'email'  => $ownerEmail,
            'trade'  => $trade,
            'plan_id' => $plan?->id,
        ]);

        // The TenancyServiceProvider event pipeline handles:
        // DB creation → migrations → SeedTenantDatabase

        // Create owner account in platform DB
        ClientUser::create([
            'client_id' => $client->id,
            'name'      => $ownerName,
            'email'     => $ownerEmail,
            'password'  => Hash::make($ownerPassword),
            'role'      => ClientUserRole::Owner,
        ]);

        // Create owner account in tenant DB
        tenancy()->initialize($client);

        User::create([
            'name'     => $ownerName,
            'email'    => $ownerEmail,
            'password' => Hash::make($ownerPassword),
            'role'     => ClientUserRole::Owner,
        ]);

        tenancy()->end();

        // Create billing record
        if ($plan) {
            ClientBilling::create([
                'client_id'      => $client->id,
                'plan_id'        => $plan->id,
                'billing_cycle'  => BillingCycle::Monthly,
                'status'         => BillingStatus::Trialing,
                'next_billing_at' => now()->addDays(30),
            ]);
        }

        return $client->fresh();
    }
}
