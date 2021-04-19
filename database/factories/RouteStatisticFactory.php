<?php

namespace Bilfeldt\LaravelRouteStatistics\Database\Factories;

use Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteStatisticFactory extends Factory
{
    protected $model = RouteStatistic::class;

    public function definition()
    {
        return [
            'user_id' => optional($event->request->user())->id,
            'method' => $event->request->getMethod(),
            'route' => $route,
            'code' => $event->response->status(),
            'ip' => $event->request->ip(),
            'date' => now()
        ];
    }
}
