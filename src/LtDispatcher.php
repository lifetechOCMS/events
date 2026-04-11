<?php
declare(strict_types=1);

namespace Lt\Events;

class LtDispatcher
{
    public static function dispatch(string $eventName, mixed $payload = null): array|string
    {
        $eventFile = EventConfig::getEventFile();
        $listenerFile = EventConfig::getListenerFile();

        // Load events
        $eventLoad = EventConfig::loadJson($eventFile, 'events');
        if ($eventLoad['responseCategory'] !== '200') {
            return EventConfig::output($eventLoad);
        }

        $eventData = $eventLoad['responseData'];

        // Find event
        $eventCheck = EventConfig::findEventIndex($eventData, $eventName);
        if ($eventCheck['responseCategory'] !== '200') {
            return EventConfig::output($eventCheck);
        }

        $eventIndex = $eventCheck['responseData']['index'];
        $event = $eventData['events'][$eventIndex];

        // Check event status
        if (($event['status'] ?? false) !== true) {
            return EventConfig::output(
                EventConfig::error("Event is disabled", "3834", "100", [
                    'event_name' => $eventName
                ])
            );
        }

        $eventListeners = $event['listeners'] ?? [];

        if (empty($eventListeners)) {
            return EventConfig::output(
                EventConfig::success("No listeners attached to event", "3835", "200", [
                    'event_name' => $eventName,
                    'payload' => $payload,
                    'listeners' => [],
                    'results' => []
                ])
            );
        }

        // Load listeners
        $listenerLoad = EventConfig::loadJson($listenerFile, 'listeners');
        if ($listenerLoad['responseCategory'] !== '200') {
            return EventConfig::output($listenerLoad);
        }

        $listenerData = $listenerLoad['responseData'];

        $results = [];
        $executedListeners = [];

        foreach ($eventListeners as $listenerName) {
            $listenerCheck = EventConfig::findListenerIndex($listenerData, $listenerName);

            if ($listenerCheck['responseCategory'] !== '200') {
                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'failed',
                    'message' => $listenerCheck['responseResult']
                ];
                continue;
            }

            $listenerIndex = $listenerCheck['responseData']['index'];
            $listener = $listenerData['listeners'][$listenerIndex];

            // Skip disabled listener
            if (($listener['status'] ?? false) !== true) {
                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'skipped',
                    'message' => 'Listener is disabled'
                ];
                continue;
            }

            $listenerClass = $listener['listener_class'] ?? '';
            $handlerMethod = $listener['handler_method'] ?? 'handle';

            if ($listenerClass === '') {
                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'failed',
                    'message' => 'Listener class is empty'
                ];
                continue;
            }

            if (!class_exists($listenerClass)) {
                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'failed',
                    'message' => "Listener class not found: {$listenerClass}"
                ];
                continue;
            }

            //$instance = new $listenerClass();
 
            if (!method_exists($listenerClass, $handlerMethod)) {
                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'failed',
                    'message' => "Handler method not found: {$handlerMethod}"
                ];
                continue;
            }

            try {
                $reflection = new \ReflectionMethod($listenerClass, $handlerMethod);

                if ($reflection->isStatic()) {
                    // Static method call
                    $listenerResponse = $listenerClass::$handlerMethod($payload);
                } else {
                    // Instance method call
                    $instance = new $listenerClass();
                    $listenerResponse = $instance->{$handlerMethod}($payload);
                }

                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'success',
                    'message' => 'Listener executed successfully',
                    'response' => $listenerResponse
                ];

                $executedListeners[] = $listenerName;

            } catch (\Throwable $e) {
                $results[] = [
                    'listener_name' => $listenerName,
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ];
            }            
        }

        return EventConfig::output(
            EventConfig::success("Event dispatched successfully", "3836", "200", [
                'event_name' => $eventName,
                'payload' => $payload,
                'listeners' => $eventListeners,
                'executed_listeners' => $executedListeners,
                'results' => $results
            ])
        );
    }
}