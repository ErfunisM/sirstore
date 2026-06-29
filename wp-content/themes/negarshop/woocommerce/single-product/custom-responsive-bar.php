<?php
/**
 * Negarshop Custom product single responsive bar
 *
 * @package negarshop
 */
global $product;

if (negarshop_option('product_responsive_add_to_cart') !== 'true') {
    return;
}

$prd_single = negarshop_option('product_single_type');
?>
<div class="product-single-responsive-bar product-single-responsive-bar--<?php echo esc_attr(negarshop_option('bottom_smart_bar_style')); ?>">
    <div class="product-price">

        <?php
        if (!empty($product->get_price_html()) && $product->get_stock_status() !== 'outofstock') {
            ?>
            <div class="price-title"><?php _e('قیمت محصول:', 'negarshop'); ?></div>
            <div class="price-inner">
                <?= $product->get_price_html() ?>
            </div>
        <?php } else {
            echo '<div class="price-inner"><span class="woocommerce-Price-amount">' . negarshop_option('noprice_text') . '</span></div>';
        }
        ?>
    </div>
    <?php if (!empty($product->get_price_html()) && $product->get_stock_status() !== 'outofstock') { ?>
        <button class="btn btn-primary show-addtocart">
            <?= __('خرید محصول', 'negarshop') ?>
        </button>
    <?php } ?>
    <?php if ($prd_single !== 'type-3') { ?>
        <button class="btn show-actions" aria-label="<?= __('نمایش عملیات', 'negarshop') ?>">
            <i class="far fa-ellipsis-v"></i></button>
    <?php } ?>
</div>
