<?php

namespace P_USP\App\Admin\Settings;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Settings')) {
    class P_USP_Settings
    {
        /**
         * Initializer Of The Class.
         * @return  void
         */
        public function init()
        {
            add_filter('woocommerce_settings_tabs_array', [$this, 'maybe_add_tab'], 999);
            add_action('woocommerce_settings_tabs_upsell-smart-popup-settings', [$this, 'maybe_add_fields']);
            add_action('woocommerce_update_options_upsell-smart-popup-settings', [$this, 'maybe_process_form_data']);
        }

        /**
         * Add Tabs
         *
         * @param $settings_tabs
         *
         * @return mixed
         */
        public function maybe_add_tab($settings_tabs)
        {
            $settings_tabs['upsell-smart-popup-settings'] = __('Upsell Smart Popup', 'upsell-smart-popup');

            return $settings_tabs;
        }

        /**
         * Add Fields
         * @return void
         */
        public function maybe_add_fields()
        {
            woocommerce_admin_fields(self::get_settings());
        }

        /**
         * Process Form Data
         * @return void
         */
        public function maybe_process_form_data()
        {
            woocommerce_update_options(self::get_settings());
        }

        /**
         * Register Settings
         * @return array
         */
        public function get_settings()
        {
            return [
                [
                    'title' => __('Cart Upsell Settings', 'upsell-smart-popup'),
                    'desc' => __('Increase your shop\'s sales and draw in more customers with the Cart Upsell Smart Pop-up Product, which automatically displays when customer visits cart page. You may set the minimum and maximum cart value here. Additionally, you have the option of hiding a certain product from the frontend or setting a specific quantity for the product to be added to the cart.', 'upsell-smart-popup'),
                    'type' => 'title',
                    'id' => 'cart_usp_settings',
                ],
                [
                    'title' => __('Enable Upsell', 'upsell-smart-popup'),
                    'desc' => __('Enable this option to display a upsell smart pop-up for a product on the cart page.', 'upsell-smart-popup'),
                    'id' => 'usp_cart_modalbox_enabled',
                    'type' => 'checkbox',
                    'default' => 'no',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Heading', 'upsell-smart-popup'),
                    'desc' => __('Enter an eye-catching heading of upsell smart pop-up. For the purpose of hiding, leave the field empty.', 'upsell-smart-popup'),
                    'id' => 'usp_cart_modalbox_heading',
                    'type' => 'text',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('ModalBox Delay', 'upsell-smart-popup'),
                    'desc' => __('Set the delay in milliseconds for the modal box to appear on the cart page', 'upsell-smart-popup'),
                    'id' => 'usp_cart_modalbox_delay',
                    'type' => 'number',
                    'default' => 2000,
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Product ID', 'upsell-smart-popup'),
                    'desc' => sprintf(__('Enter the <a href="%s" target="_blank">Product ID</a> you wish to use as an upsell smart pop-up.', 'upsell-smart-popup'), add_query_arg(['post_type' => 'product'], admin_url('edit.php'))),
                    'id' => 'usp_cart_upsell_product_id',
                    'type' => 'text',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Cart Min Amount', 'upsell-smart-popup'),
                    'desc' => __('To enable the upsell smart pop-up  enter the minimum amount of your cart total.', 'upsell-smart-popup'),
                    'id' => 'usp_cart_upsell_min_amount',
                    'type' => 'number',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Cart Max Amount', 'upsell-smart-popup'),
                    'desc' => __('To enable the upsell smart pop-up  enter the maximum amount of your cart total.', 'upsell-smart-popup'),
                    'id' => 'usp_cart_upsell_max_amount',
                    'type' => 'number',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Hide Product Visibility', 'upsell-smart-popup'),
                    'desc' => __('Enable this option to conceal the upsell product from the frontend.', 'upsell-smart-popup'),
                    'id' => 'usp_cart_upsell_product_visibility',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Forced Product Quantity', 'upsell-smart-popup'),
                    'desc' => __('Enable this option to allow to purchase only one the upsell product at a time.', 'upsell-smart-popup'),
                    'id' => 'usp_cart_upsell_product_forced_qty',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'type' => 'sectionend',
                    'id' => 'cart_usp_settings'
                ],
                [
                    'title' => __('Checkout Upsell Settings', 'upsell-smart-popup'),
                    'desc' => __('Increase your shop\'s sales and draw in more customers with the Checkout Upsell Smart Pop-up Product, which automatically displays when customer visits checkout page. Additionally, you have the option of hiding a certain product from the frontend or setting a specific quantity for the product to be added to the cart.In addition, you have the option of specifying several postcodes for the pop-up to appear in.', 'upsell-smart-popup'),
                    'type' => 'title',
                    'id' => 'checkout_usp_settings',
                ],
                [
                    'title' => __('Enable Upsell', 'upsell-smart-popup'),
                    'desc' => __('Enable this option to display a upsell smart pop-up for a product on the checkout page.', 'upsell-smart-popup'),
                    'id' => 'usp_checkout_modalbox_enabled',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Heading', 'upsell-smart-popup'),
                    'desc' => __('Enter an eye-catching heading of upsell smart pop-up. For the purpose of hiding, leave the field empty.', 'upsell-smart-popup'),
                    'id' => 'usp_checlout_modalbox_heading',
                    'type' => 'text',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('ModalBox Delay', 'upsell-smart-popup'),
                    'desc' => __('Set the delay in milliseconds for the modal box to appear on the checkout page.', 'upsell-smart-popup'),
                    'id' => 'usp_checkout_modalbox_delay',
                    'type' => 'number',
                    'default' => 5000,
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Product ID', 'upsell-smart-popup'),
                    'desc' => sprintf(__('Enter the <a href="%s" target="_blank">Product ID</a> you wish to use as an upsell smart pop-up.', 'upsell-smart-popup'), add_query_arg(['post_type' => 'product'], admin_url('edit.php'))),
                    'id' => 'usp_checkout_upsell_product_id',
                    'type' => 'text',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Postcode / ZIP', 'upsell-smart-popup'),
                    'desc' => __('Enter comma-separated postcodes may be used in order to activate the upsell smart pop-up just for certain postcodes.', 'upsell-smart-popup'),
                    'id' => 'usp_checkout_upsell_postcode',
                    'type' => 'text',
                    'default' => '',
                    'class' => '',
                    'css' => '',
                    'placeholder' => '',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Hide Product Visibility', 'upsell-smart-popup'),
                    'desc' => __('Enable this option to conceal the upsell product from the frontend.', 'upsell-smart-popup'),
                    'id' => 'usp_checkout_upsell_product_visibility',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Forced Product Quantity', 'upsell-smart-popup'),
                    'desc' => __('Enable this option to allow to purchase only one the upsell product at a time.', 'upsell-smart-popup'),
                    'id' => 'usp_checkout_upsell_product_forced_qty',
                    'default' => 'no',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'type' => 'sectionend',
                    'id' => 'checkout_usp_settings'
                ],
                [
                    'title' => __('Upsell Smart Popup Settings', 'upsell-smart-popup'),
                    'desc' => __('The below settings for sales booster.', 'upsell-smart-popup'),
                    'type' => 'title',
                    'id' => 'usp_settings',
                ],
                [
                    'title' => __('Product Star Rating', 'upsell-smart-popup'),
                    'desc' => __('Show product star ratings on the upsell smart pop-up by enabling this option.', 'upsell-smart-popup'),
                    'id' => 'usp_upsell_product_rating_enabled',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Product Brands', 'upsell-smart-popup'),
                    'desc' => __('Show product brands on the upsell smart pop-up by enabling this option.', 'upsell-smart-popup'),
                    'id' => 'usp_upsell_product_brands_enabled',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Product SKU', 'upsell-smart-popup'),
                    'desc' => __('Show product SKU on the upsell smart pop-up by enabling this option.', 'upsell-smart-popup'),
                    'id' => 'usp_upsell_product_sku_enabled',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Product Availablity', 'upsell-smart-popup'),
                    'desc' => __('Show product availablity on the upsell smart pop-up by enabling this option.', 'upsell-smart-popup'),
                    'id' => 'usp_upsell_product_availability_enabled',
                    'default' => 'yes',
                    'type' => 'checkbox',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Header Background Color', 'upsell-smart-popup'),
                    'desc' => sprintf(esc_html__('Select the color of the upsell smart pop-up header\'s background. Default %s.', 'upsell-smart-popup'), '<code>#7f54b3</code>'),
                    'id' => 'usp_modalbox_header_bg_color',
                    'type' => 'color',
                    'css' => 'width:5%;',
                    'default' => '#7f54b3',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'title' => __('Header Text Color', 'upsell-smart-popup'),
                    'desc' => sprintf(esc_html__('Select the color of the upsell smart pop-up header\'s text. Default %s.', 'upsell-smart-popup'), '<code>#ffffff</code>'),
                    'id' => 'usp_modalbox_header_text_color',
                    'type' => 'color',
                    'css' => 'width:5%;',
                    'default' => '#ffffff',
                    'autoload' => false,
                    'desc_tip' => false,
                ],
                [
                    'type' => 'sectionend',
                    'id' => 'usp_settings'
                ],
            ];
        }
    }
}