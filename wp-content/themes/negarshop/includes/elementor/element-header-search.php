<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_header_search_Widget extends \Elementor\Widget_Base
{

    public function get_name(): string
    {
        return 'negarshop_header_search';
    }

    public function get_title(): string
    {
        return 'جستجوی پیشرفته';
    }

    public function get_icon(): string
    {
        return 'eicon-site-search';
    }

    public function get_categories(): array
    {
        return ['Negarshop_header'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'settings_section',
            [
                'label' => 'تنظیمات',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'search_type',
            [
                'label' => 'نوع ابزارک جستجو',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => 'ساده',
                    'popup' => 'پاپ آپ',
                ],
            ]
        );

        $this->add_control(
            'show_search_title',
            [
                'label' => 'نمایش متن',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'search_type' => 'popup',
                ],
            ]
        );

        $this->add_control(
            'search_overlay',
            [
                'label' => 'نمایش پس زمینه حالت خیره',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'نمایش',
                'label_off' => 'مخفی',
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'search_type' => 'normal',
                ],
            ]
        );
        $this->add_control(
            'search_title',
            [
                'label' => 'متن دکمه',
                'type' => Controls_Manager::TEXT,
                'default' => 'جستجو',
                'condition' => [
                    'show_search_title' => 'yes',
                    'search_type' => 'popup',
                ],
            ]
        );
        $this->add_control(
            'search_icon',
            [
                'label' => 'نماد',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-search',
                    'library' => 'solid',
                ],
                'condition' => [
                    'search_type' => 'popup',
                ],
            ]
        );
        $this->add_control(
            'search_ajax',
            [
                'label' => 'جستجوی آژاکس',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => 'فعال',
                    'false' => 'غیرفعال',
                ],
            ]
        );
        $this->add_control(
            'search_placeholder',
            [
                'label' => 'متن جستجو',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'جستجو در محصولات ...',
            ]
        );
        $this->add_control(
            'search_post_type',
            [
                'label' => 'جستجو در',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'product',
                'options' => [
                    'product' => 'محصولات',
                    'post' => 'مقالات',
                ],
            ]
        );
        $this->add_control(
            'search_filters',
            [
                'label' => 'فیلتر های جستجو',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => 'فعال',
                    'false' => 'غیرفعال',
                ],
            ]
        );

        $this->add_control(
            'search_button_title',
            [
                'label' => 'متن دکمه',
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        $this->add_control(
            'search_button_icon',
            [
                'label' => 'آیکن دکمه',
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'solid',
                ],
                'skin' => 'inline',
                'exclude_inline_options' => 'svg'
            ]
        );
        $this->end_controls_section(); // End of settings_section


        $this->start_controls_section(
            'style_search_toggle_section',
            [
                'label' => 'دکمه نمایش جستجو',
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_type' => 'popup',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'search_toggle_typography',
                'selector' => '{{WRAPPER}} .header-search .header-search-pup',
            ]
        );
        $this->start_controls_tabs(
            'style_search_toggle_tabs'
        );
        $this->start_controls_tab(
            'style_search_toggle_section_normal',
            [
                'label' => 'عادی',
            ]
        );

        $this->add_control(
            'search_toggle_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .header-search-pup' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_toggle_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .header-search-pup',
            ]
        );
        $this->add_control(
            'search_toggle_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .header-search-pup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_toggle_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .header-search-pup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_toggle_border',
                'selector' => '{{WRAPPER}} .header-search .header-search-pup',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_search_toggle_section_hover',
            [
                'label' => 'اشاره',
            ]
        );

        $this->add_control(
            'search_toggle_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .header-search-pup:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_toggle_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .header-search-pup:hover',
            ]
        );
        $this->add_control(
            'search_toggle_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .header-search-pup:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_toggle_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .header-search-pup:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_toggle_border_hover',
                'selector' => '{{WRAPPER}} .header-search .header-search-pup:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_search_toggle_section


        $this->start_controls_section(
            'style_box_section',
            [
                'label' => 'جعبه',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_box_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields',
            ]
        );
        $this->add_control(
            'search_box_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_box_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_box_border',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'search_box_shadow',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields',
            ]
        );
        $this->end_controls_section(); // End of style_box_section


        $this->start_controls_section(
            'style_search_field_section',
            [
                'label' => 'فیلد جستجو',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'search_field_height',
            [
                'label' => 'عرض',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'search_field_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'search_field_typography',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input',
            ]
        );
        $this->start_controls_tabs(
            'style_search_field_tabs'
        );
        $this->start_controls_tab(
            'style_search_field_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'search_field_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .header-search .search-box .search-form-fields ::placeholder' => 'color: {{VALUE}}; opacity: 1;',
                    '{{WRAPPER}} .header-search .search-box .search-form-fields ::-ms-input-placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_field_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input',
            ]
        );
        $this->add_control(
            'search_field_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'search_field_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_field_border',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_search_field_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'search_field_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_field_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:hover',
            ]
        );
        $this->add_control(
            'search_field_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_field_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_field_border_hover',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:hover',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_search_field_section_focus',
            [
                'label' => 'فوکوس',
            ]
        );
        $this->add_control(
            'search_field_text_focus',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:focus' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_field_background_focus',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:focus',
            ]
        );
        $this->add_control(
            'search_field_padding_focus',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:focus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_field_border_radius_focus',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_field_border_focus',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-input:focus',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_search_field_section


        $this->start_controls_section(
            'style_search_filter_section',
            [
                'label' => 'دکمه فیلتر',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_filters' => 'true',
                ],
            ]
        );
        $this->add_control(
            'search_filter_height',
            [
                'label' => 'عرض',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'search_filter_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'search_filter_typography',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters',
            ]
        );
        $this->start_controls_tabs(
            'style_search_filter_tabs'
        );
        $this->start_controls_tab(
            'style_search_filter_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'search_filter_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_filter_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters',
            ]
        );
        $this->add_control(
            'search_filter_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'search_filter_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_filter_border',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_search_filter_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'search_filter_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_filter_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters:hover',
            ]
        );
        $this->add_control(
            'search_filter_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_filter_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_filter_border_hover',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-filters:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_search_filter_section

        $this->start_controls_section(
            'style_search_submit_section',
            [
                'label' => 'دکمه جستجو',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'search_submit_height',
            [
                'label' => 'عرض',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit' => 'height: {{VALUE}}px;',
                ],
            ]
        );
        $this->add_control(
            'search_submit_margin',
            [
                'label' => 'فاصله بیرونی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'search_submit_typography',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit',
            ]
        );
        $this->start_controls_tabs(
            'style_search_submit_tabs'
        );
        $this->start_controls_tab(
            'style_search_submit_section_normal',
            [
                'label' => 'عادی',
            ]
        );
        $this->add_control(
            'search_submit_text',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_submit_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit',
            ]
        );
        $this->add_control(
            'search_submit_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'search_submit_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_submit_border',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_search_submit_section_hover',
            [
                'label' => 'اشاره',
            ]
        );
        $this->add_control(
            'search_submit_text_hover',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit:hover' => 'color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_submit_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit:hover',
            ]
        );
        $this->add_control(
            'search_submit_padding_hover',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'search_submit_border_radius_hover',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_submit_border_hover',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-form-fields .search-buttons-group .search-submit:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); // End of style_search_submit_section

        $this->start_controls_section(
            'style_search_result_section',
            [
                'label' => 'نتیجه جستجو',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_ajax!' => 'false',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'search_result_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .header-search .search-box .search-result',
            ]
        );
        $this->add_control(
            'search_result_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-result' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'search_result_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header-search .search-box .search-result' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'search_result_border',
                'selector' => '{{WRAPPER}} .header-search .search-box .search-result',
            ]
        );
        $this->end_controls_section(); // End of style_search_result_section


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();

        negarshop_header_search($settings);
    }

}
