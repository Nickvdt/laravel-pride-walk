<?php

namespace App\Http\Middleware;

use App\Models\ApiVisit;
use Closure;

class TrackApiVisits
{
    public function handle($request, Closure $next)
    {
        $endpoint = $request->path();
        $today = now()->toDateString();

        $visit = ApiVisit::firstOrCreate(
            ['endpoint' => $endpoint, 'visited_at' => $today],
            ['visit_count' => 0]
        );

        $visit->increment('visit_count');

        return $next($request);
    }
}
