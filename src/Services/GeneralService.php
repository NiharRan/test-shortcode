<?php

namespace Nihardas\TestShortcode\Services;

class GeneralService
{
    private static $values;

    public function __construct()
    {
        self::$values = [];
        self::setShortCodes();
        add_filter('fluentcrm_smartcode_fallback_callback_general2', [$this, 'getGeneralShortCode'], 10, 4);
    }

    public static function setShortCodes()
    {
        self::$values = [
            '{{general2.title}}' => 'Test Short Code Plugin',
            '{{general2.version}}' => 'v1.1.0'
        ];
    }

    public static function addShortCode($key, $value)
    {
        self::$values[$key] = $value;
    }

    public function getGeneralShortCode($matchKey, $valueKey, $defaultValue, $subscriber)
    {
        return isset(self::$values[$matchKey]) ? self::$values[$matchKey] : '';
    }

    public static function getGeneralShorCodes($field = '')
    {
        if (empty($field)) {
            return self::$values;
        }
        return isset(self::$values[$field]) ? self::$values[$field] : '';
    }
}