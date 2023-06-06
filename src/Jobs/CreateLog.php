<?php

namespace Bilfeldt\LaravelRouteStatistics\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $attributes = [];
    public array $values = [];

    /**
     * Create a new job instance.
     */
    public function __construct(array $attributes, array $values)
    {
        $this->attributes = $attributes;
        $this->values = $values;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $model_namespace = config('route-statistics.model');
        (new $model_namespace)->firstOrCreate($this->attributes, $this->values)->increment('counter', 1);
    }
}
