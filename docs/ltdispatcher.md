# LtDispatcher API

`LtDispatcher` executes all listeners attached to an event.

## Available Methods

### `LtDispatcher::dispatch(string $eventName, mixed $payload = null): array|string`

Dispatch an event and pass payload to every attached listener.

```php
LtDispatcher::dispatch('userRegistered', [
    'email' => 'user@example.com'
]);
```

String payload example:

```php
LtDispatcher::dispatch('logEvent', 'User logged in');
```

Object payload example:

```php
LtDispatcher::dispatch('syncProfile', $userDto);
```

## Listener Method Signature

The dispatcher sends **one parameter only** to the listener handler:

```php
public function handle($payload)
{
    // ...
}
```

Static handler is also supported:

```php
public static function handle($payload)
{
    // ...
}
```
