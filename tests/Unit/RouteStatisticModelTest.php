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

    public function test_logs_parameters_if_config_enabled(): void
    {
        Config::set('route-statistics.store_route_parameters', true);

        $route = 'home';
        $params = [
            'param1' => 'one',
            'param2' => 'two',
        ];
        $request = \Illuminate\Http\Request::create($route.'/'.implode('/', $this->get_route_parameters($params)), 'GET');
        $this->app['router']->get($route.'/'.implode('/', $this->get_route_keys($params)), fn () => 'Test route response');
        $response = $this->app['router']->dispatch($request);

        (new RouteStatistic)->log($request, $response, 1, 2);

        $log = RouteStatistic::first();
        $this->assertEquals($params, $log->parameters);
    }

    public function test_logs_parameters_if_config_disabled(): void
    {
        Config::set('route-statistics.store_route_parameters', false);

        $route = 'home';
        $params = [
            'param1' => 'one',
            'param2' => 'two',
        ];
        $request = \Illuminate\Http\Request::create($route.'/'.implode('/', $this->get_route_parameters($params)), 'GET');
        $this->app['router']->get($route.'/'.implode('/', $this->get_route_keys($params)), fn () => 'Test route response');
        $response = $this->app['router']->dispatch($request);

        (new RouteStatistic)->log($request, $response, 1, 2);

        $log = RouteStatistic::first();
        $this->assertNull($log->parameters);
    }

    public function test_can_make_instance_from_factory(): void
    {
        $model = RouteStatistic::factory()->make();

        $this->assertInstanceOf(RouteStatistic::class, $model);
        $this->assertEquals($model->getAttributes()['parameters'], json_encode($model->parameters));
    }

    private function get_route_parameters(array $parameters): array
    {
        return array_values($parameters);
    }

    private function get_route_keys(array $parameters): array
    {
        return array_map(fn ($parameter) => '{'.$parameter.'}', array_keys($parameters));
    }
}
