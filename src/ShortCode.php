<?php

namespace Nihardas\TestShortcode;


class ShortCode
{
    private $shortcodes = [];

    public function __construct()
    {
        add_filter('test_shortcodes', [$this, 'getShortCodes']);
        add_filter('fluentcrm_extended_general_smart_codes', [$this, 'getShortCodes']);
        $this->setGeneralShortCodes();
        $this->setAuthorShortCodes();
        add_action('add_shortcode', [$this, 'addShortCode'], 10, 3);
    }

    public function setGeneralShortCodes()
    {
        $this->shortcodes[] = [
            'key' => 'general2',
            'title' => __('General2'),
            'shortcodes' => apply_filters('test_author_shortcodes', [
                '{{general2.title}}' => __('Title'),
                '{{general2.version}}' => __('Version')
            ])
        ];

        return $this->shortcodes;
    }

    public function setAuthorShortCodes()
    {
        $this->shortcodes[] = [
            'key' => 'author',
            'title' => __('Author'),
            'shortcodes' => apply_filters('test_author_shortcodes', [
                '{{author.name}}' => __('Author Name'),
                '{{author.email}}' => __('Author E-mail')
            ])
        ];

        return $this->shortcodes;
    }

    public function addShortCode($module, $code, $title)
    {
        foreach ($this->shortcodes as &$shortcode) {
            if ($shortcode['key'] == $module) {
                $shortcode['shortcodes'][$code] = $title;
            }
        }
    }

    public function getShortCodes($module = '')
    {
        if (!empty($module)) {
            foreach ($this->shortcodes as $key => $shortcode) {
                if ($shortcode['key'] == $module) {
                    return $this->shortcodes[$key];
                }
            }
        }
        return $this->shortcodes;
    }
}