## [⬅ Home](../README.md)
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
    'App\Listeners\LogActivity',
    'processTo', 
);
print_r($result);
```

#### Success Response Example
You can read more on response codes from [Here](response-codes.md)


#### Example of a Listener Class 
```php
namespace App\Listeners;

class LogActivity
{
    public function processTo(){
        return "Listener Listened to an event";
    }
}
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

### `LtListener::delete()`

#### Syntax

```php
use Lt\Events\LtListener;
LtListener::delete($listenerName);
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::delete('sendWelcomeEmail');
print_r($result);
```

---

### `LtListener::listen()`

#### Syntax

```php
use Lt\Events\LtListener;
LtListener::listen($eventName, $listenerName);
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::listen('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

> This method proxies to `LtEvent::listen()`.

---

### `LtListener::unlisten()`

#### Syntax

```php
use Lt\Events\LtListener;
LtListener::unlisten( $eventName, $listenerName);
```

#### Example

```php
use Lt\Events\LtListener;
$result = LtListener::unlisten('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

> This method proxies to `LtEvent::unlisten()`.
