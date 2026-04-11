# Configuration

The package uses `EventSetting` for persistent JSON configuration.

## Set values

```php
use Lt\Events\EventSetting;

EventSetting::set('storage_path', __DIR__ . '/storage/events');
EventSetting::set('event_file', 'eventdata.json');
EventSetting::set('listener_file', 'listenerdata.json');
EventSetting::set('response_type', 'array');
```

## Read values

```php
EventSetting::get();
EventSetting::get('storage_path');
```
