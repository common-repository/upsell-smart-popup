<?php

namespace P_USP\App\Admin\Setup;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Plugin_Setup')) {
    class P_USP_Plugin_Setup
    {
        /**
         * Initializer Of The Class
         * Hook into actions and filters.
         */
        public function init()
        {
            add_action('init', [$this, 'maybe_load_textdomain']);
            add_filter('plugin_action_links', [$this, 'maybe_action_links'], 10, 2);
        }

        /**
         * Plugin Translation
         * @return void
         */
        public function maybe_load_textdomain()
        {
            load_plugin_textdomain('upsell-smart-popup', false, wp_basename(p_usp()::$PLUGIN_DIR).'/languages/');
        }

        /**
         * Add Plugin Action Links
         *
         * @param $links
         * @param $file
         *
         * @return mixed
         */
        public function maybe_action_links($links, $file)
        {
            if (p_usp()::$PLUGIN_BASENAME !== $file) {
                return $links;
            }
            /* translators: 1: URL to page, 2: Link Title. */
            $settings_link = sprintf('<a href="%1$s">%2$s</a>', esc_url(add_query_arg(['page' => 'wc-settings', 'tab' => '&tab=upsell-smart-popup-settings'], admin_url('admin.php'))), __('Settings', 'upsell-smart-popup'));
            array_unshift($links, $settings_link);

            return $links;
        }

    }
}
