# Changelog

All notable changes to `laravel-route-statistics` will be documented in this file.

## 0.4.0

- Remove the facade and listener and instead rely on the `bilfeldt/laravel-request-logger` package for actual logging.
- Remove `RouteStatisticInterface` in favor of `\Bilfeldt\RequestLogger\Contracts\RequestLoggerInterface`
- Remove attributes from log method
- Note that this release contains breaking changes if one interacting with the facade, model, listener or interface directly but for those simply relying on the default macros and middleware there is no problem updating.

## 0.3.0

- Fix issue with Factory
- Fix issue with event/listener registration

## 0.2.0

- Implement usage of facade and singleton class instead of adding data to the request input

## 0.1.1

- Fix issue with publishing of config and migration

## 0.1.0

- initial release
