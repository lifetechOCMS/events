# LtEvent API

`LtEvent` manages event records and event-listener relationships.

## Methods

### `LtEvent::setEventFile(string $filePath): void`

#### Syntax

```php
LtEvent::setEventFile(string $filePath);
```

#### Example

```php
use Lt\Events\LtEvent;

LtEvent::setEventFile(__DIR__ . '/storage/custom-events.json');
```

---

### `LtEvent::register(string $eventName, array $listeners = [], bool $status = true): array|string`

#### Syntax

```php
LtEvent::register(string $eventName, array $listeners = [], bool $status = true);
```

#### Example 1: Register event only

```php
$result = LtEvent::register('userRegistered');
print_r($result);
```

#### Example 2: Register event with listeners

```php
$result = LtEvent::register('userRegistered', ['sendWelcomeEmail', 'logActivity'], true);
print_r($result);
```

#### Success Response Example

```php
[
    'responseResult' => 'Event registered successfully',
    'responseCode' => '3862',
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

---

### `LtEvent::getAll(): array|string`

#### Syntax

```php
LtEvent::getAll();
```

#### Example

```php
$result = LtEvent::getAll();
print_r($result);
```

---

### `LtEvent::delete(string $eventName): array|string`

#### Syntax

```php
LtEvent::delete(string $eventName);
```

#### Example

```php
$result = LtEvent::delete('userRegistered');
print_r($result);
```

---

### `LtEvent::update(string $eventName, array $updateData = []): array|string`

#### Syntax

```php
LtEvent::update(string $eventName, array $updateData = []);
```

#### Example 1: Update status

```php
$result = LtEvent::update('userRegistered', [
    'status' => false
]);
print_r($result);
```

#### Example 2: Replace listeners

```php
$result = LtEvent::update('userRegistered', [
    'listeners' => ['sendWelcomeEmail', 'logActivity']
]);
print_r($result);
```

#### Example 3: Update status and listeners together

```php
$result = LtEvent::update('userRegistered', [
    'status' => true,
    'listeners' => ['sendWelcomeEmail']
]);
print_r($result);
```

---

### `LtEvent::listen(string $eventName, string $listenerName): array|string`

#### Syntax

```php
LtEvent::listen(string $eventName, string $listenerName);
```

#### Example

```php
$result = LtEvent::listen('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

---

### `LtEvent::unlisten(string $eventName, string $listenerName): array|string`

#### Syntax

```php
LtEvent::unlisten(string $eventName, string $listenerName);
```

#### Example

```php
$result = LtEvent::unlisten('userRegistered', 'sendWelcomeEmail');
print_r($result);
```
