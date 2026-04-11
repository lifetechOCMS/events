<?php

declare(strict_types=1);

namespace Lt\Events\Tests;

use Lt\Events\EventConfig;
use Lt\Events\LtEvent;
use Lt\Events\LtListener;
use PHPUnit\Framework\TestCase;

final class LtEventTest extends TestCase
{
    private string $eventFile;
    private string $listenerFile;

    protected function setUp(): void
    {
        $base = sys_get_temp_dir() . '/ltevents_tests';

        if (!is_dir($base)) {
            mkdir($base, 0777, true);
        }

        $this->eventFile = $base . '/eventdata.json';
        $this->listenerFile = $base . '/listenerdata.json';

        file_put_contents($this->eventFile, json_encode(['events' => []], JSON_PRETTY_PRINT));
        file_put_contents($this->listenerFile, json_encode(['listeners' => []], JSON_PRETTY_PRINT));

        EventConfig::setEventFile($this->eventFile);
        EventConfig::setListenerFile($this->listenerFile);
        EventConfig::setResponseType('array');
    }

    public function test_event_can_register_successfully(): void
    {
        $result = LtEvent::register('userRegistered');

        $this->assertIsArray($result);
        $this->assertSame('200', $result['responseCategory']);
        $this->assertSame('userRegistered', $result['responseData']['event_name']);
    }

    public function test_duplicate_event_registration_fails(): void
    {
        LtEvent::register('userRegistered');
        $result = LtEvent::register('userRegistered');

        $this->assertIsArray($result);
        $this->assertSame('100', $result['responseCategory']);
    }

    public function test_listener_can_register_successfully(): void
    {
        $result = LtListener::register(
            'sendWelcomeEmail',
            'Lt\\Events\\Tests\\Fake\\SendWelcomeEmail'
        );

        $this->assertIsArray($result);
        $this->assertSame('200', $result['responseCategory']);
        $this->assertSame('sendWelcomeEmail', $result['responseData']['listener_name']);
    }

    public function test_event_can_listen_to_listener(): void
    {
        LtEvent::register('userRegistered');
        LtListener::register(
            'sendWelcomeEmail',
            'Lt\\Events\\Tests\\Fake\\SendWelcomeEmail'
        );

        $result = LtEvent::listen('userRegistered', 'sendWelcomeEmail');

        $this->assertIsArray($result);
        $this->assertSame('200', $result['responseCategory']);
    }

    public function test_event_can_unlisten_listener(): void
    {
        LtEvent::register('userRegistered');
        LtListener::register(
            'sendWelcomeEmail',
            'Lt\\Events\\Tests\\Fake\\SendWelcomeEmail'
        );
        LtEvent::listen('userRegistered', 'sendWelcomeEmail');

        $result = LtEvent::unlisten('userRegistered', 'sendWelcomeEmail');

        $this->assertIsArray($result);
        $this->assertSame('200', $result['responseCategory']);
    }
}