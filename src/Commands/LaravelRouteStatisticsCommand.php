<?php

namespace Bilfeldt\LaravelRouteStatistics\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaravelRouteStatisticsCommand extends Command
{
    public $signature = 'route:stats
                                    {--user=*}
                                    {--team=*}
                                    {--method=*}
                                    {--route=}
                                    {--status=}
                                    {--ip=}
                                    {--after=}
                                    {--before=}
                                    {--date=}
                                    {--sort=-counter}
                                    {--group=*}
                                    {--limit=20}
                                    ';

    public $description = 'Show route usage statistics';

    public function handle()
    {
        $query = $this->getQuery();

        if ($this->option('group')) {
            $query->select($this->option('group'))
                ->addSelect(DB::raw('MAX(date) as last_used'))
                ->addSelect(DB::raw('SUM(counter) as counter'));
        }

        $this->applyFilters($query);
        $this->applyGrouping($query);
        $this->applySorting($query);

        $results = $query->limit($this->option('limit'))->get();

        $this->table(
            $this->getFields(),
            $results->toArray()
        );

        return Command::SUCCESS;
    }

    protected function getModelClass(): string
    {
        return config('route-statistics.model');
    }

    protected function getQuery(): Builder
    {
        /** @var Builder */
        return ($this->getModelClass())::query();
    }

    protected function applyFilters(Builder $query): Builder
    {
        return $query->when(! empty($this->option('user')), function (Builder $query) {
            $query->whereIn('user_id', $this->option('user'));
        })->when(! empty($this->option('team')), function (Builder $query) {
            $query->whereIn('team_id', $this->option('team'));
        })->when(! empty($this->option('method')), function (Builder $query) {
            $query->whereIn('method', $this->option('method'));
        })->when(! empty($this->option('route')), function (Builder $query) {
            $query->where('route', 'LIKE', $this->option('route'));
        })->when(! empty($this->option('status')), function (Builder $query) {
            $query->where('status', 'LIKE', $this->option('status'));
        })->when(! empty($this->option('ip')), function (Builder $query) {
            $query->where('ip', 'LIKE', $this->option('ip'));
        })->when(! empty($this->option('after')), function (Builder $query) {
            $query->where('date', '>=', $this->option('after'));
        })->when(! empty($this->option('before')), function (Builder $query) {
            $query->where('date', '<=', $this->option('before'));
        })->when(! empty($this->option('date')), function (Builder $query) {
            $query->whereDate('date', $this->option('date'));
        });
    }

    protected function applyGrouping(Builder $query): Builder
    {
        return $query->when($this->option('group'), function (Builder $query) {
            $query->groupBy($this->option('group'));
        });
    }

    protected function applySorting(Builder $query): Builder
    {
        $sort = $this->option('sort');

        if (Str::startsWith($sort, '-')) {
            $sort = substr($sort, 1);
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        return $query->orderBy($sort, $order);
    }

    protected function getFields(): array
    {
        if ($this->option('group')) {
            return array_merge($this->option('group'), ['last_used', 'counter']);
        }

        return [
            'id',
            'user_id',
            'team_id',
            'method',
            'route',
            'status',
            'ip',
            'date',
            'counter',
        ];
    }
}
