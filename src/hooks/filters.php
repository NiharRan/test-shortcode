<?php


use Nihardas\TestShortcode\Services\AuthorService;
use Nihardas\TestShortcode\Services\GeneralService;

add_filter('test_shortcode_value_of_author', function ($code) {
    return AuthorService::getAuthorShorCodes($code);
});
add_filter('test_shortcode_value_of_general2', function ($code) {
    return GeneralService::getGeneralShorCodes($code);
});

add_filter('get_shortcode_values', function () {
    $modules = ['author', 'general2'];
    $values = [];
    foreach ($modules as $module) {
        $values[$module] = apply_filters("test_shortcode_value_of_$module", '');
    }

    return $values;
});