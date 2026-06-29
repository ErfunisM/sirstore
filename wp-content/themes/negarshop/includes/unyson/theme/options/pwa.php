<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = [
    'pwa_tab' => [
        'title' => 'PWA',
        'type' => 'tab',
        'options' => [
            'all_settings' => [
                'title' => 'کلی',
                'type' => 'tab',
                'options' => [
                    'pwa_status' => [
                        'type' => 'select',
                        'label' => 'وضعیت',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ]
                ]
            ],
            'bottom_bar_settings' => [
                'title' => 'نوار هوشمند پایین',
                'type' => 'tab',
                'options' => [
                    'bottom_smart_bar' => [
                        'type' => 'select',
                        'label' => 'نوار هوشمند پایین',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'bottom_smart_bar_style' => [
                        'type' => 'select',
                        'label' => 'سبک نوار',
                        'value' => 'fit',
                        'choices' => [
                            'fit' => 'پیشفرض',
                            'minimal' => 'مینیمال'
                        ],
                    ],
                    'bottom_home' => [
                        'type' => 'select',
                        'label' => 'خانه',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'bottom_search' => [
                        'type' => 'select',
                        'label' => 'جستجو',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'bottom_cats' => [
                        'type' => 'select',
                        'label' => 'دسته بندی ها',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'bottom_cart' => [
                        'type' => 'select',
                        'label' => 'سبد خرید',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'bottom_account' => [
                        'type' => 'select',
                        'label' => 'حساب کاربری',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                ]
            ],
            'bottom_bar_search_settings' => [
                'title' => 'فرم جستجو',
                'type' => 'tab',
                'options' => [
                    'bottom_bar_search_ajax' => [
                        'type' => 'select',
                        'label' => 'حالت آژاکس',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال'
                        ],
                    ],
                    'bottom_bar_search_filters' => [
                        'type' => 'select',
                        'label' => 'فیلتر ها',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال'
                        ],
                    ],
                    'bottom_bar_search_type' => [
                        'type' => 'select',
                        'label' => 'محتوای جهت جستجو',
                        'value' => 'product',
                        'choices' => [
                            'product' => 'محصولات',
                            'post' => 'مقالات'
                        ],
                    ]
                ]
            ],
            'colors_settings' => [
                'title' => 'رنگ ها',
                'type' => 'tab',
                'options' => [
                    'pwa_primary_color' => [
                        'label' => 'رنگ اپ',
                        'type' => 'color-picker',
                        'value' => '#00bfd6',
                    ],
                    'pwa_bg_color' => [
                        'label' => 'رنگ زمینه اپ',
                        'type' => 'color-picker',
                        'value' => '#fff',
                    ],
                ]
            ],
            'texts_settings' => [
                'title' => 'متن ها',
                'type' => 'tab',
                'options' => [
                    'app_title' => [
                        'label' => 'نام کوتاه اپلیکیشن',
                        'type' => 'text',
                        'value' => get_bloginfo('name'),
                    ],
                    'app_full_title' => [
                        'label' => 'نام کامل اپلیکیشن',
                        'type' => 'text',
                        'value' => get_bloginfo('name'),
                    ],
                    'app_desc' => [
                        'label' => 'توضیح اپلیکیشن',
                        'type' => 'text',
                        'value' => get_bloginfo('description'),
                    ],
                    'display_format' => [
                        'type' => 'select',
                        'label' => 'حالت نمایش',
                        'value' => 'standalone',
                        'choices' => [
                            'fullscreen' => 'تمام صفحه',
                            'standalone' => 'ایستاده',
                            'minimal-ui' => 'minimal ui',
                        ],
                    ],
                ]
            ],
            'icons_settings' => [
                'title' => 'آیکن ها',
                'type' => 'tab',
                'options' => [
                    'icons_192' => [
                        'type' => 'upload',
                        'images_only' => true,
                        'label' => 'آیکن اندازه 192 در 192 پیکسل',
                        'desc' => 'حتما باید 192px در 192px باشد',
                        'value' => [
                            'url' => get_theme_file_uri('statics/images/logo_192.png')
                        ],
                    ],
                    'icons_512' => [
                        'type' => 'upload',
                        'images_only' => true,
                        'label' => 'آیکن اندازه 512 در 512 پیکسل',
                        'desc' => 'حتما باید 512px در 512px باشد',
                        'value' => [
                            'url' => get_theme_file_uri('statics/images/logo_512.png')
                        ],
                    ],
                ]
            ],
        ],
    ]
];