<?php

declare(strict_types=1);

namespace Lt\Events;

class EventConfig
{
    // protected static string $eventFile = __DIR__ . '/../storage/eventdata.json';
    // protected static string $listenerFile = __DIR__ . '/../storage/listenerdata.json';
    protected static string $responseType = 'json'; // array or json

    public static function setEventFile(string $filePath): void
    {
        self::$eventFile = $filePath;
    }

    public static function getEventFile(): string
    {
        $storagePath = rtrim((string) EventSetting::get('storage_path'), '/\\');
        $eventFile = trim((string) EventSetting::get('event_file', 'eventdata.json'));
        if ($storagePath ==="" || $eventFile ===""){
           return  __DIR__ . '/../storage/eventdata.json';
        }
        return $storagePath . DIRECTORY_SEPARATOR . $eventFile;

        return self::$eventFile;
    }

    public static function setListenerFile(string $filePath): void
    {
        self::$listenerFile = $filePath;
    }

    public static function getListenerFile(): string
    {
        $storagePath = rtrim((string) EventSetting::get('storage_path'), '/\\');
        $listenerFile = trim((string) EventSetting::get('listener_file', 'listenerdata.json'));
        if ($storagePath ==="" || $listenerFile ===""){
           return  __DIR__ . '/../storage/listenerdata.json';
        }
        return $storagePath . DIRECTORY_SEPARATOR . $listenerFile; 
    }

    //setting out the output type
    public static function setResponseType(): void
    {
        $retu =  EventSetting::get('response_type');
       if($retu ==="json" || $retu ==="array"){
        self::$responseType = $retu;
       }else{
        self::$responseType = "array";
       } 
    }

    public static function output(array $response): array|string
    {
        self::setResponseType();

        if (self::$responseType === 'json') { 
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return $response;
    }
    //end of the output type

    public static function ensureFileExists(string $filePath, string $rootKey): array
    {
        $dir = dirname($filePath);

        if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
            return self::error("Unable to create directory: {$dir}", "3812" );
        }

        if (!file_exists($filePath)) {
            $initial = [$rootKey => []];
            $json = json_encode($initial, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            if ($json === false) {
                return self::error("Unable to encode initial JSON", "3813");
            }

            if (@file_put_contents($filePath, $json . PHP_EOL) === false) {
                return self::error("Unable to create file: {$filePath}", "3814" );
            }
        }

        return self::success("File ready","3815","200",['filePath' => $filePath]);
    }
     
    public static function loadJson(string $filePath, string $rootKey): array
    {
        $ensureFileExists =  self::ensureFileExists($filePath, $rootKey); 
        if ($ensureFileExists['responseCategory'] !== '200') {
            return $ensureFileExists;
        }

        $content = @file_get_contents($filePath);

        if ($content === false) {
            return self::error("Unable to read file: {$filePath}","3805");
        }

        if (trim($content) === '') {
            return self::success(
                "Empty file, default structure returned","3806","200",[$rootKey => []]);
        }

        $data = json_decode($content, true);

        if (!is_array($data)) {
            return self::error("Invalid JSON structure in file: {$filePath}","3807");
        }

        if (!isset($data[$rootKey]) || !is_array($data[$rootKey])) {
            $data[$rootKey] = [];
        }

        return self::success("JSON loaded successfully","3808","200",$data);
    }


    public static function saveJson(string $filePath, array $data): array
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($json === false) {
            return self::error("Unable to encode JSON for file: {$filePath}","3809");
        }

        if (@file_put_contents($filePath, $json . PHP_EOL, LOCK_EX) === false) {
            return self::error( "Unable to write file: {$filePath}", "3810");
        }

        return self::success("JSON saved successfully","3811","200",$data);
    }

    
    public static function now(): string
    {
        return gmdate('Y-m-d\TH:i:s\Z');
    }
  
    public static function findEventIndex(array $data, string $eventName): array
    {
        foreach (($data['events'] ?? []) as $index => $event) {
            if (($event['event_name'] ?? null) === $eventName) {
                //return $index;
                return self::success("{$index}","3825","200",['index'=>$index]);
            }
        }
        return self::error("Event not found: {$eventName}","3822");
    }

    public static function findListenerIndex(array $data, string $listenerName): array
    {
        foreach (($data['listeners'] ?? []) as $index => $listener) {
            if (($listener['listener_name'] ?? null) === $listenerName) {
                //return $index;
                return self::success("{$index}","3826","200",['index'=>$index]);
            }
        }
        return self::error("Listener not found: {$listenerName}","3821"); 
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