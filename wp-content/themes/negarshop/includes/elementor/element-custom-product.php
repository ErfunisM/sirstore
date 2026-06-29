<?php

namespace NegarshopElementor\Widgets;

use Elementor\Controls_Manager;

class Elementor_shop_custom_product_Widget extends \Elementor\Widget_Base
{
    public function show_in_panel() {
        return class_exists('ElementorPro\Modules\QueryControl\Controls\Group_Control_Query');
    }

    public function get_name() {
        return 'negarshop_custom_product';
    }

    public function get_title() {
        return 'محصولات دلخواه';
    }

    public function get_icon() {
        return 'eicon-post-info';
    }

    public function get_categories() {
        return ['Negarshop_main'];
    }

    protected function _register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        if (class_exists('\ElementorPro\Modules\QueryControl\Controls\Group_Control_Query')) {
            $this->add_group_control(\ElementorPro\Modules\QueryControl\Controls\Group_Control_Query::get_type(), [
                'name' => \NegarshopElementor\Negarshop_Products_Renderer::QUERY_CONTROL_NAME,
                'post_type' => 'product',
                'presets' => ['full'],
                'fields_options' => [
                    'post_type' => [
                        'default' => 'product',
                        'options' => [
                            'product' => __('Latest Products', 'elementor-pro'),
                            'sale' => __('Sale', 'elementor-pro'),
                            'featured' => __('Featured', 'elementor-pro'),
                            'by_id' => _x('Manual Selection', 'Posts Query Control', 'elementor-pro'),
                        ],
                    ],
                    'orderby' => [
                        'default' => 'date',
                        'options' => [
                            'date' => __('Date', 'elementor-pro'),
                            'title' => __('Title', 'elementor-pro'),
                            'price' => __('Price', 'elementor-pro'),
                            'popularity' => __('Popularity', 'elementor-pro'),
                            'rating' => __('Rating', 'elementor-pro'),
                            'rand' => __('Random', 'elementor-pro'),
                            'menu_order' => __('Menu Order', 'elementor-pro'),
                        ],
                    ],
                    'exclude' => [
                        'options' => [
                            'current_post' => __('Current Post', 'elementor-pro'),
                            'manual_selection' => __('Manual Selection', 'elementor-pro'),
                            'terms' => __('Term', 'elementor-pro'),
                        ],
                    ],
                    'include' => [
                        'options' => [
                            'terms' => __('Term', 'elementor-pro'),
                        ],
                    ],
                ],
                'exclude' => [
                    'posts_per_page',
                    'exclude_authors',
                    'authors',
                    'offset',
                    'related_fallback',
                    'related_ids',
                    'query_id',
                    'avoid_duplicates',
                    'ignore_sticky_posts',
                ],
            ]);
        }
        if (class_exists('\NegarshopElementor\Negarshop_Products_Renderer')) {
            $this->add_control(\NegarshopElementor\Negarshop_Products_Renderer::QUERY_CONTROL_NAME . '_ppp', [
                'label' => 'تعداد محصول',
                'type' => Controls_Manager::NUMBER,
                'default' => 8
            ]);
            $this->add_control(\NegarshopElementor\Negarshop_Products_Renderer::QUERY_CONTROL_NAME . '_offset', [
                'label' => 'استثنا',
                'type' => Controls_Manager::NUMBER,
                'default' => 0
            ]);
        }

        $this->end_controls_section();


        $this->start_controls_section('style_section', [
            'label' => 'ظاهر',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('color_t', [
            'label' => 'رنگ',
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => 'پیشفرض قالب',
                'custom' => 'دستی',
            ],
        ]);
        $this->add_control('color', [
            'label' => 'رنگ جعبه',
            'type' => Controls_Manager::COLOR,
            'default' => '#00bfd6',
            'selectors' => [
                '{{WRAPPER}} a:hover' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'color_t' => 'custom',
            ],
        ]);
        $this->add_control('style', [
            'label' => 'چینش',
            'type' => Controls_Manager::SELECT,
            'default' => 'list',
            'options' => [
                'list' => 'زیر هم',
                'grid' => 'کنار هم',
            ],
        ]);
        $this->add_control('col', [
            'label' => 'ستون',
            'type' => Controls_Manager::SELECT,
            'default' => 'col-lg-4',
            'options' => [
                'col-lg-2' => '6 ستون',
                'col-lg-3' => '4 ستون',
                'col-lg-4' => '3 ستون',
                'col-lg-6' => '2 ستون',
                'col-lg-12' => '1 ستون',
            ],
            'condition' => [
                'style' => 'grid',
            ],
        ]);
        $sizes = negarshop_get_all_image_sizes();
        $sizes_opts = [];
        foreach ($sizes as $key => $val) {
            $sizes_opts[$key] = $key . " (" . $val['width'] . " در " . $val['height'] . ")";
        }
        $this->add_control('card_image', [
            'label' => 'اندازه تصویر کارت ها',
            'type' => Controls_Manager::SELECT,
            'default' => 'sz_3_1',
            'options' => [
                    'custom' => 'دستی',
                ] + $sizes_opts,
        ]);

        $this->add_control('card_custom_image_width', [
            'label' => 'طول',
            'type' => Controls_Manager::NUMBER,
            'default' => '300',
            'condition' => [
                'card_image' => 'custom',
            ],
        ]);
        $this->add_control('card_custom_image_height', [
            'label' => 'عرض',
            'type' => Controls_Manager::NUMBER,
            'default' => '300',
            'condition' => [
                'card_image' => 'custom',
            ],
        ]);
        $this->end_controls_section();

        negarshop_product_card_elementor_options($this);
    }

    protected function get_shortcode_object($settings) {
        $type = 'products';

        return new \NegarshopElementor\Negarshop_Products_Renderer($settings, $type);
    }

    protected function render() {
        if (!class_exists('\ElementorPro\Modules\QueryControl\Controls\Group_Control_Query') || !class_exists('\NegarshopElementor\Negarshop_Products_Renderer')) {
            return;
        }
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();
        echo '<div class="content-widget elementor-wg transparent mini-products">';
        if ($settings['style'] === 'list') {
            echo $this->get_shortcode_object($settings)->get_custom_content('<div class="small-products">', '</div>', '', '', $settings);
        } else {
            echo $this->get_shortcode_object($settings)->get_custom_content('<div class="large-products"><div class="row">', '</div></div>', '<div class="' . $settings['col'] . '">', '</div>', $settings);
        }
        echo '</div>';
    }

}
