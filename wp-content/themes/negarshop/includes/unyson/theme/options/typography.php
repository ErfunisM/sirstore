<?php if ( !defined('FW') ) {
	die('Forbidden');
}

$options = [
	'typography_tab' => [
		'title'   => 'تایپوگرافی',
		'type'    => 'tab',
		'options' => [
			'font_sizes_tab' => [
				'title'   => 'اندازه ها',
				'type'    => 'tab',
				'options' => [
					'heading_1' => [
						'type'  => 'text',
						'label' => 'اندازه تگ h1',
						'desc'  => 'بر اساس (px,rem)',
						'value' => '2.5rem'
					],
					'heading_2' => [
						'type'  => 'text',
						'label' => 'اندازه تگ h2',
						'desc'  => 'بر اساس (px,rem)',
						'value' => '2rem'
					],
					'heading_3' => [
						'type'  => 'text',
						'label' => 'اندازه تگ h3',
						'desc'  => 'بر اساس (px,rem)',
						'value' => '1.75rem'
					],
					'heading_4' => [
						'type'  => 'text',
						'label' => 'اندازه تگ h4',
						'desc'  => 'بر اساس (px,rem)',
						'value' => '1.5rem'
					],
					'heading_5' => [
						'type'  => 'text',
						'label' => 'اندازه تگ h5',
						'desc'  => 'بر اساس (px,rem)',
						'value' => '1.25rem'
					],
					'heading_6' => [
						'type'  => 'text',
						'label' => 'اندازه تگ h6',
						'desc'  => 'بر اساس (px,rem)',
						'value' => '1rem'
					],
				]
			],

			'fonts_tab' => [
				'title'   => 'فونت',
				'type'    => 'tab',
				'options' => [
					'site_font'        => [
						'type'    => 'select',
						'label'   => 'فونت اصلی',
						'value'   => 'IRANSans_Fa',
						'choices' => [
							'IRANSans'            => 'ایران سانس',
							'IRANSans_Fa'            => 'ایران سانس اعداد فارسی',
							'IRANYekan, IRANSans_Fa' => 'ایران یکان',
							'Vazir'                  => 'وزیر',
							'shabnam'                => 'شبنم',
							'parastoo'               => 'پرستو',
							'tahoma'                 => 'تاهوما',
							'Dima'                   => 'دیما',
							'DimaFred'               => 'دیما فرد',
							'Dima-Digital'           => 'دیما دیجیتال',
							'Dima-Classic-Medium'    => 'دیما کلاسیک',
							'DimaFont'               => 'دیما فونت',
							'custom'                 => 'فونت دلخواه'
						],
					],
					'site_font_picker' => [
						'type'    => 'multi-picker',
						'picker'  => 'site_font',
						'choices' => [
							'custom' => [
								'ttf'   => [
									'type'      => 'upload',
									'label'     => 'ttf',
									'files_ext' => ['ttf'],
								],
								'eot'   => [
									'type'      => 'upload',
									'label'     => 'eot',
									'files_ext' => ['eot'],
								],
								'woff'  => [
									'type'      => 'upload',
									'label'     => 'woff',
									'files_ext' => ['woff'],
								],
								'woff2' => [
									'type'      => 'upload',
									'label'     => 'woff2',
									'files_ext' => ['woff2'],
								],
								'svg'   => [
									'type'      => 'upload',
									'label'     => 'svg',
									'files_ext' => ['svg'],
								],
							]
						]
					],
				]
			],

		]
	]
];
global $theme_style_options;
$theme_style_options = $options;