<?php
/**
 * Header basket widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_header_basket($opts = array()) {
    if (!function_exists('WC')) {
        return;
    }
    $itemsAlign = (isset($opts['cart_items_align'])) ? $opts['cart_items_align'] : "right";
    $cartMode = (isset($opts['cart_mode'])) ? $opts['cart_mode'] : "hover";
    $cartAuto = (isset($opts['cart_auto_show'])) && $opts['cart_auto_show'] === 'yes';
    $cartTitle = $opts['cart_title'] ?? __('سبد خرید', 'negarshop');
    ?>
    <div class="header-cart-basket cart-mode-<?php
    echo esc_attr($cartMode);
    if ($cartMode === 'popup' && $cartAuto) {
        echo ' cart-auto-show';
    }
    ?>">
        <?php
        if ($cartMode === 'popup') {
            echo '<div class="ns-closer"></div>';
        }
        ?>
        <?php if (WC()->cart !== null): ?>
            <a href="<?php echo wc_get_cart_url(); ?>"
               class="cart-basket-box">
                <span class="icon"><i
                            class="<?php echo isset($opts['cart_icon']['value']) ? esc_attr(negarshop_fontawesome_425($opts['cart_icon']['value'])) : 'far fa-shopping-cart'; ?>"></i></span>
                <span class="title-outer">
                    <span class="title"><?php echo esc_html($cartTitle); ?></span>
                    <span class="subtitle"><?php echo WC()->cart->get_cart_total(); ?></span>
                </span>
                <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
            <div class="widget woocommerce widget_shopping_cart cart-items-align-<?php echo esc_attr($itemsAlign); ?>">
                <div class="cart-items-header">
                    <h5 class="header-title"><?php _e('سبد خرید', 'negarshop'); ?></h5>
                    <button class="btn btn-transparent header-close"><i class="far fa-times"></i></button>
                </div>
                <div class="widget_shopping_cart_content"></div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}