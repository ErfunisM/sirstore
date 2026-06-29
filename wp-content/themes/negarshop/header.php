<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <?php
    wp_head();
    $body_classes = [];
    if (negarshop_option('wide_style', "settings", 0, true) === 'true') {
        $body_classes[] = "wide-style";
    }
    if (negarshop_option('imgs_res_bg') === 'false') {
        $body_classes[] = "res-banner-bg-trans";
    }
    if (negarshop_option('login_popup') === "true") {
        $body_classes[] = "pop-up-login";
    }
    if (negarshop_option('bottom_smart_bar') === "true") {
        $body_classes[] = "bottom-bar-showing";
    }
    if (is_singular('product') && negarshop_option('product_responsive_popup') === "false") {
        $body_classes[] = 'show-inline-description';
    }
    $body_classes[] =  'site-bottom-bar--' .negarshop_option('bottom_smart_bar_style');
    ?>
</head>
<body <?php body_class($body_classes); ?>>
<?php wp_body_open(); ?>
<div class="wrapper">
    <?php
    if (negarshop_option('loader_ac') === 'true') {
        $loaderImage = negarshop_option('loader_type_picker');
        ?>
        <div class="ns-page-loader">
            <div class="loader-content">
                <?php if (!empty($loaderImage['true']['image']['url'])) { ?>
                    <span class="logo">
                    <img src="<?= $loaderImage['true']['image']['url'] ?>" alt="<?= __('loading', 'negarshop') ?>">
                </span>
                <?php } ?>
                <div class="loader-item">
                    <?php
                    if ($loaderImage['true']['spinner'] === 'true') {
                        echo '<span class="spinner"></span>';
                    }
                    if (!empty($loaderImage['true']['text'])) {
                        echo '<span class="loader-text">' . $loaderImage['true']['text'] . '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


    <header class="site-header d-none d-xl-block d-lg-block">
        <?php
        $header_type_opts = negarshop_option('header-type');


        if ($header_type_opts === "def") {
            negarshop_get_part('header/default-content');
        } else {
            if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('header')) {
                negarshop_get_part('header/default-content');
            }
        }
        ?>
    </header>
    <?php if (function_exists('elementor_theme_do_location')) { ?>
        <header class="responsive-header d-block d-xl-none d-lg-none">
            <?php
            elementor_theme_do_location('responsive-header');
            ?>
        </header>
    <?php } ?>
    <?php
    rewind_posts();
    ?>

