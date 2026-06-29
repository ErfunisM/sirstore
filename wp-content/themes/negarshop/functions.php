<?php
if (!defined('ABSPATH')) {
    die('Forbidden');
}

if (!version_compare(PHP_VERSION, '7.4', '>=')) {
    function negarshop_php_version_admin_notice()
    {
        $class = 'notice notice-error';
        $message = '<h4>قالب نگارشاپ نیازمند PHP نسخه 7.4 به بالاتر می باشد!</h4>';
        $message .= '<b>نسخه PHP شما: </b>' . PHP_VERSION;

        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    }

    add_action('admin_notices', 'negarshop_php_version_admin_notice');
}

function negarshop_setup()
{
    add_image_size('sz_3_1', 900, 300);
    add_image_size('sz_1_1', 400, 400);
    add_image_size('thumbnail-50', 50, 50);

    register_nav_menus([
        'top' => 'نوار بالا (فقط طرح پیشفرض سربرگ)',
        'main' => 'منوی اصلی (فقط طرح پیشفرض سربرگ)',
        'category' => ' منوی دسته بندی سربرگ (فقط طرح پیشفرض سربرگ)',
        'footer' => 'منوی پابرگ (فقط طرح پیشفرض پابرگ)',
        'responsive' => 'منوی ریسپانسیو',
    ]);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('woocommerce');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', ['video']);

    update_option('wpp_adminpanel_convert_date', '0');
    update_option('wpp_adminpanel_datepicker', '0');
    update_option('yith_system_info', ['system_info' => [], 'errors' => false]);
    update_option('dokan_colors', [
        'btn_text' => '',
        'btn_primary' => '',
        'btn_primary_border' => '',
        'btn_hover_text' => '',
        'btn_hover' => '',
        'btn_hover_border' => '',
        'dash_active_link' => '',
        'dash_nav_text' => '',
        'dash_nav_bg' => '',
        'dash_nav_border' => '',
    ]);
    $wc_per_datepicker = get_option('PW_Options');
    if ($wc_per_datepicker !== false) {
        if (!is_array($wc_per_datepicker)) {
            $wc_per_datepicker = unserialize($wc_per_datepicker);
        }
        $wc_per_datepicker['enable_jalali_datepicker'] = 'yes';
        $wc_per_datepicker['persian_price'] = 'yes';
        update_option('PW_Options', $wc_per_datepicker);
    }
    if (negarshop_option('checkout_fanum') === "true") {
        add_action('woocommerce_checkout_process', 'negarshop_persian_chars_checkout');
    }

    $wo_compare = WP_PLUGIN_DIR . '/woo-smart-compare/languages';

    if (is_dir($wo_compare)) {
        negarshop_add_translate($wo_compare, get_template_directory() . '/includes/languages/wooscp-fa_IR.mo', $wo_compare . '/wooscp-fa.mo');
    }
    load_theme_textdomain('fw', __DIR__ . '/includes/languages');
    load_theme_textdomain('negarshop', __DIR__ . '/includes/languages/theme');
    remove_theme_support('widgets-block-editor');
}

function negarshop_widgets_init()
{
    $sidebar_opts = [
        'name' => 'جایگاه اصلی',
        'id' => 'sidebar-1',
        'description' => 'ابزارک ها را اینجا بکشید تا در کنار محتوا نمایش داده شود.',
        'before_widget' => '<section id="%1$s" class="widget widget--' . negarshop_option('wordpress_widgets_style') . ' %2$s">',
        'after_widget' => '</section>',
        'before_title' => sprintf('<header class="wg-header wg-header--%s"><h6>', negarshop_option('wordpress_widgets_header_style')),
        'after_title' => '</h6></header>',
    ];
    register_sidebar($sidebar_opts);
    $sidebar_opts['name'] = 'جایگاه وبلاگ';
    $sidebar_opts['id'] = 'sidebar-blog';
    register_sidebar($sidebar_opts);
    $sidebar_opts['name'] = 'جایگاه فروشگاه';
    $sidebar_opts['id'] = 'sidebar-shop';
    register_sidebar($sidebar_opts);
    $dynamic_widgets = negarshop_option("sb_widget_items");
    if (!empty($dynamic_widgets)) {
        $dyint = 1;
        foreach ($dynamic_widgets as $item) {
            $sidebar_opts['name'] = $item['title'];
            $sidebar_opts['id'] = "negarshop-dynamic-" . $dyint;
            register_sidebar($sidebar_opts);
            $dyint++;
        }
    }
}

function negarshop_theme_add_editor_styles()
{
    wp_enqueue_style('site-block-editor-styles', get_theme_file_uri('/editor-style.css'), false, '1.0', 'all');
}


add_action('after_setup_theme', 'negarshop_setup');
add_action('widgets_init', 'negarshop_widgets_init');
add_action('admin_init', 'negarshop_theme_add_editor_styles');
add_action('enqueue_block_editor_assets', 'negarshop_theme_add_editor_styles');

require_once(__DIR__ . '/includes/init.php');
require_once(__DIR__ . '/my_functions.php');