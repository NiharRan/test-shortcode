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


use Nihardas\TestShortcode\ExternalActivity;
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

        if (defined('FLUENTCAMPAIGN_DIR_FILE')) {
            new ExternalActivity();
        }
    }

    public function activate()
    {
        $is_installed = get_option('test-shortcode');
        if (!$is_installed) {
            update_option('test-shortcode', true);
        }
    }

    public function deactivate()
    {
        delete_option('test-shortcode');
    }

    public function init_plugin()
    {
        $this->services['author'] = new AuthorService();
        $this->services['general2'] = new GeneralService();
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