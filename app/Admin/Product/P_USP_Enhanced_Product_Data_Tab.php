<?php

namespace P_USP\App\Admin\Product;

if (!defined('ABSPATH')) exit;
if (!class_exists('P_USP_Enhanced_Product_Data_Tab')) {
    class P_USP_Enhanced_Product_Data_Tab
    {
        /**
         * Initializer Of The Class
         * Hook into actions and filters.
         */
        public function init()
        {
            add_filter('woocommerce_product_data_tabs', [$this, 'maybe_add_data_tabs']);
            add_action('woocommerce_product_data_panels', [$this, 'maybe_add_fields']);
            add_action('woocommerce_process_product_meta', [$this, 'maybe_process_form_data']);
        }

        /**
         * Add Tab
         * @return void
         */
        public function maybe_add_data_tabs($tabs)
        {
            $tabs['upsell_smart_popup'] = [
                'label' => __('Upsell Smart Popup', 'upsell-smart-popup'),
                'target' => 'upsell_smart_popup',
                'class' => ['show_if_simple'],
                'priority' => 15,
            ];

            return $tabs;

        }

        /**
         * Add Fields
         * @return void
         */
        public function maybe_add_fields()
        {
            $product_obj = wc_get_product(get_the_ID());
            $modalbox_heading = $product_obj->get_meta('usp_modalbox_heading');
            $modalbox_delay = $product_obj->get_meta('usp_modalbox_delay');
            $upsell_product_id = $product_obj->get_meta('usp_upsell_product_id');
            $upsell_product_visibility = $product_obj->get_meta('usp_upsell_product_visibility');
            $upsell_product_forced_qt = $product_obj->get_meta('usp_upsell_product_forced_qty');
            ?>
            <div id="upsell_smart_popup" class="panel woocommerce_options_panel hidden">
                <?php
                woocommerce_wp_text_input([
                    'label' => __('Heading:', 'upsell-smart-popup'),
                    'id' => 'usp_modalbox_heading',
                    'value' => $modalbox_heading,
                    'desc_tip' => false,
                    'placeholder' => '',
                    'description' => __('Enter an eye-catching heading of pop-up. For the purpose of hiding, leave the field empty.', 'upsell-smart-popup'),
                    'class' => '',
                    'style' => '',
                    'wrapper_class' => '',
                    'custom_attributes' => [],
                ]);

                ?>
                <p class="form-field">
                    <label for="upsell_ids"><?php esc_html_e('Product ID:', 'upsell-smart-popup'); ?></label>
                    <select title="" style="width: 100%" class="wc-product-search" id="usp_upsell_product_id" name="usp_upsell_product_id" data-placeholder="<?php esc_attr_e('Search for a product&hellip;', 'upsell-smart-popup'); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval(get_the_ID()); ?>">
                        <?php
                        if (!empty($upsell_product_id)) {
                            $product = wc_get_product($upsell_product_id);
                            if (is_object($product)) {
                                echo '<option value="'.esc_attr($product->get_id()).'">'.esc_html($product->get_formatted_name()).'</option>';
                            }
                        }
                        ?>
                    </select>
                    <a href="javascript:void(0)" id="remove__product"><?php echo esc_html__('Remove', 'upsell-smart-popup'); ?></a>
                    <span class="description"><?php echo esc_html__('Select the product you wish to use as a upsell smart pop-up.', 'upsell-smart-popup'); ?></span>
                </p>
                <?php
                woocommerce_wp_text_input([
                    'type' => 'number',
                    'label' => __('ModalBox Delay:', 'upsell-smart-popup'),
                    'id' => 'usp_modalbox_delay',
                    'value' => $modalbox_delay,
                    'desc_tip' => false,
                    'placeholder' => '',
                    'description' => __('Set the delay in milliseconds for the modal box to appear after add to cart action.', 'upsell-smart-popup'),
                    'class' => '',
                    'style' => 'width:100%;',
                    'wrapper_class' => '',
                    'custom_attributes' => [],
                ]);
                woocommerce_wp_checkbox([
                    'label' => __('Hide Product Visibility:', 'upsell-smart-popup'),
                    'id' => 'usp_upsell_product_visibility',
                    'value' => $upsell_product_visibility,
                    'desc_tip' => false,
                    'placeholder' => '',
                    'description' => __('Enable this option to conceal the upsell product from the frontend.', 'upsell-smart-popup'),
                    'class' => '',
                    'style' => '',
                    'wrapper_class' => '',
                    'custom_attributes' => [],
                ]);
                woocommerce_wp_checkbox([
                    'label' => __('Forced Product Quantity:', 'upsell-smart-popup'),
                    'id' => 'usp_upsell_product_forced_qty',
                    'value' => $upsell_product_forced_qt,
                    'desc_tip' => false,
                    'placeholder' => '',
                    'description' => __('Enable this option to allow to purchase only one the upsell product at a time.', 'upsell-smart-popup'),
                    'class' => '',
                    'style' => '',
                    'wrapper_class' => '',
                    'custom_attributes' => [],
                ]);
                ?>
            </div>
            <?php
            wp_nonce_field(md5(__FILE__), 'product_nonce');
        }

        /**
         * Process Form Data
         *
         * @param $current_product_id
         *
         * @return void
         */
        public function maybe_process_form_data($current_product_id)
        {
            if (isset($_POST['product_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['product_nonce']), md5(__FILE__))) {
                $product_obj = wc_get_product($current_product_id);
                $modalbox_heading = isset($_POST['usp_modalbox_heading']) ? sanitize_text_field($_POST['usp_modalbox_heading']) : '';
                $modalbox_delay = isset($_POST['usp_modalbox_delay']) ? sanitize_text_field($_POST['usp_modalbox_delay']) : '';
                $upsell_product_id = isset($_POST['usp_upsell_product_id']) ? sanitize_text_field($_POST['usp_upsell_product_id']) : '';
                $upsell_product_visibility = isset($_POST['usp_upsell_product_visibility']) ? sanitize_text_field($_POST['usp_upsell_product_visibility']) : 'no';
                $upsell_product_forced_qt = isset($_POST['usp_upsell_product_forced_qty']) ? sanitize_text_field($_POST['usp_upsell_product_forced_qty']) : 'no';
                $meta_keys = [
                    'usp_modalbox_heading' => $modalbox_heading,
                    'usp_modalbox_delay' => $modalbox_delay,
                    'usp_upsell_product_id' => $upsell_product_id,
                    'usp_upsell_product_visibility' => $upsell_product_visibility,
                    'usp_upsell_product_forced_qty' => $upsell_product_forced_qt,
                ];
                foreach ($meta_keys as $key => $value) {
                    if ('' !== $value) {
                        $product_obj->update_meta_data($key, $value);
                    } else {
                        $product_obj->delete_meta_data($key);
                    }
                }
                $product_obj->save_meta_data();
                // Visibility IDS
                $products_visibility_ids = get_option('usp_upsell_products_visibility_ids', []);
                if ('yes' === $upsell_product_visibility && !empty($upsell_product_id)) {
                    $products_visibility_ids[$current_product_id] = $upsell_product_id;
                } elseif (empty($upsell_product_id) && isset($products_visibility_ids[$current_product_id])) {
                    unset($products_visibility_ids[$current_product_id]);
                } else {
                    if (isset($products_visibility_ids[$current_product_id])) {
                        unset($products_visibility_ids[$current_product_id]);
                    }
                }
                update_option('usp_upsell_products_visibility_ids', $products_visibility_ids, 'no');
                // Forced QTY IDS
                $products_forced_qty_ids = get_option('usp_upsell_products_forced_qty_ids', []);
                if ('yes' === $upsell_product_forced_qt && !empty($upsell_product_id)) {
                    $products_forced_qty_ids[$current_product_id] = $upsell_product_id;
                } elseif (empty($upsell_product_id) && isset($products_forced_qty_ids[$current_product_id])) {
                    unset($products_forced_qty_ids[$current_product_id]);
                } else {
                    if (isset($products_forced_qty_ids[$current_product_id])) {
                        unset($products_forced_qty_ids[$current_product_id]);
                    }
                }
                update_option('usp_upsell_products_forced_qty_ids', $products_forced_qty_ids, 'no');
            }
        }
    }
}