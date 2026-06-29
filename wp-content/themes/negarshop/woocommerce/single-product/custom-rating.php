<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

global $product;

if ( 'no' === get_option('woocommerce_enable_review_rating') ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
if ( (int) $average === 0 ) {
	$average      = negarshop_option('product_def_rate', 'posts');
	$rating_count = 1;
}

?>

<span class="woocommerce-product-rating" data-toggle="tooltip" data-placement="bottom"
      data-original-title="<?php _e('امتیاز محصول', 'negarshop') ?>">
        <?php if ( negarshop_option('product_rate') === 'number' ) { ?>
            <i class="fal fa-star"></i>

            <span class="rate"><?php echo $average; ?> <?php _e('از','negarshop'); ?> 5
        </span>
        <?php } else {
	        echo negarshop_get_rating_html($average, $rating_count);
        } ?>

    </span>
