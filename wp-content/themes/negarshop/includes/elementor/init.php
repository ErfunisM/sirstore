<?php

namespace NegarshopElementor;

use Elementor\Plugin;

class NegarshopElementorInit
{
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function include_widgets_files()
    {
        require_once(__DIR__ . '/element-carousel.php');
        require_once(__DIR__ . '/element-moment.php');
        require_once(__DIR__ . '/element-amazing.php');
        require_once(__DIR__ . '/element-custom-product.php');
        require_once(__DIR__ . '/element-header-search.php');
        require_once(__DIR__ . '/element-header-basket.php');
        require_once(__DIR__ . '/element-header-account.php');
        require_once(__DIR__ . '/element-header-menu.php');
        require_once(__DIR__ . '/element-blog-carousel.php');
        require_once(__DIR__ . '/element-blog-main.php');
        require_once(__DIR__ . '/element-shop-orders.php');
        require_once(__DIR__ . '/element-product-categories.php');
        require_once(__DIR__ . '/element-amazing-product.php');
        require_once(__DIR__ . '/element-story.php');
        require_once(__DIR__ . '/element-live-price.php');
        require_once(__DIR__ . '/element-countdown.php');
        require_once(__DIR__ . '/element-slider.php');
    }

    public function add_elementor_widget_categories($elements_manager)
    {

        $elements_manager->add_category(
            'Negarshop_header',
            [
                'title' => 'ابزارک های سربرگ <b style="color: #00bfd6;">قالب نگارشاپ</b>',
                'icon' => 'eicon-archive-title',
            ]
        );
        $elements_manager->add_category(
            'Negarshop_responsive',
            [
                'title' => 'ابزارک های حالت ریسپانسیو <b style="color: #00bfd6;">قالب نگارشاپ</b>',
                'icon' => 'eicon-archive-title',
            ]
        );
        $elements_manager->add_category(
            'Negarshop_main',
            [
                'title' => 'ابزارک های محتوای <b style="color: #00bfd6;">قالب نگارشاپ</b>',
                'icon' => 'eicon-post-info',
            ]
        );
        $elements_manager->add_category(
            'Negarshop_footer',
            [
                'title' => 'ابزارک های پابرگ <b style="color: #00bfd6;">قالب نگارشاپ</b>',
                'icon' => 'eicon-form-horizontal',
            ]
        );

    }

    public function register_widgets()
    {
        $this->include_widgets_files();
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_carousel_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_moment_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_amazing_Widget());
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        if (is_plugin_active('elementor-pro/elementor-pro.php')) {
            Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_custom_product_Widget());
        }
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_header_search_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_header_basket_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_header_account_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_header_menu_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_blog_carousel_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_blog_main_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_order_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_product_categories());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_shop_Amazing_Product_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_Story_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_Live_Price_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_Countdown_Widget());
        Plugin::instance()->widgets_manager->register(new Widgets\Elementor_Slider_Widget());
    }

    public function Negarshop_register_elementor_locations($elementor_theme_manager)
    {
        $elementor_theme_manager->register_all_core_location();
        $elementor_theme_manager->register_location(
            'responsive-header',
            [
                'label' => 'سربرگ حالت موبایل',
            ]
        );

    }

    public function __construct()
    {
        // Register widgets
        add_action('elementor/theme/register_locations', [$this, 'Negarshop_register_elementor_locations']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets'], 11);
    }
}

// Instantiate Plugin Class
require_once __DIR__ . '/products-renderer.php';
NegarshopElementorInit::instance();

