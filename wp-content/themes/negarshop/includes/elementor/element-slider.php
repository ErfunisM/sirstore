<?php

namespace NegarshopElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Negarshop\Negarshop_Helper;

class Elementor_Slider_Widget extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        wp_register_script('negarshop-image-slider-widget', get_theme_file_uri('/includes/elementor/element-slider.js'), ['elementor-frontend'], '1.0.0', true);
        wp_register_script('negarshop-swiper-slider', get_theme_file_uri('/statics/js/swiper-bundle.min.js'), ['elementor-frontend'], '1.0.0', true);
        wp_register_style('negarshop-swiper-slider', get_theme_file_uri('/statics/css/swiper-bundle.min.css'), ['elementor-frontend'], '1.0.0', true);
    }

    public function get_script_depends()
    {
        return ['negarshop-image-slider-widget',
            'negarshop-swiper-slider',
            'negarshop-swiper-slider'];
    }

    /**
     * Get element name.
     *
     * @return string The name.
     */
    public function get_name(): string
    {
        return 'negarshop_image_slider';
    }

    /**
     * Get element title.
     *
     * @return string The title.
     */
    public function get_title(): string
    {
        return 'اسلایدر عکس';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories(): array
    {
        return ['Negarshop_main'];
    }

    /**
     * Get element icon.
     *
     * @return string Element icon.
     */
    public function get_icon(): string
    {
        return 'eicon-slides';
    }

    /**
     * Register controls.
     *
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            array(
                'label' => __('محتوا', 'negarshop'),
            )
        );
        $slides_repeater = new Repeater();
        $slides_repeater->start_controls_tabs(
            'slides_tabs'
        );

        $slides_repeater->start_controls_tab(
            'slides_image_tab',
            array(
                'label' => esc_html__('تصویر', 'negarshop'),
            )
        );
        $slides_repeater->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'background',
                'label' => __('زمینه', 'negarshop'),
                'types' => array('classic'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .item-image,{{WRAPPER}} .swiper-pagination {{CURRENT_ITEM}} span',
            )
        );

        $slides_repeater->add_control(
            'background_image_size',
            array(
                'label' => esc_html__('سایز زمینه', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => array(
                    'full' => esc_html__('Full', 'negarshop'),
                    'custom' => esc_html__('Custom', 'negarshop'),
                ),
            )
        );

        $slides_repeater->add_control(
            'background_custom_align',
            array(
                'label' => esc_html__('جهت زمینه', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('چپ', 'negarshop'),
                        'icon' => 'eicon-align-start-h',
                    ),
                    'center' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-h',
                    ),
                    'right' => array(
                        'title' => esc_html__('راست', 'negarshop'),
                        'icon' => 'eicon-align-end-h',
                    ),
                ),
                'default' => 'center',
                'condition' => array(
                    'background_image_size' => 'custom',
                ),
            )
        );

        $slides_repeater->add_control(
            'background_custom_vertical_align',
            array(
                'label' => esc_html__('جهت افقی زمینه', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'top' => array(
                        'title' => esc_html__('بالا', 'negarshop'),
                        'icon' => 'eicon-align-start-v',
                    ),
                    'middle' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-v',
                    ),
                    'bottom' => array(
                        'title' => esc_html__('پایین', 'negarshop'),
                        'icon' => 'eicon-align-end-v',
                    ),
                ),
                'default' => 'middle',
                'condition' => array(
                    'background_image_size' => 'custom',
                ),
            )
        );

        $slides_repeater->add_responsive_control(
            'background_custom_width',
            array(
                'label' => esc_html__('عرض زمینه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem', 'vw'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vw' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => '%',
                    'size' => 25,
                ),
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .item-image' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'background_image_size' => 'custom',
                ),
            )
        );

        $slides_repeater->add_responsive_control(
            'background_custom_height',
            array(
                'label' => esc_html__('طول زمینه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem', 'vh'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vh' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => '%',
                    'size' => 50,
                ),
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .item-image' => 'height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'background_image_size' => 'custom',
                ),
            )
        );

        $slides_repeater->end_controls_tab();

        $slides_repeater->start_controls_tab(
            'slides_content_tab',
            array(
                'label' => esc_html__('محتوا', 'negarshop'),
            )
        );
        $slides_repeater->add_control(
            'badge',
            array(
                'label' => __('بج', 'negarshop'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            )
        );
        $slides_repeater->add_control(
            'title',
            array(
                'label' => __('عنوان', 'negarshop'),
                'type' => Controls_Manager::TEXT,
                'default' => __('عنوان اسلاید', 'negarshop'),
                'label_block' => true,
            )
        );
        $slides_repeater->add_control(
            'content',
            array(
                'label' => __('محتوا', 'negarshop'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('توضیحات اسلاید', 'negarshop'),
                'show_label' => false,
            )
        );

        $slides_repeater->add_control(
            'content_size',
            array(
                'label' => esc_html__('سایز محتوا', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => array(
                    'full' => esc_html__('فول', 'negarshop'),
                    'custom' => esc_html__('سفارشی', 'negarshop'),
                    'container' => esc_html__('کانتاینر', 'negarshop'),
                ),
            )
        );

        $slides_repeater->add_control(
            'content_align',
            array(
                'label' => esc_html__('جهت محتوا', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('چپ', 'negarshop'),
                        'icon' => 'eicon-align-start-h',
                    ),
                    'center' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-h',
                    ),
                    'right' => array(
                        'title' => esc_html__('راست', 'negarshop'),
                        'icon' => 'eicon-align-end-h',
                    ),
                ),
                'default' => 'center',
                'condition' => array(
                    'content_size' => 'custom',
                ),
            )
        );

        $slides_repeater->add_control(
            'content_vertical_align',
            array(
                'label' => esc_html__('جهت افقی محتوا', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'top' => array(
                        'title' => esc_html__('بالا', 'negarshop'),
                        'icon' => 'eicon-align-start-v',
                    ),
                    'middle' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-v',
                    ),
                    'bottom' => array(
                        'title' => esc_html__('پایین', 'negarshop'),
                        'icon' => 'eicon-align-end-v',
                    ),
                ),
                'default' => 'middle',
                'condition' => array(
                    'content_size' => array('custom', 'container'),
                ),
            )
        );

        $slides_repeater->add_responsive_control(
            'content_custom_width',
            array(
                'label' => esc_html__('عرض محتوا', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem', 'vw'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vw' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => '%',
                    'size' => 25,
                ),
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .item-inner' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'content_size' => 'custom',
                ),
            )
        );

        $slides_repeater->add_responsive_control(
            'content_custom_height',
            array(
                'label' => esc_html__('طول محتوا', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem', 'vh'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vh' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => '%',
                    'size' => 50,
                ),
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .item-inner' => 'height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'content_size' => 'custom',
                ),
            )
        );

        $slides_repeater->end_controls_tab();

        $slides_repeater->start_controls_tab(
            'slides_link_tab',
            array(
                'label' => esc_html__('لینک', 'negarshop'),
            )
        );
        $slides_repeater->add_control(
            'link_mode',
            array(
                'label' => esc_html__('حالت لینک', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'default' => 'button',
                'options' => array(
                    'none' => esc_html__('هیچ', 'negarshop'),
                    'button' => esc_html__('دکمه', 'negarshop'),
                    'slide' => esc_html__('اسلاید', 'negarshop'),
                ),
            )
        );
        $slides_repeater->add_control(
            'link_label',
            array(
                'label' => __('عنوان لینک', 'negarshop'),
                'type' => Controls_Manager::TEXT,
                'default' => __('خواندن بیشتر', 'negarshop'),
                'label_block' => true,
                'condition' => array(
                    'link_mode' => 'button',
                ),
            )
        );
        $slides_repeater->add_control(
            'link',
            array(
                'label' => __('لینک', 'negarshop'),
                'type' => Controls_Manager::URL,
                'options' => array('url', 'is_external', 'nofollow'),
                'default' => array(
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => false,
                ),
                'label_block' => true,
                'condition' => array(
                    'link_mode!' => 'none',
                ),
            )
        );
        $slides_repeater->end_controls_tab();

        $slides_repeater->start_controls_tab(
            'slides_style_tab',
            array(
                'label' => esc_html__('استایل', 'negarshop'),
            )
        );
        $slides_repeater->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'background_overlay',
                'label' => __('کاور زمینه', 'negarshop'),
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .item-image::before',
            )
        );

        $slides_repeater->add_responsive_control(
            'overlay_custom_width',
            array(
                'label' => esc_html__('عرض کاور', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem', 'vw'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vw' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .item-image::before' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $slides_repeater->end_controls_tab();

        $slides_repeater->end_controls_tabs();

        $this->add_control(
            'slides',
            array(
                'label' => __('اسلاید ها', 'negarshop'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $slides_repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            )
        );

        $this->add_responsive_control(
            'slider_height',
            array(
                'label' => esc_html__('طول اسلاید', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem', 'vh'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vh' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .main-slider .slider-item' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .element-image-slider .main-slider .swiper' => 'height: {{SIZE}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'slider_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه اسلایدر', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 3000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                    'vh' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .main-slider .slider-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slide_content_design_section',
            array(
                'label' => __('محتوا', 'negarshop'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'slide_content_design_text_align',
            array(
                'label' => esc_html__('جهت متن', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('چپ', 'negarshop'),
                        'icon' => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__('راست', 'negarshop'),
                        'icon' => 'eicon-text-align-right',
                    ),
                ),
                'default' => 'center',
                'toggle' => false,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->start_controls_tabs(
            'slide_content_box_design_tabs',
        );

        $this->start_controls_tab(
            'slide_content_box_design_box_tab',
            array(
                'label' => esc_html__('جعبه', 'negarshop'),
            )
        );
        $this->add_responsive_control(
            'slide_content_box_margin',
            array(
                'label' => esc_html__('فاصله', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_padding',
            array(
                'label' => esc_html__('فاصله داخلی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_background',
            array(
                'name' => 'slide_content_box_background',
                'label' => esc_html__('زمینه', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'slide_content_box_border',
                'selector' => '{{WRAPPER}} .element-image-slider .slider-item .item-inner',
            )
        );

        $this->add_control(
            'slide_content_box_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'slide_content_box_design_badge_tab',
            array(
                'label' => esc_html__('بج', 'negarshop'),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'slide_content_box_design_badge_typography',
                'selector' => '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-badge .badge',
            )
        );

        $this->add_control(
            'slide_content_box_design_badge_padding',
            array(
                'label' => esc_html__('فاصله داخلی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-badge .badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'slide_content_box_design_badge_margin',
            array(
                'label' => esc_html__('فاصله', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_control(
            'slide_content_box_design_badge_text_color',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-badge .badge' => 'color: {{VALUE}}',
                ),
            )
        );
        $this->add_control(
            'slide_content_box_design_badge_background_color',
            array(
                'label' => esc_html__('رنگ زمینه', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-badge .badge' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_badge_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem'),
                'range' => array(
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-badge .badge' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'slide_content_box_design_title_tab',
            array(
                'label' => esc_html__('عنوان', 'negarshop'),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'slide_content_box_design_title_typography',
                'selector' => '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-title',
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_title_padding',
            array(
                'label' => esc_html__('فاصله داخلی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_title_margin',
            array(
                'label' => esc_html__('فاصله ', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_control(
            'slide_content_box_design_title_text_color',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-title' => 'color: {{VALUE}}',
                ),
            )
        );
        $this->add_control(
            'slide_content_box_design_title_background_color',
            array(
                'label' => esc_html__('رنگ زمینه', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-title' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_title_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem'),
                'range' => array(
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-title' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'slide_content_box_design_description_tab',
            array(
                'label' => esc_html__('توضیحات', 'negarshop'),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'slide_content_box_design_description_typography',
                'selector' => '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-description',
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_description_padding',
            array(
                'label' => esc_html__('فاصله داخلی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_description_margin',
            array(
                'label' => esc_html__('فاصله ', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_control(
            'slide_content_box_design_description_text_color',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-description' => 'color: {{VALUE}}',
                ),
            )
        );
        $this->add_control(
            'slide_content_box_design_description_background_color',
            array(
                'label' => esc_html__('رنگ زمینه', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-description' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'slide_content_box_design_description_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'em', 'rem'),
                'range' => array(
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .slider-item .item-inner .item-description' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'slide_button_design_options',
            array(
                'label' => esc_html__('تنظیمات دکمه', 'negarshop'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );
        $this->start_controls_tabs(
            'slide_button_design_tabs',
        );

        $this->start_controls_tab(
            'slide_button_design_normal_tab',
            array(
                'label' => esc_html__('عادی', 'negarshop'),
            )
        );

        $this->add_control(
            'slide_button_design_padding',
            array(
                'label' => esc_html__('فاصله داخلی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .item-buttons .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_control(
            'slide_button_design_margin',
            array(
                'label' => esc_html__('فاصله ', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .item-buttons .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_control(
            'slide_button_design_color',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .item-buttons .button' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'slide_button_design_background',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .element-image-slider .item-buttons .button',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'slide_button_design_border',
                'selector' => '{{WRAPPER}} .element-image-slider .item-buttons .button',
            )
        );

        $this->add_control(
            'slide_button_design_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .item-buttons .button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'slide_button_design_hover_tab',
            array(
                'label' => esc_html__('اشاره', 'negarshop'),
            )
        );

        $this->add_control(
            'slide_button_design_color_hover',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .element-image-slider .item-buttons .button:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'slide_button_design_background_hover',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .element-image-slider .item-buttons .button:hover',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'slide_button_design_border_hover',
                'selector' => '{{WRAPPER}} .element-image-slider .item-buttons .button:hover',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->swiper_slider_options();
    }

    /**
     * Swiper slider settings.
     *
     * @param string $prefix Options prefix.
     *
     * @return void
     */
    protected function swiper_slider_options(string $prefix = 'swiper')
    {
        $this->start_controls_section(
            $prefix . '_slider_options_section',
            array(
                'label' => __('تنظیمات اسلایدر', 'negarshop'),
            )
        );
        $this->add_responsive_control(
            $prefix . '_slider_slides_per_view',
            array(
                'label' => __('اسلاید برای نمایش', 'negarshop'),
                'type' => Controls_Manager::NUMBER,
                'frontend_available' => true,
                'desktop_default' => 1,
                'tablet_default' => 1,
                'mobile_default' => 1,
            )
        );
        $this->add_control(
            $prefix . '_slider_slides_overflow',
            array(
                'label' => __('نمایش ادامه اسلاید ها', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            )
        );
        $this->add_responsive_control(
            $prefix . '_slider_space_between',
            array(
                'label' => __('فاصله بینابینی (PX)', 'negarshop'),
                'type' => Controls_Manager::NUMBER,
                'frontend_available' => true,
                'desktop_default' => 30,
                'tablet_default' => 30,
                'mobile_default' => 30,
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation',
            array(
                'label' => __('ناوبری', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination',
            array(
                'label' => __('صفحه بندی', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
            )
        );
        $this->add_control(
            $prefix . '_slider_scrollbar',
            array(
                'label' => __('اسکرول بار', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
            )
        );
        $this->add_control(
            $prefix . '_slider_touch',
            array(
                'label' => __('تاچ', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );
        $this->add_control(
            $prefix . '_slider_vertical',
            array(
                'label' => __('حالت عمودی', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
            )
        );
        $this->add_control(
            $prefix . '_slider_autoplay',
            array(
                'label' => __('پخش خودکار', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
            )
        );
        $this->add_control(
            $prefix . '_slider_delay',
            array(
                'label' => __('تاخیر پخش خودکار', 'negarshop'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => array(
                    $prefix . '_slider_autoplay' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_free_mode',
            array(
                'label' => __('حالت آزاد', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
            )
        );
        $this->add_responsive_control(
            $prefix . '_slider_centered_slides',
            array(
                'label' => __('وسط چین', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true,
                'desktop_default' => false,
                'tablet_default' => false,
                'mobile_default' => false,
            )
        );
        $this->add_responsive_control(
            $prefix . '_slider_loop',
            array(
                'label' => __('حالت بی نهایت', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true,
                'desktop_default' => false,
                'tablet_default' => false,
                'mobile_default' => false,
            )
        );
        $this->add_control(
            $prefix . '_slider_effect',
            array(
                'label' => __('افکت', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'frontend_available' => true,
                'desktop_default' => 'slide',
                'tablet_default' => 'slide',
                'mobile_default' => 'slide',
                'options' => array(
                    'slide' => __('اسلاید', 'negarshop'),
                    'coverflow' => __('کاور', 'negarshop'),
                    'creative' => __('خلاقانه', 'negarshop'),
                    'cube' => __('مکعب', 'negarshop'),
                    'fade' => __('محو', 'negarshop'),
                ),
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            $prefix . '_slider_navigation_settings_section',
            array(
                'label' => __('ناوبری اسلایدر', 'negarshop'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => array(
                    $prefix . '_slider_navigation' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_position',
            array(
                'label' => __('موقعیت ناوبری', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => array(
                    'inside' => __('داخل', 'negarshop'),
                    'outside' => __('خارج', 'negarshop'),
                ),
                'condition' => array(
                    $prefix . '_slider_navigation' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_next',
            array(
                'label' => __('مخفی کردن دکمه بعدی', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button--next' => 'display: none !important;',
                ),
                'condition' => array(
                    $prefix . '_slider_navigation' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_prev',
            array(
                'label' => __('مخفی کردن دکمه قبلی', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => false,
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button--prev' => 'display: none !important;',
                ),
                'condition' => array(
                    $prefix . '_slider_navigation' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_vertical_align',
            array(
                'label' => esc_html__('جهت عمودی', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'top' => array(
                        'title' => esc_html__('بالا', 'negarshop'),
                        'icon' => 'eicon-align-start-v',
                    ),
                    'middle' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-v',
                    ),
                    'bottom' => array(
                        'title' => esc_html__('پایین', 'negarshop'),
                        'icon' => 'eicon-align-end-v',
                    ),
                ),
                'default' => 'middle',
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_mode',
            array(
                'label' => esc_html__('حالت', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'expanded' => array(
                        'title' => esc_html__('باز شده', 'negarshop'),
                        'icon' => 'eicon-grow',
                    ),
                    'compact' => array(
                        'title' => esc_html__('جمع شده', 'negarshop'),
                        'icon' => 'eicon-shrink',
                    ),
                ),
                'default' => 'expanded',
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_horizontal_align',
            array(
                'label' => esc_html__('جهت افقی', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('چپ', 'negarshop'),
                        'icon' => 'eicon-align-start-h',
                    ),
                    'center' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-h',
                    ),
                    'right' => array(
                        'title' => esc_html__('راست', 'negarshop'),
                        'icon' => 'eicon-align-end-h',
                    ),
                ),
                'default' => 'center',
                'condition' => array(
                    $prefix . '_slider_navigation_mode' => 'compact',
                ),
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            $prefix . '_slider_pagination_settings_section',
            array(
                'label' => __('صفحه بندی', 'negarshop'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination_type',
            array(
                'label' => __('نوع صفحه بندی', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bullets',
                'options' => array(
                    'bullets' => __('بیلبیلک', 'negarshop'),
                    'fraction' => __('عدد', 'negarshop'),
                    'slider' => __('اسلایدر', 'negarshop'),
                ),
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination_position',
            array(
                'label' => __('موقعیت صفحه بندی', 'negarshop'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => array(
                    'inside' => __('Inside', 'negarshop'),
                    'outside' => __('Outside', 'negarshop'),
                ),
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                    $prefix . '_slider_pagination_type!' => 'slider',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination_bullets_imaged',
            array(
                'label' => __('نمایش تصویر اسلاید در صفحه بندی', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                    $prefix . '_slider_pagination_type!' => 'slider',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination_vertical_align',
            array(
                'label' => esc_html__('جهت عمودی', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'top' => array(
                        'title' => esc_html__('بالا', 'negarshop'),
                        'icon' => 'eicon-align-start-v',
                    ),
                    'middle' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-v',
                    ),
                    'bottom' => array(
                        'title' => esc_html__('پایین', 'negarshop'),
                        'icon' => 'eicon-align-end-v',
                    ),
                ),
                'default' => 'middle',
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                    $prefix . '_slider_pagination_type!' => 'slider',
                ),
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination_horizontal_align',
            array(
                'label' => esc_html__('جهت افقی', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__('چپ', 'negarshop'),
                        'icon' => 'eicon-align-start-h',
                    ),
                    'center' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-align-center-h',
                    ),
                    'right' => array(
                        'title' => esc_html__('راست', 'negarshop'),
                        'icon' => 'eicon-align-end-h',
                    ),
                ),
                'default' => 'center',
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                    $prefix . '_slider_pagination_type!' => 'slider',
                ),
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            $prefix . '_slider_navigation_design_section',
            array(
                'label' => __('ناوبری', 'negarshop'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $prefix . '_slider_navigation' => 'yes',
                ),
            )
        );
        $this->start_controls_tabs(
            $prefix . '_slider_navigation_design_tabs',
        );

        $this->start_controls_tab(
            $prefix . '_slider_navigation_design_normal_tab',
            array(
                'label' => esc_html__('عادی', 'negarshop'),
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_font',
            array(
                'label' => esc_html__('اندازی آیکن', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button::before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_color',
            array(
                'label' => esc_html__('رنگ آیکن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button::before' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_width',
            array(
                'label' => esc_html__('عرض', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-buttons' => '--slider-button-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_height',
            array(
                'label' => esc_html__('طول', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-buttons' => '--slider-button-height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_margin',
            array(
                'label' => esc_html__('فاصله ', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => $prefix . '_slider_navigation_design_background',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .slider-container .slider-button',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => $prefix . '_slider_navigation_design_border',
                'selector' => '{{WRAPPER}} .slider-container .slider-button',
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            $prefix . '_slider_navigation_design_hover_tab',
            array(
                'label' => esc_html__('اشاره', 'negarshop'),
            )
        );
        $this->add_control(
            $prefix . '_slider_navigation_design_font_hover',
            array(
                'label' => esc_html__('اندازی آیکن', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button:hover::before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_navigation_design_color_hover',
            array(
                'label' => esc_html__('رنگ آیکن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .slider-container .slider-button:hover::before' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => $prefix . '_slider_navigation_design_background_hover',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .slider-container .slider-button:hover',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => $prefix . '_slider_navigation_design_border_hover',
                'selector' => '{{WRAPPER}} .slider-container .slider-button:hover',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            $prefix . '_slider_pagination_design_section',
            array(
                'label' => __('صفحه بندی', 'negarshop'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    $prefix . '_slider_pagination' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs(
            $prefix . '_slider_pagination_design_tabs',
        );

        $this->start_controls_tab(
            $prefix . '_slider_pagination_design_normal_tab',
            array(
                'label' => esc_html__('عادی', 'negarshop'),
            )
        );

        $this->add_control(
            $prefix . '_slider_pagination_design_font',
            array(
                'label' => esc_html__('اندازه متن', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-pagination .swiper-pagination-total' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slider-pagination' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}  .thumbnail-slider .swiper-slide .thumb-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['fraction', 'slider'],
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_pagination_design_color',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .slider-pagination .swiper-pagination-total' => 'color: {{VALUE}};',
                    '{{WRAPPER}}  .slider-pagination' => 'color: {{VALUE}};',
                    '{{WRAPPER}}  .thumbnail-slider .swiper-slide .thumb-title' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['fraction', 'slider'],
                ),
            )
        );

        $this->add_responsive_control(
            $prefix . '_slider_pagination_design_width',
            array(
                'label' => esc_html__('عرض', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem', '%'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .thumbnail-slider .swiper-slide' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider'],
                ),
            )
        );

        $this->add_responsive_control(
            $prefix . '_slider_pagination_design_height',
            array(
                'label' => esc_html__('طول', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .thumbnail-slider .swiper-slide .thumb-image' => 'max-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider'],
                ),
            )
        );

        $this->add_responsive_control(
            $prefix . '_slider_pagination_design_margin',
            array(
                'label' => esc_html__('فاصله ', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => 'bullets',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => $prefix . '_slider_pagination_design_background',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet, {{WRAPPER}} .thumbnail-slider .swiper-slide .thumb-item',
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider'],
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => $prefix . '_slider_pagination_design_border',
                'selector' => '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet, {{WRAPPER}} .thumbnail-slider .swiper-slide .thumb-item',
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider'],
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $prefix . '_slider_pagination_design_box_shadow',
                'selector' => '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet',
                'condition' => array(
                    $prefix . '_slider_pagination_type' => 'bullets',
                ),
            ]
        );
        $this->add_control(
            $prefix . '_slider_pagination_design_border_radius',
            array(
                'label' => esc_html__('گردی حاشیه', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet, {{WRAPPER}} .thumbnail-slider .swiper-slide .thumb-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider'],
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            $prefix . '_slider_pagination_design_active_tab',
            array(
                'label' => esc_html__('فعال', 'negarshop'),
            )
        );
        $this->add_control(
            $prefix . '_slider_pagination_design_font_active',
            array(
                'label' => esc_html__('اندازه متن', 'negarshop'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}}  .slider-pagination .swiper-pagination-current' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .thumbnail-slider .swiper-slide-thumb-active .thumb-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['fraction', 'slider'],
                ),
            )
        );

        $this->add_control(
            $prefix . '_slider_pagination_design_color_active',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}}  .slider-pagination .swiper-pagination-current' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .thumbnail-slider .swiper-slide-thumb-active .thumb-title' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['fraction', 'slider'],
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => $prefix . '_slider_pagination_design_background_active',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet-active, {{WRAPPER}} .thumbnail-slider .swiper-slide-thumb-active .thumb-item',
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider']
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $prefix . '_slider_pagination_design_box_shadow_active',
                'selector' => '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet-active',
                'condition' => array(
                    $prefix . '_slider_pagination_type' => 'bullets',
                ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => $prefix . '_slider_pagination_design_border_active',
                'selector' => '{{WRAPPER}} .slider-pagination .swiper-pagination-bullet-active, {{WRAPPER}} .thumbnail-slider .swiper-slide-thumb-active .thumb-item',
                'condition' => array(
                    $prefix . '_slider_pagination_type' => ['bullets', 'slider'],
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Swiper frontend options builder.
     *
     * @param string $prefix Options prefix.
     *
     * @return array List of swiper js options.
     */
    public function swiper_slider_frontend_options_builder(string $prefix = 'swiper'): array
    {
        $element_settings = $this->get_settings_for_display();

        $breakpoints = array(
            'desktop' => 998,
            'tablet' => 480,
            'mobile' => 0,
        );

        $options_list = array(
            '_slider_slides_per_view' => 1,
            '_slider_space_between' => 30,
            '_slider_navigation' => true,
            '_slider_pagination' => false,
            '_slider_scrollbar' => false,
            '_slider_autoplay' => false,
            '_slider_touch' => false,
            '_slider_vertical' => false,
            '_slider_delay' => 5000,
            '_slider_free_mode' => false,
            '_slider_centered_slides' => false,
            '_slider_loop' => false,
            '_slider_effect' => 'slide',
            '_slider_slides_overflow' => '',
            '_slider_pagination_bullets_imaged' => '',
            '_slider_navigation_position' => 'inside',
            '_slider_navigation_vertical_align' => 'middle',
            '_slider_navigation_horizontal_align' => 'center',
            '_slider_navigation_mode' => 'expanded',
            '_slider_pagination_position' => 'inside',
            '_slider_pagination_type' => 'bullets',
            '_slider_pagination_vertical_align' => 'middle',
            '_slider_pagination_horizontal_align' => 'center',
        );

        $slider_options = array(
            'rtl' => true,
            'breakpoints' => array(),
        );

        foreach ($options_list as $option_name => $default_value) {
            foreach ($breakpoints as $breakpoint_name => $breakpoint_width) {
                $option_full_name = $prefix . $option_name;

                if ('desktop' !== $breakpoint_name) {
                    $option_full_name .= '_' . $breakpoint_name;
                }
                $option_value = $element_settings[$option_full_name] ?? $element_settings[$prefix . $option_name] ?? $default_value;

                $slider_options['breakpoints'][$breakpoint_width] = $slider_options['breakpoints'][$breakpoint_width] ?? array();

                if ('_slider_slides_per_view' === $option_name) {
                    $slider_options['breakpoints'][$breakpoint_width]['slidesPerView'] = $option_value;
                    continue;
                }

                if ('_slider_space_between' === $option_name && is_numeric($option_value) && $option_value > 0) {
                    $slider_options['breakpoints'][$breakpoint_width]['spaceBetween'] = $option_value;
                    continue;
                }

                if ('_slider_navigation' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['navigation'] = array(
                        'nextEl' => '.carousel-next-button--' . $this->get_id_int(),
                        'prevEl' => '.carousel-prev-button--' . $this->get_id_int(),
                    );
                    continue;
                }

                if ('_slider_slides_overflow' === $option_name && !empty($option_value)) {
                    $slider_options['overflow'] = 'visible';
                    continue;
                }
                if ('_slider_pagination_bullets_imaged' === $option_name && !empty($option_value)) {
                    $slider_options['imaged_bullets'] = true;
                    continue;
                }

                if ('_slider_navigation_position' === $option_name && !empty($slider_options['navigation'])) {
                    $slider_options['navigation']['position'] = $option_value;
                    continue;
                }

                if ('_slider_navigation_vertical_align' === $option_name && !empty($slider_options['navigation'])) {
                    $slider_options['navigation']['vertical_align'] = $option_value;
                    continue;
                }

                if ('_slider_navigation_horizontal_align' === $option_name && !empty($slider_options['navigation'])) {
                    $slider_options['navigation']['horizontal_align'] = $option_value;
                    continue;
                }

                if ('_slider_navigation_mode' === $option_name && !empty($slider_options['navigation'])) {
                    $slider_options['navigation']['mode'] = $option_value;
                    continue;
                }

                if ('_slider_pagination' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['pagination'] = array(
                        'el' => '.carousel-pagination--' . $this->get_id_int(),
                        'type' => 'bullets',
                        'clickable' => true,
                    );
                    continue;
                }

                if ('_slider_pagination_position' === $option_name && !empty($slider_options['pagination'])) {
                    $slider_options['pagination']['position'] = $option_value;
                    continue;
                }

                if ('_slider_pagination_type' === $option_name && !empty($slider_options['pagination'])) {
                    $slider_options['pagination']['type'] = $option_value;
                    continue;
                }

                if ('_slider_pagination_vertical_align' === $option_name && !empty($slider_options['pagination'])) {
                    $slider_options['pagination']['vertical_align'] = $option_value;
                    continue;
                }

                if ('_slider_pagination_horizontal_align' === $option_name && !empty($slider_options['pagination'])) {
                    $slider_options['pagination']['horizontal_align'] = $option_value;
                    continue;
                }

                if ('_slider_scrollbar' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['breakpoints'][$breakpoint_width]['scrollbar'] = array(
                        'el' => '.carousel-scrollbar--' . $this->get_id_int(),
                        'draggable' => true,
                    );
                    continue;
                }

                if ('_slider_touch' === $option_name) {
                    $slider_options['allowTouchMove'] = Negarshop_Helper::is_checked($option_value);
                    continue;
                }
                if ('_slider_vertical' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['direction'] = 'vertical';
                    continue;
                }

                if ('_slider_autoplay' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $option_full_name = $prefix . '_slider_delay';

                    if ('desktop' !== $breakpoint_name) {
                        $option_full_name .= '_' . $breakpoint_name;
                    }

                    $option_value = $element_settings[$option_full_name] ?? $options_list['_slider_delay'];

                    $slider_options['breakpoints'][$breakpoint_width]['autoplay'] = array(
                        'delay' => $option_value,
                    );
                    continue;
                }

                if ('_slider_free_mode' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['breakpoints'][$breakpoint_width]['freeMode'] = true;
                    continue;
                }

                if ('_slider_centered_slides' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['breakpoints'][$breakpoint_width]['centeredSlides'] = true;
                    continue;
                }

                if ('_slider_loop' === $option_name && Negarshop_Helper::is_checked($option_value)) {
                    $slider_options['breakpoints'][$breakpoint_width]['loop'] = true;
                    continue;
                }

                if ('_slider_effect' === $option_name) {
                    $slider_options['effect'] = $option_value;
                }
            }
        }

        return array_merge($slider_options, $slider_options['breakpoints'][$breakpoints['desktop']]);
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['swiper_options'] = $this->swiper_slider_frontend_options_builder();

        if (!empty($settings['slides'])) {
            foreach ($settings['slides'] as $index => $slide) {
                if (!empty($slide['link']['url'])) {
                    $link_key = 'slide_item_link_' . $index;
                    $this->add_link_attributes($link_key, $slide['link']);
                    $settings['slides'][$index]['link_attribute'] = $this->get_render_attribute_string($link_key);
                }
            }
        }

        negarshop_page_widget_slider($settings);
    }
}