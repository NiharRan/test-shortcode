<?php

namespace Nihardas\TestShortcode\Services;

class AuthorService
{
    protected static $values;

    public function __construct()
    {
        self::$values = [];
        self::setShortCodes();
        add_filter('fluentcrm_smartcode_fallback_callback_author', [$this, 'getAuthorShorCode'], 10, 4);
    }

    public static function setShortCodes()
    {
        self::$values = [
            '{{author.name}}' => 'Nihar Ranjan Das',
            '{{author.email}}' => 'niharranjandasmu@gmail.com'
        ];
    }

    public static function addShortCode($key, $value)
    {
        self::$values[$key] = $value;
    }

    public function getAuthorShorCode($matchKey, $valueKey, $defaultValue, $subscriber)
    {
        return isset(self::$values[$matchKey]) ? self::$values[$matchKey] : '';
    }

    public static function getAuthorShorCodes($field = '')
    {
        if (empty($field)) {
            return self::$values;
        }
        return isset(self::$values[$field]) ? self::$values[$field] : '';
    }
}