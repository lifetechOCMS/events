## [⬅ Home](../README.md)

# LtEvent API

`LtEvent` manages event records and event-listener relationships.

## Table of Contents

- [register()](#lteventregister)
- [getAll()](#lteventgetall)
- [delete()](#lteventdelete)
- [update()](#lteventupdate)
- [listen()](#lteventlisten)
- [unlisten()](#lteventunlisten)
 

## [Home](../README.md)

# LtEvent API

`LtEvent` manages event records and event-listener relationships.

## Methods


### `LtEvent::register()`

Register New Event to the system
#### Syntax

```php
LtEvent::register($eventName, $listeners,  $status );
```

#### Example 1: Register event only

```php
$result = LtEvent::register('userRegistered');
print_r($result);
```

#### Example 2: Register event with listeners

```php
$result = LtEvent::register('userRegistered', ['sendWelcomeEmail', 'logActivity']);
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

### `LtEvent::getAll()`

List all Available Events
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

### `LtEvent::delete()`

Deleta an Event
#### Syntax

```php
LtEvent::delete( $eventName);
```

#### Example

```php
$result = LtEvent::delete('userRegistered');
print_r($result);
```

---

### `LtEvent::update()`
Update an Event
#### Syntax

```php
LtEvent::update(  $eventName,   $updateData  );
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

### `LtEvent::listen()`
Allow Event to listen to a Listener,
you can read more on listener @ [LtListener API](ltlistener.md)
#### Syntax

```php
LtEvent::listen(  $eventName, $listenerName);
```

#### Example

```php
$result = LtEvent::listen('userRegistered', 'sendWelcomeEmail');
print_r($result);
```

---

### `LtEvent::unlisten()`
Allow Event to unlisten to a Listener,
you can read more on listener @ [LtListener API](ltlistener.md)
#### Syntax

```php
LtEvent::unlisten(  $eventName,   $listenerName);
```

#### Example

```php
$result = LtEvent::unlisten('userRegistered', 'sendWelcomeEmail');
print_r($result);
```
