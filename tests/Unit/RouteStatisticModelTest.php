<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Jobs\CreateLog;
use Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;

class RouteStatisticModelTest extends TestCase
{
    public function test_logs_sync_if_queued_config_disabled(): void
    {
        Config::set('route-statistics.queued', false);

        Queue::fake();

        $request = \Illuminate\Http\Request::create($route = 'home', 'GET');
        $this->app['router']->get($route, fn () => 'Test route response');
        $response = $this->app['router']->dispatch($request);

        (new RouteStatistic)->log($request, $response, 1, 2);

        Queue::assertNotPushed(CreateLog::class);

        $this->markTestIncomplete('Mock the attributes and check that they are persisted in DB');
    }

    public function test_logs_queued_if_queued_config_enabled(): void
    {
        Config::set('route-statistics.queued', true);

        Queue::fake();

        $request = \Illuminate\Http\Request::create($route = 'home', 'GET');
        $this->app['router']->get($route, fn () => 'Test route response');
        $response = $this->app['router']->dispatch($request);

        (new RouteStatistic)->log($request, $response, 1, 2);

        Queue::assertPushed(CreateLog::class);
    }

    public function test_get_log_attributes(): void
    {
        $this->markTestIncomplete('Mock the request and response to ensture the correct attributes are returned');
    }
}
