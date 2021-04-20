<?php

namespace Bilfeldt\LaravelRouteStatistics;

use Bilfeldt\LaravelRouteStatistics\Commands\LaravelRouteStatisticsCommand;
use Bilfeldt\LaravelRouteStatistics\Facades\LaravelRouteStatisticsFacade;
use Bilfeldt\LaravelRouteStatistics\Http\Middleware\RouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Listeners\LogRouteStatistics;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class LaravelRouteStatisticsServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        LaravelRouteStatisticsFacade::class => LaravelRouteStatistics::class,
    ];

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
            __DIR__.'/../database/migrations/create_route_statistics_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_route_statistics_table.php'),
          // you can add any number of migrations here
        ], 'migrations');
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
            LaravelRouteStatisticsFacade::enable()->mergeAttributes($attributes);

            return $this;
        });
    }
}
