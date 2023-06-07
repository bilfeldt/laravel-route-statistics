<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Jobs\CreateLog;
use Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;
use Bilfeldt\RequestLogger\Listeners\LogRequest;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use ReflectionClass;

class ImplementLogTest extends TestCase
{
    public function test_store_logs_route_statistics()
    {

        $route = 'route-statistics';

        $request = \Illuminate\Http\Request::create($route, 'GET');
        $this->app['router']->get($route, function () {

            return 'Test route response';
        });

        $response = $this->app['router']->dispatch($request); // Execute the test request
        $request->routeStatistics();

        $listener = app()->make(LogRequest::class);
        $event    = new RequestHandled($request, $response);

        $listener->handle($event); // trigger listener handle method

        $this->assertDatabaseHas('route_statistics', [
            'method' => $request->getMethod(),
            'route'  => $route,
            'status' => $response->getStatusCode(),
            'ip'     => $request->ip(),
        ]);
    }
    public function test_store_logs_with_queue_route_statistics()
    {
        $route = 'route-statistics';
        $model = (new RouteStatistic);

        $request = \Illuminate\Http\Request::create($route, 'GET');
        $this->app['router']->get($route, function () {

            return 'Test route response';
        });
        // Execute the test request
        $response = $this->app['router']->dispatch($request);
        $request->routeStatistics();
        $reflectionClass = new ReflectionClass(RouteStatistic::class);
        $teamMethod      = $reflectionClass->getMethod('getRequestTeam');
        $dateMethod      = $reflectionClass->getMethod('getDate');

        // Make the protected method accessible
        $teamMethod->setAccessible(true);
        $dateMethod->setAccessible(true);

        CreateLog::dispatchSync([
            'user_id' => optional($request->user())->getKey(),
            'team_id' => optional($teamMethod->invoke($model, $request))->getKey(),
            'method'  => $request->getMethod(),
            'route'   => $route,
            'status'  => $response->getStatusCode(),
            'ip'      => $request->ip(),
            'date'    => $dateMethod->invoke($model),
        ], ['counter' => 0]);

        $this->assertDatabaseHas('route_statistics', [
            'route'  => $route,
            'method' => $request->getMethod(),
            'ip'     => $request->ip(),
        ]);
    }

    public function test_job_will_dispatched_with_queue()
    {

        $route = 'route-statistics';

        $request = \Illuminate\Http\Request::create($route, 'GET');
        $this->app['router']->get($route, function () {

            return 'Test route response';
        });

        // Execute the test request
        $response = $this->app['router']->dispatch($request);
        $request->routeStatistics();

        Config::set('route-statistics.with_queue', true);

        Queue::fake();

        $listener = app()->make(LogRequest::class);
        $event    = new RequestHandled($request, $response);

        $listener->handle($event); // trigger listener handle method

        Queue::assertPushed(CreateLog::class);
    }
}
