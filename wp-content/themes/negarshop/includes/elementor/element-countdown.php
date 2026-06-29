<?php

namespace NegarshopElementor\Widgets;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_Countdown_Widget extends Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        wp_register_script('negarshop-countdown-widget', get_theme_file_uri('/includes/elementor/element-countdown.js'), ['elementor-frontend'], '1.0.0', true);
    }

    public function get_script_depends()
    {
        return ['negarshop-countdown-widget'];
    }

    public function get_name()
    {
        return 'negarshop_countdown';
    }

    public function get_title()
    {
        return 'شمارشگر زمان';
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return ['Negarshop_main'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_timer',
            array(
                'label' => esc_html__('تایمر', 'negarshop'),
            )
        );

        $this->add_control(
            'end_time',
            array(
                'label' => esc_html__('پایان', 'negarshop'),
                'type' => Controls_Manager::DATE_TIME,
            )
        );

        $this->add_control(
            'show_days',
            array(
                'label' => esc_html__('نمایش روز', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            )
        );

        $this->add_control(
            'show_hours',
            array(
                'label' => esc_html__('نمایش ساعت', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_minutes',
            array(
                'label' => esc_html__('نمایش دقیقه', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'show_seconds',
            array(
                'label' => esc_html__('نمایش ثانیه', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );
        $this->add_control(
            'separator',
            array(
                'label' => esc_html__('نمایش جداکننده', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            )
        );

        $this->add_control(
            'hide_labels',
            array(
                'label' => esc_html__('مخفی کردن عنوان ها', 'negarshop'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-label' => 'display: none;',
                ),
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'timer_item_design_section',
            array(
                'label' => esc_html__('آیتم', 'negarshop'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->start_controls_tabs(
            'timer_item_design',
        );

        $this->start_controls_tab(
            'timer_item_design_normal_tab',
            array(
                'label' => esc_html__('معمولی', 'negarshop'),
            )
        );
        $this->add_control(
            'timer_item_design_size',
            array(
                'label' => esc_html__('سایز', 'negarshop'),
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
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'timer_item_design_typography',
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value',
            )
        );
        $this->add_control(
            'timer_item_design_padding',
            array(
                'label' => esc_html__('فاصله داخلی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_control(
            'timer_item_design_margin',
            array(
                'label' => esc_html__('فاصله خارجی', 'negarshop'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%', 'em', 'rem'),
                'selectors' => array(
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_control(
            'timer_item_design_color',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'timer_item_design_background',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'timer_item_design_border',
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value',
            )
        );

        $this->add_control(
            'timer_item_design_border_radius',
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
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-value' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'timer_item_design_bold_tab',
            array(
                'label' => esc_html__('برجسته', 'negarshop'),
            )
        );

        $this->add_control(
            'timer_item_design_size_bold',
            array(
                'label' => esc_html__('سایز', 'negarshop'),
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
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item:last-of-type .item-value' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'timer_item_design_typography_bold',
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item:last-of-type .item-value',
            )
        );

        $this->add_control(
            'timer_item_design_color_bold',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item:last-of-type .item-value' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'timer_item_design_background_bold',
                'types' => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item:last-of-type .item-value',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'timer_item_design_border_bold',
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item:last-of-type .item-value',
            )
        );

        $this->add_control(
            'timer_item_design_border_radius_bold',
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
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item:last-of-type .item-value' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'timer_item_title_design_section',
            array(
                'label' => esc_html__('عنوان ها', 'negarshop'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'timer_item_title_design_color_bold',
            array(
                'label' => esc_html__('رنگ متن', 'negarshop'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-label' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'timer_item_title_design_typography_bold',
                'selector' => '{{WRAPPER}} .widget-negarshop-countdown .countdown-item .item-label',
            )
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['end_time'])) {
            return;
        }
        printf('<div class="widget-negarshop-countdown" data-timer="%s">', esc_attr($settings['end_time']));
        if ($settings['show_days'] === 'yes') {
            printf('<span class="countdown-item"><span class="item-value">{days}</span><span class="item-label">%s</span></span>', 'روز');
            echo $settings['separator'] === 'yes' ? ':' : '';
        }
        if ($settings['show_hours'] === 'yes') {
            printf('<span class="countdown-item"><span class="item-value">{hours}</span><span class="item-label">%s</span></span>', 'ساعت');
        }
        if ($settings['show_minutes'] === 'yes') {
            echo $settings['separator'] === 'yes' ? ':' : '';
            printf('<span class="countdown-item"><span class="item-value">{minutes}</span><span class="item-label">%s</span></span>', 'دقیقه');
        }
        if ($settings['show_seconds'] === 'yes') {
            echo $settings['separator'] === 'yes' ? ':' : '';
            printf('<span class="countdown-item"><span class="item-value">{seconds}</span><span class="item-label">%s</span></span>', 'ثانیه');
        }
        echo '</div>';
    }

}
