# Getting Started

```php
use Lt\Events\LtEvent;
use Lt\Events\LtListener;
use Lt\Events\LtDispatcher;

LtEvent::register('userRegistered');

LtListener::register('sendWelcomeEmail', App\Listeners\SendWelcomeEmail::class);

LtEvent::listen('userRegistered', 'sendWelcomeEmail');

LtDispatcher::dispatch('userRegistered', ['email' => 'test@example.com']);
```
