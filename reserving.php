<?php

/**
 * Plugin Name: Reserving
 * Description: Online Food Ordering & Reservation
 * Version: 1.2
 * Requires at least: 6.0
 * Tested up to: 6.6.2
 * Requires PHP: 7.4
 * Author: quomodosoft
 * Author URI: https://quomodosoft.com
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: reserving
 * Domain Path: /languages/
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (defined('RESERVING')) {
        /**
         * The plugin was already loaded (maybe as another plugin with different directory name)
         */
} else {

        require __DIR__ . '/vendor/autoload.php';

        /*
        **
        *** 
        *** 1. Used for security
        *** 2. Used to help know where we am on the filesystem.
        *** 
        **
        */
        define('RESERVING', true);
        define('RESERVING_VERSION', '1.2');
        define('RESERVING_LITE', true);
        define('RESERVING_ROOT', __FILE__);
        define('RESERVING_URL', plugins_url('/', RESERVING_ROOT));
        define('RESERVING_ASSETS_URL', RESERVING_URL . 'assets/');
        define('RESERVING_ASSETS_BACKEND_URL', RESERVING_URL . 'assets/backend/');
        define('RESERVING_ASSETS_PUBLIC_URL', RESERVING_URL . 'assets/public/');
        define('RESERVING_DIR_PATH', plugin_dir_path(RESERVING_ROOT));
        define('RESERVING_ADDONS_DIR_URL', plugin_dir_url(RESERVING_ROOT) . 'app/extensions/');
        define('RESERVING_PLUGIN_BASE', plugin_basename(RESERVING_ROOT));
        define('RESERVING_ITEM_NAME', 'Reserving - Online Food Ordering & Reservation');
        define('RESERVING_ROOT_PAGE', 'reserving');

        /*
        **
        *** Now lets include the bootloader file
        **
        */

        add_action('plugins_loaded', 'reserving_action_init_src', 150);

        /*
        **
        *** All Core Function loader
        **
        */

        function reserving_action_init_src()
        {
                do_action('reserving_before_bootstrap');
                // basic config
                load_plugin_textdomain('reserving');
                require_once RESERVING_DIR_PATH . '/app/system/boot.php';
                do_action('reserving_bootstrap');
        }

        /**
         * Do stuff upon plugin activation
         *
         * @return void
         */
        function reserving_plugin_activate()
        {
                $installer = new Reserving\Installer();
                $installer->plugin_activate();
        }

        register_activation_hook(__FILE__, 'reserving_plugin_activate');

        /**
         * Do stuff upon plugin deactivation
         *
         * @return void
         */
        function reserving_plugin_deactivate()
        {
                $installer = new Reserving\Installer();
                $installer->plugin_deactivate();
        }

        register_deactivation_hook(__FILE__, 'reserving_plugin_deactivate');
}
