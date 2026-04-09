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

    public static function deleteEvent(string $eventName): array|string
    {
        $eventFile = EventConfig::getEventFile();

        $eventLoad = EventConfig::loadJson($eventFile, 'events');
        if ($eventLoad['responseCategory'] !== '200') {
            return EventConfig::output($eventLoad);
        }

        $eventData = $eventLoad['responseData'];

        $eventCheck = EventConfig::findEventIndex($eventData, $eventName);
        if ($eventCheck['responseCategory'] !== '200') {
            return EventConfig::output($eventCheck);
        }

        $eventIndex = $eventCheck['responseData']['index'];
        $deletedEvent = $eventData['events'][$eventIndex];

        unset($eventData['events'][$eventIndex]);
        $eventData['events'] = array_values($eventData['events']);

        $save = EventConfig::saveJson($eventFile, $eventData);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Event deleted successfully","3831","200",$deletedEvent)
        );
    }
    
    public static function addListener(string $listenerName,string $listenerClass,string $handlerMethod = 'handle', ?string $eventName = null,bool $status = true): array|string 
    {
        $listenerFile = EventConfig::getListenerFile(); 

        // Load listener data
        $load = EventConfig::loadJson($listenerFile, 'listeners');
        if ($load['responseCategory'] !== '200') {
            return EventConfig::output($load);
        }

        $data = $load['responseData'];

        // Check if listener already exists
        $listenerCheck = EventConfig::findListenerIndex($data, $listenerName);
        if ($listenerCheck['responseCategory'] === '200') {
            return EventConfig::output(EventConfig::error("Listener already exists", "3823"));
        }

        $now = EventConfig::now();

        $record = [
            'listener_name'  => $listenerName,
            'listener_class' => $listenerClass,
            'handler_method' => $handlerMethod,
            'status'         => $status,
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $data['listeners'][] = $record;

        // Save listener first
        return EventConfig::output(EventConfig::saveJson($listenerFile, $data));  
         
    }
    

    /* let event listen to listeners
    */

    public static function listen(string $eventName, string $listenerName): array|string
    {
        $eventFile = EventConfig::getEventFile();
        $listenerFile = EventConfig::getListenerFile();

        // Load events
        $eventLoad = EventConfig::loadJson($eventFile, 'events');
        if ($eventLoad['responseCategory'] !== '200') {
            return EventConfig::output($eventLoad);
        }

        $eventData = $eventLoad['responseData'];

        // Load listeners
        $listenerLoad = EventConfig::loadJson($listenerFile, 'listeners');
        if ($listenerLoad['responseCategory'] !== '200') {
            return EventConfig::output($listenerLoad);
        }

        $listenerData = $listenerLoad['responseData'];

        // Check event exists
        $eventCheck = EventConfig::findEventIndex($eventData, $eventName);
        if ($eventCheck['responseCategory'] !== '200') {
            return EventConfig::output($eventCheck);
        }

        $eventIndex = $eventCheck['responseData']['index'];

        // Check listener exists
        $listenerCheck = EventConfig::findListenerIndex($listenerData, $listenerName);
        if ($listenerCheck['responseCategory'] !== '200') {
            return EventConfig::output($listenerCheck);
        }

        // Check if listener already linked
        $currentListeners = $eventData['events'][$eventIndex]['listeners'] ?? [];

        if (in_array($listenerName, $currentListeners, true)) {
            return EventConfig::output(EventConfig::error("Listener already linked to event","3827"));
        }

        // Link listener to event
        $eventData['events'][$eventIndex]['listeners'][] = $listenerName;
        $eventData['events'][$eventIndex]['updated_at'] = EventConfig::now();

        // Save updated events
        $save = EventConfig::saveJson($eventFile, $eventData);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Listener linked to event successfully","3828","200",
                ['event_name' => $eventName,'listener_name' => $listenerName]
            )
        );
    }


    public static function unlisten(string $eventName, string $listenerName): array|string
    {
        $eventFile = EventConfig::getEventFile();

        // Load events
        $eventLoad = EventConfig::loadJson($eventFile, 'events');
        if ($eventLoad['responseCategory'] !== '200') {
            return EventConfig::output($eventLoad);
        }

        $eventData = $eventLoad['responseData'];

        // Check event exists
        $eventCheck = EventConfig::findEventIndex($eventData, $eventName);
        if ($eventCheck['responseCategory'] !== '200') {
            return EventConfig::output($eventCheck);
        }

        $eventIndex = $eventCheck['responseData']['index'];
        $currentListeners = $eventData['events'][$eventIndex]['listeners'] ?? [];

        // Check if listener is linked to event
        if (!in_array($listenerName, $currentListeners, true)) {
            return EventConfig::output(EventConfig::error("Listener is not linked to event","3829"));
        }

        // Remove listener from event
        $eventData['events'][$eventIndex]['listeners'] = array_values(
            array_filter($currentListeners,fn (string $name): bool => $name !== $listenerName)
        );

        $eventData['events'][$eventIndex]['updated_at'] = EventConfig::now();

        // Save updated event data
        $save = EventConfig::saveJson($eventFile, $eventData);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Listener removed from event successfully","3830","200",
                ['event_name' => $eventName,'listener_name' => $listenerName]
            )
        );
    }
}