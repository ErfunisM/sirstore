<?php

if (negarshop_option('bottom_smart_bar') !== 'true') {
    return;
}

$productCategories = get_terms('product_cat', ['parent' => 0]);

?>
<div class="site-bottom-bar site-bottom-bar--<?php echo esc_attr(negarshop_option('bottom_smart_bar_style')); ?>">
    <div id="responsive-contents">
        <?php if (negarshop_option('bottom_search') === 'true') { ?>
            <div id="responsive-search-page">
                <h4 class="section-title"><?= __('جستجو در سایت', 'negarshop') ?></h4>
                <?php
                negarshop_header_search([
                    'search_ajax' => negarshop_option('bottom_bar_search_ajax'),
                    'search_filters' => negarshop_option('bottom_bar_search_filters'),
                    'style' => 'style-bar',
                    'search_post_type' => negarshop_option('bottom_bar_search_type'),
                    'search_button_icon' => [
                        'value' => 'fas fa-search'
                    ]
                ]);
                ?>
            </div>
        <?php } ?>
        <?php if (negarshop_option('bottom_cats') === 'true' && !empty($productCategories)) { ?>
            <div id="responsive-categories-page">
                <h4 class="section-title"><?= __('دسته بندی ها', 'negarshop') ?></h4>
                <?php
                negarshop_print_terms($productCategories);
                ?>
            </div>
        <?php } ?>
        <?php if (negarshop_option('bottom_cart') === 'true') { ?>
            <div id="responsive-cart-page">
                <h4 class="section-title"><?= __('سبد خرید', 'negarshop') ?></h4>

                <?php
                negarshop_header_basket([
                    'style' => 'responsive-cart'
                ]);
                ?>
            </div>
        <?php } ?>
    </div>

    <div class="responsive-loader">
        <i class="spinner"></i>
        <div class="loader-text"><?= __('درحال بارگذاری ...', 'negarshop') ?></div>
    </div>

    <nav id="responsive-footer-bar">
        <ul>
            <li class="back-item">
                <a href="<?= site_url('/') ?>">
                    <i class="far fa-arrow-right"></i>
                </a>
            </li>
            <?php if (negarshop_option('bottom_home') === 'true') { ?>
                <li class="not-ajax <?php echo is_home() || is_front_page() ? 'active-item current-page' : ''; ?>">
                    <a href="<?= site_url('/') ?>">
                        <i class="far fa-arrow-right back-icon"></i>
                        <i class="far fa-home"></i>
                        <span class="menu-title"><?= __('خانه', 'negarshop') ?></span>
                    </a>
                </li>
            <?php } ?>
            <?php if (negarshop_option('bottom_search') === 'true') { ?>
                <li>
                    <a href="#responsive-search-page"><i class="far fa-search"></i><span
                                class="menu-title"><?= __('جستجو', 'negarshop') ?></span></a>
                </li>
            <?php } ?>
            <?php if (negarshop_option('bottom_cats') === 'true' && !empty($productCategories)) { ?>
                <li>
                    <a href="#responsive-categories-page"><i class="far fa-list-ul"></i><span
                                class="menu-title"><?= __('دسته بندی ها', 'negarshop') ?></span></a>
                </li>
            <?php } ?>
            <?php if (negarshop_option('bottom_cart') === 'true') { ?>
                <li>
                    <a href="#responsive-cart-page"><i class="far fa-shopping-cart"></i><span
                                class="menu-title"><?= __('سبد خرید', 'negarshop') ?></span></a>
                </li>
            <?php } ?>
            <?php if (negarshop_option('bottom_account') === 'true' && function_exists('wc_get_account_endpoint_url')) { ?>
                <li class="not-ajax <?php echo in_array('woocommerce-account', get_body_class()) ? 'active-item current-page' : ''; ?>">
                    <a href="<?php echo wc_get_account_endpoint_url(''); ?>">
                        <i class="far fa-arrow-left back-icon"></i>
                        <i class="far fa-user"></i>
                        <span class="menu-title"><?= __('حساب کاربری', 'negarshop') ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>