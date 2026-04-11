<?php

declare(strict_types=1);

namespace Lt\Events\Tests\Fake;

class SendWelcomeEmail
{
    public function handle(mixed $payload): array
    {
        return [
            'status' => 'ok',
            'payload' => $payload
        ];
    }
}