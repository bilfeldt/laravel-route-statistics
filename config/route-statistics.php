<?php

return [
    'enabled' => env('ROUTE_STATISTICS_ENABLED', true),

    'aggregate' => env('ROUTE_STATISTICS_AGGREGATE', 'DAY'), // Possible values are: MINUTE, HOUR, DAY, MONTH, YEAR
];
