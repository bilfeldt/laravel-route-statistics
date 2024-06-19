<?php

namespace Bilfeldt\LaravelRouteStatistics\Http\Middleware;

use Closure;

class RouteStatisticsMiddleware
{
    const ALIAS = 'routestatistics';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->routeStatistics();

        return $next($request);
    }
}
