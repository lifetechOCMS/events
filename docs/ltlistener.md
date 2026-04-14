# LtListener API

`LtListener` manages listener records.


## Table of Contents

- [register()](#ltlistenerregister)
- [getAll()](#ltlistenergetall)
- [delete()](#ltlistenerdelete)
- [update()](#ltlistenerupdate)
- [listen()](#ltlistenerlisten)
- [unlisten()](#ltlistenerunlisten)


## Methods


### `LtListener::register()`
Register New Listener
#### Syntax

```php
use Lt\Events\LtListener;
LtListener::register(
     $listenerName,
     $listenerClass,
     $handlerMethod,
);
```
 

#### Example: Register with custom handler

```php
use Lt\Events\LtListener;
$result = LtListener::register(
    'logActivity',
    'App\Listeners\LogActivit',
    'processTo', 
);
print_r($result);
```

#### Success Response Example
You can read more on response codes from [Here](response-codes.md)
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

### `LtListener::getAll()`
List All Listeners
#### Syntax

```php
use Lt\Events\LtListener;
LtListener::getAll();
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::getAll();
print_r($result);
```

---

### `LtListener::update()`

#### Syntax

```php
use Lt\Events\LtListener;
LtListener::update( $listenerName, $updateData );
```

#### Example 1: Change handler method

```php
use Lt\Events\LtListener;
$result = LtListener::update('sendWelcomeEmail', [
    'handler_method' => 'process'
]);
print_r($result);
```

#### Example 2: Disable listener

```php
use Lt\Events\LtListener;
$result = LtListener::update('sendWelcomeEmail', [
    'status' => false
]);
print_r($result);
```

#### Example 3: Change class and handler

```php
use Lt\Events\LtListener;
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
use Lt\Events\LtListener;
LtListener::delete(string $listenerName);
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::delete('sendWelcomeEmail');
print_r($result);
```

---

### `LtListener::listen(string $eventName, string $listenerName): array|string`

#### Syntax

```php
use Lt\Events\LtListener;
LtListener::listen(string $eventName, string $listenerName);
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::listen('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

> This method proxies to `LtEvent::listen()`.

---

### `LtListener::unlisten(string $eventName, string $listenerName): array|string`

#### Syntax

```php
use Lt\Events\LtListener;
LtListener::unlisten(string $eventName, string $listenerName);
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::unlisten('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

> This method proxies to `LtEvent::unlisten()`.
