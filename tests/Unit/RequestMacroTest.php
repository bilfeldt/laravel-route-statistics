<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Facades\LaravelRouteStatisticsFacade;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;
use Illuminate\Http\Request;

class RequestMacroTest extends TestCase
{
    public function test_enables_route_statistics()
    {
        $request = new Request();

        $this->assertEmpty($request->attributes->get('log'));

        $request->routeStatistics();

        $this->assertIsArray($request->attributes->get('log'));
        $this->assertContains('routestat', $request->attributes->get('log'));
    }
}
