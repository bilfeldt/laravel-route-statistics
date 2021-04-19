<?php

namespace Bilfeldt\LaravelRouteStatistics\Commands;

use Illuminate\Console\Command;

class LaravelRouteStatisticsCommand extends Command
{
    public $signature = 'laravel_route_statistics';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
