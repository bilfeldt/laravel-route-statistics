<?php

namespace Bilfeldt\LaravelRouteStatistics;

use Bilfeldt\LaravelRouteStatistics\Commands\LaravelRouteStatisticsCommand;
use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Listeners\LogRouteStatistics;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class LaravelRouteStatisticsServiceProvider extends ServiceProvider
{
    /*
    public function configurePackage(Package $package): void
    {
        //
        // This class is a Package Service Provider
        //
        // More info: https://github.com/spatie/laravel-package-tools
        //
        $package
            ->name('laravel-route-statistics')
            ->hasConfigFile()
            ->hasMigration('create_route_statistics_table')
            ->hasCommand(LaravelRouteStatisticsCommand::class);
    }
    */

    public function register()
    {
        $this->mergeConfig();
    }

    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();

        $this->bootMiddleware();
        $this->bootEventListeners();
        $this->bootMacros();
        $this->bootCommands();
    }

    private function mergeConfig()
    {
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'route-statistics');
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('route-statistics.php')], 'config');
    }

    private function publishMigrations()
    {
        $path = $this->getMigrationsPath();
        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LaravelRouteStatisticsCommand::class,
            ]);
        }
    }

    private function bootMiddleware()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('routestatistics', RouteStatistics::class);
    }

    private function bootEventListeners()
    {
        Event::listen(
            RequestHandled::class,
            [LogRouteStatistics::class, 'handle']
        );
    }

    private function bootMacros()
    {
        Request::macro('routeStatistics', function (array $attributes = []) {
            return $this->merge([
                'routeStatistics' => array_merge(['enabled' => true], $attributes),
            ]);
        });
    }

    private function getConfigPath()
    {
        return __DIR__ . '/../config/route-statistics.php';
    }

    private function getMigrationsPath()
    {
        return __DIR__ . '/../database/migrations/';
    }
}
