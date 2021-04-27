<?php

namespace Bilfeldt\LaravelRouteStatistics\Listeners;

use Bilfeldt\LaravelRouteStatistics\Facades\LaravelRouteStatisticsFacade;
use Illuminate\Foundation\Http\Events\RequestHandled;

class LogRouteStatistics
{
    public function handle(RequestHandled $event)
    {
        if (! config('route-statistics.enabled')) {
            return;
        }

        if (! LaravelRouteStatisticsFacade::isEnabled()) {
            return;
        }

        if ($route = optional($event->request->route())->getName() ?? optional($event->request->route())->uri()) {
            $model = config('route-statistics.model');
            $model::incrementOrCreate(array_merge([
                'user_id' => optional($event->request->user())->id,
                'method' => $event->request->getMethod(),
                'route' => $route,
                'code' => $event->response->status(),
                'ip' => $event->request->ip(),
                'date' => $this->getDate(),
            ], LaravelRouteStatisticsFacade::getAttributes()));
        }
    }

    protected function getDate()
    {
        $date = now();

        if (in_array(config('route-statistics.aggregate'), ['YEAR', 'MONTH', 'DAY', 'HOUR', 'MINUTE'])) {
            $date->setSecond(0);
        }

        if (in_array(config('route-statistics.aggregate'), ['YEAR', 'MONTH', 'DAY', 'HOUR'])) {
            $date->setMinute(0);
        }

        if (in_array(config('route-statistics.aggregate'), ['YEAR', 'MONTH', 'DAY'])) {
            $date->setHour(0);
        }

        if (in_array(config('route-statistics.aggregate'), ['YEAR', 'MONTH'])) {
            $date->setDay(1);
        }

        if (in_array(config('route-statistics.aggregate'), ['YEAR'])) {
            $date->setMonth(1);
        }

        return $date;
    }
}
