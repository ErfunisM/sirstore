<?php
namespace NegarshopElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_shop_moment_Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'script-negarshop_moment', get_theme_file_uri( '/includes/elementor/element-moment.js' ), [ 'elementor-frontend' ], '1.0.0', true );
	}

	public function get_script_depends() {
		return [ 'script-negarshop_moment' ];
	}
	public function get_name() {
		return 'negarshop_moment';
	}
	public function get_title() {
		return 'پیشنهاد لحظه ای';
	}
	public function get_icon() {
		return 'eicon-countdown';
	}
	public function get_categories() {
		return [ 'Negarshop_main' ];
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'style_section',
			[
				'label' => 'ظاهر',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'color_t',
			[
				'label'   =>  'رنگ',
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   =>  'پیشفرض قالب',
					'custom'   =>  'دستی',
				],
			]
		);
		$this->add_control(
			'color',
			[
				'label' => 'رنگ جعبه',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#00bfd6',
				'selectors' => [
					'{{WRAPPER}} .style-2 .section-header' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .section-header a.archive' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .more .btn-primary' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .owl-item .price ins' => 'color: {{VALUE}}',
					'{{WRAPPER}} .owl-item .price' => 'color: {{VALUE}}',
					'{{WRAPPER}} .owl-item .price span.amount' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_t' => 'custom',
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
				'label' =>  'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'products_type',
			[
				'label'   =>  'کوئری نمایش محصولات',
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'news',
				'options' => [
					'news'   =>  'جدید ترین ها',
					'category'   =>  'دسته بندی خاص',
					'ids'   =>  'شناسه محصولات',
					'idsTitled'   =>  'شناسه محصولات + عنوان سفارشی',
				],
			]
		);
		$this->add_control(
			'woo_categories',
			[
				'label' =>  'دسته بندی ها',
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
				'label' =>  'شناسه ها',
				'placeholder'  =>  'مثال: 1,2,3,4',
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
				'label' =>  'عنوان',
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'id', [
				'label' =>  'شناسه',
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);


		$this->add_control(
			'items',
			[
				'label'=>  'محصولات',
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
				'label' =>  'تعداد جهت نمایش',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
			]
		);
		$this->add_control(
			'items_type', [
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default'=>'products'
			]
		);
		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['id'] = $this->get_id();
		$settings['items_type_picker']['products']['products_type_picker']['products_type'] = $settings['products_type'];
		$settings['items_type_picker']['products']['products_type_picker']['category']['woo_categories'] = $settings['woo_categories'];
		$settings['items_type_picker']['products']['products_type_picker']['ids']['product_ids'] = $settings['product_ids'];
		$settings['items_type_picker']['products']['products_type_picker']['idsTitled']['items'] = $settings['items'];
		$settings['items_type_picker']['products']['products_count'] = $settings['products_count'];
		negarshop_page_widget_moment($settings,'elementor');
	}

}
