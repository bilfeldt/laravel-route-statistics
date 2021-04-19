<?php

namespace Bilfeldt\LaravelRouteStatistics;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bilfeldt\LaravelRouteStatistics\LaravelRouteStatistics
 */
class LaravelRouteStatisticsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelRouteStatistics::class;
    }
}
