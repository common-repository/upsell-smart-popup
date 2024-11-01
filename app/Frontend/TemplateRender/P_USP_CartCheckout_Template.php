<?php

namespace P_USP\App\Frontend\TemplateRender;

use P_USP\App\Frontend\Controllers\P_USP_Upsell_Controller;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_CartCheckout_Template')) {
    class P_USP_CartCheckout_Template
    {
        /**
         * Initializer Of The Class
         * Hook into actions and filters.
         */
        public function init()
        {
            add_action('wp_footer', [$this, 'maybe_render_template']);
        }

        /**
         * Show Template
         * @return void
         */
        public function maybe_render_template()
        {
            // If not cart and checkout page
            if (!is_cart() && !is_checkout()) {
                return;
            }
            // If cart is empty return
            if (p_usp()->cart_handler()::is_cart_empty()) {
                return;
            }
            $is_cart_page = false;
            $is_checkout_page = false;
            $is_modalbox_enabled = false;
            $modalbox_type = '';
            $modalbox_heading = '';
            $modalbox_delay = 2000;
            $checkout_post_codes = '';
            // If is cart page
            if (is_cart() && !isset($_GET['removed_item'])) { // phpcs:ignore WordPress.Security.NonceVerification
                $is_cart_page = true;
                $modalbox_type = 'cart__modalbox';
                $is_modalbox_enabled = p_usp()->db()::is_cart_modalbox_enabled();
                $modalbox_heading = p_usp()->db()::get_cart_modalbox_heading();
                $modalbox_delay = p_usp()->db()::get_cart_modalbox_delay();
                $product_id = p_usp()->db()::get_cart_upsell_product_id();
                $usp_cart_min = p_usp()->db()::get_cart_upsell_min_amount();
                $usp_cart_max = p_usp()->db()::get_cart_upsell_max_amount();
                if (!empty($usp_cart_min) || !empty($usp_cart_max)) {
                    if (!p_usp()->cart_handler()::check_cart_min_max($usp_cart_min, $usp_cart_max)) {
                        return;
                    }
                }
            }
            // If is checkout page
            if (is_checkout()) {
                $is_checkout_page = true;
                $modalbox_type = 'checkout__modalbox';
                $is_modalbox_enabled = p_usp()->db()::is_checkout_modalbox_enabled();
                $modalbox_heading = p_usp()->db()::get_checlout_modalbox_heading();
                $modalbox_delay = p_usp()->db()::get_checkout_modalbox_delay();
                $product_id = p_usp()->db()::get_checkout_upsell_product_id();
                $checkout_post_codes = p_usp()->db()::get_checkout_upsell_postcode();
            }
            if (empty($product_id) || !$is_modalbox_enabled) {
                return;
            }
            $product_obj = new P_USP_Upsell_Controller($product_id);
            if (!$product_obj->has_product) {
                return;
            }
            wc_get_template('modalbox-view.php', [
                'is_modalbox_enabled' => false,
                'modalbox_type' => $modalbox_type,
                'modalbox_heading' => $modalbox_heading,
                'modalbox_class' => implode(' ', get_post_class(['product__wrapper'], $product_obj->product->get_id())),
                'modalbox_delay' => $modalbox_delay,
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
                    'is_shop_page' => false,
                    'is_product_page' => false,
                    'is_cart_page' => $is_cart_page,
                    'is_checkkout_page' => $is_checkout_page,
                    'checkout_post_codes' => $checkout_post_codes,
                ]
            ], '', p_usp()::$PLUGIN_DIR.'/app/Frontend/TemplateRender/');
        }
    }
}
