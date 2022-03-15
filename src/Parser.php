<?php

namespace Nihardas\TestShortcode;

class Parser
{
    public function parse($text)
    {
        $shortcodes = apply_filters('test_shortcodes', '');
        foreach ($shortcodes as $shortcode) {
            $module = $shortcode['key'];
            foreach ($shortcode['shortcodes'] as $key => $code) {
                $pos = strpos($text, $key);
                if ($pos) {
                    $value = apply_filters("test_shortcode_value_of_$module", $key);
                    $text = str_replace($key, $value, $text);
                }
            }
        }

        return $text;
    }
}