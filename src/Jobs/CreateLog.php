<?php

namespace Bilfeldt\LaravelRouteStatistics\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $attributes;

    /**
     * Create a new job instance.
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $modelClass = config('route-statistics.model');
        $modelClass::firstOrCreate($this->attributes, ['counter' => 0])->increment('counter', 1);
    }
}
