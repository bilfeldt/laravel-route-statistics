<?php

namespace Bilfeldt\LaravelRouteStatistics\Models;

use Bilfeldt\RequestLogger\Contracts\RequestLoggerInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class RouteStatistic extends Model implements RequestLoggerInterface
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
    ];

    //======================================================================
    // ACCESSORS
    //======================================================================

    //======================================================================
    // MUTATORS
    //======================================================================

    //======================================================================
    // SCOPES
    //======================================================================

    public function scopeWhereApi(Builder $query): Builder
    {
        return $query->where('route', 'LIKE', 'api.%');
    }

    public function scopeWhereWeb(Builder $query): Builder
    {
        return $query->where('route', 'NOT LIKE', 'api.%');
    }

    //======================================================================
    // RELATIONS
    //======================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo('App\\Models\\Team');
    }

    //======================================================================
    // METHODS
    //======================================================================

    public function log(Request $request, $response, ?int $time = null, ?int $memory = null): void
    {
        if ($route = optional($request->route())->getName() ?? optional($request->route())->uri()) {
            static::firstOrCreate([
                'user_id' => optional($request->user())->getKey(),
                'team_id' => optional($this->getRequestTeam($request))->getKey(),
                'method'  => $request->getMethod(),
                'route'   => $route,
                'status'  => $response->getStatusCode(),
                'ip'      => $request->ip(),
                'date'    => $this->getDate(),
            ], ['counter' => 0])->increment('counter', 1);
        }
    }

    protected function getRequestTeam(Request $request): ?Model
    {
        if ($request->route('team') instanceof Model) {
            return $request->route('team');
        }

        if ($user = $request->user()) {
            return method_exists($user, 'currentTeam') ? $user->currentTeam : null;
        }

        return null;
    }

    protected function getDate()
    {
        $date = Date::now();
        $aggregate = config('route-statistics.aggregate');

        if ($aggregate && ! in_array($aggregate, ['YEAR', 'MONTH', 'DAY', 'HOUR', 'MINUTE'])) {
            throw new \OutOfBoundsException('Invalid date aggregation');
        }

        if (in_array($aggregate, ['YEAR', 'MONTH', 'DAY', 'HOUR', 'MINUTE'])) {
            $date->setSecond(0);
        }

        if (in_array($aggregate, ['YEAR', 'MONTH', 'DAY', 'HOUR'])) {
            $date->setMinute(0);
        }

        if (in_array($aggregate, ['YEAR', 'MONTH', 'DAY'])) {
            $date->setHour(0);
        }

        if (in_array($aggregate, ['YEAR', 'MONTH'])) {
            $date->setDay(1);
        }

        if (in_array($aggregate, ['YEAR'])) {
            $date->setMonth(1);
        }

        return $date;
    }

    protected static function newFactory()
    {
        return \Bilfeldt\LaravelRouteStatistics\Database\Factories\RouteStatisticFactory::new();
    }
}
