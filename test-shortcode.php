<?php
/**
 * @package Test_ShortCode
 * @version 1.7.2
 */

/*
Plugin Name: Test Short Code
Plugin URI: http://wordpress.org/plugins/test-shorce-code/
Description: This is a short code checking plugin.
Author: Nihar Ranjan Das
Version: 1.7.2
Author URI: http://nh.tt/
*/


use Nihardas\TestShortcode\Services\AuthorService;
use Nihardas\TestShortcode\Services\GeneralService;
use Nihardas\TestShortcode\ShortCode;
use Nihardas\TestShortcode\Parser;

if (!defined('ABSPATH')) exit();

require_once "vendor/autoload.php";


class TestShortCode
{
    private ShortCode $shortcode;
    private Parser $parser;
    private array $services;

    public function __construct()
    {
        $this->services = [];
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
        $this->shortcode = new ShortCode();
        $this->parser = new Parser();
    }

    public function activate()
    {
        $is_installed = get_option('test-shortcode2');
        if (!$is_installed) {
            update_option('test-shortcode2', true);
        }
    }

    public function deactivate()
    {
        delete_option('test-shortcode2');
    }

    public function init_plugin()
    {
        $this->services['author'] = new AuthorService();
        $this->services['general'] = new GeneralService();

        do_action('add_author_shortcode_value', '{{author.phone}}', '01761152186');
        do_action('add_general_shortcode_value', '{{general.published_at}}', date('d-m-Y'));

        $text = '<p>Hi,<br>I am {{author.name}} and {{author.email}} is my personal email.</p>
                <small>@copyright <strong>{{general.title}}</strong> {{general.version}}</small>';
        echo $text;
        echo '<br/><br/> --------------------------------------------- <br/>';
        $text = $this->parser->parse($text);
        echo $text;
        $shortcodes = apply_filters('get_shortcode_values', []);
        echo json_encode($shortcodes, JSON_PRETTY_PRINT);
        exit();
    }

    public static function init()
    {
        $instance = null;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }
}


if (!function_exists('test_shortcode_init')) {
    function test_shortcode_init()
    {
        TestShortCode::init();
    }
}

test_shortcode_init();