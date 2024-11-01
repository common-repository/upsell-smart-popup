<?php

namespace P_USP\App\Frontend\Controllers;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_General_Hooks')) {
    class P_USP_General_Hooks
    {
        /**
         * Initialize WordPress Hooks
         * @return  void
         */
        public function init()
        {
            add_filter('woocommerce_cart_item_permalink', [$this, 'maybe_remove_item_permalink'], 10, 3);
            add_filter('pre_get_posts', [$this, 'maybe_products_visibility']);
            add_action('template_redirect', [$this, 'maybe_product_forced_qty']);
            add_filter('woocommerce_quantity_input_args', [$this, 'maybe_product_forced_qty_input'], 10, 2);
        }

        /**
         * Remove Product Link
         *
         * @param $product_get_permalink_cart_item
         * @param $cart_item
         * @param $cart_item_key
         *
         * @return mixed|string
         */
        public function maybe_remove_item_permalink($product_get_permalink_cart_item, $cart_item, $cart_item_key)
        {
            $product_id = isset($cart_item['product_id']) ? $cart_item['product_id'] : '';
            $ids_arr = p_usp()->db()::get_upsell_products_visibility_ids();
            if (!empty($ids_arr) && in_array($product_id, $ids_arr)) {
                return '';
            }

            return $product_get_permalink_cart_item;
        }

        /**
         * Hide Products From Frontend
         *
         * @param $qeury
         *
         * @return void
         */
        public function maybe_products_visibility($qeury)
        {
            $ids_arr = p_usp()->db()::get_upsell_products_visibility_ids();
            if (!is_admin() && $qeury->is_main_query() && !empty($ids_arr)) {
                $qeury->set('post__not_in', $ids_arr);
            }
        }

        /**
         * Forced Product QTY
         * @return void
         */
        public function maybe_product_forced_qty()
        {
            if (count(WC()->cart->get_cart()) > 0) {
                $ids_arr = p_usp()->db()::get_upsell_products_forced_qty_ids();
                foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                    $product = $values['data'];
                    if (in_array($product->get_id(), $ids_arr)) {
                        WC()->cart->set_quantity($cart_item_key);
                    }
                }
            }
        }

        /**
         * Forced Product QTY Input Min & Max
         * @return void
         */
        public function maybe_product_forced_qty_input($args, $product)
        {
            $ids_arr = p_usp()->db()::get_upsell_products_forced_qty_ids();
            if (in_array($product->get_id(), $ids_arr)) {
                //$args['min_value'] = 0;
                $args['max_value'] = 1;
            }

            return $args;
        }

    }
}
