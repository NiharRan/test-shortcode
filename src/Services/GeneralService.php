<?php

namespace Nihardas\TestShortcode\Services;

class GeneralService
{
    private static $values;

    public function __construct()
    {
        self::$values = [];
        self::setShortCodes();
    }

    public static function setShortCodes()
    {
        self::$values = [
            '{{general.title}}' => 'Test Short Code Plugin',
            '{{general.version}}' => 'v1.1.0'
        ];
    }

    public static function addShortCode($key, $value)
    {
        self::$values[$key] = $value;
    }

    public static function getGeneralShorCodes($field = '')
    {
        if (empty($field)) {
            return self::$values;
        }
        return isset(self::$values[$field]) ? self::$values[$field] : '';
    }
}