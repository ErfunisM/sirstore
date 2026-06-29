<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_header_basket_Widget extends \Elementor\Widget_Base
{

    public function get_name() {
        return 'negarshop_header_basket';
    }

    public function get_title() {
        return 'سبد خرید';
    }

    public function get_icon() {
        return 'eicon-cart';
    }

    public function get_categories() {
        return ['Negarshop_header'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'settings_section',
            [
                'label' => 'تنظیمات',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'cart_mode',
            [
                'label' => 'سبک سبد خرید',
                'type' => Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'hover' => 'زیر منو',
                    'popup' => 'پاپ آپ'
                ],
            ]
        );
        $this->add_control(
            'cart_auto_show',
            [
                'label' => 'باز شدن خودکار',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'فعال',
                'label_off' => 'غیرفعال',
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'cart_mode' => 'popup'
                ]
            ]
        );
        $this->add_control(
            'cart_items_align',
            [
                'label' => 'جهت نمایش موارد سبد خرید',
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => 'راست',
                    'left' => 'چپ',
                ]
            ]
        );
        $this->add_control(
            'show_cart_icon',
            [
                'label' => 'آیکن',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'display: flex;'
                ]
            ]
        );
        $this->add_control(
            'cart_icon',
            [
                'label' => 'آیکن',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-shopping-cart',
                    'library' => 'solid',
                ],
                'condition' => [
                    'show_cart_icon' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_align',
            [
                'label' => 'جهت آیکن',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'row',
                'options' => [
                    'row-reverse' => 'چپ',
                    'row' => 'راست',
                ],
                'condition' => [
                    'show_cart_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box' => 'flex-direction: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'show_cart_title',
            [
                'label' => 'عنوان',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title' => 'display: block;'
                ]
            ]
        );
        $this->add_control(
            'cart_title',
            [
                'label' => 'متن عنوان',
                'type' => Controls_Manager::TEXT,
                'default' => 'سبد خرید',
                'condition' => [
                    'show_cart_title' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'cart_title_align',
            [
                'label' => 'جهت عنوان',
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
                'condition' => [
                    'show_cart_title' => 'yes',
                ],
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'show_cart_sub_title',
            [
                'label' => 'جمع کل',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle' => 'display: block;'
                ]
            ]
        );
        $this->add_control(
            'cart_sub_title_align',
            [
                'label' => 'جهت جمع کل',
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
                'condition' => [
                    'show_cart_sub_title' => 'yes',
                ],
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'show_cart_title_outer',
            [
                'label' => 'Hidden',
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'css',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title-outer' => 'display: none !important;'
                ],
                'condition' => [
                    'show_cart_title!' => 'yes',
                    'show_cart_sub_title!' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'show_cart_count',
            [
                'label' => 'تعداد',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => 'display: block;'
                ]
            ]
        );
        $this->add_control(
            'cart_count_absolute',
            [
                'label' => 'حالت معلق تعداد',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'فعال',
                'label_off' => 'غیرفعال',
                'return_value' => 'yes',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => 'position: absolute; top: -10px;'
                ],
                'condition' => [
                    'show_cart_count' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'cart_count_align',
            [
                'label' => 'جهت تعداد',
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => 'راست',
                        'icon' => 'eicon-h-align-right',
                    ],
                    'left' => [
                        'title' => 'چپ',
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'condition' => [
                    'show_cart_count' => 'yes',
                    'cart_count_absolute' => 'yes',
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => '{{VALUE}}: 0;',
                ],
            ]
        );
        $this->end_controls_section(); // End of settings_section


        $this->start_controls_section(
            'style_cart_box_section',
            [
                'label' => 'جعبه',
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs(
            'style_cart_box_tabs'
        );
        $this->start_controls_tab(
            'style_cart_box_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_box_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box',
            ]
        );
        $this->add_control(
            'cart_box_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_box_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_box_border',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_box_shadow',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_cart_box_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_box_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover',
            ]
        );
        $this->add_control(
            'cart_box_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_box_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_box_border_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_box_shadow_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_cart_box_section


        $this->start_controls_section(
            'style_cart_icon_section',
            [
                'label' => 'آیکن',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart_icon' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_height',
            [
                'label' => 'عرض',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_width',
            [
                'label' => 'طول',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'width: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cart_icon_typography',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon',
            ]
        );
        $this->add_control(
            'cart_icon_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_cart_icon_tabs'
        );
        $this->start_controls_tab(
            'style_cart_icon_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'cart_icon_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_icon_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon',
            ]
        );
        $this->add_control(
            'cart_icon_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_icon_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_icon_border',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_icon_shadow',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .icon',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_cart_icon_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'cart_icon_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .icon' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_icon_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .icon',
            ]
        );
        $this->add_control(
            'cart_icon_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_icon_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_icon_border_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .icon',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_icon_shadow_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .icon',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_cart_icon_section


        $this->start_controls_section(
            'style_cart_title_section',
            [
                'label' => 'عنوان',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart_title' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cart_title_typography',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .title',
            ]
        );
        $this->add_control(
            'cart_title_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_cart_title_tabs'
        );
        $this->start_controls_tab(
            'style_cart_title_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'cart_title_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_title_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .title',
            ]
        );
        $this->add_control(
            'cart_title_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_title_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_title_border',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_title_shadow',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .title',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_cart_title_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'cart_title_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .title' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_title_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .title',
            ]
        );
        $this->add_control(
            'cart_title_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_title_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_title_border_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_title_shadow_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .title',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_cart_title_section


        $this->start_controls_section(
            'style_cart_sub_title_section',
            [
                'label' => 'جمع کل',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart_sub_title' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cart_sub_title_typography',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle',
            ]
        );
        $this->add_control(
            'cart_sub_title_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_cart_sub_title_tabs'
        );
        $this->start_controls_tab(
            'style_cart_sub_title_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'cart_sub_title_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_sub_title_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle',
            ]
        );
        $this->add_control(
            'cart_sub_title_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_sub_title_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_sub_title_border',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_sub_title_shadow',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .subtitle',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_cart_sub_title_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'cart_sub_title_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .subtitle' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_sub_title_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .subtitle',
            ]
        );
        $this->add_control(
            'cart_sub_title_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_sub_title_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_sub_title_border_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .subtitle',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_sub_title_shadow_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .subtitle',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_cart_sub_title_section


        $this->start_controls_section(
            'style_cart_count_section',
            [
                'label' => 'تعداد',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart_count' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cart_count_typography',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .count',
            ]
        );
        $this->add_control(
            'cart_count_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_cart_count_tabs'
        );
        $this->start_controls_tab(
            'style_cart_count_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'cart_count_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_count_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .count',
            ]
        );
        $this->add_control(
            'cart_count_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_count_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box .count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_count_border',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .count',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_count_shadow',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box .count',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_cart_count_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'cart_count_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .count' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_count_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .count',
            ]
        );
        $this->add_control(
            'cart_count_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_count_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_count_border_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .count',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_count_shadow_hover',
                'selector' => '{{WRAPPER}} .header-cart-basket .cart-basket-box:hover .count',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_cart_count_section

        $this->start_controls_section(
            'style_cart_items_box_section',
            [
                'label' => 'جعبه آیتم ها',
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_items_box_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart',
            ]
        );
        $this->add_control(
            'cart_items_box_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_items_box_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'cart_items_border_radius',
            [
                'label' => 'گردی محتوا',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart ul li a.remove' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart .buttons .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart ul li img.wp-post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_items_box_border',
                'selector' => '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cart_items_box_shadow',
                'selector' => '{{WRAPPER}} .header-cart-basket > .widget.widget_shopping_cart',
            ]
        );
        $this->end_controls_section(); // End of style_cart_items_box_section
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();

        negarshop_header_basket($settings);
    }

}
