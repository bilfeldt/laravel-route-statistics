<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | This is a 'master' switch to enable/disable logging. Setting this to
    | false will disable all logging.
    |
    */
    'enabled' => env('ROUTE_STATISTICS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Aggregation
    |--------------------------------------------------------------------------
    |
    | This setting controls how we should aggregate requests.
    | Possible values are: MINUTE, HOUR, DAY, MONTH, YEAR
    |
    */
    'aggregate' => env('ROUTE_STATISTICS_AGGREGATE', 'DAY'),

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | This is the model used to store request statistics.
    | It is possible to implement a custom model which extends the default model
    | or alternatively implement a completely new model which implements
    | Bilfeldt\RequestLogger\Contracts\RequestLoggerInterface
    |
    */
    'model' => env('ROUTE_STATISTICS_MODEL', \Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic::class),

    /*
    |--------------------------------------------------------------------------
    | Store Strategy
    |--------------------------------------------------------------------------
    |
    | If you set this to true, the Logs stored in the database using queues
    | It is good when you have large database
    |
    */
    'queued' => env('ROUTE_STATISTICS_QUEUED', false),
];
