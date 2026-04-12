# 📦 LifeTech Events Package

![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-in--development-orange)

A lightweight, file-based event and listener system for PHP applications, designed for simplicity, flexibility, and framework independence.

---

# 🚀 Overview

LifeTech Events is a modular event-dispatching system that allows you to:

- define events
- register listeners
- link listeners to events
- dispatch events with payloads

It uses a **JSON-based storage system**, making it easy to integrate into any PHP project without requiring a database.

---

# 💡 Why This Package?

Most PHP event systems are:

- tightly coupled to frameworks (Laravel, Symfony)
- require service containers
- depend on complex configurations

This package is designed to be:

✔ framework-agnostic  
✔ lightweight  
✔ easy to integrate  
✔ file-based (no database required)  
✔ developer-friendly API  

---

# ✨ Key Advantages

## 1. No Framework Dependency
Works in:

- plain PHP
- custom frameworks (like LifeTech OCMS)
- Laravel / Symfony (as standalone module)

---

## 2. File-Based Storage
- No database required  
- Uses JSON for persistence  
- Easy to debug and inspect  

---

## 3. Simple API Design

```php
LtEvent::register('userRegistered');
LtListener::register('sendEmail', SendEmail::class);
LtEvent::listen('userRegistered', 'sendEmail');
LtDispatcher::dispatch('userRegistered', $payload);
```

---

## 4. Flexible Listener Execution

Supports both:

### Instance methods
```php
public function handle($payload) {}
```

### Static methods
```php
public static function handle($payload) {}
```

---

## 5. Persistent Configuration

Uses `EventSetting`:

```php
EventSetting::set('storage_path', '/custom/path');
EventSetting::set('response_type', 'json');
```

---

## 6. Consistent Response System

Every operation returns structured responses:

```php
[
  'responseResult' => '...',
  'responseCode' => '3862',
  'responseCategory' => '200',
  'responseData' => [...]
]
```

---

# 🧱 Core Components

| Component | Responsibility |
|----------|--------------|
| `EventSetting` | Config management (JSON-based) |
| `EventConfig` | File handling & utilities |
| `LtEvent` | Event CRUD + linking |
| `LtListener` | Listener CRUD |
| `LtDispatcher` | Executes listeners |

---

# ⚙️ Installation

```bash
composer require lifetechocms/events
```

---

# 📌 Basic Usage

```php
use Lt\Events\LtEvent;
use Lt\Events\LtListener;
use Lt\Events\LtDispatcher;

LtEvent::register('userRegistered');

LtListener::register('sendWelcomeEmail', App\Listeners\SendWelcomeEmail::class);

LtEvent::listen('userRegistered', 'sendWelcomeEmail');

LtDispatcher::dispatch('userRegistered', [
    'email' => 'user@example.com'
]);
```

---

# 👥 Who Can Use This Package?

This package is ideal for:

- PHP Developers building custom frameworks  
- Backend Engineers implementing event-driven systems  
- Laravel / Symfony users needing lightweight event handling  
- LifeTech OCMS users for native integration  

---

# 🧠 Use Cases

- user registration workflows  
- logging systems  
- notification systems  
- plugin/module systems  
- background task triggers  

---

# 🔒 Security Notes

- keep storage outside public web root  
- validate listener classes before execution  
- avoid exposing config JSON directly  

---

# 📚 Documentation

See full docs:

- docs/getting-started.md  
- docs/ltevent.md  
- docs/ltlistener.md  
- docs/ltdispatcher.md  
- docs/response-codes.md  

---

# 🛣️ Roadmap

- event priority system  
- async/queue support  
- middleware layer  
- event subscribers  

---

# 👤 Author

**Ajayi Abolore A. Ajayi**  
Founder & Lead Architect — LifeTech OCMS  

---

# 📄 License

MIT License
