<?php if ( !defined('FW') ) {
	die('Forbidden');
}
$features     = negarshop_option('product_features');
$feature_opts = [];
if ( !empty($features) ) {
	foreach ( $features as $feature ) {
	    $slug = (!isset($feature['slug']) || empty($feature['slug'])) ? $feature['title'] : $feature['slug'];
		$feature_opts[base64_encode($slug)] = [
			'type'  => 'checkbox',
			'label' => $feature['title'],
			'desc'  => $feature['desc'],
			'value' => true,
			'text'  => 'فعال',
		];
	}
}
$alerts      = negarshop_option('product_alerts');
$alerts_opts = [];
if ( !empty($alerts) ) {
	foreach ( $alerts as $alert ) {
		$alerts_opts[md5($alert['title'])] = [
			'type'  => 'checkbox',
			'label' => $alert['title'],
			'desc'  => $alert['desc'],
			'value' => $alert['active'],
			'text'  => 'فعال',
		];
	}
}
$ribbons      = negarshop_option('product_ribbons');
$ribbons_opts = [];
if ( !empty($ribbons) ) {
	foreach ( $ribbons as $ribbon ) {
		if ( $ribbon['active'] ) {
			$ribbons_opts[md5($ribbon['title'])] = [
				'type'  => 'checkbox',
				'label' => $ribbon['title'],
				'value' => $ribbon['def'],
				'text'  => 'فعال',
			];
		}
	}
}
$options = [
	'product_side_tab'            => [
		'type'     => 'box',
		'priority' => 'high',
		'context'  => 'side',
		'title'    => 'تنظیمات محصول',
		'options'  => [
			              'product_title_field'   => [
				              'label' => 'توضیح عنوان',
				              'type'  => 'text',
				              'value' => ''
			              ],
			              'product_shipping_time' => [
				              'label'      => 'آماده ارسال از n روز بعد',
				              'desc'       => 'این محصول n روز دیگر بعد از هر سفارش ارسال می شود.',
				              'type'       => 'slider',
				              'value'      => 0,
				              'properties' => [
					              'min'  => 0,
					              'max'  => 60,
					              'step' => 1,
				              ],
			              ],
			              'product_sale'          => [
				              'type'       => 'select',
				              'fw-storage' => [
					              'type'      => 'post-meta',
					              'post-meta' => 'product_sale_slider',
				              ],
				              'label'      => 'نمایش در اسلایدر شگفت انگیز ها',
				              'desc'       => 'برای نمایش در اسلایدر شگفت انگیز ها بایستی دسته بندی این محصول در ابزارک اسلایدر شگفت انگیز ها انتخاب گردد.',
				              'value'      => 'false',
				              'choices'    => [
					              'true'  => 'فعال',
					              'false' => 'غیر فعال'
				              ],
			              ],
			              'product_def_rate'      => [
				              'label'      => 'امتیاز پیش فرض',
				              'desc'       => 'این امتیاز درصورتی که کاربری به محصول امتیاز ثبت نکرده باشد نمایش داده می شود.',
				              'type'       => 'slider',
				              'value'      => 0,
				              'properties' => [
					              'min'  => 0,
					              'max'  => 5,
					              'step' => 0.5,
				              ],
			              ],
			              'product_car_vip'       => [
				              'type'       => 'select',
				              'fw-storage' => [
					              'type'      => 'post-meta',
					              'post-meta' => 'product_car_vip',
				              ],
				              'label'      => 'نمایش در اسلایدر دسته بندی',
				              'value'      => 'false',
				              'choices'    => [
					              'true'  => 'فعال',
					              'false' => 'غیر فعال'
				              ],
			              ],
			              'product_vip_attrs'     => [
				              'label'           => 'ویژگی های کلیدی',
				              'type'            => 'addable-popup',
				              'template'        => '{{- title }}: {{- values }}',
				              'sortable'        => true,
				              'add-button-text' => 'افزودن ویژگی جدید',
				              'popup-options'   => [
					              'icon'   => [
						              'type'  => 'icon',
						              'label' => 'آیکن',
					              ],
					              'title'  => [
						              'type'  => 'text',
						              'label' => 'عنوان',
					              ],
					              'values' => [
						              'type'  => 'text',
						              'label' => 'مقدار',
					              ],
				              ],
			              ],

			              'model_ac'        => [
				              'type'    => 'multi-picker',
				              'label'   => false,
				              'value'   => [
				              	'selector'  =>  'false'
				              ],
				              'picker' => array(
					              'selector' => array(
						              'label'   => 'ماکت محصول',
						              'type'    => 'select',
						              'choices' => array(
							              'true'  => 'فعال',
							              'false' => 'غیر فعال'
						              )
					              )
				              ),
				              'choices' => [
					              'true' => [
						              'model_m' => [
							              'type'  => 'text',
							              'label' => 'آدرس فایل js ماکت',
							              'desc'  => 'تبدیل فایل obj به js <br> <a href="https://github.com/timoxley/threejs/tree/master/utils/exporters/obj">این لینک</a>',
							              'value' => '',
						              ],
						              'model_t' => [
							              'type'  => 'text',
							              'label' => 'آدرس فایل تکسچر ماکت',
							              'value' => '',
						              ],
						              'model_c' => [
							              'type'  => 'text',
							              'label' => 'آدرس xml ماکت',
							              'value' => '',
						              ],
					              ]
				              ]
			              ],
		              ] + $feature_opts,
	],
	'product_side_tab_alerts'     => [
		'type'     => 'box',
		'priority' => 'high',
		'context'  => 'side',
		'title'    => 'پیام ها',
		'options'  => $alerts_opts
	],
	'product_side_tab_ribbons'    => [
		'type'     => 'box',
		'priority' => 'high',
		'context'  => 'side',
		'title'    => 'ریبون ها',
		'options'  => $ribbons_opts
	],
	'product_side_tab_image' => [
		'type'     => 'box',
		'priority' => 'low',
		'context'  => 'side',
		'title'    => 'تنظیمات تصویر',
		'options'  => [
            'image_background' => [
                'label'       => 'رنگ زمینه تصویر',
                'type'  => 'color-picker',
                'value' => '',
            ],
			'hover_image' => [
				'type'        => 'upload',
				'images_only' => true,
				'label'       => 'تصویر دوم',
				'value'       => [
					'url' => get_theme_file_uri('statics/images/logo.png')
				],
			]
		]
	],
	'product_acc_desc_tab'        => [
		'type'     => 'box',
		'priority' => 'high',
		'title'    => 'سایر توضیحات',
		'options'  => [
			'product_acc_desc' => [
				'label'           => 'توضیحات دسته بندی شده',
				'type'            => 'addable-popup',
				'size'            => 'large',
				'template'        => '{{- title }}',
				'sortable'        => true,
				'add-button-text' => 'افزودن توضیح جدید',
				'popup-options'   => [
					'icon'   => [
						'type'  => 'icon',
						'label' => 'آیکن',
					],
					'title'  => [
						'type'  => 'text',
						'label' => 'عنوان',
					],
					'values' => [
						'type'  => 'wp-editor',
						'label' => 'توضیحات',
						'size'  => 'large',
					],
				],
			]
		],
	],
	'product_videos_tab'          => [
		'type'     => 'box',
		'priority' => 'high',
		'title'    => 'ویدئو محصول',
		'options'  => [
			'product_videos' => [
				'type'            => 'addable-box',
				'label'           => 'ویدئو های محصول',
				'box-options'     => [
					'id'    => ['type' => 'unique'],
					'title' => ['type' => 'text', 'label' => 'عنوان'],
					'value' => [
						'label'     => 'ویدئو',
						'type'      => 'upload',
						'files_ext' => ['mp4', 'webm', 'ogg'],
					],
					'url' => ['type' => 'text', 'label' => 'آدرس ویدئو','desc'=>'میتوانید به جای آپلود از لینک مستقیم استفاده کنید.'],
				],
				'template'        => '{{- title }}',
				'add-button-text' => 'افزودن ویدئو جدید',
				'sortable'        => true,
			],
		]
	],
	'product_reviews_tab'         => [
		'type'     => 'box',
		'priority' => 'high',
		'title'    => 'بررسی محصول',
		'options'  => [
			'product_reviews_rate' => [
				'type'            => 'addable-box',
				'label'           => 'امتیاز ویژگی ها',
				'box-options'     => [
					'id'    => ['type' => 'unique'],
					'title' => ['type' => 'text', 'label' => 'عنوان'],
					'value' => [
						'label'      => 'مقدار',
						'type'       => 'slider',
						'value'      => 0,
						'properties' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
				],
				'template'        => '{{- title }} ({{- value}}%)',
				'add-button-text' => 'افزودن مورد جدید',
				'sortable'        => true,
			],
			'product_reviews_p'    => [
				'label'           => 'نقاط قوت',
				'type'            => 'addable-option',
				'option'          => ['type' => 'text'],
				'add-button-text' => 'افزودن مورد جدید',
				'sortable'        => true,
			],
			'product_reviews_m'    => [
				'label'           => 'نقاط ضعف',
				'type'            => 'addable-option',
				'option'          => ['type' => 'text'],
				'add-button-text' => 'افزودن مورد جدید',
				'sortable'        => true,
			],
		],
	],
	'product_additional_tab'      => [
		'type'     => 'box',
		'priority' => 'high',
		'title'    => 'بسته محصولات پیشنهادی',
		'options'  => [
			'pa_ac'        => [
				'type'    => 'select',
				'label'   => 'وضعیت نمایش بسته محصولات پیشنهادی',
				'value'   => 'false',
				'choices' => [
					'true'  => 'فعال',
					'false' => 'غیر فعال'
				],
			],
			'pa_ac_picker' => [
				'type'    => 'multi-picker',
				'picker'  => 'pa_ac',
				'choices' => [
					'true' => [
						'pa_title'   => [
							'type'  => 'text',
							'label' => 'عنوان',
							'value' => 'بسته پیشنهادی برای این محصول'
						],
						'pa_product' => [
							'type'       => 'multi-select',
							'label'      => 'محصول گروهی',
							'desc'       => 'باید محصول گروهی انتخاب شود',
							'population' => 'posts',
							'source'     => 'product',
							'limit'      => 1,
						]
					]
				]
			],
		],
	]
];