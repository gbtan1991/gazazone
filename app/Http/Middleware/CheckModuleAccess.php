<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $clientUser = auth()->user();

        if (! $clientUser) {
            return redirect()->route('login');
        }

        $plan = $clientUser->client->plan;

        $allowed = match ($module) {
            'crm' => $plan?->has_crm ?? false,
            'pm'  => $plan?->has_pm ?? false,
            default => true,
        };

        if (! $allowed) {
            abort(403, 'Dieses Modul ist in Ihrem Plan nicht enthalten.');
        }

        return $next($request);
    }
}
