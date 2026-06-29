<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

if (!$short_description) {
    return;
}

?>
<div class="product-section product-excerpt">
    <div class="woocommerce-product-details__short-description <?php echo negarshop_option('product_short_description_trigger') === 'true' ? 'has-trigger' : ''; ?>">
        <?php
        if (negarshop_option('product_single_type') === 'type-3') {
            ?>
            <div class="product-excerpt-header">
                <i class="far fa-pen-square"></i>
                <div>
                    <h6 class="sec-title"><?php _e("معرفی کوتاه محصول", 'negarshop'); ?></h6>
                    <p class="product-title"><?php the_title(); ?></p>
                </div>
            </div>
        <?php } else { ?>
            <h6 class="sec-title"><?php _e("معرفی کوتاه", 'negarshop'); ?></h6>
            <p class="product-title"><?php the_title(); ?></p>
        <?php } ?>
        <div class="product-excerpt-content">
            <?php echo $short_description; // WPCS: XSS ok. ?>
        </div>
    </div>
</div>
