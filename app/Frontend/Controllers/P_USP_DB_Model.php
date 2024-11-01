<?php

namespace P_USP\App\Frontend\Controllers;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_DB_Model')) {
    class P_USP_DB_Model
    {
        private static $_instance;

        /**
         * Class Instance
         * @return P_USP_DB_Model
         */
        public static function instance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Is Woo Ajax Enabled
         * @return bool
         */
        public static function is_ajax_enabled()
        {
            return 'yes' === get_option('woocommerce_enable_ajax_add_to_cart');
        }

        /**
         * Is Cart Enabled
         * @return bool
         */
        public static function is_cart_modalbox_enabled()
        {
            return 'yes' === get_option('usp_cart_modalbox_enabled', 'no');
        }

        /**
         * Get Cart Heading
         * @return false|mixed|void
         */
        public static function get_cart_modalbox_heading()
        {
            return get_option('usp_cart_modalbox_heading', '');
        }

        /**
         * Get Cart Heading
         * @return false|mixed|void
         */
        public static function get_cart_modalbox_delay()
        {
            return get_option('usp_cart_modalbox_delay', 2000);
        }

        /**
         * Get Cart Product ID
         * @return false|int|mixed|void
         */
        public static function get_cart_upsell_product_id()
        {
            $product_id = get_option('usp_cart_upsell_product_id', '');

            return !empty($product_id) ? absint($product_id) : $product_id;
        }

        /**
         * Get Cart Min Amount
         * @return false|mixed|void
         */
        public static function get_cart_upsell_min_amount()
        {
            return get_option('usp_cart_upsell_min_amount', '');
        }

        /**
         * Get Cart Max Amount
         * @return false|mixed|void
         */
        public static function get_cart_upsell_max_amount()
        {
            return get_option('usp_cart_upsell_max_amount', '');
        }

        /**
         * Get Cart Visibility
         * @return bool
         */
        public static function get_cart_upsell_product_visibility()
        {
            return 'yes' === get_option('usp_cart_upsell_product_visibility', 'no');
        }

        /**
         * Get Cart Forced QTY
         * @return bool
         */
        public static function get_cart_upsell_product_forced_qty()
        {
            return 'yes' === get_option('usp_cart_upsell_product_forced_qty', 'no');
        }

        /**
         * Is Checkout Enabled
         * @return bool
         */
        public static function is_checkout_modalbox_enabled()
        {
            return 'yes' === get_option('usp_checkout_modalbox_enabled', 'no');
        }

        /**
         * Get Checkout Heading
         * @return false|mixed|void
         */
        public static function get_checlout_modalbox_heading()
        {
            return get_option('usp_checlout_modalbox_heading', '');
        }

        /**
         * Get Checkout Heading
         * @return false|mixed|void
         */
        public static function get_checkout_modalbox_delay()
        {
            return get_option('usp_checkout_modalbox_delay', 5000);
        }

        /**
         * Get Checkout Product ID
         * @return false|int|mixed|void
         */
        public static function get_checkout_upsell_product_id()
        {
            $product_id = get_option('usp_checkout_upsell_product_id', '');

            return !empty($product_id) ? absint($product_id) : $product_id;
        }

        /**
         * Get Checkout Postcodes
         * @return false|int|mixed|void
         */
        public static function get_checkout_upsell_postcode()
        {
            return get_option('usp_checkout_upsell_postcode', '');
        }

        /**
         * Get Checkout Visibility
         * @return bool
         */
        public static function get_checkout_upsell_product_visibility()
        {
            return 'yes' === get_option('usp_checkout_upsell_product_visibility', 'no');
        }

        /**
         * Get Checkout Forced QTY
         * @return bool
         */
        public static function get_checkout_upsell_product_forced_qty()
        {
            return 'yes' === get_option('usp_checkout_upsell_product_forced_qty', 'no');
        }

        /**
         * Get Heading
         *
         * @param $product_id
         *
         * @return mixed
         */
        public static function get_modalbox_header_heading($product_id)
        {
            return get_post_meta($product_id, 'usp_modalbox_heading', true);
        }

        /**
         * Get Modalbox Delay
         *
         * @param $product_id
         *
         * @return mixed
         */
        public static function get_modalbox_delay($product_id)
        {
            return get_post_meta($product_id, 'usp_modalbox_delay', true);
        }

        /**
         * Get Product ID
         *
         * @param $product_id
         *
         * @return mixed
         */
        public static function get_upsell_product_id($product_id)
        {
            return get_post_meta($product_id, 'usp_upsell_product_id', true);
        }

        /**
         * Is Product Star Ratiing Enabled?
         * @return bool
         */
        public static function get_upsell_product_rating_enabled()
        {
            return 'yes' === get_option('usp_upsell_product_rating_enabled', 'yes');
        }

        /**
         * Is Product Brands Enabled?
         * @return bool
         */
        public static function get_upsell_product_brands_enabled()
        {
            return 'yes' === get_option('usp_upsell_product_brands_enabled', 'yes');
        }

        /**
         * Is Product SKU Enabled
         * @return bool
         */
        public static function get_upsell_product_sku_enabled()
        {
            return 'yes' === get_option('usp_upsell_product_sku_enabled', 'yes');
        }

        /**
         * Is Product Availabiliy Enabled
         * @return bool
         */
        public static function get_upsell_product_availability_enabled()
        {
            return 'yes' === get_option('usp_upsell_product_availability_enabled', 'yes');
        }

        /**
         * Get Cart Header Background Color
         * @return false|mixed|void
         */
        public static function get_modalbox_header_bg_color()
        {
            return get_option('usp_modalbox_header_bg_color', '#7f54b3');
        }

        /**
         * Get Header Text Color
         * @return false|mixed|void
         */
        public static function get_modalbox_header_text_color()
        {
            return get_option('usp_modalbox_header_text_color', '#ffffff');
        }

        /**
         * Get Ids Of Products To Be Hide
         * @return array
         */
        public static function get_upsell_products_visibility_ids()
        {
            $data = [];
            // Cart
            $is_cart_modalbox_enabled = self::is_cart_modalbox_enabled();
            $cart_upsell_product_visibility = self::get_cart_upsell_product_visibility();
            if ($is_cart_modalbox_enabled && $cart_upsell_product_visibility) {
                $cart_upsell_product_id = self::get_cart_upsell_product_id();
                $data = wp_parse_args([$cart_upsell_product_id], $data);
            }
            // Checkout
            $is_checkout_modalbox_enabled = self::is_checkout_modalbox_enabled();
            $checkout_usp_product_visibility = self::get_checkout_upsell_product_visibility();
            if ($is_checkout_modalbox_enabled && $checkout_usp_product_visibility) {
                $heckout_upsell_product_id = self::get_checkout_upsell_product_id();
                $data = wp_parse_args([$heckout_upsell_product_id], $data);
            }
            // Products
            $upsell_products_visibility_ids = array_values(get_option('usp_upsell_products_visibility_ids', []));

            return wp_parse_args($upsell_products_visibility_ids, $data);
        }

        /**
         * Get Ids Of Products To Be Added Once
         * @return array
         */
        public static function get_upsell_products_forced_qty_ids()
        {
            $data = [];
            // Cart
            $is_cart_modalbox_enabled = self::is_cart_modalbox_enabled();
            $cart_upsell_product_forced_qty = self::get_cart_upsell_product_forced_qty();
            if ($is_cart_modalbox_enabled && $cart_upsell_product_forced_qty) {
                $cart_upsell_product_id = self::get_cart_upsell_product_id();
                $data = wp_parse_args([$cart_upsell_product_id], $data);
            }
            // Checkout
            $is_checkout_modalbox_enabled = self::is_checkout_modalbox_enabled();
            $checkout_upsell_product_forced_qty = self::get_checkout_upsell_product_forced_qty();
            if ($is_checkout_modalbox_enabled && $checkout_upsell_product_forced_qty) {
                $heckout_upsell_product_id = self::get_checkout_upsell_product_id();
                $data = wp_parse_args([$heckout_upsell_product_id], $data);
            }
            // Products
            $upsell_products_forced_qty_ids = array_values(get_option('usp_upsell_products_forced_qty_ids', []));

            return wp_parse_args($upsell_products_forced_qty_ids, $data);
        }

    }
}
