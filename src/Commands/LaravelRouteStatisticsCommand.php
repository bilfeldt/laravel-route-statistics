<?php

namespace Bilfeldt\LaravelRouteStatistics\Commands;

use Illuminate\Console\Command;

class LaravelRouteStatisticsCommand extends Command
{
    public $signature = 'routestat';

    public $description = 'Show route usage statistics';

    public function handle()
    {
        $this->comment('All done');
    }
}
