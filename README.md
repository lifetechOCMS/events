# 📦 LifeTechOCMS Events — Lightweight PHP Event System

![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-active-success)
![Maintained](https://img.shields.io/badge/maintained-yes-brightgreen)
![Packagist Version](https://img.shields.io/packagist/v/lifetechocms/events)
![Downloads](https://img.shields.io/packagist/dt/lifetechocms/events)
![GitHub Stars](https://img.shields.io/github/stars/lifetechocms/events?style=social)

> A lightweight, framework-agnostic **event dispatcher system for PHP**, built for modular applications, custom frameworks, and scalable architectures.

---

# 🚀 Overview

**LifeTechOCMS Events** is a powerful yet simple **event-driven architecture package for PHP** that allows developers to:

- create and manage events  
- register listeners dynamically  
- attach listeners to events  
- dispatch events with payloads  

Unlike traditional event systems, this package is:

- ✅ database-free (JSON storage)  
- ✅ framework-independent  
- ✅ easy to integrate  
- ✅ production-ready  

---

# 🔍 Why Use LifeTechOCMS Events?

Most PHP event systems are:

- tightly coupled to frameworks   
- require service containers  
- complex to configure  

### LifeTechOCMS Events solves this by offering:

✔ Works with any PHP framework (Laravel, Symfony, Drupal, Shopify, etc.)
✔ Zero framework dependency  
✔ Simple and intuitive API  
✔ File-based persistence (no DB needed)  
✔ Flexible event-listener mapping  
✔ Clean response structure for APIs  

---

# ⚙️ Installation

```bash
composer require lifetechocms/events
```

---

# 📌 Quick Start

```php
use Lt\Events\LtEvent;
use Lt\Events\LtListener;
use Lt\Events\LtDispatcher;

//Event Registration
LtEvent::register('userRegistered'); //userRegistered is the eventName

//Listener Registration
//listenerName, ListenerClassPath, and ListenerClassMethod
LtListener::register(
    'sendWelcomeEmail',
    'App\Listeners\SendWelcomeEmail',
    'sendTo'
);

//to allow Event to Listen to a Listener
LtEvent::listen('userRegistered', 'sendWelcomeEmail');

//to Dispatch an Event with a payload, the payload can be array,string or object
LtDispatcher::dispatch('userRegistered', ['email' => 'user@example.com']);
```
---
# Documentation

- [Getting Started](docs/getting-started.md)⬅ Basic concepts
- [LtEvent API](docs/ltevent.md) ⬅ Manage events
- [LtListener API](docs/ltlistener.md) ⬅ Manage listeners.
- [LtDispatcher API](docs/ltdispatcher.md) ⬅ Dispatch events
- [Response Codes](docs/response-codes.md) ⬅ Full respomse code reference
- [Configuration](docs/configuration.md) ⬅ Storage setup(optional)
- [Architecture & Storage](docs/architecture.md) ⬅ System overview
- [CONTRIBUTING](CONTRIBUTING.md) ⬅ System overview

---
# ✨ Key Features

- Event registration and lifecycle management  
- Listener registration and execution  
- Dispatcher supporting static & instance methods  
- JSON-based persistent storage  
- Runtime configuration via EventSetting  
- Framework-agnostic design  
---

# 🎯 Use Cases

- Event-driven PHP applications  
- Custom MVC frameworks  
- Plugin/module systems  
- Notification systems  
- Logging and auditing systems  
- Decoupled business logic  

---


# 🔁 Response Format

Set Response output to either Array or Json

```php
use Lt\Events\EventSetting;
EventSetting::set('responseType','json'); //json or array
```
See more [Available Response Codes](docs/response-codes.md)
 ---

# 🔒 Security Best Practices

- store JSON files outside public web root  
- validate listener classes  
- restrict file permissions  

---

# 👤 Author

**Ajayi Abolore A. Ajayi**  
Founder & Lead Architect — LifeTech OCMS  

---

# 📄 License

MIT License  

---

# ⭐ Contribute

- Star the repo  
- Fork and contribute  
- Report issues  

---

# 🔥 SEO Keywords

PHP event system, PHP dispatcher, PHP listener system, event-driven PHP, lightweight PHP events, PHP observer alternative
