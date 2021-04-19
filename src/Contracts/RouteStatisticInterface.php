<?php

namespace Bilfeldt\LaravelRouteStatistics\Contracts;

interface RouteStatisticInterface
{
    public static function incrementOrCreate(array $attributes, int $amount = 1);
}
