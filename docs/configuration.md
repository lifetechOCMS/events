### [Home](../README.md) || [Getting Started](getting-started.md) ||  [LtEvent API](ltevent.md) || [LtListener API](ltlistener.md) ||  [LtDispatcher API](ltdispatcher.md)|| [Response Codes](response-codes.md) || [Configuration](configuration.md)  || [Architecture](architecture.md) 
---

# Configuration

The package uses `EventSetting` for persistent JSON configuration.

## Read all settings

```php
use Lt\Events\EventSetting;

print_r(EventSetting::get());
```

## Read one setting

```php
echo EventSetting::get('storage_path');
```

## Update a setting

```php
print_r(EventSetting::set('storage_path', __DIR__ . '/storage/events'));
print_r(EventSetting::set('response_type', 'json'));
```

## Setting keys currently used

- `storage_path`
- `event_file`
- `listener_file`
- `response_type`
```
