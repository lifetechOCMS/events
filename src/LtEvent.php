<?php
declare(strict_types=1);

namespace Lt\Events;

class LtEvent
{
    public static function setEventFile(string $filePath): void
    {
        EventConfig::setEventFile($filePath);
    }

    public static function register(string $eventName, bool $status = true): array
    {
        $eventFile = EventConfig::getEventFile();

        // Load file
        $load = EventConfig::loadJson($eventFile, 'events');
        if (($load['responseCategory'] ?? '100') !== '200') {
            return $load;
        }

        $data = $load['responseData'];

        // Check duplicate
        foreach ($data['events'] as $event) {
            if (($event['event_name'] ?? null) === $eventName) {
                return EventConfig::error(
                    "Event already exists",
                    "3812"
                );
            }
        }

        // Create event
        $now = EventConfig::now();

        $record = [
            'event_name' => $eventName,
            'status' => $status,
            'created_at' => $now,
            'updated_at' => $now,
            'listeners' => []
        ];

        $data['events'][] = $record;

        // Save
        $save = EventConfig::saveJson($eventFile, $data);
        if (($save['responseCategory'] ?? '100') !== '200') {
            return $save;
        }

        // Success
        return EventConfig::success(
            "Event registered successfully",
            "3811",
            "200",
            $record
        );
    }

    public static function register(string $eventName, bool $status = true): bool
    {
        EventConfig::validateCamelCase($eventName, 'event name');

        $eventFile = EventConfig::getEventFile();
        $data = EventConfig::loadJson($eventFile, 'events');

        foreach ($data['events'] as $event) {
            if (($event['event_name'] ?? null) === $eventName) {
                return false;
            }
        }

        $now = EventConfig::now();

        $data['events'][] = [
            'event_name' => $eventName,
            'status' => $status,
            'created_at' => $now,
            'updated_at' => $now,
            'listeners' => []
        ];

        return EventConfig::saveJson($eventFile, $data);
    }

    public static function addListener(string $listenerName,string $listenerClass, string $handlerMethod = 'handle',bool $status = true ) : bool
    {


        //EventConfig::validateCamelCase($listenerName, 'listener name');

        $listenerFile = EventConfig::getListenerFile();
        
        $data = EventConfig::loadJson($listenerFile, 'listeners');



        foreach ($data['listeners'] as $listener) {
            if (($listener['listener_name'] ?? null) === $listenerName) {
                return false;
            }
        } 

        $now = EventConfig::now();

        $data['listeners'][] = [
            'listener_name' => $listenerName,
            'listener_class' => $listenerClass,
            'handler_method' => $handlerMethod,
            'status' => $status,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        return EventConfig::saveJson($listenerFile, $data);
    }


    /* let event listen to listeners
    */
    public static function listen(string $eventName, string $listenerName): bool
    {
        //EventConfig::validateCamelCase($eventName, 'event name');
        //EventConfig::validateCamelCase($listenerName, 'listener name');

        $eventFile = EventConfig::getEventFile();
        $listenerFile = EventConfig::getListenerFile();

        $eventData = EventConfig::loadJson($eventFile, 'events');
        $listenerData = EventConfig::loadJson($listenerFile, 'listeners');

        $eventIndex = EventConfig::findEventIndex($eventData, $eventName);
        if ($eventIndex === null) {
            return false;
        }

        $listenerIndex = EventConfig::findListenerIndex($listenerData, $listenerName);
        if ($listenerIndex === null) {
            return false;
        }

        $currentListeners = $eventData['events'][$eventIndex]['listeners'] ?? [];

        if (in_array($listenerName, $currentListeners, true)) {
            return false;
        }

        $eventData['events'][$eventIndex]['listeners'][] = $listenerName;
        $eventData['events'][$eventIndex]['updated_at'] = EventConfig::now();

        return EventConfig::saveJson($eventFile, $eventData);
    }
}