<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Facades\LaravelRouteStatisticsFacade;
use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;
use Illuminate\Http\Request;

class RouteStatisticsMiddlewareTest extends TestCase
{
    /** @test */
    public function test_enables_route_statistics_pre_stream()
    {
        $request = new Request();
        $stats = LaravelRouteStatisticsFacade::disable();

        $this->assertFalse($stats->isEnabled());

        // when we pass the request to this middleware,
        // it should've have added a new parameter 'routeStatistics'
        (new RouteStatistics())->handle($request, function ($request) use ($stats) {
            $this->assertTrue($stats->isEnabled());
        });
    }
}
