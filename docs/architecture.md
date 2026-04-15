### [Home](../README.md) || [Getting Started](getting-started.md) ||  [LtEvent API](ltevent.md) || [LtListener API](ltlistener.md) ||  [LtDispatcher API](ltdispatcher.md)|| [Response Codes](response-codes.md) || [Configuration](configuration.md)  || [Architecture & Storage](architecture.md) 
---
# Architecture & Storage (LifeTech Events)

[⬅ Home](../README.md)

---

# 🧠 Architecture Overview

LifeTech Events follows a modular and layered architecture designed for flexibility and framework independence.

## Core Components

| Component | Responsibility |
|----------|--------------|
| `EventSetting` | Manages configuration (JSON-based) |
| `EventConfig` | Handles file operations and responses |
| `LtEvent` | Event CRUD and listener linking |
| `LtListener` | Listener CRUD |
| `LtDispatcher` | Executes listeners |

---

## Architecture Flow

```
EventSetting (config JSON)
        ↓
EventConfig (helpers + file paths)
        ↓
LtEvent / LtListener
        ↓
LtDispatcher (execution engine)
```

---

## Execution Flow

1. Event is registered via `LtEvent`
2. Listener is registered via `LtListener`
3. Listener is attached to event
4. Dispatcher triggers listeners with payload

---

# 💾 Storage System

LifeTech Events uses a **file-based JSON storage system** instead of a database.

---

## Storage Structure

```
storage/
└── events/
    ├── eventdata.json
    ├── listenerdata.json
    └── eventsetting.json
```

---

## Storage Files

### 1. eventdata.json

Stores all events.

```json
{
  "events": [
    {
      "event_name": "userRegistered",
      "status": true,
      "created_at": "...",
      "updated_at": "...",
      "listeners": []
    }
  ]
}
```

---

### 2. listenerdata.json

Stores all listeners.

```json
{
  "listeners": [
    {
      "listener_name": "sendWelcomeEmail",
      "listener_class": "App\\Listeners\\SendWelcomeEmail",
      "handler_method": "handle",
      "status": true
    }
  ]
}
```

---

### 3. eventsetting.json

Stores configuration.

```json
{
  "storage_path": "...",
  "event_file": "eventdata.json",
  "listener_file": "listenerdata.json",
  "response_type": "array"
}
```

---

# ⚙️ Configuration Example

```php
use Lt\Events\EventSetting;

EventSetting::set('storage_path', __DIR__ . '/storage/events');
EventSetting::set('response_type', 'json');
```

---

# 🔒 Storage Best Practices

- Store JSON files outside public web root  
- Restrict file permissions  
- Backup storage regularly  
- Avoid direct URL access  

---

# 🚀 Why File-Based Storage?

- No database dependency  
- Easy to debug  
- Fast for lightweight applications  
- Simple integration  

---

# 📌 Notes

- Storage is automatically created if not found  
- JSON structure is validated on load  
- Default values are used when files are empty  

---

# ⭐ Summary

LifeTech Events architecture is:

- modular  
- lightweight  
- scalable  
- framework-independent  

and designed for modern PHP applications.
