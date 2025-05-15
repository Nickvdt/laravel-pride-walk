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

        $visit = ApiVisit::where('endpoint', $endpoint)
            ->where('ip_address', $ipAddress)
            ->whereDate('visited_at', $today)
            ->first();

        if (!$visit) {
            ApiVisit::create([
                'endpoint' => $endpoint,
                'ip_address' => $ipAddress,
                'visited_at' => $today,
                'visit_count' => 1,
            ]);
        }

        return $next($request);
    }
}
