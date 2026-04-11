# LtListener API

`LtListener` manages listener records.

## Available Methods

### `LtListener::setListenerFile(string $filePath): void`

Override the listener data file path directly.

```php
LtListener::setListenerFile(__DIR__ . '/storage/custom-listeners.json');
```

---

### `LtListener::register(string $listenerName, string $listenerClass, string $handlerMethod = 'handle', bool $status = true): array|string`

Register a listener.

```php
LtListener::register(
    'sendWelcomeEmail',
    App\Listeners\SendWelcomeEmail::class
);
```

Custom handler method:

```php
LtListener::register(
    'logActivity',
    App\Listeners\LogActivity::class,
    'process'
);
```

---

### `LtListener::update(string $listenerName, array $updateData = []): array|string`

Update an existing listener.

Supported update keys currently include:

- `listener_class`
- `handler_method`
- `status`

```php
LtListener::update('sendWelcomeEmail', [
    'handler_method' => 'process'
]);
```

```php
LtListener::update('sendWelcomeEmail', [
    'status' => false
]);
```

---

### `LtListener::delete(string $listenerName): array|string`

Delete a listener.

```php
LtListener::delete('sendWelcomeEmail');
```

---

### `LtListener::getAll(): array|string`

Load all listener records.

```php
LtListener::getAll();
```
