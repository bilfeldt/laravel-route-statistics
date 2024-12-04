# Upgrade guide

## 3.* => 4.*

A new nullable json field `parameters` has been added after the `route` field.

Simply publish the migration files and migrate:

```bash
php artisan vendor:publish --provider="Bilfeldt\LaravelRouteStatistics\LaravelRouteStatisticsServiceProvider" --tag="migrations"
php artisan migrate
```

## 2.* => 3.*

There are no breaking changes if you are simply using this package. But the dependency of [`bilfeldt/laravel-request-logger`](https://packagist.org/packages/bilfeldt/laravel-request-logger) was upgraded to version 3 which means if you are also logging requests using this package, then you need to consult [the upgrade guide for that package](https://github.com/bilfeldt/laravel-request-logger/blob/main/CHANGELOG.md#2--3).

## 1.* => 2.*

No breaking changes. The only changes are to the development dependencies used for testing and then the minimum Laravel and PHP requirements.
