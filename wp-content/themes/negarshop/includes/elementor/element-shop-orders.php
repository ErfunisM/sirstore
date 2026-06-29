<?php
namespace NegarshopElementor\Widgets;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_shop_order_Widget extends Widget_Base {

	public function get_name() {
		return 'negarshop_shop_orders';
	}
	public function get_title() {
		return 'ابزارک فیلتر ترتیب نمایش';
	}
	public function get_icon() {
		return 'eicon-sort-amount-desc';
	}
	public function get_categories() {
		return [ 'woocommerce-elements-archive' ];
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'style_section',
			[
				'label' => 'ظاهر',
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'outer_background',
				'label' => 'رنگ زمینه',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .woocommerce-products-header',
			]
		);
		$this->add_control(
			'outer_color',
			[
				'label' => 'رنگ متون',
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-products-header h1' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-products-header .sort-tabs h6' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-products-header .sort-tabs ul li button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-products-header .order-by-stock span.title' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['id'] = $this->get_id();
		negarshop_shop_header_filters();
	}

}
