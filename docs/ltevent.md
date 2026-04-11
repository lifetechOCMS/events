# LtEvent API

`LtEvent` manages event records and event-listener relationships.

## Available Methods

### `LtEvent::setEventFile(string $filePath): void`

Override the event data file path directly.

```php
LtEvent::setEventFile(__DIR__ . '/storage/custom-events.json');
```

---

### `LtEvent::register(string $eventName, array $listeners = [], bool $status = true): array|string`

Create a new event.

```php
LtEvent::register('userRegistered');
```

Register an event with listeners already attached:

```php
LtEvent::register('userRegistered', ['sendWelcomeEmail'], true);
```

---

### `LtEvent::update(string $eventName, array $updateData = []): array|string`

Update an existing event.

Supported update keys currently include:

- `status`
- `listeners`

```php
LtEvent::update('userRegistered', [
    'status' => false
]);
```

```php
LtEvent::update('userRegistered', [
    'listeners' => ['sendWelcomeEmail', 'logActivity']
]);
```

```php
LtEvent::update('userRegistered', [
    'status' => true,
    'listeners' => ['sendWelcomeEmail']
]);
```

---

### `LtEvent::delete(string $eventName): array|string`

Delete an event.

```php
LtEvent::delete('userRegistered');
```

---

### `LtEvent::listen(string $eventName, string $listenerName): array|string`

Attach a listener to an event.

```php
LtEvent::listen('userRegistered', 'sendWelcomeEmail');
```

---

### `LtEvent::unlisten(string $eventName, string $listenerName): array|string`

Remove a listener from an event.

```php
LtEvent::unlisten('userRegistered', 'sendWelcomeEmail');
```

---

### `LtEvent::getAll(): array|string`

Load all event records.

```php
LtEvent::getAll();
```

---

## Example Response Format

```php
[
    'responseResult' => 'Event registered successfully',
    'responseCode' => '3811',
    'responseCategory' => '200',
    'responseData' => [
        'event_name' => 'userRegistered',
        'status' => true,
        'created_at' => '2026-04-11T12:00:00Z',
        'updated_at' => '2026-04-11T12:00:00Z',
        'listeners' => []
    ]
]
```
