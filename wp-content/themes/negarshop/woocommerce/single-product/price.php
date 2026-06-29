<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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
 * @version 3.0.0
 */

if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

global $product;
/**
 * @var \WC_Product $product
 */
$price_txt = __("قیمت: ", 'negarshop');
if ( negarshop_option('product_varation_price') === "false" and $product->get_type() == "variable" ) {
	return;
}
if ( !empty($product->get_price_html()) && $product->get_stock_status() !== 'outofstock' ) {
	?>
    <p class="price"><span class="price-text"><?php echo $price_txt; ?></span><?php echo $product->get_price_html(); ?>
    </p>
<?php } else {
	echo '<p class="coming-soon">' . negarshop_option('noprice_text') . '</p>';
} ?>