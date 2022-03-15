<?php


use Nihardas\TestShortcode\Services\AuthorService;
use Nihardas\TestShortcode\Services\GeneralService;

add_filter('test_shortcode_value_of_author', function ($code) {
    return (new AuthorService)->getAuthorShorCodes($code);
});
add_filter('test_shortcode_value_of_general', function ($code) {
    return (new GeneralService)->getGeneralShorCodes($code);
});