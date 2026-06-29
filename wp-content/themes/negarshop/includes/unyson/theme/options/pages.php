<?php if ( !defined('FW') ) {
	die('Forbidden');
}

$options = [
	'pages_tab' => [
		'title'   => 'صفحات جانبی',
		'type'    => 'tab',
		'options' => [
			'pages_blog_tab' => [
				'title'   => 'وبلاگ',
				'type'    => 'tab',
				'options' => [
					'blog_single_comment_adv' => [
						'type'    => 'select',
						'label'   => 'حالت دیدگاه وبلاگ',
						'value'   => 'advanced',
						'choices' => [
							'advanced' => 'پیشرفته',
							'simple'   => 'ساده'
						],
					],
					'blog_sidebar'            => [
						'type'    => 'image-picker',
						'value'   => 'right',
						'label'   => 'ستون بندی وبلاگ ساده',
						'choices' => [
							'left'  => get_template_directory_uri() . '/statics/images/left-sidebar.png',
							'right' => get_template_directory_uri() . '/statics/images/right-sidebar.png',
							'full'  => get_template_directory_uri() . '/statics/images/full-width.png',
						]
					],
					'blogsingle_sidebar'      => [
						'type'    => 'image-picker',
						'value'   => 'right',
						'label'   => 'ستون بندی مطالب وبلاگ',
						'choices' => [
							'left'  => get_template_directory_uri() . '/statics/images/left-sidebar.png',
							'right' => get_template_directory_uri() . '/statics/images/right-sidebar.png',
							'full'  => get_template_directory_uri() . '/statics/images/full-width.png',
						]
					]
				]
			],
		]
	]
];