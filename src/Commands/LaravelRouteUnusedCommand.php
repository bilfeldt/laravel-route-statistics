<?php

namespace Bilfeldt\LaravelRouteStatistics\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Support\Facades\DB;

class LaravelRouteUnusedCommand extends RouteListCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'route:unused';

    public $description = 'Show unused routes';

    private array $routes;

    public function handle()
    {
        $this->routes = $this->getQuery()
            ->select([
                'route',
                DB::raw('max(date) as last_used'),
                DB::raw('sum(counter) as total_counter'),
            ])
            ->groupBy('route')
            ->get()
            ->toArray();

        parent::handle();
    }

    protected function filterRoute(array $route)
    {
        $route = parent::filterRoute($route);

        if (! $route) {
            return $route;
        }

        if (in_array($route['name'], data_get($this->routes, '*.route'))
            || in_array($route['uri'], data_get($this->routes, '*.route'))
        ) {
            return null;
        }

        return $route;
    }

    protected function getModelClass(): string
    {
        return config('route-statistics.model');
    }

    protected function getQuery(): Builder
    {
        /** @var Builder */
        return ($this->getModelClass())::query();
    }
}
