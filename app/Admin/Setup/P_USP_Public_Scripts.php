<?php

namespace P_USP\App\Admin\Setup;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Public_Scripts')) {
    class P_USP_Public_Scripts
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
            add_action('wp_enqueue_scripts', [$this, 'maybe_enqueue_scripts']);
        }

        /**
         * Public Scripts
         * @return void
         */
        public function maybe_enqueue_scripts()
        {
            $l10n = apply_filters('p_usp_public_localizations', [
                'ajaxURL' => esc_js(admin_url('admin-ajax.php')),
                'ajaxNonce' => wp_create_nonce(p_usp()::$AJAX_NONCE),
                'pluginURL' => esc_js(p_usp()->helper()::get_plugin_url()),
                'blogURL' => get_bloginfo('url'),
                'l10n' => [],
            ]);
            $css_file = "/assets/public/css/app".$this->min.".css";
            $js_file = "/assets/public/js/app".$this->min.".js";
            /*---------------- App CSS ----------------*/
            wp_enqueue_style('upsell-smart-popup', p_usp()->helper()::get_plugin_url($css_file), [], $this->version);
            /*---------------- App JS ----------------*/
            wp_enqueue_script('upsell-smart-popup', p_usp()->helper()::get_plugin_url($js_file), ['jquery'], $this->version, true);
            wp_localize_script('upsell-smart-popup', 'p_usp_params', $l10n);
            /*---------------- Jquery UI Dialog ----------------*/
            if (!did_action('wp-jquery-ui-dialog')) {
                wp_enqueue_script('jquery-ui-dialog');
                wp_enqueue_style('wp-jquery-ui-dialog');
            }
            /*---------------- Jquery UI Dialog CSS----------------*/
            $inline_style = [];
            $header_bg_color = p_usp()->db()::get_modalbox_header_bg_color();
            $header_text_color = p_usp()->db()::get_modalbox_header_text_color();
            $inline_style[] = sprintf('.usp__modalbox_wrapper .ui-dialog-titlebar {background:%s !important;}', $header_bg_color);
            $inline_style[] = sprintf('.usp__modalbox_wrapper .ui-dialog-titlebar span{color:%s !important;}', $header_text_color);
            $inline_style[] = sprintf('.usp__modalbox_wrapper .ui-dialog-titlebar-close{color:%s !important;}', $header_text_color);
                wp_add_inline_style('upsell-smart-popup', implode(' ', $inline_style));
        }
    }
}
