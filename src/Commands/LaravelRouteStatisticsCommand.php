<?php

namespace Bilfeldt\LaravelRouteStatistics\Commands;

use Illuminate\Console\Command;

class LaravelRouteStatisticsCommand extends Command
{
    public $signature = 'laravel-route-statistics';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
