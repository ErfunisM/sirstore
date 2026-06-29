<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_shop_carousel_Widget extends \Elementor\Widget_Base
{

    public function get_name() {
        return 'negarshop_carousel';
    }

    public function get_title() {
        return 'اسلایدر محصولات';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['Negarshop_main'];
    }

    protected function _register_controls() {
        $this->start_controls_section('carousel_section', [
            'label' => 'تنظیمات اسلایدر',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('carousel_autoplay', [
            'label' => 'پخش خودکار',
            'type' => Controls_Manager::SELECT,
            'default' => 'false',
            'options' => [
                'true' => 'فعال',
                'false' => 'غیرفعال'
            ],
        ]);
        $this->add_control('carousel_loop', [
            'label' => 'حالت بینهایت',
            'type' => Controls_Manager::SELECT,
            'default' => 'true',
            'options' => [
                'true' => 'فعال',
                'false' => 'غیرفعال'
            ],
        ]);
        $this->add_control('carousel_nav', [
            'label' => 'جهت ها',
            'type' => Controls_Manager::SELECT,
            'default' => 'true',
            'options' => [
                'true' => 'فعال',
                'false' => 'غیرفعال'
            ],
        ]);

        $sizes = negarshop_get_all_image_sizes();
        $sizes_opts = [];
        foreach ($sizes as $key => $val) {
            $sizes_opts[$key] = $val['width'] . " در " . $val['height'];
        }
        $this->add_control('card_image', [
            'label' => 'اندازه تصویر محصولات',
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
        $this->add_control('carousel_items_xl', [
            'label' => 'تعداد محصول نمایشی در حالت دسکتاپ',
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
        ]);
        $this->add_control('carousel_items_lg', [
            'label' => 'تعداد محصول نمایشی در حالت نمایشگر دسکتاپ متوسط',
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
        ]);
        $this->add_control('carousel_items_md', [
            'label' => 'تعداد محصول نمایشی در حالت تبلت',
            'type' => Controls_Manager::NUMBER,
            'default' => 2,
        ]);
        $this->add_control('carousel_items_xs', [
            'label' => 'تعداد محصول نمایشی در حالت موبایل',
            'type' => Controls_Manager::NUMBER,
            'default' => 2.5,
        ]);
        $this->end_controls_section();

        $this->start_controls_section('tabs_setting_section', [
            'label' => 'تنظیمات تب ها',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('tab_status', [
            'label' => 'وضعیت تب ها',
            'type' => Controls_Manager::SELECT,
            'default' => 'flex',
            'options' => [
                'flex' => 'نمایش',
                'none' => 'مخفی'
            ],
            'selectors' => [
                '{{WRAPPER}} .content-widget header.section-header' => 'display: {{VALUE}}'
            ]
        ]);
        $this->add_control('tab_mode', [
            'label' => 'حالت تب ها',
            'type' => Controls_Manager::SELECT,
            'default' => 'top',
            'options' => [
                'top' => 'بالا',
                'side' => 'کنار'
            ],
            'condition' => [
                'tab_status' => 'flex'
            ]
        ]);
        $this->end_controls_section();



        $this->start_controls_section(
            'style_tab_section',
            [
                'label' => 'تب ها',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'tab_status' => 'flex',
                ],
            ]
        );

        $this->add_control(
            'tab_align',
            [
                'label' => 'چینش',
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => 'راست',
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => 'وسط',
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => 'چپ',
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tab_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .products-carousel .tabs li a',
            ]
        );
        $this->start_controls_tabs(
            'style_tab_tabs'
        );
        $this->start_controls_tab(
            'style_tab_section_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'tab_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .products-carousel .tabs li a',
            ]
        );
        $this->add_control(
            'tab_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'tab_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_border',
                'selector' => '{{WRAPPER}} .products-carousel .tabs li a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_tab_section_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'tab_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .products-carousel .tabs li a:hover',
            ]
        );
        $this->add_control(
            'tab_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'tab_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_border_hover',
                'selector' => '{{WRAPPER}} .products-carousel .tabs li a:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_tab_section_active',
            [
                'label' => 'فعال',
            ]
        );

        $this->add_control(
            'tab_text_active',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li.active a' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_background_active',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .products-carousel .tabs li.active a',
            ]
        );
        $this->add_control(
            'tab_padding_active',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li.active a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'tab_border_radius_active',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .tabs li.active a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_border_active',
                'selector' => '{{WRAPPER}} .products-carousel .tabs li.active a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'style_tab_link',
            [
                'label' => 'لینک آرشیو',
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_link_typography',
                'selector' => '{{WRAPPER}} .products-carousel .section-header .archive-link',
            ]
        );
        $this->start_controls_tabs(
            'style_tab_link_tabs'
        );
        $this->start_controls_tab(
            'style_tab_link_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'tab_link_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .section-header .archive-link' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_link_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .products-carousel .section-header .archive-link',
            ]
        );
        $this->add_control(
            'tab_link_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .section-header .archive-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'tab_link_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .section-header .archive-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_link_border',
                'selector' => '{{WRAPPER}} .products-carousel .section-header .archive-link',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_tab_link_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'tab_link_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .section-header .archive-link:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_link_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .products-carousel .section-header .archive-link:hover',
            ]
        );
        $this->add_control(
            'tab_link_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .section-header .archive-link:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'tab_link_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .products-carousel .section-header .archive-link:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_link_border_hover',
                'selector' => '{{WRAPPER}} .products-carousel .section-header .archive-link:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section('content_section', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('tab_name', [
            'label' => 'عنوان تب',
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
        ]);
        $repeater->add_control('items_type', [
            'type' => Controls_Manager::HIDDEN,
            'default' => 'products'
        ]);
        $repeater->add_control('link', [
            'label' => 'لینک آرشیو',
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
        ]);
        $repeater->add_control('products_stock', [
            'label' => 'وضعیت محصول',
            'type' => Controls_Manager::SELECT,
            'default' => 'all',
            'options' => [
                'all' => 'همه',
                'instock' => 'فقط موجود ها',
                'outofstock' => 'نا موجود ها',
                'sale' => 'فروش ویژه',
            ],
        ]);
        $repeater->add_control('products_type', [
            'label' => 'کوئری نمایش محصولات',
            'type' => Controls_Manager::SELECT,
            'default' => 'news',
            'options' => [
                'news' => 'جدید ترین ها',
                'views' => 'پربازدید ترین ها',
                'sell' => 'پرفروش ترین ها',
                'archive' => 'آرشیو کنونی',
                'category' => 'دسته بندی خاص',
                'tag' => 'برچسب',
                'ids' => 'شناسه محصولات',
            ],
        ]);
        $repeater->add_control('woo_categories', [
            'label' => 'دسته بندی ها',
            'type' => Controls_Manager::SELECT,
            'default' => 0,
            'options' => negarshop_get_categories('product_cat'),
            'condition' => [
                'products_type' => 'category',
            ],
        ]);
        $repeater->add_control('woo_tags', [
            'label' => 'برچسب ها',
            'type' => Controls_Manager::SELECT,
            'default' => 0,
            'options' => negarshop_get_categories('product_tag'),
            'condition' => [
                'products_type' => 'tag',
            ],
        ]);
        $repeater->add_control('product_ids', [
            'label' => 'شناسه ها',
            'placeholder' => 'مثال: 1,2,3,4',
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'condition' => [
                'products_type' => 'ids',
            ],
        ]);
        $repeater->add_control('views_time', [
            'label' => 'زمان بندی',
            'type' => Controls_Manager::SELECT,
            'default' => '7day',
            'options' => [
                '7day' => 'هفته',
                'month' => 'این ماه',
                'last_month' => 'ماه گذشته',
                'year' => 'سال',
            ],
            'condition' => [
                'products_type' => 'views',
            ],
        ]);
        $repeater->add_control('sell_time', [
            'label' => 'زمان بندی',
            'type' => Controls_Manager::SELECT,
            'default' => '7day',
            'options' => [
                '7day' => 'هفته',
                'month' => 'این ماه',
                'last_month' => 'ماه گذشته',
                'year' => 'سال',
            ],
            'condition' => [
                'products_type' => 'sell',
            ],
        ]);
        $repeater->add_control('products_count', [
            'label' => 'تعداد جهت نمایش',
            'type' => Controls_Manager::NUMBER,
            'default' => 5,
        ]);

        $this->add_control('tabs', [
            'label' => 'تب ها',
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'tab_name' => 'مطالب جدید',
                    'products_type' => 'news',
                    'products_count' => 5
                ]
            ],
            'title_field' => '{{{ tab_name }}}',
        ]);


        $this->end_controls_section();


        $this->start_controls_section('style_section', [
            'label' => 'عمومی',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('primary_color', [
            'label' => 'رنگ اصلی',
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .products-carousel .loading .spinner' => 'border-top-color: {{VALUE}}',
                '{{WRAPPER}} .products-carousel ul.tabs li a::after' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .btn-primary' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                '{{WRAPPER}} .products-carousel .tabs-count-1.style-2 ul.tabs::after' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .products-carousel ul.tabs li.active a' => 'color: {{VALUE}}',
                '{{WRAPPER}} .products-carousel a:not(.btn):hover' => 'color: {{VALUE}}',
            ],
        ]);
        $this->end_controls_section();

        negarshop_product_card_elementor_options($this);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();
        $settings['banner'] = 'false';
        if (!empty($settings['tabs'])) {
            $tmp = [];
            foreach ($settings['tabs'] as $items) {
                $tmp2 = $items;
                $tmp2['items_type_picker']['products']['products_type_picker']['products_type'] = $items['products_type'];

                $tmp2['items_type_picker']['products']['products_type_picker']['category']['woo_categories'] = $items['woo_categories'];
                $tmp2['items_type_picker']['products']['products_type_picker']['tag']['woo_tags'] = $items['woo_tags'];
                $tmp2['items_type_picker']['products']['products_type_picker']['ids']['product_ids'] = $items['product_ids'];
                $tmp2['items_type_picker']['products']['products_type_picker']['views']['views_time'] = $items['views_time'];
                $tmp2['items_type_picker']['products']['products_type_picker']['sell']['sell_time'] = $items['sell_time'];
                $tmp2['items_type_picker']['products']['products_count'] = $items['products_count'];
                $tmp2['items_type_picker']['items_type'] = $items['items_type'];

                $tmp[] = $tmp2;

            }
            $settings['tabs'] = $tmp;
        }
        negarshop_page_widget_carousel($settings);
    }

}
