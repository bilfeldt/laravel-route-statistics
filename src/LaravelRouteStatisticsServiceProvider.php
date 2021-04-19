<?php

namespace Bilfeldt\LaravelRouteStatistics;

use Bilfeldt\LaravelRouteStatistics\Commands\LaravelRouteStatisticsCommand;
use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Listeners\LogRouteStatistics;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelRouteStatisticsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-route-statistics')
            ->hasConfigFile()
            ->hasMigration('create_route_statistics_table')
            ->hasCommand(LaravelRouteStatisticsCommand::class);
    }

    public function boot()
    {
        parent::boot();

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('routestats', RouteStatistics::class);

        Event::listen(
            RequestHandled::class,
            [LogRouteStatistics::class, 'handle']
        );
    }
}
