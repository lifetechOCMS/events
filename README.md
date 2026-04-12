📦 LifeTech Events — Lightweight PHP Event System
![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-active-success)
![Maintained](https://img.shields.io/badge/maintained-yes-brightgreen)
![Packagist Version](https://img.shields.io/packagist/v/lifetechocms/events)
![Downloads](https://img.shields.io/packagist/dt/lifetechocms/events)
![GitHub Stars](https://img.shields.io/github/stars/lifetechocms/events?style=social)
> A lightweight, framework-agnostic **event dispatcher system for PHP**, built for modular applications, custom frameworks, and scalable architectures.
---
🚀 Overview
LifeTech Events is a powerful yet simple event-driven architecture package for PHP that allows developers to:
create and manage events
register listeners dynamically
attach listeners to events
dispatch events with payloads
Unlike traditional event systems, this package is:
✅ database-free (JSON storage)
✅ framework-independent
✅ easy to integrate
✅ production-ready
---
🔍 Why Use LifeTech Events?
Most PHP event systems are:
tightly coupled to frameworks (Laravel, Symfony)
require service containers
complex to configure
LifeTech Events solves this by offering:
✔ Zero framework dependency  
✔ Simple and intuitive API  
✔ File-based persistence (no DB needed)  
✔ Flexible event-listener mapping  
✔ Clean response structure for APIs
---
✨ Key Features
🔄 Event registration and lifecycle management
🎧 Listener registration and execution
⚡ Dispatcher supporting static & instance methods
💾 JSON-based persistent storage
⚙️ Runtime configuration via `EventSetting`
📦 Fully modular and extensible
---
⚙️ Installation
```bash
composer require lifetechocms/events
```
---
📌 Quick Start
```php
use Lt\Events\LtEvent;
use Lt\Events\LtListener;
use Lt\Events\LtDispatcher;

LtEvent::register('userRegistered');

LtListener::register(
    'sendWelcomeEmail',
    App\Listeners\SendWelcomeEmail::class
);

LtEvent::listen('userRegistered', 'sendWelcomeEmail');

LtDispatcher::dispatch('userRegistered', [
    'email' => 'user@example.com'
]);
```
---
🧠 How It Works
```
EventSetting (JSON config)
        ↓
EventConfig (file + helpers)
        ↓
LtEvent / LtListener
        ↓
LtDispatcher (execution engine)
```
---
🎯 Use Cases
Event-driven PHP applications
Custom MVC frameworks
Plugin/module systems
Notification systems
Logging and auditing systems
Decoupled business logic
---
👥 Who Should Use This?
PHP Developers
Backend Engineers
Laravel / Symfony users
LifeTech OCMS users
---
⚙️ Configuration
```php
use Lt\Events\EventSetting;

EventSetting::set('storage_path', __DIR__ . '/storage/events');
EventSetting::set('response_type', 'json');
```
---
🔁 Response Format
```php
[
  'responseResult' => '...',
  'responseCode' => '3862',
  'responseCategory' => '200',
  'responseData' => [...]
]
```
---
📚 Documentation
docs/getting-started.md
docs/ltevent.md
docs/ltlistener.md
docs/ltdispatcher.md
docs/response-codes.md
---
🔒 Security Best Practices
store JSON files outside public web root
validate listener classes
restrict file permissions
---
🛣️ Roadmap
Event priority system
Async / queue support
Middleware
Plugin system
Event logging
---
👤 Author
Ajayi Abolore A. Ajayi  
Founder & Lead Architect — LifeTech OCMS
---
📄 License
MIT License
---
⭐ Contribute
Star the repo
Fork and contribute
Report issues
---
🔥 SEO Keywords
PHP event system, PHP dispatcher, PHP listener system, event-driven PHP, lightweight PHP events, PHP observer alternative