<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}?>
    <div class="title-bg">
		<?php
		the_title( '<h1 class="product_title entry-title">', '</h1>' );
		echo '<div class="nowrap-line">';
		negarshop_print_ribbons(get_the_id(), true);
		if(negarshop_option('product_title_field', 'posts',get_the_id()) != ""){
			echo '<h3 class="product_sub_title entry-sub-title">' . negarshop_option('product_title_field', 'posts',get_the_id()) . '</h3>';
		}
		echo '</div>';
		?>
    </div>
<?php do_action('woocommerce_single_product_custom_title'); ?>