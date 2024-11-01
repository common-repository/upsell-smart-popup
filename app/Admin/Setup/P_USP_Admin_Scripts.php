<?php

namespace P_USP\App\Admin\Setup;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Admin_Scripts')) {
    class P_USP_Admin_Scripts
    {
        private $version;

        private $min = '';

        /**
         * Initializer Of The Class
         * Hook into actions and filters.
         */
        public function init()
        {
            $this->version = p_usp()::$PLUGIN_VERSION;
            $this->min = p_usp()::$IS_DEV_MOD ? '' : '.min';
            add_action('admin_enqueue_scripts', [$this, 'maybe_enqueue_scripts']);
        }

        /**
         * Admin Scripts
         *
         * @param $hook
         *
         * @return void
         */
        public function maybe_enqueue_scripts($hook)
        {
            $l10n = apply_filters('p_usp_admin_localizations', [
                'ajaxURL' => esc_js(admin_url('admin-ajax.php')),
                'ajaxNonce' => wp_create_nonce(p_usp()::$AJAX_NONCE),
                'pluginURL' => esc_js(p_usp()->helper()::get_plugin_url()),
                'blogURL' => get_bloginfo('url'),
                'l10n' => [],
            ]);
            wp_enqueue_style('upsell-smart-popup', p_usp()->helper()::get_plugin_url("/assets/admin/css/app".$this->min.".css"), [], $this->version);
            wp_enqueue_script('upsell-smart-popup', p_usp()->helper()::get_plugin_url("/assets/admin/js/app".$this->min.".js"), ['jquery'], $this->version);
            wp_localize_script('upsell-smart-popup', 'p_usp_params', $l10n);

        }
    }
}
