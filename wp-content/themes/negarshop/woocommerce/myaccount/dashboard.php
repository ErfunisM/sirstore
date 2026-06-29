<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     4.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$allowed_html = [
    'a' => [
        'href' => [],
    ],
];
?>

    <p>
        <?php
        /* translators: 1: Orders URL 2: Address URL 3: Account URL. */
        $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
        if (wc_shipping_enabled()) {
            /* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
            $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
        }
        printf(wp_kses($dashboard_desc, $allowed_html), esc_url(wc_get_endpoint_url('orders')), esc_url(wc_get_endpoint_url('edit-address')), esc_url(wc_get_endpoint_url('edit-account')));
        ?>
    </p>
    <div class="ns-profile-content">
        <table class="table">
            <tr>
                <td class="w-50">
                    <div class="title"><i class="far fa-user"></i> <?php _e('نام و نام خانوادگی:', 'negarshop'); ?>
                    </div>
                    <div class="value"><?php echo (!empty($current_user->user_firstname . $current_user->user_lastname)) ? $current_user->user_firstname . ' ' . $current_user->user_lastname : __('لطفا نام خود را وارد نمایید.', 'negarshop'); ?></div>
                </td>
                <td>
                    <div class="title"><i class="far fa-envelope"></i> <?php _e('پست الکترونیک :', 'negarshop'); ?>
                    </div>
                    <div class="value"><?php echo (!empty($current_user->user_email)) ? $current_user->user_email : __('لطفا ایمیل خود را وارد نمایید.', 'negarshop'); ?></div>
                </td>
            </tr>
            <tr>
                <?php
                $userPhone = Negarshop_Smart_Auth::get_user_mobile($current_user->ID);
                ?>
                <td>
                    <div class="title"><i class="far fa-phone"></i> <?php _e('شماره تلفن همراه:', 'negarshop'); ?></div>
                    <div class="value">
                        <?php
                        echo empty($userPhone) ? 'لطفا تنظیم نمایید.' : $userPhone;
                        ?>
                    </div>
                </td>
                <td>
                    <div class="title"><i class="far fa-calendar"></i> <?php _e('تاریخ عضویت:', 'negarshop'); ?></div>
                    <div class="value"><?php echo date_i18n("Y/m/d", strtotime($current_user->user_registered)); ?></div>
                </td>
            </tr>
        </table>
        <a class="btn" href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>"><i
                    class="fal fa-user-edit"></i> <?php _e('ویرایش اطلاعات', 'negarshop'); ?></a>
    </div>
<?php

if (negarshop_option('delivery_active') === 'true') {
    wc_get_template_part('myaccount/latest', 'orders');
}

/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
