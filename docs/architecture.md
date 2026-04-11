# Architecture

## Core Classes

- `EventSetting` → persistent JSON configuration
- `EventConfig` → path building, file helpers, responses
- `LtEvent` → event CRUD and listener linking
- `LtListener` → listener CRUD
- `LtDispatcher` → executes listeners for an event

## Flow

```text
EventSetting (config JSON)
        ↓
EventConfig (helpers + file paths)
        ↓
LtEvent / LtListener
        ↓
LtDispatcher
```
