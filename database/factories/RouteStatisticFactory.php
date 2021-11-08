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
            'method' => $this->faker->randomElements(['GET', 'POST', 'PUT', 'PATCH', 'DELETE']),
            'route'  => $this->faker->domainWord().'.'.$this->faker->randomElements(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']),
            'code'   => $this->faker->randomElement([200, 201, 202, 204, 300, 301, 302, 303, 304, 400, 401, 402, 403, 404, 405, 406, 422, 429, 500, 501, 502, 503, 504]),
            'ip'     => $this->faker->ipv4,
            'date'   => $this->faker->dateTime,
        ];
    }
}
