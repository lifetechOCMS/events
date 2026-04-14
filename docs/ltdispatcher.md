### [Home](../README.md) || [Getting Started](getting-started.md) ||  [LtEvent API](ltevent.md) || [LtListener API](ltlistener.md) ||  [LtDispatcher API](ltdispatcher.md)|| [Response Codes](response-codes.md) || [Configuration](configuration.md)  || [Architecture](architecture.md) 
---

# LtDispatcher API

`LtDispatcher` executes all listeners attached to an event.

## Method

### `LtDispatcher::dispatch($eventName, $payload)`

#### Syntax

```php
use Lt\Events\LtDispatcher;
LtDispatcher::dispatch($eventName, $payload);
```

#### Example 1: Dispatch with Array payload

```php
use Lt\Events\LtDispatcher;
$result = LtDispatcher::dispatch('userRegistered', [
    'email' => 'user@example.com'
]);
print_r($result);
```

#### Example 2: Dispatch with String payload

```php
use Lt\Events\LtDispatcher;
$result = LtDispatcher::dispatch('logEvent', 'User logged in');
print_r($result);
```

#### Example 3: Dispatch with  Object payload

```php
use Lt\Events\LtDispatcher;
$result = LtDispatcher::dispatch('syncProfile', $userDto);
print_r($result);
```

## Listener Handler Signature

The dispatcher sends **one parameter only** to the handler:

```php
public function handle($payload)
{
    // ...
}
```

Static handlers are also supported:

```php
public static function handle($payload)
{
    // ...
}
```

## Dispatch Result Details

The dispatcher aggregates per-listener results into the final response:

- success
- skipped
- failed
- listener handler return value
