<?php

namespace Bilfeldt\LaravelRouteStatistics\Models;

use Bilfeldt\LaravelRouteStatistics\Contracts\RouteStatisticInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteStatistic extends Model implements RouteStatisticInterface
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('user');
    }

    public static function incrementOrCreate(array $attributes, int $amount = 1)
    {
        self::firstOrCreate($attributes, ['counter' => 0])->increment('counter', $amount);
    }
}
