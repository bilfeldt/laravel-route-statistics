<?php

namespace Bilfeldt\LaravelRouteStatistics\Commands;

use Exception;
use Illuminate\Console\Command;
use TypeError;

class LaravelRouteTruncateCommand extends Command
{
    public $signature = 'route:truncate-stats';

    public $description = 'Prune route usage statistics';

    public function handle(): int
    {
        try {
            call_user_func_array([config('route-statistics.model'), 'truncate'], []);
        }
        catch(TypeError $ex) {
            $this->components->error('Failed to truncate route usage statistics: '.$ex->getMessage());
        }

        $this->components->info('Route usage statistics truncated');

        return Command::SUCCESS;
    }
}
