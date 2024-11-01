<?php

namespace P_USP\App\Frontend\Controllers;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Cart_Helper')) {
    class P_USP_Cart_Helper
    {
        private static $_instance;

        /**
         * Class Instance
         * @return P_USP_Cart_Helper
         */
        public static function instance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Is Cart Empty
         * @return bool
         */
        public static function is_cart_empty()
        {
            if (0 === WC()->cart->get_cart_contents_count()) {
                return true;
            }

            return false;
        }

        /**
         * Is Product exist in Cart
         *
         * @param $product_id
         *
         * @return bool
         */
        public static function is_product_exist_in_cart($product_id)
        {
            $product_cart_id = WC()->cart->generate_cart_id($product_id);
            $in_cart = WC()->cart->find_product_in_cart($product_cart_id);
            if ($in_cart) {
                return true;
            }

            return false;
        }

        /**
         * Check Min and Max Of Cart
         *
         * @param $min
         * @param $max
         *
         * @return bool
         */
        public static function check_cart_min_max($min, $max)
        {
            if (!empty($min) && !empty($max)) {
                if (WC()->cart->get_cart_contents_total() >= $min && WC()->cart->get_cart_contents_total() <= $max) {
                    return true;
                } else {
                    return false;
                }
            }
            if (!empty($min) && empty($max)) {
                if (WC()->cart->get_cart_contents_total() >= $min) {
                    return true;
                }
            }
            if (empty($min) && !empty($max)) {
                if (WC()->cart->get_cart_contents_total() <= $max) {
                    return true;
                }
            }

            return false;
        }
    }
}
