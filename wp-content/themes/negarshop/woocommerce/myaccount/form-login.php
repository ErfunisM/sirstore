<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!is_user_logged_in() && negarshop_option('sms_smart_login') === 'true') {
    global $smart_login_page;
    $smart_login_page = true;
    echo '<div class="smart-login-page full-width">';
    echo '<style>';
    echo 'body.woocommerce-account:not(.logged-in) {overflow: hidden;}';
    echo '</style>';
    negarshop_smart_login_content();
    echo '</div>';
    return;
}

$active_tab = "login";
if (isset($_GET['register']) || isset($_POST['register'])) {
    $active_tab = "register";
}
$logo = negarshop_option('header-type-picker');
$header_footer = negarshop_option('login_header');
if ($header_footer == "false") {
    ?>
    <style>
        .woocommerce-account:not(.logged-in) #responsive-header, .woocommerce-account:not(.logged-in) header.site-header, .woocommerce-account:not(.logged-in) footer.site-footer {
            display: none !important;
        }


        .woocommerce-account:not(.logged-in) article.post-item .site-logo {
            text-align: center;
            margin-top: -98px;
            margin-bottom: 20px
        }

        .woocommerce-account:not(.logged-in) article.post-item .site-logo img {
            height: 58px;
            width: auto;
        }

        .woocommerce-account:not(.logged-in) .blog-home {
            margin-top: 100px;
        }
    </style>
<?php } ?>
<div class="negarshop-userlogin" id="customer_login">
    <?php if ($header_footer == "false" && isset($logo['elementor']['header_logo']['url'])) { ?>
        <div class="site-logo">
            <a href="<?php echo site_url(); ?>">
                <img src="<?php echo $logo['elementor']['header_logo']['url']; ?>" alt="<?php bloginfo('name'); ?>">
            </a>
        </div>
    <?php } ?>
    <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
        <ul class="nav nav-pills mb-3" id="myaccount-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link<?php echo $active_tab == "login" ? " active" : "" ?>" id="login-tab"
                   data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">
                    <i class="fas fa-sign-in"></i>
                    <span>
                        <span class="title"><?php _e('ورود', 'negarshop'); ?></span>
                        <span class="sub-title"><?php _e('به', 'negarshop'); ?>
                            &nbsp;
                            <?php bloginfo('name'); ?></span>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $active_tab == "register" ? " active" : "" ?>" id="register-tab"
                   data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register"
                   aria-selected="false">
                    <i class="fas fa-user-plus"></i>
                    <span>
                        <span class="title"><?php _e('ثبت نام', 'negarshop'); ?></span>
                        <span class="sub-title"><?php _e('در', 'negarshop'); ?>
&nbsp;
                            <?php bloginfo('name'); ?></span>
                    </span>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myaccount-tabContent">
            <div class="negarshop-card">
                <?php do_action('woocommerce_before_customer_login_form'); ?>
            </div>
            <div class="tab-pane fade<?php echo $active_tab == "login" ? " show active" : "" ?>" id="pills-login"
                 role="tabpanel" aria-labelledby="login-tab">
                <div class="negarshop-login-tab">
                    <div class="negarshop-card">
                        <h2><?php _e('ورود به حساب کاربری', 'negarshop'); ?></h2>
                        <form class="woocommerce-form woocommerce-form-login login" method="post">

                            <?php do_action('woocommerce_login_form_start'); ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?></label>
                                <input type="text"
                                       class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                       name="username" id="username" autocomplete="username"
                                       value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-1">
                                <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?></label>
                                <input class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                       type="password" name="password" id="password" autocomplete="current-password"/>
                            </p>
                            <p class="woocommerce-LostPassword lost_password">
                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                            </p>

                            <?php do_action('woocommerce_login_form'); ?>
                            <p class="ns-checkbox">
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                       name="rememberme" type="checkbox" id="rememberme" value="forever"/>
                                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox"
                                       for="rememberme"><?php esc_html_e('Remember me', 'woocommerce'); ?></label>
                            </p>

                            <p class="form-row">
                                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                                <button type="submit" class="woocommerce-Button button btn btn-primary w-100 btn-lg"
                                        name="login"><?php _e('ورود به', 'negarshop'); ?>
                                    &nbsp;<?php bloginfo('name'); ?></button>
                            </p>

                            <?php do_action('woocommerce_login_form_end'); ?>

                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade<?php echo $active_tab == "register" ? " show active" : "" ?>" id="pills-register"
                 role="tabpanel" aria-labelledby="pills-register">
                <div class="negarshop-register-tab">
                    <div class="negarshop-card">
                        <h2><?php esc_html_e('ثبت نام در', 'negarshop'); ?><?php bloginfo('name'); ?></h2>
                        <form method="post" class="woocommerce-form woocommerce-form-register register">

                            <?php do_action('woocommerce_register_form_start'); ?>

                            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?></label>
                                    <input type="text"
                                           class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                           name="username" id="reg_username" autocomplete="username"
                                           value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                                </p>

                            <?php endif; ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?></label>
                                <input type="email"
                                       class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                       name="email" id="reg_email" autocomplete="email"
                                       value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                            </p>

                            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?></label>
                                    <input type="password"
                                           class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                           name="password" id="reg_password" autocomplete="new-password"/>
                                </p>

                            <?php endif; ?>

                            <?php do_action('woocommerce_register_form'); ?>

                            <p class="woocommerce-FormRow form-row">
                                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                                <button type="submit" class="woocommerce-Button button btn btn-primary w-100 btn-lg"
                                        name="register"
                                        value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php _e('ثبت نام در', 'negarshop'); ?>
                                    &nbsp;<?php bloginfo('name'); ?></button>
                            </p>

                            <?php do_action('woocommerce_register_form_end'); ?>

                        </form>
                    </div>
                </div>
            </div>
            <div class="negarshop-card">
                <?php do_action('woocommerce_after_customer_login_form'); ?>
            </div>
            <a href="<?php echo site_url(); ?>" onclick="history.back()" class="login-back-btn"><i
                        class="fas fa-angle-right"></i> <?php _e('بازگشت به صفحه قبل', 'negarshop'); ?></a>
        </div>
    <?php endif; ?>
</div>