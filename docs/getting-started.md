### [Home](../README.md) || [Getting Started](getting-started.md) ||  [LtEvent API](ltevent.md) || [LtListener API](ltlistener.md) ||  [LtDispatcher API](ltdispatcher.md)|| [Response Codes](response-codes.md) || [Configuration](configuration.md)  || [Architecture](architecture.md) 
---
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
