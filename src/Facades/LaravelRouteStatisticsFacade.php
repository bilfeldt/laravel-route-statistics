<?php

namespace Bilfeldt\LaravelRouteStatistics\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static $this isEnabled(): bool
 * @method static $this enable(): self
 * @method static $this disable(): self
 * @method static $this setEnable(bool $enable): self
 * @method static $this setAttributes(array $attributes): self
 * @method static $this getAttributes(): array
 * @method static $this mergeAttributes(array $attributes): self
 */
class LaravelRouteStatisticsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelRouteStatisticsFacade::class;
    }
}
