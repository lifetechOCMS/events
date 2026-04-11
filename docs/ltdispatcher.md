# LtDispatcher API

`LtDispatcher` executes all listeners attached to an event.

## Method

### `LtDispatcher::dispatch(string $eventName, mixed $payload = null): array|string`

#### Syntax

```php
LtDispatcher::dispatch(string $eventName, mixed $payload = null);
```

#### Example 1: Array payload

```php
$result = LtDispatcher::dispatch('userRegistered', [
    'email' => 'user@example.com'
]);
print_r($result);
```

#### Example 2: String payload

```php
$result = LtDispatcher::dispatch('logEvent', 'User logged in');
print_r($result);
```

#### Example 3: Object payload

```php
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
