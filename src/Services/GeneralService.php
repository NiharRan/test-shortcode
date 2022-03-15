<?php

namespace Nihardas\TestShortcode\Services;

class GeneralService
{
    private $values;

    public function __construct()
    {
        $this->values = [];
        $this->setShortCodes();
        add_action('add_general_shortcode_value', [$this, 'addShortCode'], 10, 2);
    }

    public function setShortCodes()
    {
        $this->values = [
            '{{general.title}}' => 'Test Short Code Plugin',
            '{{general.version}}' => 'v1.1.0'
        ];
    }

    public function addShortCode($key, $value)
    {
        $this->values[$key] = $value;
        dd($this->values);
    }

    public function getGeneralShorCodes($field = '')
    {
        if (empty($field)) {
            return;
        }
        return isset($this->values[$field]) ? $this->values[$field] : '';
    }
}