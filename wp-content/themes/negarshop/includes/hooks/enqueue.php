<?php
/**
 * WordPress enqueue styles and scripts hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_scripts()
{
    $currentThemeVersion = wp_get_theme()->get('Version') . '-d1';
    wp_enqueue_style('negarshop-fontawesome', get_theme_file_uri('/statics/fonts/fontawesome/fa-all.min.css'), [], $currentThemeVersion);

    $font_family = negarshop_option('site_font');

    if ($font_family == 'Vazir') {
        wp_enqueue_style('negarshop-vazir', get_theme_file_uri('/statics/fonts/vazir/vazir.css'), [], $currentThemeVersion);
    } else if ($font_family == 'shabnam') {
        wp_enqueue_style('negarshop-vazir', get_theme_file_uri('/statics/fonts/shabnam/shabnam.css'), [], $currentThemeVersion);
    } else if ($font_family == 'parastoo') {
        wp_enqueue_style('negarshop-vazir', get_theme_file_uri('/statics/fonts/parastoo/parastoo.css'), [], $currentThemeVersion);
    } else if ($font_family == 'IRANYekan, IRANSans_Fa') {
        wp_enqueue_style('negarshop-iranyekan', get_theme_file_uri('/statics/fonts/iranyekan/style.css'), [], $currentThemeVersion);
        wp_enqueue_style('negarshop-iransans', get_theme_file_uri('/statics/fonts/iransans/iransans.css'), [], $currentThemeVersion);
    } else if ($font_family == 'IRANSans_Fa') {
        wp_enqueue_style('negarshop-iransans', get_theme_file_uri('/statics/fonts/iransans/iransans.css'), [], $currentThemeVersion);
    } else if ($font_family == 'IRANSans') {
        wp_enqueue_style('negarshop-iransans-en', get_theme_file_uri('/statics/fonts/iransans/iransans-en.css'), [], $currentThemeVersion);
    } else if (mb_stripos($font_family, 'Dima') !== false) {
        wp_enqueue_style('negarshop-dimafonts', get_theme_file_uri('/statics/fonts/dima/' . $font_family . '.css'), [], $currentThemeVersion);
    } else if ($font_family === "custom") {
        add_action('wp_head', function () {
            echo '<style>';
            $opt = negarshop_option('site_font_picker');
            echo negarshop_get_font_face_from_data('custom', $opt['custom']);
            echo '</style>';
        });
    }


    if (function_exists('is_checkout') && is_checkout()) {
        wp_enqueue_style('negarshop-leaflet', get_theme_file_uri('/statics/css/leaflet.css'), [], $currentThemeVersion);
        wp_enqueue_script('negarshop-leaflet', get_theme_file_uri('/statics/js/leaflet.js'), null, $currentThemeVersion);
    }

    wp_enqueue_style('negarshop-bootstrap', get_theme_file_uri('/statics/css/bootstrap.min.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-nouislider', get_theme_file_uri('/statics/css/nouislider.min.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-owl', get_theme_file_uri('/statics/css/owl.carousel.min.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-owltheme', get_theme_file_uri('/statics/css/owl.theme.default.min.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-lightbox', get_theme_file_uri('/statics/css/lightgallery.min.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-select2', get_theme_file_uri('/statics/css/select2.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-compare', get_theme_file_uri('/statics/css/compare-rtl.css'), [], $currentThemeVersion);
    wp_enqueue_style('negarshop-magnify', get_theme_file_uri('/statics/css/magnify.css'), [], $currentThemeVersion);
    if (is_rtl()) {
        wp_enqueue_style('negarshop-style', get_theme_file_uri('/statics/css/core.css'), [], $currentThemeVersion);
    } else {
        wp_enqueue_style('negarshop-style', get_theme_file_uri('/statics/css/core-ltr.css'), [], $currentThemeVersion);
        wp_enqueue_style('negarshop-style-ltr-customizes', get_theme_file_uri('/statics/css/core-ltr_customizes.css'), [], $currentThemeVersion);
    }
    wp_enqueue_style('negarshop-main', get_stylesheet_uri());

    wp_enqueue_script('negarshop-popper', get_theme_file_uri('/statics/js/popper.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-bootstrap', get_theme_file_uri('/statics/js/bootstrap.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-bootstrap-notify', get_theme_file_uri('/statics/js/bootstrap-notify.min.js'), [
        'negarshop-bootstrap'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-jquery-sticky', get_theme_file_uri('/statics/js/jquery.sticky-sidebar.min.js'), [], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-ResizeSensor', get_theme_file_uri('/statics/js/ResizeSensor.js'), [], $currentThemeVersion, true);

    wp_enqueue_script('negarshop-nouislider', get_theme_file_uri('/statics/js/nouislider.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-confetti', get_theme_file_uri('/statics/js/jquery.confetti.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-owl', get_theme_file_uri('/statics/js/owl.carousel.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-lightbox', get_theme_file_uri('/statics/js/lightgallery.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-print', get_theme_file_uri('/statics/js/printThis.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-accounting', get_theme_file_uri('/statics/js/accounting.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('negarshop-select2', get_theme_file_uri('/statics/js/select2.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    if (is_singular('product')) {
        wp_enqueue_script('negarshop-highchart', get_theme_file_uri('/statics/js/highcharts.js'), [
            'jquery'
        ], $currentThemeVersion, true);
        wp_enqueue_script('negarshop-highchart-exporting', get_theme_file_uri('/statics/js/highcharts-exporting.js'), [
            'negarshop-highchart'
        ], $currentThemeVersion, true);
    }
    wp_enqueue_script('negarshop-ajax-tab-carousel', get_theme_file_uri('/statics/js/tab-carousel.js'), [
        'jquery',
        'negarshop-owl'
    ], $currentThemeVersion, true);
    wp_localize_script('negarshop-ajax-tab-carousel', 'negarshop_obj', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    if (negarshop_option('comment_upload_files') === 'true' && is_singular('product')) {
        wp_enqueue_style('negarshop-dropzone', get_theme_file_uri('/statics/css/dropzone.min.css'), [], $currentThemeVersion);
        wp_enqueue_script('negarshop-dropzone', get_theme_file_uri('/statics/js/dropzone.min.js'), [], $currentThemeVersion, true);
        wp_localize_script('negarshop-dropzone', 'NSDP', [
            'nonce' => wp_create_nonce('dropzone-nonce')
        ]);
    }

    wp_enqueue_script('negarshop-var-product', get_theme_file_uri('/statics/js/variable_product_data.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_localize_script('negarshop-var-product', 'negarshop_obj', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    wp_enqueue_script('negarshop-script', get_theme_file_uri('/statics/js/script.js'), [
        'jquery'
    ], $currentThemeVersion, true);

    $checkout_location = negarshop_option('checkout_location-multi-picker');
    wp_localize_script('negarshop-script', 'negarshop_obj', [
        'OFFLINE_URL' => site_url('/offline.html'),
        'service_worker' => site_url('/service-worker.js'),
        'ajax_url' => admin_url('admin-ajax.php'),
        'my_account' => function_exists('WC') ? wc_get_page_permalink('myaccount') : "",
        'checkout_location' => empty($checkout_location) ? '' : array_values($checkout_location['true'])

    ]);

    if (negarshop_option('negarshop_compare') === 'true') {
        wp_enqueue_script('negarshop-compare', get_theme_file_uri('/statics/js/negarshop-compare.js'), [
            'jquery'
        ], $currentThemeVersion, true);

        wp_localize_script('negarshop-compare', 'negarshop_compare_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    wp_enqueue_script('negarshop-cb-change-price', get_theme_file_uri('/statics/js/price-changes.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_localize_script('negarshop-cb-change-price', 'negarshop_obj', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    wp_dequeue_style('dokan-fontawesome');

    wp_enqueue_script('negarshop-three-int', get_theme_file_uri('/statics/js/product-3d.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_localize_script('negarshop-three-int', 'negarshop_obj', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'assets_url' => get_theme_file_uri('/statics/js/'),
        'my_account' => function_exists('WC') ? wc_get_page_permalink('myaccount') : ""
    ]);
    wp_enqueue_script('negarshop-magnify', get_theme_file_uri('/statics/js/jquery.magnify.js'), null, $currentThemeVersion, true);
    wp_enqueue_script('negarshop-magnify-mobile', get_theme_file_uri('/statics/js/jquery.magnify-mobile.js'), null, $currentThemeVersion, true);

    wp_enqueue_script('negarshop-countdown-js', get_theme_file_uri('/statics/js/jquery.countdown.min.js'), [
        'jquery'
    ], $currentThemeVersion, true);
    wp_enqueue_script('script-ns_elementor_fixes', get_theme_file_uri('/statics/js/elementor_fixes.js'), null, $currentThemeVersion);

    wp_enqueue_script('yith_wccl_frontend_cb', get_theme_file_uri('/statics/js/yith-color-atts.js'), [
        'jquery',
        'wc-add-to-cart-variation'
    ], $currentThemeVersion, true);
    wp_enqueue_script('wc-cart-fragments');

}

function negarshop_wp_admin_style()
{
    wp_register_style('negarshop_wp_admin_css', get_theme_file_uri('/statics/css/admin_panel.css'), false, '1.0.0');
    wp_enqueue_style('negarshop_wp_admin_css');
    wp_register_style('negarshop_datepicker_css', get_theme_file_uri('/statics/css/persian-datepicker.min.css'), false, '1.0.0');
    wp_enqueue_style('negarshop_datepicker_css');

    wp_enqueue_script('negarshop-wp_admin_js', get_theme_file_uri('/statics/js/admin_panel.js'), [
        'jquery'
    ], null, true);
    wp_localize_script('negarshop-wp_admin_js', 'negarshop_obj', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    wp_deregister_script('firebase-auth');
    wp_dequeue_script('firebase-auth');

    wp_deregister_script('firebase');
    wp_dequeue_script('firebase');

    $screen = get_current_screen();
    if ($screen->post_type === "page" && $screen->base === "post") {
        wp_dequeue_script('wc-handpicked-products');
        wp_dequeue_script('wc-product-best-sellers');
        wp_dequeue_script('wc-product-category');
        wp_dequeue_script('wc-product-new');
        wp_dequeue_script('wc-product-on-sale');
        wp_dequeue_script('wc-product-top-rated');
        wp_dequeue_script('wc-products-attribute');
        wp_dequeue_script('wc-featured-product');

        wp_deregister_script('wc-handpicked-products');
        wp_deregister_script('wc-product-best-sellers');
        wp_deregister_script('wc-product-category');
        wp_deregister_script('wc-product-new');
        wp_deregister_script('wc-product-on-sale');
        wp_deregister_script('wc-product-top-rated');
        wp_deregister_script('wc-products-attribute');
        wp_deregister_script('wc-featured-product');
    }
    if ($screen->id === "appearance_page_fw-settings") {
        wp_dequeue_style('jquery-ui-style');
        wp_deregister_style('jquery-ui-style');
        wp_enqueue_style('negarshop-iranyekan', get_theme_file_uri('/statics/fonts/iranyekan/style.css'), [], '1.0.0');
        wp_register_style('negarshop_theme_options_css', get_theme_file_uri('/statics/css/theme-option.css'), false, '1.0.0');
        wp_enqueue_style('negarshop_theme_options_css');
    }
}

function negarshop_dequeue()
{
    wp_dequeue_style('wooscp-frontend');
    wp_deregister_style('wooscp-frontend');
    wp_deregister_script('yith-wcwtl-frontend');
    wp_dequeue_script('yith-wcwtl-frontend');
    wp_deregister_script('ywsl_frontend');
    wp_dequeue_script('ywsl_frontend');
    wp_deregister_script('fw-shortcode-section');
    wp_dequeue_script('fw-shortcode-section');
    wp_deregister_script('woo-tracks');
    wp_dequeue_script('woo-tracks');
    wp_deregister_script('yith_wccl_frontend');
    wp_dequeue_script('yith_wccl_frontend');
    wp_dequeue_style('ywsl_frontend');
    wp_deregister_style('ywsl_frontend');
    wp_dequeue_style('dokan-fontawesome');
    wp_deregister_style('dokan-fontawesome');
    wp_dequeue_style('dokan-follow-store');
    wp_deregister_style('dokan-follow-store');
    wp_dequeue_style('yith-wcwtl-frontend');
    wp_deregister_style('yith-wcwtl-frontend');
    wp_dequeue_style('google-fonts-1');
    wp_deregister_style('google-fonts-1');
    wp_dequeue_style('elementor-icons-fa-regular');
    wp_deregister_style('elementor-icons-fa-regular');
    wp_dequeue_style('elementor-icons-shared-0');
    wp_deregister_style('elementor-icons-shared-0');
}

function negarshop_footer_scripts()
{
    $langTexts = [
        'searchArchive' => __("نتیجه مورد نظر را پیدا نکردید؟", 'negarshop'),
        'searchAllBtn' => __("مشاهده همه", 'negarshop'),
        'searchNotFound' => __("چیزی پیدا نشد!", 'negarshop'),
        'errorSend' => __("مشکلی هنگام ارسال پیش آمد!", 'negarshop'),
        'bad' => __("بد", 'negarshop'),
        'medium' => __("متوسط", 'negarshop'),
        'good' => __("خوب", 'negarshop'),
        'excelent' => __("عالی", 'negarshop'),
        'verybad' => __("خیلی بد", 'negarshop'),
        'pleaseWait' => __("لطفا صبر کنید ...", 'negarshop'),
    ];
    echo '<script>
        var loadJS = function(url, implementationCode, location){
            //url is URL of external file, implementationCode is the code
            //to be called from the file, location is the location to 
            //insert the <script> element
        
            var scriptTag = document.createElement(\'script\');
            scriptTag.src = url;
        
            scriptTag.onload = implementationCode;
            scriptTag.onreadystatechange = implementationCode;
        
            location.appendChild(scriptTag);
        };
        var loadLazyloadPlugin = function(){
        var myLazyLoad = new LazyLoad({
                elements_selector: ".lazy"
            });
        jQuery(document).bind("ajaxComplete", function($){
           myLazyLoad.update();
         });
        }
        loadJS("' . get_theme_file_uri('/statics/js/lazyload.min.js') . '", loadLazyloadPlugin, document.body); 
        var defaultText = {
          ';
    foreach ($langTexts as $key => $val) {
        echo $key . ':"' . $val . '",';
    }
    echo '
        };
    </script>';
}

function negarshop_header_styles()
{
    echo '<meta name="theme-color" content="' . negarshop_option('main_color') . '"/>';

    if (function_exists('negarshop_custom_styles')) {
        $main_color = negarshop_option('main_color', "settings", 0, true);
        $bg_color = negarshop_option('bg_color', "settings", 0, true);
        $font = negarshop_option('site_font');
        $basket_wg_bg = negarshop_option('basket_color', "settings", 0, true);
        $basket_wg_txt = negarshop_option('basket_txt_color', "settings", 0, true);
        $basket_counter = negarshop_option('basket_badge_color', "settings", 0, true);
        $basket_counter_txt = negarshop_option('basket_badge_txt_color', "settings", 0, true);
        $basket_inner_txt = negarshop_option('basket_inner_txt_color', "settings", 0, true);
        $bg_img = negarshop_option('bg_pattern', "settings", 0, true);
        $bg_img_picker = negarshop_option('bg_image_picker', "settings", 0, true);
        $price_color = negarshop_option('price_color', "settings", 0, true);
        $site_radius = negarshop_option('site_radius', "settings", 0, true);
        $container_size = negarshop_option('container_size');


        $opts = [
            'font' => $font,
            'main' => $main_color,
            'price' => $price_color,
            'bg-color' => $bg_color,
            'basket-wg-bg' => $basket_wg_bg,
            'basket-wg-txt' => $basket_wg_txt,
            'basket-counter-bg' => $basket_counter,
            'basket-counter-txt' => $basket_counter_txt,
            'basket-inner-color' => $basket_inner_txt,
            'radius' => $site_radius,
            'container_size' => $container_size,
        ];
        switch ($bg_img) {
            case "select":
                $opts['bg-image'] = get_template_directory_uri() . '/statics/images/backgrounds/patterns/' . $bg_img_picker['select']['bg_patterns'] . '.png';
                break;
            case "upload":
                $opts['bg-image'] = $bg_img_picker['upload']['bg_image']['url'];
                break;
            default:
                break;
        }

        echo negarshop_custom_styles($opts);
    }
}

function negarshop_default_scripts($scripts)
{
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = Array_Diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
}

function negarshop_hex2rgba($color, $opacity = false): string
{
    $default = 'rgb(0,0,0)';

    if (empty($color)) {
        return $default;
    }

    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    if (strlen($color) == 6) {
        $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
    } elseif (strlen($color) == 3) {
        $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
    } else {
        return $default;
    }

    $rgb = array_map('hexdec', $hex);

    if ($opacity) {
        if (abs($opacity) > 1) {
            $opacity = 1.0;
        }
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    return $output;
}

function negarshop_custom_styles($styles_ar)
{
    $font = $styles_ar['font'];
    $bg_color = $styles_ar['bg-color'];
    $main = $styles_ar['main'];
    $main_compatible = negarshop_option('main_color_compatible');
    $accent_color = negarshop_option('accent_color');
    if (empty($main_compatible)) {
        $main_compatible = '#fff';
    }
    $radius = $styles_ar['radius'];
    $price_color = $styles_ar['price'];
    $container_size = $styles_ar['container_size'];
    $main_rgba_1 = negarshop_hex2rgba($main, 0.1);
    $main_rgba_2 = negarshop_hex2rgba($main, 0.2);

    $basket_wg_bg = $styles_ar['basket-wg-bg'];
    $basket_wg_txt = $styles_ar['basket-wg-txt'];
    $basket_counter = $styles_ar['basket-counter-bg'];
    $basket_counter_txt = $styles_ar['basket-counter-txt'];
    $basket_inner_txt = $styles_ar['basket-inner-color'];
    $basket_inner_txt_rgba = negarshop_hex2rgba($basket_inner_txt, 0.1);

    $pp_opt_tmp = negarshop_option('items_placeholder_picker');

    $heading_1 = negarshop_option('heading_1');
    $heading_2 = negarshop_option('heading_2');
    $heading_3 = negarshop_option('heading_3');
    $heading_4 = negarshop_option('heading_4');
    $heading_5 = negarshop_option('heading_5');
    $heading_6 = negarshop_option('heading_6');


    $product_placeholder = negarshop_option('items_placeholder') === "true" ? 'url(' . $pp_opt_tmp['true']['image']['url'] . ')' : 'none';

    $bg_image_css = isset($styles_ar['bg-image']) ? 'background-image: url(' . $styles_ar['bg-image'] . '); ' : '';
    $styles = "
    <style>
        :root{
            --ns-radius: {$radius}px;
            --ns-primary: $main;
            --ns-accent: $accent_color;
        }
        body{
            background-color: $bg_color;
            $bg_image_css
        }
        .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-4 li::before, .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-4 li::after,
		.woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-4 a::before, .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-4 a::after{
			background-color: $bg_color;
		}
        html, body, .flip-clock-a *, .tooltip, #orders_statistics_chart_container, #orders_statistics_chart_container *{
            font-family: $font, sans-serif;
        }
        .content-widget article.item figure, article.product figure.thumb, .product-card figure{
			background-image: $product_placeholder;
        }
        
		.entry-content .h1,
		.entry-content h1 {
		 font-size:$heading_1
		}
		.entry-content .h2,
		.entry-content h2 {
		 font-size:$heading_2
		}
		.entry-content .h3,
		.entry-content h3 {
		 font-size:$heading_3
		}
		.entry-content .h4,
		.entry-content h4 {
		 font-size:$heading_4
		}
		.entry-content .h5,
		.entry-content h5 {
		 font-size:$heading_5
		}
		.entry-content .h6,
		.entry-content h6 {
		 font-size:$heading_6
		}
        /* ------------------------- Normal ------------------------- */
        .products-archive-header .products-archive-tabs-wrapper .products-archive-tabs--underline li button.active {
            color: $main;
            box-shadow: $main 0 3px 0 0;
        }
        .amazing-product-widget .amazing-product-item .item-pricing .item-price ins, .amazing-product-widget .amazing-product-item .countdown-outer .countdown-title b, .product-category--minimal:hover .woocommerce-loop-category__title, .products-archive-header .products-archive-tabs-wrapper .products-archive-tabs--underline li button:hover, .product-single-responsive-bar .product-price .price-inner .woocommerce-Price-amount, .site-bottom-bar--fit #responsive-footer-bar ul li.active-item a,.header-cart-basket.style-5 .cart-basket-box >.title, .product-single-style-3 .product-shipping-time i,.product-single-style-3 .product-shipping-time .shiping-title b,.inline-sale-timer-box *,.content-widget.slider-2.style-2 .product-info .feature-daels-price .sale-price, article.product div.title a:hover, .woocommerce-account:not(.logged-in) article.post-item .negarshop-userlogin .nav-pills .nav-item .active, .woocommerce-account:not(.logged-in) article.post-item .negarshop-userlogin .woocommerce-LostPassword a, .ns-checkbox input[type=\"radio\"]:checked + label::before, section.blog-home article.post-item.post .content a, a:hover, .header-account .account-box:hover .title, .header-main-nav .header-main-menu > ul > li.loaded:hover>a, section.widget ul li a:hover, .content-widget.slider-2.style-2 .product-info .footer-sec .finished, .content-widget.slider-2.style-2 .product-info .static-title span, .product-card .info > .price span span, .product-card .info > .price span.amount, section.blog-home article.post-item .title .title-tag:hover, .woocommerce nav.woocommerce-MyAccount-navigation ul li.is-active a, .woocommerce.single-product .sale-timer .right .title span, .offer-moments .owl-item .price ins, .offer-moments .owl-item .price span.amount, .page-template-amazing-offer article.product .price ins, .ns-checkbox input[type=\"checkbox\"]:checked+label::before, .content-widget.products-carousel.tabs ul.tabs li.active a, .product .product-sales-count i, .woocommerce nav.woocommerce-MyAccount-navigation ul li.is-active a
        {
            color: $main;
        }
        .amazing-product-widget:before, .amazing-product-widget .amazing-product-item .stock-bar .progress-bar, .digits-form_submit-btn, .woocommerce-pagination .comments-pagination a:hover, .woocommerce-pagination li a:hover, .products-archive-header .products-archive-tabs-wrapper .products-archive-tabs--classic li button.active, .site-bottom-bar--minimal #responsive-footer-bar ul li.active-item a, .quantity.custom-num span:hover, .product-card--side-actions .actions ul .add-to-cart a, .product-card--side-actions .actions ul .add-to-cart button, .product-card--bold-actions .actions ul .add-to-cart a, .product-card--bold-actions .actions ul .add-to-cart button, .category-card:hover, .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.chosen a:before, .header-cart-basket.style-5 .cart-basket-box > .icon, .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-5 li a::after, .cart-header-steps .step-item .icon, .product-add-to-cart-sticky .add-product, .negarshop-countdown:not(.no-style) .countdown-section:last-of-type::before, .select_option.select_option_colorpicker.selected,.select_option.select_option_label.selected, .header-search.style-5.darken-color-mode .search-box .action-btns .action-btn.search-submit:hover, .content-widget.slider.product-archive .wg-title, .lg-actions .lg-next:hover, .lg-actions .lg-prev:hover,.lg-outer .lg-toogle-thumb:hover, .lg-outer.lg-dropdown-active #lg-share,.lg-toolbar .lg-icon:hover, .lg-progress-bar .lg-progress, .dokan-progress>.dokan-progress-bar, #negarshop-to-top>span, .header-search .search-box .action-btns .action-btn.search-submit::after, .select2-container--default .select2-results__option--highlighted[aria-selected], .header-account .account-box:hover .icon, .header-main-nav .header-main-menu > ul > li.loaded:hover>a::after, .btn-negar, .content-widget.slider-2.style-2 .carousel-indicators li.active, .btn-primary, .btn-primary:hover, .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show > .btn-primary.dropdown-toggle, .btn-primary.disabled, .btn-primary:disabled , .navigation.pagination .nav-links a:hover, .woocommerce-message a:active, .woocommerce .onsale, header.section-header a.archive, .woocommerce.single-product .sale-timer .left .discount span, .woocommerce-pagination ul li a:hover , .ui-slider .ui-slider-range, .switch input:checked + .slider, .woocommerce .quantity.custom-num span:hover, .content-widget.slider-2.style-2 .carousel-inner .carousel-item .discount-percent, .sidebar .woocommerce-product-search button, .product-single-ribbons .ribbons>div>span, .content-widget.products-carousel.tabs ul.tabs li a::after, .cb-nouislider .noUi-connect, .comment-users-reviews .progress .progress-bar, .ns-table tbody td.actions a.dislike_product:hover, .ns-store-header .nav-pills .nav-item a.active, .ns-store-avatar header.store-avatar-header
        {
            background-color: $main;
            color: $main_compatible;
        }
        .content-widget.slider.product-archive .wg-title, .lg-outer .lg-thumb-item.active, .lg-outer .lg-thumb-item:hover,.btn-primary, .btn-primary:hover, .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show > .btn-primary.dropdown-toggle, .btn-primary.disabled, .btn-primary:disabled, .ui-slider span, .ns-store-avatar header.store-avatar-header .avatar
        {
            border-color: $main;
        }
        .spinner, nav#main-menu li.loading>a::after
        {
            border-top-color: $main;
        }
        .content-widget.slider-2.style-2 .carousel-indicators li::before
        {
            border-right-color: $main;
        }
        .product-card .card-footer .card-price span span, .product-card .card-footer .card-price span.amount, .woocommerce-page.woocommerce-cart table.shop_table tr.cart_item td.product-price .woocommerce-Price-amount, .content-widget.slider.product-archive .slide-details .prd-price, .woocommerce-variation-price, .woocommerce p.price > span, .woocommerce p.price ins,.table-cell .woocommerce-Price-amount,#order_review span.amount{
            color: $price_color;
        }
        .header-cart-basket.style-5 .cart-basket-box .count{
            box-shadow: $main 0 3px 6px;
        }
        .products-carousel .tabs li.active a {
            border-bottom-color: $main;
        }
        .product-category--minimal:hover > a {
            box-shadow: $main 0 0 0 2px inset;
        }
        /* ------------------------- Importants ------------------------- */
        .header-cart-basket.style-5 .cart-basket-box .count, .woocommerce .product .product_meta > span a:hover, .woocommerce .product .product_meta > span span:hover, .product-section .sale-timer-box, .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active>a
        {
            color: $main !important;
        }
        .dokan-btn-theme, .wooscp-area .wooscp-inner .wooscp-bar .wooscp-bar-btn{
            background-color: $main !important;
        }
        .woocommerce .product .product_meta > span a:hover, .woocommerce .product .product_meta > span span:hover, .dokan-btn-theme{
            border-color: $main !important;
        }
        .cls-3{
            fill: $main;
        }
        .negarshop-countdown .countdown-section:last-of-type{
          background: $main_rgba_2;
          color: $main;
        }
        /* ------------------------- Customs ------------------------- */
        .woo-variation-swatches-stylesheet-enabled .variable-items-wrapper .variable-item:not(.radio-variable-item).selected, .woo-variation-swatches-stylesheet-enabled .variable-items-wrapper .variable-item:not(.radio-variable-item).selected:hover {
          box-shadow: 0 0 0 2px $main !important;
        }
        .content-widget.products-carousel.tabs.tabs-count-1.style-2 ul.tabs::after, .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs-style-2 li.active i::after, .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs-style-2 li.active i, .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active>a, .woocommerce nav.woocommerce-MyAccount-navigation ul li.is-active a{
            background-color: $main_rgba_1 !important;
        }
        .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-3 li.active{
		    box-shadow: $main 0 -3px 0 inset;
		}
        /*-------------basket----------------*/
        .header-cart-basket .cart-basket-box{
            background-color: $basket_wg_bg;
            color: $basket_wg_txt;
        }
         .header-cart-basket .cart-basket-box .count{
            background-color: $basket_counter;
            color: $basket_counter_txt;
        }
        .header-cart-basket > .widget.widget_shopping_cart ul li a.remove:hover{
            background-color: $basket_inner_txt;
        }
        .header-cart-basket > .widget.widget_shopping_cart p.total{
            color: $basket_inner_txt;
            background-color: $basket_inner_txt_rgba;
        }
        .header-cart-basket > .widget.widget_shopping_cart .buttons .button:hover{
            color: $basket_inner_txt;
        }
        .header-cart-basket > .widget.widget_shopping_cart .buttons a.checkout:hover{
            background-color: $basket_inner_txt;
        }
        input[type=\"password\"]:not(.browser-default), .site-bottom-bar--minimal #responsive-footer-bar ul li a, .site-bottom-bar--minimal #responsive-footer-bar, .progress-bar, .amazing-product-widget .amazing-product-item .item-header .item-figure, .amazing-product-widget, .digits-form_submit-btn, .product-category > a, .product-archive-filters--popup .shop-archive-sidebar, .products-archive-header .products-archive-tabs-wrapper .products-archive-tabs--classic li button.active, .custom-background--gray, .products-archive-active-filters ul li a, .owl-carousel.wc-product-carousel .owl-item .view-3d-slide, .product-single-actions:not(.mini-product-single-actions), .site-bottom-bar #responsive-categories-page .terms-list li a, .product-card .thumbnail, .quantity.custom-num span, .products-carousel .carousel-content .loading, .header-cart-basket > .widget.widget_shopping_cart ul li img.wp-post-image, .header-cart-basket > .widget.widget_shopping_cart ul li a.remove, .product-card--side-actions .actions ul .add-to-cart a, .product-card--side-actions .actions ul .add-to-cart button, .product-card .header-actions ul, .header-cart-basket .cart-basket-box, .product-card--bold-actions .actions ul .add-to-cart a, .product-card--bold-actions .actions ul .add-to-cart button, .header-search .search-box .search-form-fields, .category-card, .woocommerce .woocommerce-product-details__short-description button#product-short-desc-toggle .outer, #responsive-contents .header-cart-basket .widget.widget_shopping_cart p.total,.wc-product-carousel .owl-item img.product-gallery-img, .dokan-store-products-filter-area .orderby-search, .woocommerce nav.woocommerce-MyAccount-navigation ul li:not(.res-toggle-menu) a,.product-single-style-3 .product-section, .product-single-style-3 .select_option.select_option_colorpicker.selected, .product-single-style-3 .select_option.select_option_label.selected, .woocommerce .product .product-single-style-3 .product_meta > span i, .product-single-style-3 .product-shipping-time,.product-single-style-3 .wc-product-carousel,.woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs.wc-tabs-style-3, .product-section.product-additional-items .additional-factor, .product-single-ribbons .ribbons > div > span, #comment-attachments, .comment-attachments li, .question-pagination .page-numbers, .negarshop-card, .leaflet-bar, .woocommerce-checkout .leaflet-container, .cart-header-steps .step-item .icon, .order-delivery-times li label, article.product figure.thumb, .negarshop-countdown .countdown-section:last-of-type::before, .negarshop-countdown .countdown-section, #negarshopAlertBox, #negarshopAlertBox #closeBtn, .product-alerts .alert-item, .select_option, .select_option *, .product-single-actions, .cb-chips ul.chip-items li, .select2-container--default .select2-selection--single, .header-search.style-5.darken-color-mode .search-box .action-btns .action-btn.search-submit, ul.dokan-account-migration-lists li, .product-summary-left, .header-main-menu.vertical-menu ul.main-menu > li:hover, .product-card, .product-card figure, .img-banner-wg, .btn, .form-control, .form-control-sm, .input-group-sm > .form-control, .input-group-sm > .input-group-append > .btn, .input-group-sm > .input-group-append > .input-group-text, .input-group-sm > .input-group-prepend > .btn, .input-group-sm > .input-group-prepend > .input-group-text,#negarshop-to-top > span i,section.widget:not(.widget_media_image), .dokan-widget-area aside.widget:not(.widget_media_image),.woocommerce.single-product div.product > .product-section, nav.woocommerce-breadcrumb, .woocommerce.single-product div.product .woocommerce-tabs.wc-tabs-wrapper .woocommerce-Tabs-panel, .dokan-other-vendor-camparison,.woocommerce .title-bg,.product-single-actions li>*,.woocommerce .quantity.custom-num input.input-text,.woocommerce .quantity.custom-num span,.table-gray,.comment-form-header .comment-notes,.cb-nouislider .noUi-connects,input[type=\"submit\"]:not(.browser-default), input[type=\"button\"]:not(.browser-default), input[type=\"reset\"]:not(.browser-default), .btn, .dokan-btn,article.product,.colored-dots .dot-item,.woocommerce.single-product div.product .product-section.single-style-2-gallery .owl-carousel.wc-product-carousel .owl-item .car-dtag,.owl-carousel.wc-product-carousel .owl-nav button,.owl-carousel.wc-product-carousel-thumbs .owl-item,.account-box .account-links,.account-box .account-links > li a,.header-main-nav .header-main-menu li > ul,.is-mega-menu-con.is-product-mega-menu .tabs a.item-hover,figure.optimized-1-1,.is-mega-menu-con.is-product-mega-menu .owl-carousel .owl-nav button,.content-widget.slider.product-archive figure.thumb,.content-widget.slider .carousel .carousel-indicators li,ul li.wc-layered-nav-rating a,.switch .slider,.switch .slider::before,.woocommerce-products-header,.price_slider_amount button.button,.modal-content, #cbQVModalCarousel .carousel-item,.woocommerce-pagination ul li a, .woocommerce-pagination ul li span,.tile-posts article.blog-item,section.blog-home article.post-item,section.blog-home article.post-item figure.post-thumb,section.blog-home article.post-item .entry-video .inner,.navigation.pagination .nav-links > *,.content-widget.blog-posts article.blog-item figure.thumbnail,.content-widget.blog-posts article.blog-item time,.content-widget.blog-posts article.blog-item,.content-widget.blog-posts .owl-dots button,section.blog-home .post-wg,section.blog-home .post-wg ol.comment-list article.comment-body,section.blog-home article.post-item .tags a,blockquote,nav.top-bar li > ul ,.header-search .search-box .search-result,.product-section .sale-timer-box, .product-section .sale-timer-box .counter-sec,.product-section .sale-timer-box .title .badge,.header-cart-basket.style-2 .cart-basket-box,.header-cart-basket > .widget.widget_shopping_cart .buttons a.checkout,.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a,.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li,.woocommerce nav.woocommerce-MyAccount-navigation ul li a,.woocommerce-message, .woocommerce-error,.woocommerce-message a, .woocommerce-page.woocommerce-cart table.shop_table td.product-remove a.remove, .cart-collaterals .cart_totals,ul#shipping_method li label,.list-group,ul.woocommerce-order-overview, .header-cart-basket > .widget.widget_shopping_cart > .widget_shopping_cart_content,.header-cart-basket > .widget.widget_shopping_cart,footer.site-footer .about-site,ul.product-categories li.open .children,.wooscp-area .wooscp-inner .wooscp-bar .wooscp-bar-btn,.woocommerce-tabs.wc-tabs-wrapper > div.woocommerce-Tabs-panel .product-seller .store-avatar img,.ns-table tbody td.actions a.dislike_product,.is-mega-menu-con.is-product-mega-menu li.contents,footer.site-footer .support-times,li.recentcomments,section.widget.widget_media_image img,.header-main-menu.vertical-menu ul.main-menu,.prm-brands-list__item,.prm-brands-list__item .prm-brands-list__title,.content-widget.slider .carousel,.content-widget.title-widget span.icon,.products-carousel .carousel-banner,footer.site-footer .footer-socials ul li a,header.site-header .header-socials ul li a,.header-search .search-box .action-btns{
            -webkit-border-radius: {$radius}px; -moz-border-radius: {$radius}px; border-radius: {$radius}px;
        }
        .category-card img, .product-video-carousel .owl-nav button, .input-group .form-control:not(select), textarea:not(.browser-default), .dokan-form-control, .form-control, input[type=\"text\"]:not(.browser-default), input[type=\"search\"]:not(.browser-default), input[type=\"email\"]:not(.browser-default), input[type=\"url\"]:not(.browser-default), input[type=\"number\"]:not(.browser-default) ,.input-group .btn,.dokan-message, .dokan-info, .dokan-error{
            -webkit-border-radius: {$radius}px !important; -moz-border-radius: {$radius}px !important; border-radius: {$radius}px !important;
        }
        .header-search.style-3 .search-box .action-btns {
            border-radius: {$radius}px 0 0 {$radius}px;
        }
        .woocommerce-account:not(.logged-in) article.post-item .nav-pills, .woocommerce-account:not(.logged-in) article.post-item .negarshop-userlogin .nav-pills .nav-item .active, .ns-store-avatar header.store-avatar-header,.woocommerce-page.woocommerce-cart table.shop_table tr:first-of-type td.product-subtotal{
            border-radius: {$radius}px {$radius}px 0 0;
        }
        .ns-store-avatar.wc-dashboard .user-actions a,.woocommerce-page.woocommerce-cart table.shop_table tr:nth-last-of-type(2) td.product-subtotal{
            border-radius: 0 0 {$radius}px {$radius}px;
        }
        .ns-table tbody tr td:first-of-type {
            border-radius: 0 {$radius}px {$radius}px 0;
        }
        .ns-table tbody tr td:last-of-type {
            border-radius: {$radius}px 0 0 {$radius}px;
        }
        .leaflet-touch .leaflet-bar a:first-child{
            border-radius: {$radius}px {$radius}px 0 0;
        }
        .leaflet-touch .leaflet-bar a:last-child{
            border-radius: 0 0 {$radius}px {$radius}px;
        }
        @media only screen and (max-width: 768px) {
            .woocommerce-tabs.wc-tabs-wrapper ul.wc-tabs li{
                border-radius: {$radius}px;
            }
        }
        
        @media (min-width: {$container_size}px){
            .container{
                max-width: {$container_size}px
            }
        }
        ";


    $langTexts = [
        '.comment .comment-awaiting-moderation::before' => __("در انتظار تایید مدیریت", 'negarshop'),
        '.woocommerce-variation-price:not(:empty)::before' => __("قیمت: ", 'negarshop'),
        '.woocommerce-pagination ul li a.next::before' => __("بعدی", 'negarshop'),
        '.woocommerce-pagination ul li a.prev::before' => __("قبلی", 'negarshop'),
        '.woocommerce .quantity.custom-num label.screen-reader-text::before' => __("تعداد: ", 'negarshop'),
        '.yith-woocompare-widget ul.products-list li .remove::after' => __("حذف", 'negarshop'),
        '.woocommerce .product .product_meta > span.product-brand::before' => __("برند: ", 'negarshop'),
        '.show-ywsl-box::before' => __("برای ورود کلیک کنید", 'negarshop'),
        'a.reset_variations::before' => __("پاک کردن ویژگی ها", 'negarshop'),
        '.woocommerce form .form-row .required::before' => __("(ضروری)", 'negarshop'),
        '.content-widget.price-changes .prices-table tbody td.past-price::before' => __("قیمت قبل: ", 'negarshop'),
        '.content-widget.price-changes .prices-table tbody td.new-price::before' => __("قیمت جدید: ", 'negarshop'),
        '.content-widget.price-changes .prices-table tbody td.changes::before' => __("تغییرات: ", 'negarshop'),
        '.content-widget.price-changes .prices-table tbody td.difference::before' => __("مابه التفاوت: ", 'negarshop'),
    ];

    foreach ($langTexts as $key => $val) {
        $styles .= $key . '{content: \'' . $val . '\'} ';
    }

    $styles .= "</style>
    <script type='text/javascript'>var jsVars = {\"borderActiveColor\":\"$main\"};</script>
    ";

    return str_replace(['	', '  ', PHP_EOL], '', $styles);
}

add_action('wp_enqueue_scripts', 'negarshop_scripts');
add_action('wp_head', 'negarshop_header_styles');
add_action('wp_footer', 'negarshop_footer_scripts');
add_action('admin_enqueue_scripts', 'negarshop_wp_admin_style');
add_action('wp_default_scripts', 'negarshop_default_scripts');
add_action('wp_enqueue_scripts', 'negarshop_dequeue', 99999);
add_action('wp_enqueue_styles', 'negarshop_dequeue', 99999);
add_action('wp_footer', 'negarshop_dequeue', 9999);
add_action('init', 'negarshop_dequeue', 9999);