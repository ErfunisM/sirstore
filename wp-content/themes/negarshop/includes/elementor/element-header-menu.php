<?php
/**
 * Header menu elementor widget.
 *
 * @package negarshop
 */

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_header_menu_Widget extends \Elementor\Widget_Base
{

    public function get_name(): string
    {
        return 'negarshop_header_menu';
    }

    public function get_title(): string
    {
        return 'منوی اصلی';
    }

    public function get_icon(): string
    {
        return 'eicon-nav-menu';
    }

    public function get_categories(): array
    {
        return ['Negarshop_header'];
    }

    protected function _register_controls()
    {
        $menus = negarshop_get_nav_menus_array();
        $this->start_controls_section(
            'settings_section',
            [
                'label' => 'تنظیمات',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'menu_source',
            [
                'label' => 'انتخاب منو',
                'type' => Controls_Manager::SELECT,
                'default' => empty($menus) ? false : array_keys($menus)[0],
                'options' => $menus
            ]
        );

        $this->add_control(
            'menu_type',
            [
                'label' => 'نوع منو',
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => 'کنار هم',
                    'dropdown-show' => 'زیر هم',
                    'dropdown' => 'باز شونده',
                    'sidebar' => 'سایدبار',
                    'ubermenu' => 'اوبر منو',
                ],
            ]
        );
        $this->add_control(
            'hide_in_homepage',
            [
                'label' => 'مخفی کردن در صفحه نخست',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'menu_type' => 'dropdown',
                ],
            ]
        );
        $this->add_control(
            'show_menu_title',
            [
                'label' => 'نمایش متن',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'menu_title',
            [
                'label' => 'متن منو',
                'type' => Controls_Manager::TEXT,
                'default' => 'دسته بندی ها',
                'condition' => [
                    'menu_type' => ['dropdown', 'sidebar'],
                    'show_menu_title' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'menu_icon',
            [
                'label' => 'نماد',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-bars',
                    'library' => 'solid',
                ],
                'condition' => [
                    'menu_type' => ['dropdown', 'sidebar'],
                ],
            ]
        );

        $this->add_control(
            'sidebar_align',
            [
                'label' => 'جهت منو',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => 'راست',
                    'left' => 'چپ',
                ],
                'condition' => [
                    'menu_type' => 'sidebar',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'style_menu_dropdown_section',
            [
                'label' => 'دکمه نمایش منو',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type' => ['dropdown', 'sidebar'],
                ],
            ]
        ); // Style dropdown button.

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_dropdown_typography',
                'selector' => '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle, {{WRAPPER}} .responsive-menu .toggle-menu',
            ]
        );
        $this->start_controls_tabs(
            'style_menu_dropdown_tabs'
        );
        $this->start_controls_tab(
            'style_menu_dropdown_section_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'menu_dropdown_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .toggle-menu' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_dropdown_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle, {{WRAPPER}} .responsive-menu .toggle-menu',
            ]
        );
        $this->add_control(
            'menu_dropdown_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .toggle-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_dropdown_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .toggle-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_dropdown_border',
                'selector' => '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle, {{WRAPPER}} .responsive-menu .toggle-menu',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_menu_dropdown_section_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'menu_dropdown_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .toggle-menu:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_dropdown_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle:hover, {{WRAPPER}} .responsive-menu .toggle-menu:hover',
            ]
        );
        $this->add_control(
            'menu_dropdown_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .toggle-menu:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_dropdown_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .toggle-menu:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_dropdown_border_hover',
                'selector' => '{{WRAPPER}} .header-main-menu.vertical-menu button.vertical-menu-toggle:hover, {{WRAPPER}} .responsive-menu .toggle-menu:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'style_menu_section',
            [
                'label' => 'جعبه ردیف اول',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type!' => 'ubermenu',
                ],
            ]
        ); // Style menu first row.
        $this->add_control(
            'menu_align',
            [
                'label' => 'چینش منو',
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => 'چپ',
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => 'وسط',
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => 'راست',
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu ul.main-menu' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li a' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav.header_menu_type_normal, {{WRAPPER}} .header-main-nav.header_menu_type_dropdown .header-main-menu.vertical-menu ul.main-menu, {{WRAPPER}} .header-main-nav.header_menu_type_dropdown-show .header-main-menu.vertical-menu ul.main-menu, {{WRAPPER}} .responsive-menu .menu-popup',
            ]
        );
        $this->add_control(
            'menu_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav.header_menu_type_normal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-main-nav.header_menu_type_dropdown .header-main-menu.vertical-menu ul.main-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-main-nav.header_menu_type_dropdown-show .header-main-menu.vertical-menu ul.main-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav.header_menu_type_normal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-main-nav.header_menu_type_dropdown .header-main-menu.vertical-menu ul.main-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .header-main-nav.header_menu_type_dropdown-show .header-main-menu.vertical-menu ul.main-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_border',
                'selector' => '{{WRAPPER}} .header-main-nav.header_menu_type_normal, {{WRAPPER}} .header-main-nav.header_menu_type_dropdown .header-main-menu.vertical-menu ul.main-menu, {{WRAPPER}} .header-main-nav.header_menu_type_dropdown-show .header-main-menu.vertical-menu ul.main-menu, {{WRAPPER}} .responsive-menu .menu-popup',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_menu_item_section',
            [
                'label' => 'ردیف اول',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type!' => 'ubermenu',
                ],
            ]
        );

        $this->add_control(
            'menu_item_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_item_typography',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li a',
            ]
        );
        $this->start_controls_tabs(
            'style_menu_item_tabs'
        );
        $this->start_controls_tab(
            'style_menu_item_section_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'menu_item_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.loading > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.loaded > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} li > a.loading::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul span.toggle' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_item_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li a',
            ]
        );
        $this->add_control(
            'menu_item_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_item_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul span.toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_item_border',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'menu_item_shadow',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_menu_item_section_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'menu_item_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.loading:hover > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.loaded:hover > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} li:hover > a.loading::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>span.toggle' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_item_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li:hover > a,{{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>a',
            ]
        );
        $this->add_control(
            'menu_item_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li:hover > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_item_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li:hover > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>span.toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_item_border_hover',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li:hover > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'menu_item_shadow_hover',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li:hover > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li:hover>a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_menu_item_section_active',
            [
                'label' => 'فعال',
            ]
        );

        $this->add_control(
            'menu_item_text_active',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item.loading > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item.loaded > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} li.current-menu-item > a.loading::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_item_background_active',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>a',
            ]
        );
        $this->add_control(
            'menu_item_padding_active',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_item_border_radius_active',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>span.toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_item_border_active',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'menu_item_shadow_active',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu > ul > li.current-menu-item > a, {{WRAPPER}} .responsive-menu .menu-popup nav ul li.current-menu-item>a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'style_menu_child_section',
            [
                'label' => 'جعبه ردیف دوم',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type!' => 'ubermenu',
                ],
            ]
        ); // Child item box section

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_child_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul',
            ]
        );
        $this->add_control(
            'menu_child_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_child_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_child_border',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'menu_child_box_shadow',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul',
            ]
        );

        $this->end_controls_section();// End of child item box section

        $this->start_controls_section(
            'style_menu_child_item_section',
            [
                'label' => 'ردیف دوم',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type!' => 'ubermenu',
                ],
            ]
        );

        $this->add_control(
            'menu_child_item_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_child_item_typography',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li a',
            ]
        );
        $this->start_controls_tabs(
            'style_menu_child_item_tabs'
        );
        $this->start_controls_tab(
            'style_menu_child_item_section_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'menu_child_item_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.menu-item-has-children > a::after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.loading > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.loaded > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li > a.loading::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_child_item_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li a',
            ]
        );
        $this->add_control(
            'menu_child_item_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_child_item_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_child_item_border',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_menu_child_item_section_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'menu_child_item_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.menu-item-has-children:hover > a::after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.loading:hover > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.loaded:hover > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li:hover > a.loading::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li:hover > a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_child_item_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li:hover > a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li:hover > a',
            ]
        );
        $this->add_control(
            'menu_child_item_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li:hover > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li:hover > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_child_item_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li:hover > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li:hover > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_child_item_border_hover',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li:hover > a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li:hover > a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_menu_child_item_section_active',
            [
                'label' => 'فعال',
            ]
        );

        $this->add_control(
            'menu_child_item_text_active',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.menu-item-has-children.current-menu-item > a::after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item.loading > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item.loaded > a::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item > a.loading::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li.current-menu-item > a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_child_item_background_active',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item > a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li.current-menu-item > a',
            ]
        );
        $this->add_control(
            'menu_child_item_padding_active',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li.current-menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_child_item_border_radius_active',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-menu .menu-popup nav li > ul li.current-menu-item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_child_item_border_active',
                'selector' => '{{WRAPPER}} .header-main-nav .header-main-menu li > ul li.current-menu-item > a, {{WRAPPER}} .responsive-menu .menu-popup nav li > ul li.current-menu-item > a',
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
        if (wp_get_nav_menu_items($settings['menu_source']) === false) {
            printf('<div class="no-menu-set">%s</div>', __('لطفا منوی خود را از طریق المنتور تنظیم نمایید.', 'negarshop'));
        } else {
            negarshop_header_menu($settings);
        }
    }

}
