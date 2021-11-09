<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests;

use Bilfeldt\LaravelRouteStatistics\LaravelRouteStatisticsServiceProvider;
use Bilfeldt\RequestLogger\RequestLoggerServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Bilfeldt\\LaravelRouteStatistics\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            RequestLoggerServiceProvider::class,
            LaravelRouteStatisticsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $migration = include __DIR__.'/../database/migrations/create_route_statistics_table.php.stub';
        $migration->up();
    }
}
