<?php if ( !defined('FW') ) {
	die('Forbidden');
}

$options = [
	'general_tab' => [
		'title'   => 'عمومی',
		'type'    => 'tab',
		'options' => [
			'loader_tab' => [
				'title'   => 'پیش بارگزاری',
				'type'    => 'tab',
				'options' => [
					'loader_ac'          => [
						'type'    => 'select',
						'label'   => 'وضعیت نمایش',
						'value'   => 'false',
						'choices' => [
							'true'  => 'فعال',
							'false' => 'غیر فعال'
						],
					],
					'loader_type_picker' => [
						'type'    => 'multi-picker',
						'picker'  => 'loader_ac',
						'choices' => [
							'true' => [
								'image' => [
									'type'        => 'upload',
									'images_only' => true,
									'label'       => 'عکس',
									'value'       => [
										'url' => get_theme_file_uri('statics/images/logo.png')
									],
								],
								'spinner'          => [
									'type'    => 'select',
									'label'   => 'آیکن بارگزاری',
									'value'   => 'true',
									'choices' => [
										'true'  => 'فعال',
										'false' => 'غیر فعال'
									],
								],
								'text'          => [
									'type'    => 'text',
									'label'   => 'متن بارگزاری',
									'value'   => 'در حال بارگزاری ...',
								],
							]
						]
					],
				]
			],
			'popup_tab'  => [
				'title'   => 'پیام',
				'type'    => 'tab',
				'options' => [
					'popup_ac'          => [
						'type'    => 'select',
						'label'   => 'وضعیت نمایش',
						'value'   => 'false',
						'choices' => [
							'true'  => 'فعال',
							'false' => 'غیر فعال'
						],
					],
					'popup_title'       => [
						'type'  => 'text',
						'label' => 'عنوان پیام',
						'value' => ''
					],
					'popup_link'        => [
						'type'  => 'text',
						'label' => 'لینک پیام',
						'value' => ''
					],
					'popup_time'        => [
						'type'  => 'text',
						'label' => 'زمان کوکی',
						'desc'  => 'واحد ساعت',
						'value' => '1'
					],
					'popup_type'        => [
						'type'    => 'select',
						'label'   => 'نوع پیام',
						'value'   => 'pic',
						'choices' => [
							'pic'       => 'تصویر',
							'shortcode' => 'خبرنامه'
						],
					],
					'popup_type_picker' => [
						'type'    => 'multi-picker',
						'picker'  => 'popup_type',
						'choices' => [
							'pic'       => [
								'popup_image' => [
									'type'        => 'upload',
									'images_only' => true,
									'label'       => 'عکس پیام',
								],
							],
							'shortcode' => [
								'shorcode_code' => [
									'type'  => 'text',
									'label' => 'کدکوتاه',
									'value' => ''
								],
							]
						]
					],
				]
			],
		],
	]
];
