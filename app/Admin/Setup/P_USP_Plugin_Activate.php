<?php

namespace P_USP\App\Admin\Setup;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Plugin_Activate')) {
    class P_USP_Plugin_Activate
    {
        private static $_instance;

        private static $php_version = '7.0';

        /**
         * Get Class Instance
         * @return P_USP_Plugin_Activate
         */
        public static function instance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * On Activation
         * @return void
         */
        public static function activate($network_wide)
        {
            self::is_valid_requirements();
            // DO Now
            if (function_exists('is_multisite') && is_multisite()) {
                if ($network_wide) {
                    $sites = get_sites();
                    foreach ($sites as $site) {
                        switch_to_blog($site->blog_id);
                        self::do_it();
                        restore_current_blog();
                    }
                } else {
                    self::do_it();
                }
            } else {
                self::do_it();
            }

        }

        /**
         * Check Requirement
         * @return void
         */
        private static function is_valid_requirements()
        {
            $is_valid_requirements = true;
            $php_version = version_compare(PHP_VERSION, esc_html(self::$php_version), '>=');
            if (!$php_version) {
                $is_valid_requirements = false;
                $message = sprintf('<p>The Upsell Smart Popup plugin only works with PHP 7.0. Your current PHP version is <strong>%s</strong> The plugin is deactivated.</p><a href="%s">Go Back</a>', esc_html(self::$php_version), esc_url(admin_url('plugins.php')));
            }
            if (!is_plugin_active('woocommerce/woocommerce.php')) {
                $is_valid_requirements = false;
                $message = sprintf('<p>The Upsell Smart Popup plugin only works with <strong>Woocommerce</strong>. The plugin is deactivated.</p><a href="%s">Go Back</a>', esc_url(admin_url('plugins.php')));

            }
            if (!$is_valid_requirements) {
                deactivate_plugins(p_usp()::$PLUGIN_BASENAME);
                wp_die(wp_kses_post($message));
            }
        }

        /**
         * Do Stuffs
         * @return void
         */
        private static function do_it() {}
    }
}
