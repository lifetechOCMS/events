<?php
declare(strict_types=1);

namespace Lt\Events;
use Lt\Events\LtEvent;

class LtListener
{
    public static function setEventFile(string $filePath): void
    {
        EventConfig::setEventFile($filePath);
    }
    public static function register(string $listenerName,string $listenerClass,string $handlerMethod = 'handle', ?string $eventName = null,bool $status = true): array|string 
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
    
    public static function update(string $listenerName, array $updateData = []): array|string
    {
        $listenerFile = EventConfig::getListenerFile();

        $load = EventConfig::loadJson($listenerFile, 'listeners');
        if ($load['responseCategory'] !== '200') {
            return EventConfig::output($load);
        }

        $data = $load['responseData'];

        $listenerCheck = EventConfig::findListenerIndex($data, $listenerName);
        if ($listenerCheck['responseCategory'] !== '200') {
            return EventConfig::output($listenerCheck);
        }

        $listenerIndex = $listenerCheck['responseData']['index'];
        $listener = $data['listeners'][$listenerIndex];

        if (isset($updateData['listener_class'])) {
            $listener['listener_class'] = $updateData['listener_class'];
        }

        if (isset($updateData['handler_method'])) {
            $listener['handler_method'] = $updateData['handler_method'];
        }

        if (isset($updateData['status'])) {
            $listener['status'] = (bool) $updateData['status'];
        }

        $listener['updated_at'] = EventConfig::now();

        $data['listeners'][$listenerIndex] = $listener;

        $save = EventConfig::saveJson($listenerFile, $data);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Listener updated successfully", "3833", "200", $listener)
        );
    }

    public static function delete(string $listenerName): array|string
    {
        $listenerFile = EventConfig::getListenerFile();

        $load = EventConfig::loadJson($listenerFile, 'listeners');
        if ($load['responseCategory'] !== '200') {
            return EventConfig::output($load);
        }

        $data = $load['responseData'];

        $listenerCheck = EventConfig::findListenerIndex($data, $listenerName);
        if ($listenerCheck['responseCategory'] !== '200') {
            return EventConfig::output($listenerCheck);
        }

        $listenerIndex = $listenerCheck['responseData']['index'];
        $deletedListener = $data['listeners'][$listenerIndex];

        unset($data['listeners'][$listenerIndex]);
        $data['listeners'] = array_values($data['listeners']);

        $save = EventConfig::saveJson($listenerFile, $data);
        if ($save['responseCategory'] !== '200') {
            return EventConfig::output($save);
        }

        return EventConfig::output(
            EventConfig::success("Listener deleted successfully", "3832", "200", $deletedListener)
        );
    }

    public static function listen(string $eventName, string $listenerName): array|string
    {
        return LtEvent::listen($eventName, $listenerName);
    }
    public static function unlisten(string $eventName, string $listenerName): array|string
    {
        return LtEvent::unlisten($eventName, $listenerName);
    }

}