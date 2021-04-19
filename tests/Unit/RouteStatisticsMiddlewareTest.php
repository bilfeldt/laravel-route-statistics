<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;
use Illuminate\Http\Request;

class RouteStatisticsMiddlewareTest extends TestCase
{
    /** @test */
    function it_adds_route_statistics_parameter()
    {
        // Given we have a request
        $request = new Request();

        // when we pass the request to this middleware,
        // it should've have added a new parameter 'routeStatistics'
        (new RouteStatistics())->handle($request, function ($request) {
            ray($request->input());
            $this->assertIsArray($request->input('routeStatistics'));
            $this->assertArrayHasKey('enabled', $request->input('routeStatistics'));
            $this->assertTrue($request->input('routeStatistics')['enabled']);
        });
    }
}
