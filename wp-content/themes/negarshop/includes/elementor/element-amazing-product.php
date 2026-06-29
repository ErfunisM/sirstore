<?php
namespace NegarshopElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_shop_Amazing_Product_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script( 'script-negarshop-amazing-product', get_theme_file_uri( '/includes/elementor/element-amazing-product.js' ), [ 'elementor-frontend' ], '1.0.0', true );
    }

    public function get_script_depends() {
        return [ 'script-negarshop-amazing-product' ];
    }

	public function get_name() {
		return 'negarshop_amazing_product';
	}
	public function get_title() {
		return 'محصول شگفت انگیز';
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
            'widget_style',
            [
                'label'   =>  'استایل نمایش',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical'   =>  'عمودی',
                    'horizontal'   =>  'افقی',
                ],
            ]
        );
		$this->add_control(
			'color',
			[
				'label' => 'رنگ ابزارک',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .amazing-product-widget .amazing-product-item .stock-bar .progress-bar' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget .negarshop-countdown:not(.no-style) .countdown-section:last-of-type:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget .negarshop-countdown .countdown-section:last-of-type' => 'color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget .amazing-product-item .countdown-outer .countdown-title b' => 'color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget .btn-primary' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget a:not(.btn-primary):hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .amazing-product-widget .amazing-product-item .item-pricing .item-price ins' => 'color: {{VALUE}}',
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
        negarshop_widget_amazing_product($settings);
	}

}
