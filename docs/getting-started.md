## [Home](../README.md) || [Getting Started](docs/getting-started.md) ||  [LtEvent API](docs/ltevent.md) || [LtListener API](docs/ltlistener.md) ||  [LtDispatcher API](docs/ltdispatcher.md)|| [Response Codes](docs/response-codes.md) || [Configuration](docs/configuration.md)  || [Architecture](docs/architecture.md) 

# Getting Started

## Basic Flow

```php
use Lt\Events\LtEvent;
use Lt\Events\LtListener;
use Lt\Events\LtDispatcher;

LtEvent::register('userRegistered');

LtListener::register(
    'sendWelcomeEmail',
    App\Listeners\SendWelcomeEmail::class
);

LtEvent::listen('userRegistered', 'sendWelcomeEmail');

LtDispatcher::dispatch('userRegistered', [
    'email' => 'user@example.com'
]);
```

## Typical Response Structure

```php
[
    'responseResult' => 'Event Registered',
    'responseCode' => '3811',
    'responseCategory' => '200',
    'responseData' => [...]
]
```
