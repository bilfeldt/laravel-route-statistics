<?php

namespace Bilfeldt\LaravelRouteStatistics;

use Bilfeldt\LaravelRouteStatistics\Commands\LaravelRouteStatisticsCommand;
use Bilfeldt\LaravelRouteStatistics\Commands\LaravelRouteUnusedCommand;
use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatisticsMiddleware;
use Bilfeldt\RequestLogger\RequestLoggerFacade;
use Illuminate\Routing\Router;
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
        $this->bootMacros();
        $this->bootCommands();
        $this->bootLogger();
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/route-statistics.php', 'route-statistics');
    }

    private function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/route-statistics.php' => config_path('route-statistics.php'),
        ], 'config');
    }

    private function publishMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/create_route_statistics_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_route_statistics_table.php'),
            // you can add any number of migrations here
        ], 'migrations');
    }

    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LaravelRouteStatisticsCommand::class,
                LaravelRouteUnusedCommand::class,
            ]);
        }
    }

    private function bootMiddleware()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware(RouteStatisticsMiddleware::ALIAS, RouteStatisticsMiddleware::class);
    }

    private function bootMacros()
    {
        Request::macro('routeStatistics', function () {
            if (config('route-statistics.enabled')) {
                $this->enableLog('routestat');
            }

            return $this;
        });
    }

    private function bootLogger()
    {
        RequestLoggerFacade::extend('routestat', function ($app) {
            $model = config('route-statistics.model');

            return new $model();
        });
    }
}
