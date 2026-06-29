<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = [
    'style_tab' => [
        'title' => 'استایل و رنگ ها',
        'type' => 'tab',
        'options' => [

            'style_main_tab' => [
                'title' => 'اصلی',
                'type' => 'tab',
                'options' => [
                    'container_size' => [
                        'label' => 'عرض سایت',
                        'type' => 'number',
                        'value' => '1315',
                    ],
                    'main_color' => [
                        'label' => 'رنگ اصلی سایت',
                        'type' => 'color-picker',
                        'value' => '#00bfd6',
                    ],
                    'main_color_compatible' => [
                        'label' => 'رنگ سازگار با رنگ اصلی',
                        'type' => 'color-picker',
                        'value' => '',
                    ],
                    'accent_color' => [
                        'label' => 'رنگ لهجه',
                        'type' => 'color-picker',
                        'value' => '#333',
                    ],
                    'bg_color' => [
                        'label' => 'رنگ زمینه سایت',
                        'type' => 'color-picker',
                        'value' => '#eee',
                    ],
                    'price_color' => [
                        'label' => 'رنگ قیمت ها',
                        'type' => 'color-picker',
                        'value' => '#4caf50',
                    ],
                    'site_radius' => [
                        'label' => 'تنظیم گردی ها',
                        'type' => 'slider',
                        'value' => 20,
                        'properties' => [
                            'min' => 0,
                            'max' => 30,
                            'step' => 1,
                        ],
                    ],
                    'bg_pattern' => [
                        'type' => 'select',
                        'label' => 'پترن زمینه',
                        'value' => 'false',
                        'choices' => [
                            'select' => 'انتخاب',
                            'upload' => 'بارگذاری',
                            'false' => 'غیرفعال'
                        ],
                    ],
                    'bg_image_picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'bg_pattern',
                        'choices' => [
                            'upload' => [
                                'bg_image' => [
                                    'type' => 'upload',
                                    'label' => 'بارگذاری طرح',
                                    'images_only' => true,
                                    'value' => [
                                        'url' => ''
                                    ],
                                ],
                            ],
                            'select' => [
                                'bg_patterns' => [
                                    'type' => 'image-picker',
                                    'value' => 'pattern-1',
                                    'label' => 'انتخاب طرح',
                                    'choices' => [
                                        'pattern-1' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-1.png',
                                        'pattern-2' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-2.png',
                                        'pattern-3' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-3.png',
                                        'pattern-4' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-4.png',
                                        'pattern-5' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-5.png',
                                        'pattern-6' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-6.png',
                                        'pattern-7' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-7.png',
                                        'pattern-8' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-8.png',
                                        'pattern-9' => get_template_directory_uri() . '/statics/images/backgrounds/patterns/pattern-9.png',
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'wide_style' => [
                        'type' => 'select',
                        'label' => 'حالت تمام صفحه',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال',
                        ],
                    ],
                    'imgs_res_bg' => [
                        'type' => 'select',
                        'label' => 'رنگ زمینه بنر ها در حالت موبایل',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال',
                        ],
                    ],
                ]
            ],

            'style_cart_tab' => [
                'title' => 'سبد خرید',
                'type' => 'tab',
                'options' => [
                    'basket_color' => [
                        'label' => 'رنگ زمینه گزینه سبد خرید',
                        'type' => 'rgba-color-picker',
                        'value' => 'rgba(0, 191, 214, 0.1)',
                    ],
                    'basket_txt_color' => [
                        'label' => 'رنگ متن گزینه سبد خرید',
                        'type' => 'rgba-color-picker',
                        'value' => '#00bfd6',
                    ],
                    'basket_badge_color' => [
                        'label' => 'رنگ زمینه شمارشگر سبد خرید',
                        'type' => 'rgba-color-picker',
                        'value' => '#00bfd6',
                    ],
                    'basket_badge_txt_color' => [
                        'label' => 'رنگ متن شمارشگر سبد خرید',
                        'type' => 'rgba-color-picker',
                        'value' => '#fff',
                    ],
                    'basket_inner_txt_color' => [
                        'label' => 'رنگ محتوای سبد خرید',
                        'type' => 'rgba-color-picker',
                        'value' => '#00bfd6',
                    ],
                ]
            ]
        ]
    ]
];
global $theme_style_options;
$theme_style_options = $options;