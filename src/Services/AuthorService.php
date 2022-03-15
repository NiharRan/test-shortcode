<?php

namespace Nihardas\TestShortcode\Services;

class AuthorService
{
    private $values;

    public function __construct()
    {
        $this->values = [];
        $this->setShortCodes();
        add_action('add_author_shortcode_value', [$this, 'addShortCode'], 10, 2);
    }

    public function setShortCodes()
    {
        $this->values = [
            '{{author.name}}' => 'Nihar Ranjan Das',
            '{{author.email}}' => 'niharranjandasmu@gmail.com'
        ];
    }

    public function addShortCode($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function getAuthorShorCodes($field = '')
    {
        if (empty($field)) {
            return;
        }
        return isset($this->values[$field]) ? $this->values[$field] : '';
    }
}