<?php

declare(strict_types=1);

namespace Lt\Events;

class EventSetting
{
    protected static string $settingFile = __DIR__ . '/../storage/eventsetting.json';

    public static function setSettingFile(string $filePath): void
    {
        self::$settingFile = $filePath;
    }

    public static function getSettingFile(): string
    {
        return self::$settingFile;
    }

    public static function get(?string $key = null, mixed $default = null): mixed
    {
        $settings = self::load();

        if ($key === null) {
            return $settings;
        }

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): array
    {
        $settings = self::load();
        $settings[$key] = $value;

        return self::save($settings);
    }

    public static function load(): array
    {
        self::ensureFileExists();

        $content = @file_get_contents(self::$settingFile);

        if ($content === false || trim($content) === '') {
            return self::defaults();
        }

        $data = json_decode($content, true);

        if (!is_array($data)) {
            return self::defaults();
        }

        return array_merge(self::defaults(), $data);
    }

    public static function save(array $settings): array
    {
        $dir = dirname(self::$settingFile);

        if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
            return EventConfig::error("Unable to create settings directory", "3840");
        }

        $json = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($json === false) {
            return EventConfig::error("Unable to encode settings JSON", "3841");
        }

        if (@file_put_contents(self::$settingFile, $json . PHP_EOL, LOCK_EX) === false) {
            return EventConfig::error("Unable to save settings file", "3842");
        }

        return EventConfig::success("Settings saved successfully", "3843", "200", $settings);
    }

    protected static function ensureFileExists(): void
    {
        $dir = dirname(self::$settingFile);

        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        if (!file_exists(self::$settingFile)) {
            @file_put_contents(
                self::$settingFile,
                json_encode(self::defaults(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL
            );
        }
    }

    protected static function defaults(): array
    {
        return [
            'storage_path' => __DIR__ . '/../storage/events',
            'event_file' => 'eventdata.json',
            'listener_file' => 'listenerdata.json',
            'response_type' => 'array',
        ];
    }
}