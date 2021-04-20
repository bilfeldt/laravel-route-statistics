<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Facades\LaravelRouteStatisticsFacade;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;

class LaravelRouteStatisticsFacadeTest extends TestCase
{
    public function test_is_a_singleton()
    {
        $first = LaravelRouteStatisticsFacade::enable();

        $second = LaravelRouteStatisticsFacade::disable();

        $this->assertSame($first, $second);
    }
}
