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
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->runMigrations([
            'create_route_statistics_table',
            'add_parameters_to_route_statistics_table',
        ]);
    }

    private function runMigrations(array $fileNames): void
    {
        foreach ($fileNames as $fileName) {
            $class = require __DIR__.'/../database/migrations/'.$fileName.'.php.stub';
            $class->up();
        }
    }
}
