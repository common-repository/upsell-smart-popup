<?php

namespace P_USP\App\Frontend\TemplateRender;

use P_USP\App\Frontend\Controllers\P_USP_Upsell_Controller;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Product_Template')) {
    class P_USP_Product_Template
    {
        /**
         * Initializer Of The Class
         * Hook into actions and filters.
         */
        public function init()
        {
            add_action('wp_ajax_maybe_ajax_request_product_data', [$this, 'maybe_ajax_product_request']);
            add_action('wp_ajax_nopriv_maybe_ajax_request_product_data', [$this, 'maybe_ajax_product_request']);
            add_action('wp_footer', [$this, 'maybe_render_template']);
        }

        /**
         * Show Template
         * @return void
         */
        public function maybe_render_template()
        {
            // If not, Shop and Category and Tag and Product page
            if (!is_shop() && !is_product_category() && !is_product_tag() && !is_product()) {
                return;
            }
            $is_modalbox_enabled = false;
            $modalbox_heading = '';
            $modalbox_delay = 2000;
            $modalbox_class = '';
            $is_product_page = false;
            $product_id = '';
            $product_title = '';
            $product_price = '';
            $product_categories = '';
            $product_sku = '';
            $product_availability = '';
            $product_ratings = '';
            $product_image = '';
            $product_description = '';
            $product_addtocart_button = '';
            if (isset($_REQUEST['add-to-cart']) && sanitize_text_field($_REQUEST['add-to-cart'])) { // phpcs:ignore WordPress.Security.NonceVerification
                $add_to_cart = sanitize_text_field($_REQUEST['add-to-cart']); // phpcs:ignore WordPress.Security.NonceVerification
                $product_obj = new P_USP_Upsell_Controller($add_to_cart);
                if (!$product_obj->has_product) {
                    return;
                }
                $is_modalbox_enabled = true;
                $is_product_page = true;
                $modalbox_heading = p_usp()->db()::get_modalbox_header_heading($add_to_cart);
                $modalbox_delay = p_usp()->db()::get_modalbox_delay($add_to_cart);
                $modalbox_class = implode(' ', get_post_class(['product__wrapper'], $product_obj->product->get_id()));
                $product_id = $product_obj->product->get_id();
                $product_title = $product_obj->product->get_title();
                $product_price = $product_obj->product->get_price_html();
                $product_categories = $product_obj->get_product_categories();
                $product_sku = $product_obj->product->get_sku();
                $product_availability = $product_obj->get_product_availability();
                $product_ratings = $product_obj->get_product_rating();
                $product_image = $product_obj->product->get_image();
                $product_description = $product_obj->product->get_short_description();
                $product_addtocart_button = $product_obj->get_add_to_cart_button();
            }
            wc_get_template('modalbox-view.php', [
                'is_modalbox_enabled' => $is_modalbox_enabled,
                'modalbox_type' => 'product_modalbox',
                'modalbox_heading' => $modalbox_heading,
                'modalbox_class' => $modalbox_class,
                'modalbox_delay' => $modalbox_delay,
                'product_id' => $product_id,
                'product_title' => $product_title,
                'product_image' => $product_image,
                'product_description' => $product_description,
                'product_price' => $product_price,
                'product_categories' => $product_categories,
                'product_ratings' => $product_ratings,
                'product_sku' => $product_sku,
                'product_availability' => $product_availability,
                'product_addtocart_button' => $product_addtocart_button,
                'misc' => [
                    'is_shop_page' => is_shop() || is_product_category() || is_product_tag() || is_product(),
                    'is_product_page' => $is_product_page,
                    'is_cart_page' => false,
                    'is_checkkout_page' => false,
                    'checkout_post_codes' => '',
                ]
            ], '', p_usp()::$PLUGIN_DIR.'/app/Frontend/TemplateRender/');
        }

        /**
         * Process Ajax Request
         * @return void
         */
        public function maybe_ajax_product_request()
        {
            if (!empty($_POST['_wpnonce']) && wp_verify_nonce(sanitize_text_field($_POST['_wpnonce']), p_usp()::$AJAX_NONCE)) {
                $add_to_cart = isset($_POST['add_to_cart']) ? sanitize_text_field($_POST['add_to_cart']) : null;
                if (!empty($add_to_cart)) {
                    $product_obj = new P_USP_Upsell_Controller($add_to_cart);
                    if (!$product_obj->has_product) {
                        return;
                    }
                    wp_send_json_success([
                        'is_modalbox_enabled' => false,
                        'modalbox_type' => 'product_modalbox',
                        'modalbox_heading' => p_usp()->db()::get_modalbox_header_heading($add_to_cart),
                        'modalbox_class' => implode(' ', get_post_class(['product__wrapper'], $product_obj->product->get_id())),
                        'modalbox_delay' => p_usp()->db()::get_modalbox_delay($add_to_cart),
                        'product_id' => $product_obj->product->get_id(),
                        'product_title' => $product_obj->product->get_title(),
                        'product_image' => $product_obj->product->get_image(),
                        'product_description' => $product_obj->product->get_short_description(),
                        'product_price' => $product_obj->product->get_price_html(),
                        'product_categories' => $product_obj->get_product_categories(),
                        'product_ratings' => $product_obj->get_product_rating(),
                        'product_sku' => $product_obj->product->get_sku(),
                        'product_availability' => $product_obj->get_product_availability(),
                        'product_addtocart_button' => $product_obj->get_add_to_cart_button(),
                        'misc' => [
                            'is_shop_page' => is_shop() || is_product_category() || is_product_tag() || is_product(),
                            'is_product_page' => false,
                            'is_cart_page' => false,
                            'is_checkkout_page' => false,
                            'checkout_post_codes' => '',
                        ]
                    ], 200);
                }
            }
        }
    }
}