<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
?>
<div class="cart-empty">
<div class="cart-empty-icon">
    <i class="fal fa-shopping-cart"></i>
</div>
<?php
do_action( 'woocommerce_cart_is_empty' );
if(!is_user_logged_in()) {
    ?>
    <a href="<?php echo esc_url(wc_get_page_permalink( 'myaccount' )); ?>" class="account-btn btn btn-primary">
        <i class="fal fa-sign-in"></i>
        <span><?php _e("به حساب کاربری خود وارد شوید",'negarshop'); ?></span>
    </a>
    <?php
}



if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
        <a class="button wc-backward btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            <?php
            /**
             * Filter "Return To Shop" text.
             *
             * @since 4.6.0
             * @param string $default_text Default text.
             */
            echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );
            ?>
        </a>
	</p>
<?php endif; ?>

</div>