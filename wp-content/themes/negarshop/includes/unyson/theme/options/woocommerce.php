<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = [
    'woocommerce_tab' => [
        'title' => 'ووکامرس',
        'type' => 'tab',
        'options' => [
            'pages_shop_tab' => [
                'title' => 'آرشیو محصولات',
                'type' => 'tab',
                'options' => [
                    'products_archive_categories' => [
                        'type' => 'select',
                        'label' => 'نمایش کریوسل دسته بندی ها',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'products_archive_categories-picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'products_archive_categories',
                        'choices' => [
                            'true' => [
                                'style' => [
                                    'type' => 'select',
                                    'label' => 'طرح کریوسل دسته بندی ها',
                                    'value' => 'default',
                                    'choices' => [
                                        'default' => 'پیشفرض',
                                        'minimal' => 'مینیمال'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'products_archive_slider' => [
                        'type' => 'select',
                        'label' => 'نمایش اسلایدر آرشیو محصولات',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'products_archive_slider_text' => [
                        'type' => 'text',
                        'label' => 'متن اسلایدر آرشیو محصولات',
                        'value' => 'محصولات پیشنهادی',
                    ],
                    'products_archive_orders_header_style' => [
                        'type' => 'select',
                        'label' => 'طرح جعبه مرتب سازی',
                        'value' => 'classic',
                        'choices' => [
                            'classic' => 'کلاسیک',
                            'transparent' => 'بدون زمینه',
                        ],
                    ],
                    'products_archive_orderby_style' => [
                        'type' => 'select',
                        'label' => 'حالت فیلد مرتب سازی',
                        'value' => 'tab',
                        'choices' => [
                            'tab' => 'تب',
                            'select' => 'انتخاب',
                        ],
                    ],
                    'products_archive_orderby_tab-picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'products_archive_orderby_style',
                        'choices' => [
                            'tab' => [
                                'style' => [
                                    'type' => 'select',
                                    'label' => 'طرح تب ها مرتب سازی',
                                    'value' => 'classic',
                                    'choices' => [
                                        'classic' => 'کلاسیک',
                                        'underline' => 'خط زیر',
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'products_archive_stock_filter' => [
                        'type' => 'select',
                        'label' => 'نمایش فیلتر موجود ها',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال',
                        ],
                    ],
                    'products_archive_active_filter' => [
                        'type' => 'select',
                        'label' => 'نمایش فیلترهای فعال',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال',
                        ],
                    ],
                    'sort_by_stock' => [
                        'type' => 'select',
                        'label' => 'نمایش محصولات موجود در ابتدا',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال',
                        ],
                    ],
                    'products_archive_res_count' => [
                        'type' => 'select',
                        'label' => 'تعداد نمایش محصولات در هر سطر در حالت موبایل',
                        'value' => '2',
                        'choices' => [
                            '1' => 'یک',
                            '2' => 'دو'
                        ],
                    ],
                    'products_archive_sidebar_acc' => [
                        'type' => 'select',
                        'label' => 'حالت آکاردیون ابزارک های کناری',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'shop_sidebar' => [
                        'type' => 'image-picker',
                        'value' => 'right',
                        'label' => 'ستون بندی صفحه',
                        'choices' => [
                            'left' => get_template_directory_uri() . '/statics/images/left-sidebar.png',
                            'right' => get_template_directory_uri() . '/statics/images/right-sidebar.png',
                            'full' => get_template_directory_uri() . '/statics/images/full-width.png',
                            'popup' => get_template_directory_uri() . '/statics/images/pop-up.png',
                        ]
                    ]
                ]
            ],
            'woocommerce_tab_checkout' => [
                'title' => 'تسویه حساب',
                'type' => 'tab',
                'options' => [
                    'checkout_steps' => [
                        'type' => 'select',
                        'label' => 'مراحل خرید',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'checkout_design' => [
                        'type' => 'select',
                        'label' => 'طرح صفحه تسویه حساب',
                        'value' => 'style-1',
                        'choices' => [
                            'style-1' => 'طرح اول',
                            'style-2' => 'طرح دوم',
                        ],
                    ],
                    'checkout_fanum' => [
                        'type' => 'select',
                        'label' => 'اجبار به تایپ فارسی',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'checkout_location' => [
                        'type' => 'select',
                        'label' => 'نقشه صفحه تسویه حساب',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'checkout_location-multi-picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'checkout_location',

                        'choices' => [
                            'true' => [
                                'lat' => [
                                    'type' => 'text',
                                    'label' => 'مقدار lat پیشفرض',
                                    'value' => '38.0717'
                                ],
                                'lon' => [
                                    'type' => 'text',
                                    'label' => 'مقدار lon پیشفرض',
                                    'value' => '46.3115'
                                ],
                            ],
                        ]
                    ],
                    'thankyou_page_customize' => [
                        'type' => 'select',
                        'label' => 'متن تشکر از خرید',
                        'value' => 'default',
                        'choices' => [
                            'default' => 'پیشفرض',
                            'custom' => 'سفارشی',
                        ],
                    ],
                    'thankyou_page-multi-picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'thankyou_page_customize',

                        'choices' => [
                            'custom' => [
                                'text' => [
                                    'type' => 'wp-editor',
                                    'label' => 'متن تشکر از خرید',
                                    'value' => 'متشکریم، سفارش شما دریافت شد.'
                                ]
                            ],
                        ]
                    ],
                ]
            ],
            'delivery-tab' => [
                'title' => 'زمان بندی ارسال',
                'type' => 'tab',
                'options' => [
                    'delivery_active' => [
                        'type' => 'select',
                        'label' => 'وضعیت نمایش',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'delivery_allowed_dates' => [
                        'type' => 'select-multiple',
                        'value' => ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'],
                        'label' => 'روز های تحویل',
                        'choices' => [
                            'saturday' => 'شنبه',
                            'sunday' => 'یکشنبه',
                            'monday' => 'دوشنبه',
                            'tuesday' => 'سه شنبه',
                            'wednesday' => 'چهارشنبه',
                            'thursday' => 'پنجشنبه',
                            'friday' => 'جمعه',
                        ],
                    ],
                    'delivery_min' => [
                        'type' => 'slider',
                        'value' => 4,
                        'desc' => 'زمان ارسال و تحویل کالا به مشتری',
                        'properties' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1
                        ],
                        'label' => 'زمان ارسال',
                    ],
                    'delivery_times' => [
                        'type' => 'slider',
                        'value' => 6,
                        'desc' => 'تعداد روز پیشنهادی در صفحه تسویه حساب',
                        'properties' => [
                            'min' => 1,
                            'max' => 15,
                            'step' => 1
                        ],
                        'label' => 'تعداد روز پیشنهادی',
                    ],
                ],
            ]
        ]
    ]
];