<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatisticsMiddleware;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;
use Illuminate\Http\Request;

class RouteStatisticsMiddlewareTest extends TestCase
{
    /** @test */
    public function test_enables_route_statistics_pre_stream()
    {
        $request = new Request();

        $this->assertEmpty($request->attributes->get('log'));

        // when we pass the request to this middleware,
        // it should add a 'routestat' to the array attributes 'log'
        (new RouteStatisticsMiddleware())->handle($request, function ($request) {
            $this->assertIsArray($request->attributes->get('log'));
            $this->assertContains('routestat', $request->attributes->get('log'));
        });
    }
}
