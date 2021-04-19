<?php

namespace Bilfeldt\LaravelRouteStatistics\Http\Middleware;

use Closure;

class RouteStatistics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->merge([
            'routeStatistics' => [
                'enabled' => true,
            ],
        ]);

        return $next($request);
    }
}
