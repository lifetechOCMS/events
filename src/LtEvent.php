<?php
declare(strict_types=1);

namespace Lt\Events;

class LtEvent
{
    public static function setEventFile(string $filePath): void
    {
        EventConfig::setEventFile($filePath);
    }


    public static function get(): array | string
    {
        return EventSetting::get();
    }
    public static function set(string $key, mixed $value): array | string
    {
        return EventSetting::set($key, $value);
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
       // return EventConfig::output(EventConfig::saveJson($eventFile, $data));

        $save = EventConfig::saveJson($eventFile, $data);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }
        return EventConfig::output(EventConfig::success("Event registered successfully","3862","200",$record));

    }

    public static function delete(string $eventName): array|string
    {
        $eventFile = EventConfig::getEventFile();

        $load = EventConfig::loadJson($eventFile, 'events');
        if ($load['responseCategory'] !== '200') {
            return EventConfig::output($load);
        }

        $data = $load['responseData'];

        $eventCheck = EventConfig::findEventIndex($data, $eventName);
        if ($eventCheck['responseCategory'] !== '200') {
            return EventConfig::output($eventCheck);
        }

        $eventIndex = $eventCheck['responseData']['index'];
        $deletedEvent = $data['events'][$eventIndex];

        unset($data['events'][$eventIndex]);
        $data['events'] = array_values($data['events']);

        $save = EventConfig::saveJson($eventFile, $data);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Event deleted successfully", "3831", "200", $deletedEvent)
        );
    }

    public static function update(string $eventName, array $updateData = []): array|string
    {
        $eventFile = EventConfig::getEventFile();

        $load = EventConfig::loadJson($eventFile, 'events');
        if ($load['responseCategory'] !== '200') {
            return EventConfig::output($load);
        }

        $data = $load['responseData'];

        $eventCheck = EventConfig::findEventIndex($data, $eventName);
        if ($eventCheck['responseCategory'] !== '200') {
            return EventConfig::output($eventCheck);
        }

        $eventIndex = $eventCheck['responseData']['index'];
        $event = $data['events'][$eventIndex];

        if (isset($updateData['status'])) {
            $event['status'] = (bool) $updateData['status'];
        }

        if (isset($updateData['listeners'])) {
            if (!is_array($updateData['listeners'])) {
                return EventConfig::output(
                    EventConfig::error("Listeners must be an array", "3832")
                );
            }

            if (!empty($updateData['listeners'])) {
                $listenerFile = EventConfig::getListenerFile();
                $loadListeners = EventConfig::loadJson($listenerFile, 'listeners');

                if ($loadListeners['responseCategory'] !== '200') {
                    return EventConfig::output($loadListeners);
                }

                $listenerData = $loadListeners['responseData'];

                foreach ($updateData['listeners'] as $listenerName) {
                    $listenerCheck = EventConfig::findListenerIndex($listenerData, $listenerName);

                    if ($listenerCheck['responseCategory'] !== '200') {
                        return EventConfig::output($listenerCheck);
                    }
                }
            }

            $event['listeners'] = array_values(array_unique($updateData['listeners']));
        }

        $event['updated_at'] = EventConfig::now();

        $data['events'][$eventIndex] = $event;

        $save = EventConfig::saveJson($eventFile, $data);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Event updated successfully", "3833", "200", $event)
        );
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