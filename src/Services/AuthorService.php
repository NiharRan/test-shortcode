<?php

namespace Nihardas\TestShortcode\Services;

class AuthorService
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
            '{{author.name}}' => 'Nihar Ranjan Das',
            '{{author.email}}' => 'niharranjandasmu@gmail.com'
        ];
    }

    public static function addShortCode($key, $value)
    {
        self::$values[$key] = $value;
    }

    public static function getAuthorShorCodes($field = '')
    {
        if (empty($field)) {
            return self::$values;
        }
        return isset(self::$values[$field]) ? self::$values[$field] : '';
    }
}