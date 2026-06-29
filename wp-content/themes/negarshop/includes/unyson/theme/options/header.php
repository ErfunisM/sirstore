<?php if (!defined('FW')) {
	die('Forbidden');
}

$options = array(
	'header-tab' => array(
		'title' => 'سربرگ',
		'type' => 'tab',
		'options' => array(
			'header-tab-main' => array(
				'title' => 'حالت اصلی',
				'type' => 'tab',
				'options' => array(
					'header-type' =>  array(
						'type'  =>  'select',
						'label' =>  'طرح سربرگ',
						'value' => 'elementor',
						'choices' => array(
							'def' => 'ساده',
							'elementor' => 'المنتور',
						),
					),
					'header-type-picker' => array(
						'type' => 'multi-picker',
						'picker' => 'header-type',
						'choices' => array(
							'def' => array(
								'header_logo' => array(
									'type' => 'upload',
									'images_only' => true,
									'label' => 'عکس لوگو',
									'value' => array(
										'url' => get_theme_file_uri('statics/images/logo.png')
									),
								),
							),
							'elementor' => array(
								'header_logo' => array(
									'type' => 'upload',
									'images_only' => true,
									'label' => 'عکس لوگو صفحه لاگین',
									'value' => array(
										'url' => get_theme_file_uri('statics/images/logo.png')
									),
								),
							)
						)
					),
				),
			),
			'header-tab-account' => array(
				'title' => 'حساب کاربری',
				'type' => 'tab',
				'options' => array(
					'login_popup' =>  array(
						'type'  =>  'select',
						'label' =>  'ورود به حساب پاپ آپ',
						'value' => 'true',
						'choices' => array(
							'true' => 'فعال',
							'false' => 'غیرفعال',
						),
					),
				)
			),
		),
	)
);