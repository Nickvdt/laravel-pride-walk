<?php

namespace App\Http\Middleware;

use App\Models\ApiVisit;
use Closure;
use Illuminate\Support\Facades\Log;

class TrackApiVisits
{
    public function handle($request, Closure $next)
    {
        $endpoint = $request->path();
        $ipAddress = $request->ip();
        $today = now()->toDateString();

        // Zoek of er al een bezoek van dit IP is geregistreerd vandaag
        $visit = ApiVisit::firstOrCreate(
            [
                'endpoint' => $endpoint,
                'ip_address' => $ipAddress,
                'visited_at' => $today,
            ],
            ['visit_count' => 0]
        );

        // Tel alleen op als het IP vandaag nog niet is geregistreerd
        if ($visit->wasRecentlyCreated) {
            $visit->increment('visit_count');
        }

        return $next($request);
    }
}
