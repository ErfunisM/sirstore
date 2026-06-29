<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}
do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));

    return;
}
$deliveryDates = negarshop_get_cart_delivery_times(WC()->cart->get_cart());

// Adding the smart login form to the checkout page.
if (negarshop_option('sms_smart_login') === 'true' && is_user_logged_in()) {
    $user = wp_get_current_user();
    if (!Negarshop_Smart_Auth::is_active($user->ID)) {
        echo '<p>برای ادامه روند خرید لطفا شماره موبایل خود را تایید کنید.</p>';
        negarshop_myaccount_mobile_verify_form();
        return;
    }
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <?php if ($checkout->get_checkout_fields()) : ?>
        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="col2-set row" id="customer_details">
            <div class="col-lg<?php echo negarshop_option('checkout_design') === "style-2" ? "-12" : ""; ?>">
                <?php do_action('woocommerce_checkout_billing'); ?>
            </div>

            <div class="col-lg<?php echo negarshop_option('checkout_design') === "style-2" ? "-12 mt-5" : ""; ?>">
                <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    <?php endif; ?>

    <?php if (!empty($deliveryDates) && negarshop_option('delivery_active') === 'true'): ?>
        <h3 class="checkout-leader" id="order_delivery_heading">
            <span><?php esc_html_e('زمان تحویل', 'negarshop'); ?></span>
        </h3>

        <ul class="order-delivery-times">
            <?php foreach ($deliveryDates as $key => $item) { ?>
                <li class="ns-checkbox">
                    <input type="radio" name="delivery_time" id="delivery_time_<?= $key ?>"
                           value="<?= $key ?>" <?= $key === 0 ? 'checked' : '' ?>>
                    <label for="delivery_time_<?= $key ?>">
                        <span class="delivery-title"><?= __($item['dayName']) ?></span>
                        <span class="delivery-time"><?= ns_jdate('d F Y', $item['date']) ?></span>
                    </label>
                </li>
            <?php } ?>
        </ul>
    <?php endif; ?>


    <h3 class="checkout-leader" id="order_review_heading">
        <span><?php esc_html_e('Your order', 'woocommerce'); ?></span>
    </h3>

    <?php do_action('woocommerce_checkout_before_order_review'); ?>

    <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action('woocommerce_checkout_order_review'); ?>
    </div>

    <?php do_action('woocommerce_checkout_after_order_review'); ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
