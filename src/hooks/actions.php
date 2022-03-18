<?php

use Nihardas\TestShortcode\Services\AuthorService;
use Nihardas\TestShortcode\Services\GeneralService;

add_action('add_author_shortcode_value', function ($code, $title, $value) {
    AuthorService::addShortCode($code, $value);
    do_action('add_shortcode', 'author', $code, $title);
}, 10, 3);
add_action('add_general2_shortcode_value', function ($code, $title, $value) {
    GeneralService::addShortCode($code, $value);
    do_action('add_shortcode', 'general2', $code, $title);
}, 10, 3);

