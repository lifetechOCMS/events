<?php
declare(strict_types=1);

namespace Lt\Events;

class LtEvent
{
    public static function setEventFile(string $filePath): void
    {
        EventConfig::setEventFile($filePath);
    }

    public static function register(string $eventName, array $listeners=[], bool $status = true): array | string
    {
        $eventFile = EventConfig::getEventFile();

        $load = EventConfig::loadJson($eventFile, 'events');
        if ($load['responseCategory'] !== '200') {
            return EventConfig::output($load);
        }

        $data = $load['responseData'];

        foreach ($data['events'] as $event) {
            if (($event['event_name'] ?? null) === $eventName) {
                return EventConfig::output(EventConfig::error("Event already exists", "3820"));
            }
        }


        // Validate listeners array
        if (!empty($listeners)) {
            $listenerFile = EventConfig::getListenerFile();
            $loadListeners = EventConfig::loadJson($listenerFile, 'listeners');

            if ($loadListeners['responseCategory'] !== '200') {
                return EventConfig::output($loadListeners);
            }

            $listenerData = $loadListeners['responseData'];
            $registeredListeners = $listenerData['listeners'] ?? [];

            foreach ($listeners as $listenerName) { 
                $listenerIndex = EventConfig::findListenerIndex($listenerData, $listenerName);

                if ($listenerIndex['responseCategory'] !== '200') {
                    return EventConfig::output($listenerIndex);
                }                
            }

            // Remove duplicate listener names, keep clean indexing
            $listeners = array_values(array_unique($listeners));
        }

        $now = EventConfig::now();

        $record = [
            'event_name' => $eventName,
            'status' => $status,
            'created_at' => $now,
            'updated_at' => $now,
            'listeners' => $listeners
        ];

        $data['events'][] = $record;

        return EventConfig::output(EventConfig::saveJson($eventFile, $data));
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