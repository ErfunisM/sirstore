<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_header_account_Widget extends \Elementor\Widget_Base
{

    public function get_name() {
        return 'negarshop_header_account';
    }

    public function get_title() {
        return 'حساب کاربری';
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['Negarshop_header'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'settings_section',
            [
                'label' => 'تنظیمات',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_account_title',
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
            'account_title',
            [
                'label' => 'متن عنوان',
                'type' => Controls_Manager::TEXT,
                'default' => 'حساب کاربری',
                'condition' => [
                    'show_account_title' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'show_account_sub_title',
            [
                'label' => 'نمایش متن خوش آمد',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_account_icon',
            [
                'label' => 'نمایش نماد',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'account_icon_align',
            [
                'label' => 'جهت آیکن',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'row-reverse',
                'options' => [
                    'row-reverse' => 'چپ',
                    'row' => 'راست',
                ],
                'condition' => [
                    'show_account_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .box-inner' => 'flex-direction: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'account_icon',
            [
                'label' => 'نماد',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-user',
                    'library' => 'solid',
                ],
                'condition' => [
                    'show_account_icon' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'show_account_avatar',
            [
                'label' => 'نمایش عکس پروفایل',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_account_icon' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'show_account_items',
            [
                'label' => 'نمایش منوی لینک ها',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'account_items_align',
            [
                'label' => 'جهت منوی باز شونده',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'to-left',
                'options' => [
                    'to-left' => 'چپ',
                    'to-right' => 'راست',
                ],
                'condition' => [
                    'show_account_items' => 'yes',
                ]
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'title', [
                'label' => 'نام',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link', [
                'label' => 'لینک',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'member_items',
            [
                'label' => 'منو های مهمان',
                'description' => 'این موارد فقط برای مهمان ها نمایش داده میشود!',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'prevent_empty' => false,
                'title_field' => '{{{ title }}}',
                'condition' => [
                    'show_account_items' => 'yes',
                ],
            ]
        );
        $repeater2 = new \Elementor\Repeater();
        $repeater2->add_control(
            'title', [
                'label' => 'نام',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater2->add_control(
            'link', [
                'label' => 'لینک',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater2->add_control(
            'roles',
            [
                'label' => 'نمایش برای',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'user' => 'کاربر عادی',
                    'vendor' => 'فروشنده',
                    'all' => 'هر دو',
                ],
            ]
        );
        $this->add_control(
            'user_items',
            [
                'label' => 'منو های کاربران',
                'description' => 'این موارد فقط برای کاربران نمایش داده میشود!',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater2->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
                'prevent_empty' => false,
                'condition' => [
                    'show_account_items' => 'yes',
                ],
            ]
        );
        $this->end_controls_section(); // End of settings_section

        $this->start_controls_section(
            'style_account_icon_section',
            [
                'label' => 'نمادک',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_account_icon' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'account_icon_height',
            [
                'label' => 'عرض',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .icon' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'account_icon_width',
            [
                'label' => 'طول',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .icon' => 'width: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'account_icon_typography',
                'selector' => '{{WRAPPER}} .header-account .account-box .icon',
            ]
        );
        $this->add_control(
            'account_icon_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_account_icon_tabs'
        );
        $this->start_controls_tab(
            'style_account_icon_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'account_icon_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .icon' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_icon_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box .icon',
            ]
        );
        $this->add_control(
            'account_icon_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_icon_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_icon_border',
                'selector' => '{{WRAPPER}} .header-account .account-box .icon',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_account_icon_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'account_icon_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .icon' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_icon_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box:hover .icon',
            ]
        );
        $this->add_control(
            'account_icon_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_icon_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_icon_border_hover',
                'selector' => '{{WRAPPER}} .header-account .account-box:hover .icon',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_account_icon_section


        $this->start_controls_section(
            'style_account_title_section',
            [
                'label' => 'عنوان',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_account_title' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'account_title_typography',
                'selector' => '{{WRAPPER}} .header-account .account-box .title',
            ]
        );
        $this->start_controls_tabs(
            'style_account_title_tabs'
        );
        $this->start_controls_tab(
            'style_account_title_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'account_title_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .title' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_title_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box .title',
            ]
        );
        $this->add_control(
            'account_title_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_title_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_title_border',
                'selector' => '{{WRAPPER}} .header-account .account-box .title',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_account_title_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'account_title_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .title' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_title_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box:hover .title',
            ]
        );
        $this->add_control(
            'account_title_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_title_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_title_border_hover',
                'selector' => '{{WRAPPER}} .header-account .account-box:hover .title',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_account_title_section


        $this->start_controls_section(
            'style_account_sub_title_section',
            [
                'label' => 'پیام خوش آمد',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_account_sub_title' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'account_sub_title_typography',
                'selector' => '{{WRAPPER}} .header-account .account-box .subtitle',
            ]
        );
        $this->start_controls_tabs(
            'style_account_sub_title_tabs'
        );
        $this->start_controls_tab(
            'style_account_sub_title_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'account_sub_title_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .subtitle' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_sub_title_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box .subtitle',
            ]
        );
        $this->add_control(
            'account_sub_title_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_sub_title_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_sub_title_border',
                'selector' => '{{WRAPPER}} .header-account .account-box .subtitle',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_account_sub_title_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'account_sub_title_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .subtitle' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_sub_title_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box:hover .subtitle',
            ]
        );
        $this->add_control(
            'account_sub_title_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_sub_title_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box:hover .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_sub_title_border_hover',
                'selector' => '{{WRAPPER}} .header-account .account-box:hover .subtitle',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_account_sub_title_section


        $this->start_controls_section(
            'style_account_items_box_section',
            [
                'label' => 'جعبه لینک ها',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_account_items' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_items_box_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links',
            ]
        );
        $this->add_control(
            'account_items_box_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_items_box_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_items_box_border',
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'account_items_box_shadow',
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links',
            ]
        );
        $this->end_controls_section(); // End of style_account_items_box_section

        $this->start_controls_section(
            'style_account_items_section',
            [
                'label' => 'لینک ها',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_account_items' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'account_items_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'account_items_typography',
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links > li a',
            ]
        );
        $this->start_controls_tabs(
            'style_account_items_tabs'
        );
        $this->start_controls_tab(
            'style_account_items_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'account_items_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li a' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_items_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links > li a',
            ]
        );
        $this->add_control(
            'account_items_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_items_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_items_border',
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links > li a',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_account_items_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'account_items_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li a:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'account_items_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links > li a:hover',
            ]
        );
        $this->add_control(
            'account_items_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'account_items_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-account .account-box .account-links > li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'account_items_border_hover',
                'selector' => '{{WRAPPER}} .header-account .account-box .account-links > li a:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_account_items_section
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();

        negarshop_header_account($settings);
    }

}
