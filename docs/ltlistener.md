# LtListener API

`LtListener` manages listener records.

## Methods

### `LtListener::setEventFile(string $filePath): void`

#### Syntax

```php
LtListener::setEventFile(string $filePath);
```

#### Example

```php
use Lt\Events\LtListener;

LtListener::setEventFile(__DIR__ . '/storage/custom-events.json');
```

> Note: this method name currently targets the event file, not the listener file. This reflects the current code exactly.

---

### `LtListener::register(string $listenerName, string $listenerClass, string $handlerMethod = 'handle', ?string $eventName = null, bool $status = true): array|string`

#### Syntax

```php
LtListener::register(
    string $listenerName,
    string $listenerClass,
    string $handlerMethod = 'handle',
    ?string $eventName = null,
    bool $status = true
);
```

#### Example 1: Register with default handler

```php
$result = LtListener::register(
    'sendWelcomeEmail',
    App\Listeners\SendWelcomeEmail::class
);
print_r($result);
```

#### Example 2: Register with custom handler

```php
$result = LtListener::register(
    'logActivity',
    App\Listeners\LogActivity::class,
    'process',
    null,
    true
);
print_r($result);
```

#### Success Response Example

```php
[
    'responseResult' => 'Listener registered successfully',
    'responseCode' => '3863',
    'responseCategory' => '200',
    'responseData' => [
        'listener_name' => 'sendWelcomeEmail',
        'listener_class' => 'App\\Listeners\\SendWelcomeEmail',
        'handler_method' => 'handle',
        'status' => true,
        'created_at' => '2026-04-11T12:00:00Z',
        'updated_at' => '2026-04-11T12:00:00Z'
    ]
]
```

---

### `LtListener::getAll(): array|string`

#### Syntax

```php
LtListener::getAll();
```

#### Example

```php
$result = LtListener::getAll();
print_r($result);
```

---

### `LtListener::update(string $listenerName, array $updateData = []): array|string`

#### Syntax

```php
LtListener::update(string $listenerName, array $updateData = []);
```

#### Example 1: Change handler method

```php
$result = LtListener::update('sendWelcomeEmail', [
    'handler_method' => 'process'
]);
print_r($result);
```

#### Example 2: Disable listener

```php
$result = LtListener::update('sendWelcomeEmail', [
    'status' => false
]);
print_r($result);
```

#### Example 3: Change class and handler

```php
$result = LtListener::update('sendWelcomeEmail', [
    'listener_class' => App\Listeners\Mail\SendWelcomeEmail::class,
    'handler_method' => 'handleNow'
]);
print_r($result);
```

---

### `LtListener::delete(string $listenerName): array|string`

#### Syntax

```php
LtListener::delete(string $listenerName);
```

#### Example

```php
$result = LtListener::delete('sendWelcomeEmail');
print_r($result);
```

---

### `LtListener::listen(string $eventName, string $listenerName): array|string`

#### Syntax

```php
LtListener::listen(string $eventName, string $listenerName);
```

#### Example

```php
$result = LtListener::listen('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

> This method proxies to `LtEvent::listen()`.

---

### `LtListener::unlisten(string $eventName, string $listenerName): array|string`

#### Syntax

```php
LtListener::unlisten(string $eventName, string $listenerName);
```

#### Example

```php
$result = LtListener::unlisten('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

> This method proxies to `LtEvent::unlisten()`.
