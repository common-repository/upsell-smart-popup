<?php

namespace P_USP\App\Frontend\Controllers;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Upsell_Controller')) {
    class P_USP_Upsell_Controller
    {
        public $product;

        public $has_product = false;

        public $add_to_cart_class = 'product_popup_addtocart_btn';

        /**
         * Initialize the class and set its properties.
         */
        public function __construct($product_id)
        {

            if (!is_cart() && !is_checkout()) {
                $product_id = p_usp()->db()::get_upsell_product_id($product_id);
            }
            if (is_cart()) {
                $this->add_to_cart_class = 'cart_modalbox_addtocart';
            }
            if (is_checkout()) {
                $this->add_to_cart_class = 'checkout_modalbox_addtocart';
            }
            $product = wc_get_product($product_id);
            if (false !== $product
                && is_object($product)
                && false === p_usp()->cart_handler()::is_product_exist_in_cart($product->get_id())
                && 'external' !== $product->get_type()
                && 'variable' !== $product->get_type()
                && 'grouped' !== $product->get_type()
            ) {

                $this->product = $product;
                $this->has_product = true;
            }
        }

        /**
         * Get Add To Cart Button
         * @return string
         */
        public function get_add_to_cart_button()
        {
            $add_to_cart_class = $this->add_to_cart_class;
            $class = p_usp()->db()::is_ajax_enabled() ? "$add_to_cart_class add_to_cart_button ajax_add_to_cart" : "$add_to_cart_class add_to_cart_button";

            return sprintf(
                '<a href="%s" rel="nofollow" data-product_id="%s" data-quantity="%s" data-product_sku="%s" class="product__add_to_cart button %s product_type_%s">%s</a>', esc_url($this->product->add_to_cart_url()),
                esc_attr($this->product->get_id()), esc_attr(1), esc_attr($this->product->get_sku()), $class, esc_attr($this->product->get_type()), esc_html($this->product->add_to_cart_text())
            );
        }

        /**
         * Get Availability
         * @return string
         */
        public function get_product_availability()
        {
            $stock_html = wc_get_stock_html($this->product);

            return '' === $stock_html ? __('In Stock', 'upsell-smart-popup') : $stock_html;
        }

        /**
         * Get Categories
         * @return string
         */
        public function get_product_categories()
        {
            return wc_get_product_category_list($this->product->get_id());
        }

        /**
         * Get Rating
         * @return string
         */
        public function get_product_rating()
        {
            $rating_count = $this->product->get_rating_count();
            $average = $this->product->get_average_rating();

            return wc_get_rating_html($average, $rating_count);
        }

    }
}
