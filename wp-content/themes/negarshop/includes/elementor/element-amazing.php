<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_shop_amazing_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'negarshop_amazing';
    }

    public function get_title()
    {
        return 'اسلایدر پیشنهاد شگفت انگیز';
    }

    public function get_icon()
    {
        return 'eicon-price-table';
    }

    public function get_categories()
    {
        return ['Negarshop_main'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'widget_section',
            [
                'label' => 'ابزارک',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'instuck_progress',
            [
                'label' => 'نوار موجودی',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'true',
                'options' => [
                    'true' => 'فعال',
                    'false' => 'غیرفعال',
                ],
            ]
        );
        $this->add_control(
            'tabs_style',
            [
                'label' => 'طرح تب ها',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal-tab',
                'options' => [
                    'normal-tab' => 'بزرگ',
                    'mini-tab' => 'کوچک',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'محتوا',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title', [
                'label' => 'عنوان',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'products_type',
            [
                'label' => 'کوئری نمایش محصولات',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'news',
                'options' => [
                    'news' => 'جدید ترین ها',
                    'category' => 'دسته بندی خاص',
                    'ids' => 'شناسه محصولات',
                    'idsTitled' => 'شناسه محصولات + عنوان سفارشی',
                ],
            ]
        );
        $this->add_control(
            'woo_categories',
            [
                'label' => 'دسته بندی ها',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 0,
                'options' => negarshop_get_categories('product_cat'),
                'condition' => [
                    'products_type' => 'category',
                ],
            ]
        );
        $this->add_control(
            'product_ids',
            [
                'label' => 'شناسه ها',
                'placeholder' => 'مثال: 1,2,3,4',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'products_type' => 'ids',
                ],
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => 'عنوان',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'id', [
                'label' => 'شناسه',
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $this->add_control(
            'items',
            [
                'label' => 'محصولات',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
                'condition' => [
                    'products_type' => 'idsTitled',
                ],
            ]
        );
        $this->add_control(
            'products_count',
            [
                'label' => 'تعداد جهت نمایش',
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );
        $this->add_control(
            'items_type', [
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'products'
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'style_section',
            [
                'label' => 'طراحی',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => 'رنگ اصلی',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .progress-bar' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .cls-3' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .negarshop-countdown .countdown-section:last-of-type' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .negarshop-countdown .countdown-section:last-of-type:before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} a.archive' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .carousel-indicators li.active' => 'background-color: {{VALUE}} !important',
                    '{{WRAPPER}} .product-info .static-title span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-info .box-title span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-info .feature-daels-price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-info .sale-price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-info .footer-sec .finished' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .carousel-indicators li::before' => 'border-color: transparent {{VALUE}} transparent transparent',
                    '{{WRAPPER}} .carousel-inner .carousel-item .discount-percent' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_color',
            [
                'label' => 'رنگ زمینه',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .carousel .carousel-inner' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .carousel' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .carousel-item' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'box_border_radius',
            [
                'label' => 'گردی حاشیه',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'slide_design_section',
            [
                'label' => 'آیتم اسلاید',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_custom_width',
            array(
                'label' => esc_html__('عرض عکس', 'negarshop'),
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
                ),
                'default' => array(
                    'unit' => '%',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .product-thumb' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $this->add_control(
            'slide_content_align',
            array(
                'label' => esc_html__('جهت متن', 'negarshop'),
                'type' => Controls_Manager::CHOOSE,
                'options' => array(
                    'right' => array(
                        'title' => esc_html__('راست', 'negarshop'),
                        'icon' => 'eicon-text-align-right',
                    ),
                    'center' => array(
                        'title' => esc_html__('وسط', 'negarshop'),
                        'icon' => 'eicon-text-align-center',
                    ),
                    'left' => array(
                        'title' => esc_html__('چپ', 'negarshop'),
                        'icon' => 'eicon-text-align-left',
                    ),
                ),
                'toggle' => true,
                'selectors' => array(
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .product-info .title-rate-sec' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .product-info .feature-daels-price' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .product-info .feature-daels-price > *' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .content-widget.slider-2.style-2 .product-info ul.feature-attr-p' => 'text-align: {{VALUE}};',
                ),
            )
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();
        $settings['items_type_picker']['products']['products_type_picker']['products_type'] = $settings['products_type'];
        $settings['items_type_picker']['products']['products_type_picker']['category']['woo_categories'] = $settings['woo_categories'];
        $settings['items_type_picker']['products']['products_type_picker']['ids']['product_ids'] = $settings['product_ids'];
        $settings['items_type_picker']['products']['products_type_picker']['idsTitled']['items'] = $settings['items'];
        $settings['items_type_picker']['products']['products_count'] = $settings['products_count'];
        negarshop_page_widget_amazing($settings, 'elementor');
    }

}
