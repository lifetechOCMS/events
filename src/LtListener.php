<?php
declare(strict_types=1);

namespace Lt\Events;

class LtListener
{
    public static function setEventFile(string $filePath): void
    {
        EventConfig::setEventFile($filePath);
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
    

    
}