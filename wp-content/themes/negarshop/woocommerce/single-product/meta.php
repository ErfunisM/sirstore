<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */
if (!defined('ABSPATH')) {
    exit;
}
global $product, $post;
if (negarshop_option('product_category_tools') !== 'true') {
    return;
}
?>
<div class="product_meta mb-5">

    <?php do_action('woocommerce_product_meta_start'); ?>


    <?php echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in"><i class="fal fa-archive"></i> ' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ', '</span>'); ?>
    <?php get_template_part('/woocommerce/single-product/custom', 'rating');


    if (negarshop_option('product_sales_ac')) {
        $count = get_post_meta(get_the_ID(), 'total_sales', true);

        if ($count > 0) {
            ?>
            <span class="product-sales">
                    <i class="fal fa-chart-bar"></i>
                    <span class="count">
                        <?php echo $count > 5000 ? '+5000' : $count; ?>

                        <?php _e("فروش موفق", 'negarshop'); ?>
                    </span>
                </span>
        <?php }
    }
    ?>


    <?php do_action('woocommerce_product_meta_end'); ?>
</div>
