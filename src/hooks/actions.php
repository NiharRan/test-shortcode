<?php

use Nihardas\TestShortcode\Services\AuthorService;
use Nihardas\TestShortcode\Services\GeneralService;

add_action('add_author_shortcode_value', function ($code, $value) {
    AuthorService::addShortCode($code, $value);
}, 10, 2);
add_action('add_general_shortcode_value', function ($code, $value) {
    GeneralService::addShortCode($code, $value);
}, 10, 2);

