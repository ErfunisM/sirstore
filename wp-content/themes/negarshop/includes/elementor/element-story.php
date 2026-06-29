<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_Story_Widget extends Widget_Base {

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        wp_register_script( 'negarshop-story-widget', get_theme_file_uri( '/includes/elementor/element-story.js' ), [ 'elementor-frontend' ], '1.0.0', true );
    }

    public function get_script_depends() {
        return [ 'negarshop-story-widget' ];
    }

    public function get_name () {
        return 'negarshop_story';
    }

    public function get_title () {
        return 'استوری';
    }

    public function get_icon () {
        return 'eicon-history';
    }

    public function get_categories () {
        return ['Negarshop_main'];
    }

    protected function _register_controls () {
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'استوری ها',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => 'عنوان',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'استوری',
            ],
        );

        $repeater->add_control(
            'link',
            [
                'label' => 'لینک',
                'type' => \Elementor\Controls_Manager::URL,
                'label_block' => true,
            ],
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content',
                'label' => 'محتوا',
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .item-content',
            ]
        );
        $this->add_control(
            'items',
            [
                'label' => 'لیست استوری ها',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'style_section',
            [
                'label' => 'ظاهر',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'items_radius',
            [
                'label' => 'گردی آیتم ها',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'selectors' => [
                    '{{WRAPPER}} .widget-story .story-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .widget-story .story-item .item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .widget-story .story-items .owl-stage-outer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render () {
        $settings       = $this->get_settings_for_display();
        $settings['id'] = $this->get_id();
        negarshop_page_widget_story($settings);
    }

}
