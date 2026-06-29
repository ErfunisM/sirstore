<?php

namespace NegarshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_blog_carousel_Widget extends Widget_Base {

	public function get_name () {
		return 'negarshop_blog_carousel';
	}

	public function get_title () {
		return 'کریوسل وبلاگ';
	}

	public function get_icon () {
		return 'eicon-post-navigation';
	}

	public function get_categories () {
		return ['Negarshop_main'];
	}

	protected function _register_controls () {


		$this->start_controls_section('content_section', [
				'label' => 'محتوا',
				'tab'   => Controls_Manager::TAB_CONTENT,
			]);
		$this->add_control('products_type', [
				'label'   => 'کوئری نمایش پست ها',
				'type'    => Controls_Manager::SELECT,
				'default' => 'news',
				'options' => [
					'news'     => 'جدید ترین ها',
					'category' => 'دسته بندی خاص',
					'ids'      => 'شناسه پست ها',
				],
			]);
		$categories = [];
		foreach ( get_categories() as $cat ) {
			$categories[$cat->term_id] = $cat->name;
		}
		$this->add_control('categories', [
				'label'     => 'دسته بندی ها',
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => true,
				'options'   => $categories,
				'default'   => [],
				'condition' => [
					'products_type' => 'category',
				],
			]);
		$this->add_control('product_ids', [
				'label'       => 'شناسه ها',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => 'مثال: 1,2,3,4',
				'condition'   => [
					'products_type' => 'ids',
				],
			]);
		$this->add_control('products_count', [
				'label'       => 'تعداد',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'input_type'  => 'number',
				'default'     => '4',
			]);
		$this->add_control('products_offset', [
				'label'       => 'استثنا',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'input_type'  => 'number',
				'default'     => '0',
			]);
		$this->end_controls_section();


		$this->start_controls_section('style_section', [
				'label' => 'ظاهر',
				'tab'   => Controls_Manager::TAB_STYLE,
			]);
		$this->add_control('color_t', [
				'label'   => 'رنگ',
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => 'پیشفرض قالب',
					'custom'  => 'دستی',
				],
			]);
		$this->add_control('color', [
				'label'     => 'رنگ جعبه',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00bfd6',
				'selectors' => [
					'{{WRAPPER}} a.archive'                    => 'background-color: {{VALUE}}',
					'{{WRAPPER}} article.item figcaption time' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'color_t' => 'custom',
				],
			]);
		$this->add_control('style', [
				'label'   => 'طرح',
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => 'طرح اول',
					'style-2' => 'طرح دوم',
				],
			]);
		$this->add_control('slide_per_count', [
				'label'       => 'تعداد در هر اسلاید',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'input_type'  => 'number',
				'default'     => '4',
			]);
		$this->end_controls_section();
	}

	protected function render () {
		$settings       = $this->get_settings_for_display();
		$settings['id'] = $this->get_id();


		$settings['items_type'] = 'products';
		$settings['items_type_picker'] = [
			'products'  =>  [
				'products_type_picker'  =>  [
					'products_type' =>  $settings['products_type'],
					'category' =>  [
						'woo_categories'  =>  $settings['categories']
					],
					'ids' =>  [
						'product_ids'  =>  $settings['product_ids']
					],
				],
				'products_count'    =>  $settings['products_count'],
				'products_offset'    =>  $settings['products_offset'],
			]
		];
		negarshop_page_widget_blog_carousel($settings, 'elementor');
	}

}
