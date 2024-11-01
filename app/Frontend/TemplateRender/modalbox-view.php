<?php
/* @var TYPE_NAME $is_modalbox_enabled */
/* @var TYPE_NAME $modalbox_type */
/* @var TYPE_NAME $modalbox_heading */
/* @var TYPE_NAME $modalbox_class */
/* @var TYPE_NAME $modalbox_delay */
/* @var TYPE_NAME $product_id */
/* @var TYPE_NAME $product_title */
/* @var TYPE_NAME $product_price */
/* @var TYPE_NAME $product_image */
/* @var TYPE_NAME $product_categories */
/* @var TYPE_NAME $product_ratings */
/* @var TYPE_NAME $product_sku */
/* @var TYPE_NAME $product_availability */
/* @var TYPE_NAME $product_description */
/* @var TYPE_NAME $product_addtocart_button */
/* @var TYPE_NAME $misc */
$config = [
    'is_modalbox_enabled' => $is_modalbox_enabled,
    'modalbox_type' => $modalbox_type,
    'modalbox_heading' => $modalbox_heading,
    'modalbox_delay' => $modalbox_delay,
    'product_id' => $product_id,
    'misc' => $misc,
];
?>
<div id="usp__modalbox" class="d__none <?php echo esc_attr($modalbox_type); ?>" data-modalbox-config="<?php echo esc_attr(wp_json_encode($config)); ?>">
    <div class="<?php esc_attr_e($modalbox_class); ?>" id="product__wrapper">
        <div class="product__photo"> <?php echo wp_kses_post($product_image); ?></div>
        <div class="product__content">
            <h2 class="product__title"><?php echo wp_kses_post($product_title); ?></h2>
            <h4 class="product__price"><?php echo wp_kses_post($product_price); ?></h4>
            <div class="product__info">
                <?php if (p_usp()->db()::get_upsell_product_rating_enabled()) { ?>
                    <div class="product__rating"><?php echo wp_kses_post($product_ratings); ?></div>
                <?php } ?>
                <?php if (p_usp()->db()::get_upsell_product_brands_enabled()) {
                    $brand_label = apply_filters('p_usp_product_brand_label', __('Brand:', 'upsell-smart-popup'));
                    ?>
                    <div class="product__info_line">
                        <span class="product__info_label"><?php echo esc_html($brand_label); ?></span>
                        <span class="product__info_value categories"><?php echo wp_kses_post($product_categories); ?></span>
                    </div>
                <?php } ?>
                <?php if (p_usp()->db()::get_upsell_product_sku_enabled() && !is_null($product_sku)) {
                    $product_sku_label = apply_filters('p_usp_product_sku_label', __('Product Code:', 'upsell-smart-popup'));
                    ?>
                    <div class="product__info_line">
                        <span class="product__info_label"><?php echo esc_html($product_sku_label); ?></span>
                        <span class="product__info_value sku"><?php echo esc_html($product_sku); ?></span>
                    </div>
                <?php } ?>
                <?php if (p_usp()->db()::get_upsell_product_availability_enabled()) {
                    $product_availability_label = apply_filters('p_usp_product_availability_label', __('Availability:', 'upsell-smart-popup'))
                    ?>
                    <div class="product__info_line">
                        <span class="product__info_label"><?php echo esc_html($product_availability_label); ?></span>
                        <span class="product__info_value availability"><?php echo wp_kses_post($product_availability); ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="product__actions">
                <?php echo wp_kses_post($product_addtocart_button); ?>
            </div>
            <div class="product__decription">
                <p><?php echo wp_kses_post($product_description); ?></p>
            </div>
        </div>
    </div>
</div>