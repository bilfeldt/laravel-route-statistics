# This is my package LaravelRouteStatistics

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bilfeldt/laravel-route-statistics.svg?style=flat-square)](https://packagist.org/packages/bilfeldt/laravel-route-statistics)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bilfeldt/laravel-route-statistics/run-tests?label=tests)](https://github.com/bilfeldt/laravel-route-statistics/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bilfeldt/laravel-route-statistics/Check%20&%20fix%20styling?label=code%20style)](https://github.com/bilfeldt/laravel-route-statistics/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/bilfeldt/laravel-route-statistics.svg?style=flat-square)](https://packagist.org/packages/bilfeldt/laravel-route-statistics)

Log requests and group together for aggregated statistics of route usage. This package is usefull for logging:

- Authenticated requests: We log the authenticated user
- Unauthenticated requests: We log the IP - this is especially interesting to track scrapers or login attempts  
- 3xx/4xx/5xx requests: It can be useful not only to log successful responses but also those resulting in errors

## Installation

You can install the package via composer:

```bash
composer require bilfeldt/laravel-route-statistics
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Bilfeldt\LaravelRouteStatistics\LaravelRouteStatisticsServiceProvider" --tag="route-statistics-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Bilfeldt\LaravelRouteStatistics\LaravelRouteStatisticsServiceProvider" --tag="route-statistics-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel_route_statistics = new Bilfeldt\LaravelRouteStatistics();
echo $laravel_route_statistics->echoPhrase('Hello, Spatie!');
```

## How it works

This package works as follows:
1. Tag the request for logging: Can be done using middleware or request helper
2. (optional) Add any context data which will be used when logging: A common use case is adding relevant route parameters 
3. Log the request: Persist the log record to the database

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Anders Bilfeldt](https://github.com/bilfeldt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
