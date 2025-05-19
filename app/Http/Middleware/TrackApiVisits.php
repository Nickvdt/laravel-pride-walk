<?php

namespace App\Http\Middleware;

use App\Models\ApiVisit;
use Closure;

class TrackApiVisits
{
    public function handle($request, Closure $next)
    {
        $endpoint = $request->path();
        $ipAddressHash = hash('sha256', $request->ip());
        $now = now();

        // Zoek bezoek binnen de laatste 30 minuten
        $recentVisit = ApiVisit::where('endpoint', $endpoint)
            ->where('ip_address', $ipAddressHash)
            ->where('visited_at', '>=', $now->subMinutes(30))
            ->first();

        if (!$recentVisit) {
            // Geen recent bezoek, dus opslaan
            ApiVisit::create([
                'endpoint' => $endpoint,
                'ip_address' => $ipAddressHash,
                'visited_at' => $now,
                'visit_count' => 1,
            ]);
        }

        return $next($request);
    }
}
