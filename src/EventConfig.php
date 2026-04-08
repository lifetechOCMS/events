<?php

declare(strict_types=1);

namespace Lt\Events;

class EventConfig
{
    protected static string $eventFile = __DIR__ . '/../storage/eventdata.json';
    protected static string $listenerFile = __DIR__ . '/../storage/listenerdata.json';

    public static function setEventFile(string $filePath): void
    {
        self::$eventFile = $filePath;
    }

    public static function getEventFile(): string
    {
        return self::$eventFile;
    }

    public static function setListenerFile(string $filePath): void
    {
        self::$listenerFile = $filePath;
    }

    public static function getListenerFile(): string
    {
        return self::$listenerFile;
    }

    public static function ensureFileExists(string $filePath, string $rootKey): void
    {
        $dir = dirname($filePath);

        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        if (!file_exists($filePath)) {
            $initial = [$rootKey => []];
            $json = json_encode($initial, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            @file_put_contents($filePath, $json . PHP_EOL);
        }
    }

    public static function loadJson(string $filePath, string $rootKey): array
    {
        self::ensureFileExists($filePath, $rootKey);

        $content = @file_get_contents($filePath);

        if ($content === false || trim($content) === '') {
            return [$rootKey => []];
        }

        $data = json_decode($content, true);

        if (!is_array($data)) {
            return [$rootKey => []];
        }

        if (!isset($data[$rootKey]) || !is_array($data[$rootKey])) {
            $data[$rootKey] = [];
        }

        return $data;
    }

    public static function saveJson(string $filePath, array $data): bool
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($json === false) {
            return false;
        }

        return @file_put_contents($filePath, $json . PHP_EOL, LOCK_EX) !== false;
    }

    public static function validateCamelCase(string $value, string $label): void
    {
        if (!preg_match('/^[a-z][a-zA-Z0-9]*$/', $value)) {
            throw new \InvalidArgumentException(
                ucfirst($label) . " must be camelCase. Given: {$value}"
            );
        }
    }

    public static function now(): string
    {
        return gmdate('Y-m-d\TH:i:s\Z');
    }
  
    public static function findEventIndex(array $data, string $eventName): ?int
    {
        foreach (($data['events'] ?? []) as $index => $event) {
            if (($event['event_name'] ?? null) === $eventName) {
                return $index;
            }
        }

        return null;
    }

    public static function findListenerIndex(array $data, string $listenerName): ?int
    {
        foreach (($data['listeners'] ?? []) as $index => $listener) {
            if (($listener['listener_name'] ?? null) === $listenerName) {
                return $index;
            }
        }

        return null;
    }

    public static function response( string $responseResult, string $responseCode = "3800",string $responseCategory = "100",    array $responseData = []     ): array 
    {
        return [
            'responseResult'   => $responseResult,
            'responseCode'     => $responseCode,
            'responseCategory' => $responseCategory,
            'responseData'     => $responseData,
        ];
    }
    public static function success(string $responseResult, string $responseCode = "3808",string $responseCategory = "200",    array $responseData = []): array
    {
        return self::response($responseResult, $responseCode, $responseCategory,$responseData);
    }

    public static function error(string $responseResult, string $responseCode = "3800",string $responseCategory = "100",    array $responseData = []): array
    {
        return self::response($responseResult, $responseCode, $responseCategory,$responseData);
    }
}