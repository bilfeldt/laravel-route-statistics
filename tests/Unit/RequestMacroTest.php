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
        $stats = LaravelRouteStatisticsFacade::disable();

        $this->assertFalse($stats->isEnabled());

        $request->routeStatistics();

        $this->assertTrue($stats->isEnabled());
    }

    public function test_merges_attributes()
    {
        $request = new Request();
        $stats = LaravelRouteStatisticsFacade::disable();
        $stats->setAttributes(['first_name' => 'john']);

        $request->routeStatistics(['last_name' => 'doe']);

        $this->assertEquals(['first_name' => 'john', 'last_name' => 'doe'], $stats->getAttributes());
    }
}
