<?php

namespace NegarshopElementor\Widgets;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_shop_product_categories extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'negarshop_product_categories';
    }

    public function get_title()
    {
        return 'دسته بندی محصولات';
    }

    public function get_icon()
    {
        return 'eicon-product-categories';
    }

    public function get_categories()
    {
        return ['Negarshop_main'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section('Content_settings', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('displayStyle', [
            'label' => 'استایل کارت',
            'type' => Controls_Manager::SELECT,
            'default' => 'list',
            'options' => [
                'horizontal' => 'کنار هم',
                'vertical' => 'زیر هم',
                'tile' => 'کاشی',
            ],
        ]);

        $this->add_control('termsToShow', [
            'label' => 'نحوه نمایش',
            'type' => Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => [
                'latest' => 'آخرین ها',
                'a-z' => 'ترتیب عنوان',
                'top' => 'تاپ ترین ها',
                'custom' => 'سفارشی',
                'advanced' => 'پیشرفته',
            ],
        ]);

        $this->add_control(
            'onlyParents',
            [
                'label' => 'نمایش والد ها',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'termsToShow' => ['latest', 'a-z', 'top']
                ]
            ]
        );

        if (class_exists('\ElementorPro\Modules\QueryControl\Controls\Group_Control_Query')) {
            $this->add_control('termsSelect', [
                'type' => 'query',
                'multiple' => true,
                'autocomplete' => [
                    'object' => 'tax',
                    'display' => 'detailed',
                    'by_field' => 'term_taxonomy_id',
                    'query' => [
                        'taxonomy' => 'product_cat'
                    ],
                ],
                'condition' => [
                    'termsToShow' => 'custom'
                ]
            ]);
        }


        $this->add_control('termsCount', [
            'label' => 'تعداد',
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 100,
            'step' => 1,
            'default' => 8,
            'condition' => [
                'termsToShow' => ['latest', 'a-z', 'top']
            ]
        ]);

        $slides_repeater = new Repeater();

        $terms_list = get_terms(
            array(
                'taxonomy' => 'product_cat',
                'fields' => 'id=>name',
                'hide_empty' => false,
            )
        );
        $slides_repeater->add_control(
            'term',
            array(
                'label' => 'دسته بندی',
                'type' => Controls_Manager::SELECT,
                'default' => array_key_first($terms_list),
                'options' => $terms_list,
                'label_block' => false,
            )
        );

        $slides_repeater->add_control(
            'custom_link',
            array(
                'label' => 'لینک',
                'type' => Controls_Manager::URL,
                'description' => 'اگر خالی بگذارید از لینک دسته بندی استفاده خواهد شد.',
                'default' => array('url' => ''),
                'options' => array('url'),
                'label_block' => true,
            )
        );

        $slides_repeater->add_control(
            'title',
            array(
                'label' => 'عنوان',
                'type' => Controls_Manager::TEXT,
                'description' => 'اگر خالی بگذارید از عنوان دسته بندی استفاده خواهد شد.',
                'default' => '',
                'label_block' => false,
            )
        );

        $slides_repeater->add_control(
            'sub_title',
            array(
                'label' => 'زیر عنوان',
                'type' => Controls_Manager::TEXT,
                'description' => 'اگر خالی بگذارید تعداد محصولات را نمایش خواهد داد. برای نمایش تعداد از s&#37; میتوانید استفاده نمایید.',
                'default' => '',
                'label_block' => false,
            )
        );

        $slides_repeater->add_control(
            'image',
            array(
                'label' => 'تصویر دلخواه',
                'type' => Controls_Manager::MEDIA,
            )
        );

        $this->add_control(
            'custom_terms',
            array(
                'label' => 'دسته بندی های پیشرفته',
                'type' => Controls_Manager::REPEATER,
                'fields' => $slides_repeater->get_controls(),
                'default' => array(
                    array(),
                ),
                'title_field' => '{{{ title }}}',
                'condition' => array(
                    'termsToShow' => 'advanced',
                ),
            )
        );
        $this->add_control('countPerRow', [
            'label' => 'نمایش در هر سطر',
            'type' => Controls_Manager::SELECT,
            'default' => 'fill',
            'options' => [
                'fill' => 'همه در یک سطر',
                'auto' => 'خودکار',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '6' => '6',
                '12' => '12',
            ],
        ]);
        $this->add_control('responsiveMode', [
            'label' => 'حالت نمایش ریسپانسیو',
            'type' => Controls_Manager::SELECT,
            'default' => 'nowrap',
            'options' => [
                'nowrap' => 'در یک سطر',
                'wrap' => 'زیر هم',
            ],
        ]);
        $this->add_control('responsiveCountPerRow', [
            'label' => 'نمایش در هر سطر ریسپانسیو',
            'type' => Controls_Manager::SELECT,
            'default' => '2',
            'options' => [
                'auto' => 'خودکار',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '6' => '6',
                '12' => '12',
            ],
        ]);
        $this->end_controls_section();
        $this->start_controls_section('category_item_image_settings', [
            'label' => 'تصویر دسته بندی',
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => array(
                'displayStyle!' => 'tile',
            ),
        ]);

        $this->add_responsive_control(
            'card_image_width',
            [
                'label' => 'اندازه تصویر',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-card:not(.category-card--tile) img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'image_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card:not(.category-card--tile) img',
            ]
        );
        $this->add_responsive_control(
            'category_item_image_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:not(.category-card--tile) img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_img_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:not(.category-card--tile) img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section('category_item_settings', [
            'label' => 'آیتم دسته بندی',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->start_controls_tabs(
            'style_category_item_tabs'
        );
        $this->start_controls_tab(
            'style_category_item_section_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'card_tile_mode_overlay',
            [
                'label' => 'رنگ روکش',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-card--tile::before' => 'background-color: {{VALUE}} !important'
                ],

                'condition' => array(
                    'displayStyle' => 'tile',
                ),
            ]
        );

        $this->add_control(
            'card_title_popover',
            [
                'label' => 'عنوان دسته بندی',
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => 'پیشفرض',
                'label_on' => 'سفارشی',
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->start_popover();
        $this->add_control(
            'card_title_text_color',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-title' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_responsive_control(
            'card_title_text_size',
            [
                'label' => 'سایز متن',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_title_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card .card-title',
            ]
        );

        $this->add_responsive_control(
            'card_title_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'card_title_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_title_border',
                'selector' => '{{WRAPPER}} .category-card .card-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_title_shadow',
                'selector' => '{{WRAPPER}} .category-card .card-title',
            ]
        );
        $this->end_popover();

        $this->add_control(
            'card_subtitle_popover',
            [
                'label' => 'تعداد محصولات',
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => 'پیشفرض',
                'label_on' => 'سفارشی',
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->start_popover();
        $this->add_control(
            'card_subtitle_inline',
            [
                'label' => 'در یک سطر',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'card_subtitle_text_color',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-subtitle' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_responsive_control(
            'card_subtitle_text_size',
            [
                'label' => 'سایز متن',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-subtitle' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_subtitle_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card .card-subtitle',
            ]
        );
        $this->add_control(
            'card_subtitle_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'card_subtitle_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card .card-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_subtitle_border',
                'selector' => '{{WRAPPER}} .category-card .card-subtitle',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_subtitle_shadow',
                'selector' => '{{WRAPPER}} .category-card .card-subtitle',
            ]
        );
        $this->end_popover();
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'category_item_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card',
            ]
        );
        $this->add_responsive_control(
            'category_item_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .category-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'category_item_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .category-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'category_item_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'category_item_border',
                'selector' => '{{WRAPPER}} .category-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_item_box_shadow',
                'selector' => '{{WRAPPER}} .category-card',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_category_item_section_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'card_tile_mode_overlay_hover',
            [
                'label' => 'رنگ روکش',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-card--tile:hover::before' => 'background-color: {{VALUE}} !important'
                ],

                'condition' => array(
                    'displayStyle' => 'tile',
                ),
            ]
        );

        $this->add_control(
            'card_title_popover_hover',
            [
                'label' => 'عنوان دسته بندی',
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => 'پیشفرض',
                'label_on' => 'سفارشی',
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->start_popover();
        $this->add_control(
            'card_title_text_color_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover .card-title' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_responsive_control(
            'card_title_text_size_hover',
            [
                'label' => 'سایز متن',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover .card-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_title_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card:hover .card-title',
            ]
        );
        $this->add_control(
            'card_title_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover .card-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_title_border_hover',
                'selector' => '{{WRAPPER}} .category-card:hover .card-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_title_shadow_hover',
                'selector' => '{{WRAPPER}} .category-card:hover .card-title',
            ]
        );
        $this->end_popover();

        $this->add_control(
            'card_subtitle_popover_hover',
            [
                'label' => 'تعداد محصولات',
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => 'پیشفرض',
                'label_on' => 'سفارشی',
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->start_popover();
        $this->add_control(
            'card_subtitle_text_color_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover .card-subtitle' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_responsive_control(
            'card_subtitle_text_size_hover',
            [
                'label' => 'سایز متن',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover .card-subtitle' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_subtitle_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card:hover .card-subtitle',
            ]
        );
        $this->add_control(
            'card_subtitle_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover .card-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_subtitle_border_hover',
                'selector' => '{{WRAPPER}} .category-card:hover .card-subtitle',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_subtitle_shadow_hover',
                'selector' => '{{WRAPPER}} .category-card:hover .card-subtitle',
            ]
        );
        $this->end_popover();
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'category_item_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category-card:hover',
            ]
        );
        $this->add_responsive_control(
            'category_item_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'category_item_margin_hover',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'category_item_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category-card:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'category_item_border_hover',
                'selector' => '{{WRAPPER}} .category-card:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_item_box_shadow_hover',
                'selector' => '{{WRAPPER}} .category-card:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();

        $termArgs = [
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'number' => $settings['termsCount']
        ];

        if ($settings['termsToShow'] === 'latest') {
            $termArgs['orderby'] = 'id';
            $termArgs['order'] = 'DESC';
        }

        if ($settings['termsToShow'] === 'top') {
            $termArgs['orderby'] = 'count';
            $termArgs['order'] = 'DESC';
        }

        if ($settings['termsToShow'] === 'a-z') {
            $termArgs['orderby'] = 'name';
            $termArgs['order'] = 'ASC';
        }

        if ($settings['termsToShow'] !== 'custom' && $settings['onlyParents'] === 'yes') {
            $termArgs['parent'] = 0;
        }

        if ($settings['termsToShow'] === 'custom') {
            $termArgs['orderby'] = 'id';
            $termArgs['order'] = 'DESC';
        }

        if (class_exists('\ElementorPro\Modules\QueryControl\Controls\Group_Control_Query') && $settings['termsToShow'] === 'custom' && !empty($settings['termsSelect'])) {
            $termArgs['include'] = $settings['termsSelect'];
        }

        if ($settings['termsToShow'] === 'custom') {
            $categories = $settings['termsSelect'];
        } else {
            $categories = get_terms($termArgs);
        }

        if (empty($categories)) {
            return;
        }


        $colClass = "col-lg";
        if ($settings['countPerRow'] === 'auto') {
            $colClass .= '-auto';
        } else if (is_numeric($settings['countPerRow'])) {
            $colClass .= '-' . (12 / $settings['countPerRow']);
        }


        $cardStyle = 'category-card--' . $settings['displayStyle'];
        $rowClass = $settings['responsiveMode'] === 'nowrap' ? 'flex-nowrap flex-lg-wrap overflow-auto' : '';

        if ($settings['responsiveCountPerRow'] === 'auto') {
            $colClass = 'col-auto ' . $colClass;
        } else if (is_numeric($settings['responsiveCountPerRow'])) {
            $colClass = 'col-' . (12 / $settings['responsiveCountPerRow']) . ' ' . $colClass;
        }

        $termsList = [];

        if ('advanced' === $settings['termsToShow']) {
            if (!empty($settings['custom_terms'])) {
                foreach ($settings['custom_terms'] as $item) {
                    if (empty($item)) {
                        continue;
                    }

                    $term = get_term($item['term']);

                    if (empty($term) || is_wp_error($term)) {
                        continue;
                    }

                    if (!empty($item['image']) && !empty($item['image']['id'])) {
                        $image_id = $item['image']['id'];
                    } else {
                        $image_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    }

                    $termsList[] = array(
                        'id' => $term->term_id,
                        'name' => empty($item['title']) ? $term->name : $item['title'],
                        'link' => empty($item['custom_link']['url']) ? get_term_link($term->term_id, $term->taxonomy) : $item['custom_link']['url'],
                        'sub-title' => empty($item['sub_title']) ? '+%s' : $item['sub_title'],
                        'count' => $term->count,
                        'thumb' => !empty($image_id) ? wp_get_attachment_image((int)$image_id, 'full') : '',
                    );
                }
            }

        } else {
            foreach ($categories as $category) {
                if (!is_object($category)) {
                    $category = get_term($category);
                }
                if (is_wp_error($category)) {
                    continue;
                }
                if (is_wp_error(get_term_link($category))) {
                    continue;
                }
                $thumb = get_term_meta($category->term_id, 'thumbnail_id', true);

                $termsList[] = [
                    'id' => $category->term_id,
                    'name' => $category->name,
                    'sub-title' => sprintf(__('+%s محصول', 'negarshop'), $category->count),
                    'link' => get_term_link($category),
                    'count' => $category->count,
                    'thumb' => !empty($thumb) ? wp_get_attachment_image((int)$thumb, 'full') : ''
                ];
            }
        }

        printf('<div class="row %s">', $rowClass);

        foreach ($termsList as $term) {
            printf('<div class="%s mb-3">', $colClass);
            printf('<a href="%s" class="category-card %s">', $term['link'], $cardStyle);
            echo $term['thumb'];
            printf('<div class="card-inner %s">', $settings['card_subtitle_inline'] === 'yes' ? 'inline-content' : '');
            printf('<h4 class="card-title">%s</h4>', $term['name']);
            printf('<div class="card-subtitle">%s</div>', str_replace('%s', $term['count'], $term['sub-title']));
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    }

}
