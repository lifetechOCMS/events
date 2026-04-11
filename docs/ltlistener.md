# LtListener API

`LtListener` manages listener records.

## Methods

### `LtListener::setListenerFile(string $filePath): void`

#### Syntax

```php
LtListener::setListenerFile(string $filePath);
```

#### Example

```php
use Lt\Events\LtListener;

LtListener::setListenerFile(__DIR__ . '/storage/custom-listeners.json');
```

---

### `LtListener::register(string $listenerName, string $listenerClass, string $handlerMethod = 'handle', bool $status = true): array|string`

#### Syntax

```php
LtListener::register(
    string $listenerName,
    string $listenerClass,
    string $handlerMethod = 'handle',
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
    true
);
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

## Example Success Response

```php
[
    'responseResult' => 'Listener registered successfully',
    'responseCode' => '3824',
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
