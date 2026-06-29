<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = [
    'product_tab' => [
        'title' => 'محصول',
        'type' => 'tab',
        'options' => [
            'product_card' => [
                'title' => 'کارت محصول (صفحه فروشگاه)',
                'type' => 'tab',
                'options' => [
                    'items_placeholder' => [
                        'type' => 'select',
                        'label' => 'تصویر پیش بارگزاری کارت ها',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'items_placeholder_picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'items_placeholder',
                        'choices' => [
                            'true' => [
                                'image' => [
                                    'type' => 'upload',
                                    'images_only' => true,
                                    'label' => 'عکس ',
                                    'value' => [
                                        'url' => get_theme_file_uri('statics/images/product-placeholder.png')
                                    ],
                                ],
                            ]
                        ]
                    ],
                    'items_thumbnail_size' => [
                        'type' => 'select',
                        'label' => 'ابعاد تصویر محصول',
                        'value' => '1x1',
                        'choices' => [
                            '1x1' => 'مربع',
                            '1x1.1' => '1 در 1.1',
                            '1x1.2' => '1 در 1.2',
                            '1x1.3' => '1 در 1.3',
                            '1x1.4' => '1 در 1.4',
                            '1x1.5' => '1 در 1.5',
                            '1x1.6' => '1 در 1.6',
                            '1x1.7' => '1 در 1.7',
                            '1x1.8' => '1 در 1.8',
                            '1x1.9' => '1 در 1.9',
                            '1x2' => '1 در 2',
                            '2x1' => '2 در 1',
                            '2x1.1' => '2 در 1.1',
                            '2x1.2' => '2 در 1.2',
                            '2x1.3' => '2 در 1.3',
                            '2x1.4' => '2 در 1.4',
                            '2x1.5' => '2 در 1.5',
                            '2x1.6' => '2 در 1.6',
                            '2x1.7' => '2 در 1.7',
                            '2x1.8' => '2 در 1.8',
                            '2x1.9' => '2 در 1.9',
                        ],
                    ],
                    'items_price' => [
                        'type' => 'select',
                        'label' => 'وضعیت نمایش قیمت محصول',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'items_title' => [
                        'type' => 'select',
                        'label' => 'نمایش کامل عنوان',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'one_price' => [
                        'type' => 'select',
                        'label' => 'نمایش قیمت واحد',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'sale_price_responsive' => [
                        'type' => 'select',
                        'label' => 'نمایش قیمت قبل از تخفیف در ریسپانسیو',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'item_ribbs' => [
                        'type' => 'select',
                        'label' => 'نمایش ریبون ها',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'item_brand' => [
                        'type' => 'select',
                        'label' => 'نمایش برند',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'item_rate' => [
                        'type' => 'select',
                        'label' => 'نمایش امتیاز',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'item_colors' => [
                        'type' => 'select',
                        'label' => 'نمایش رنگ های محصول',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'card_bottom_actions_style' => [
                        'type' => 'select',
                        'label' => 'طرح گزینه های کارت',
                        'value' => 'minimal-actions',
                        'choices' => [
                            'minimal-actions' => 'مینیمال',
                            'bold-actions' => 'بولد',
                            'side-actions' => 'کنار',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'product_action_more' => [
                        'type' => 'checkbox',
                        'label' => 'گزینه مشاهده سریع',
                        'value' => true,
                        'text' => 'فعال',
                    ],
                    'product_action_addtocart' => [
                        'type' => 'checkbox',
                        'label' => 'گزینه افزودن به سبد خرید',
                        'value' => true,
                        'text' => 'فعال',
                    ],
                    'product_action_compare' => [
                        'type' => 'checkbox',
                        'label' => 'گزینه مقایسه',
                        'value' => true,
                        'text' => 'فعال',
                    ],
                    'product_action_like' => [
                        'type' => 'checkbox',
                        'label' => 'گزینه علاقه مندی',
                        'value' => true,
                        'text' => 'فعال',
                    ],
                ]
            ],
            'product_page' => [
                'title' => 'صفحه محصول',
                'type' => 'tab',
                'options' => [
                    'product_single_type' => [
                        'type' => 'image-picker',
                        'value' => 'type-1',
                        'label' => 'ساختار صفحه',
                        'choices' => [
                            'type-1' => get_template_directory_uri() . '/statics/images/options/single-1.png',
                            'type-2' => get_template_directory_uri() . '/statics/images/options/single-2.png',
                            'type-3' => get_template_directory_uri() . '/statics/images/options/single-3.png',
                        ]
                    ],
                    'product_single_type-picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'product_single_type',
                        'choices' => [
                            'type-1' => [
                                'actions_position' => [
                                    'type' => 'select',
                                    'label' => 'جایگاه دکمه ها',
                                    'value' => 'thumbnail',
                                    'choices' => [
                                        'thumbnail' => 'بالای تصویر محصول',
                                        'cart' => 'بالای سبد خرید'
                                    ],
                                ],
                                'actions_style' => [
                                    'type' => 'select',
                                    'label' => 'طرح دکمه ها',
                                    'value' => 'classic',
                                    'choices' => [
                                        'classic' => 'کلاسیک',
                                        'simple' => 'ساده',
                                        'bordered' => 'محصور',
                                    ],
                                ],
                                'cart_style' => [
                                    'type' => 'select',
                                    'label' => 'طرح فرم خرید محصول',
                                    'value' => 'classic',
                                    'choices' => [
                                        'classic' => 'کلاسیک',
                                        'simple' => 'ساده',
                                        'bordered' => 'محصور',
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'product_thumbnail_background' => [
                        'type' => 'select',
                        'label' => 'رنگ زمینه تصویر محصول',
                        'value' => 'transparent',
                        'choices' => [
                            'transparent' => 'بدون رنگ',
                            'gray' => 'رنگی'
                        ],
                    ],
                    'product_thumbnail_size' => [
                        'type' => 'select',
                        'label' => 'ابعاد تصویر محصول',
                        'value' => '1x1',
                        'choices' => [
                            '1x1' => 'مربع',
                            '1x1.1' => '1 در 1.1',
                            '1x1.2' => '1 در 1.2',
                            '1x1.3' => '1 در 1.3',
                            '1x1.4' => '1 در 1.4',
                            '1x1.5' => '1 در 1.5',
                            '1x1.6' => '1 در 1.6',
                            '1x1.7' => '1 در 1.7',
                            '1x1.8' => '1 در 1.8',
                            '1x1.9' => '1 در 1.9',
                            '1x2' => '1 در 2',
                            '2x1' => '2 در 1',
                            '2x1.1' => '2 در 1.1',
                            '2x1.2' => '2 در 1.2',
                            '2x1.3' => '2 در 1.3',
                            '2x1.4' => '2 در 1.4',
                            '2x1.5' => '2 در 1.5',
                            '2x1.6' => '2 در 1.6',
                            '2x1.7' => '2 در 1.7',
                            '2x1.8' => '2 در 1.8',
                            '2x1.9' => '2 در 1.9',
                        ],
                    ],
                    'product_short_description_trigger' => [
                        'type' => 'select',
                        'label' => 'کوتاه کردن معرفی کوتاه محصول',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_responsive_popup' => [
                        'type' => 'select',
                        'label' => 'نمایش توضیحات و ویژگی و... در پاپ آپ',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_responsive_add_to_cart' => [
                        'type' => 'select',
                        'label' => 'نمایش خرید محصول در پاپ آپ',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_tab_styles' => [
                        'type' => 'select',
                        'label' => 'طرح های تب بندی',
                        'value' => 'style-1',
                        'choices' => [
                            'style-1' => 'طرح اول',
                            'style-2' => 'طرح دوم',
                            'style-3' => 'طرح سوم',
                            'style-4' => 'طرح چهارم',
                            'style-5' => 'طرح پنجم',
                        ],
                    ],
                    'product_acc_desc' => [
                        'type' => 'select',
                        'label' => 'توضیحات دسته بندی شده',
                        'value' => 'show',
                        'choices' => [
                            'show' => 'باز شده',
                            'hide' => 'جمع شده'
                        ],
                    ],
                    'product_shipping_time' => [
                        'type' => 'select',
                        'label' => 'نمایش زمان ارسال',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_price_percent' => [
                        'type' => 'select',
                        'label' => 'رند کردن درصد تخفیف',
                        'value' => 'false',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_price_update' => [
                        'type' => 'select',
                        'label' => 'نمایش آخرین بروزرسانی قیمت',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_varation_price' => [
                        'type' => 'select',
                        'label' => 'نمایش بازه قیمت محصول متغیر',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'noprice_text' => [
                        'type' => 'text',
                        'label' => 'متن بدون قیمت',
                        'value' => 'بزودی موجود می شود!'
                    ],
                    'product_stock_ac' => [
                        'type' => 'select',
                        'label' => 'نمایش تعداد موجودی برای کاربر',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_sales_ac' => [
                        'type' => 'checkbox',
                        'label' => 'نمایش تعداد فروش برای کاربر',
                        'value' => true,
                        'text' => 'فعال',
                    ],
                    'product_category_tools' => [
                        'type' => 'select',
                        'label' => 'نمایش دسته بندی و امتیاز و...',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_rate' => [
                        'type' => 'select',
                        'label' => 'نوع امتیاز محصول',
                        'value' => 'number',
                        'choices' => [
                            'number' => 'عددی',
                            'star' => 'ستاره ای'
                        ],
                    ],
                    'product_tags_tools' => [
                        'type' => 'select',
                        'label' => 'نمایش برچسب ها',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_tools_ac' => [
                        'type' => 'select',
                        'label' => 'نمایش ابزارک های محصول',
                        'desc' => 'ابزارک های پسندیدن، اشتراک گذاری، مقایسه و...',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'product_tools_picker' => [
                        'type' => 'multi-picker',
                        'picker' => 'product_tools_ac',
                        'choices' => [
                            'true' => [
                                'product_tools_like' => [
                                    'type' => 'checkbox',
                                    'label' => 'علاقه مندی',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                                'product_tools_share' => [
                                    'type' => 'checkbox',
                                    'label' => 'اشتراک گذاری',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                                'product_tools_wait' => [
                                    'type' => 'checkbox',
                                    'label' => 'اطلاع رسانی هنگام موجود شدن',
                                    'desc' => 'فقط برای محصولات ناموجود',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                                'product_tools_compare' => [
                                    'type' => 'checkbox',
                                    'label' => 'مقایسه',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                                'product_tools_changes' => [
                                    'type' => 'checkbox',
                                    'label' => 'تغییرات قیمت',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                                'product_tools_3dview' => [
                                    'type' => 'checkbox',
                                    'label' => 'نمایش سه بعدی',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                                'product_tools_video' => [
                                    'type' => 'checkbox',
                                    'label' => 'نمایش ویدئو محصول',
                                    'value' => true,
                                    'text' => 'فعال',
                                ],
                            ],
                        ]
                    ],
                    'related_count' => [
                        'type' => 'slider',
                        'value' => 4,
                        'properties' => [
                            'min' => 1,
                            'max' => 10,
                            'step' => 1
                        ],
                        'label' => 'تعداد نمایش محصولات مرتبط در هر اسلاید',
                    ],


                    'product_features' => [
                        'type' => 'addable-box',
                        'label' => 'ویژگی محصولات',
                        'box-options' => [
                            'slug' => ['type' => 'text', 'label' => 'اسلاگ انگلیسی'],
                            'title' => ['type' => 'text', 'label' => 'نام'],
                            'desc' => ['type' => 'text', 'label' => 'توضیح مختصر'],
                            'content' => ['type' => 'wp-editor', 'label' => 'توضیح کامل'],
                            'icon_type' => [
                                'type' => 'select',
                                'label' => 'نوع آیکن',
                                'value' => 'false',
                                'choices' => [
                                    'select' => 'انتخاب',
                                    'upload' => 'بارگذاری',
                                    'false' => 'غیرفعال'
                                ],
                            ],
                            'icon_picker' => [
                                'type' => 'multi-picker',
                                'picker' => 'icon_type',
                                'choices' => [
                                    'upload' => [
                                        'image' => [
                                            'type' => 'upload',
                                            'label' => 'بارگذاری',
                                            'images_only' => true,
                                            'value' => [
                                                'url' => ''
                                            ],
                                        ],
                                    ],
                                    'select' => [
                                        'image' => [
                                            'type' => 'image-picker',
                                            'value' => '30abad48',
                                            'label' => 'انتخاب',
                                            'choices' => [
                                                '30abad48' => get_template_directory_uri() . '/statics/images/svg/30abad48.svg',
                                                '28cf2088' => get_template_directory_uri() . '/statics/images/svg/28cf2088.svg',
                                                '4c9cdf1f' => get_template_directory_uri() . '/statics/images/svg/4c9cdf1f.svg',
                                                'd9c5e979' => get_template_directory_uri() . '/statics/images/svg/d9c5e979.svg',
                                                '9aec2c1d' => get_template_directory_uri() . '/statics/images/svg/9aec2c1d.svg',
                                                'a2d8b759' => get_template_directory_uri() . '/statics/images/svg/a2d8b759.svg',
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                        ],
                        'template' => '{{- title }}',
                        'limit' => 10,
                        'sortable' => true,
                    ],
                    'product_alerts' => [
                        'type' => 'addable-box',
                        'label' => 'پیام های سفارشی',
                        'box-options' => [
                            'active' => [
                                'type' => 'checkbox',
                                'label' => 'وضعیت',
                                'value' => true,
                                'text' => 'فعال',
                            ],
                            'icon' => [
                                'label' => 'آیکن',
                                'type' => 'icon',
                                'value' => '',
                            ],
                            'title' => ['type' => 'text', 'label' => 'نام'],
                            'desc' => ['type' => 'text', 'label' => 'توضیحات'],
                            'link' => ['type' => 'text', 'label' => 'آدرس'],
                            'bg' => [
                                'label' => 'رنگ زمینه',
                                'type' => 'rgba-color-picker',
                                'value' => 'rgba(50, 50, 50, 0.1)',
                            ],
                            'color' => [
                                'label' => 'رنگ متن',
                                'type' => 'rgba-color-picker',
                                'value' => 'rgba(50, 50, 50, 1)',
                            ],
                            'roles' => [
                                'type' => 'select',
                                'label' => 'شرط نمایش',
                                'value' => 'all',
                                'choices' => [
                                    'all' => 'در هر صورت',
                                    'instock' => 'در صورت موجود بودن',
                                    'outofstock' => 'در صورت ناموجود بودن',
                                ],
                            ],
                        ],
                        'template' => '{{- title }}',
                        'limit' => 10,
                        'sortable' => true,
                    ],
                    'product_tabs' => [
                        'type' => 'addable-box',
                        'label' => 'تب های محصولات',
                        'box-options' => [
                            'active' => [
                                'type' => 'checkbox',
                                'label' => 'وضعیت',
                                'value' => true,
                                'text' => 'فعال',
                            ],
                            'title' => ['type' => 'text', 'label' => 'نام'],
                            'slug' => ['type' => 'text', 'label' => 'نامک'],
                            'priority' => ['type' => 'text', 'label' => 'ترتیب'],
                        ],
                        'template' => '{{- title }}',
                        'value' => [
                            [
                                'active' => true,
                                'title' => 'توضیحات',
                                'slug' => 'description',
                                'priority' => 10
                            ],
                            [
                                'active' => true,
                                'title' => 'بررسی ها',
                                'slug' => 'cb_rates',
                                'priority' => 10
                            ],
                            [
                                'active' => true,
                                'title' => 'مشخصات',
                                'slug' => 'additional_information',
                                'priority' => 20
                            ],
                            [
                                'active' => true,
                                'title' => 'نظرات',
                                'slug' => 'reviews',
                                'priority' => 30
                            ],
                            [
                                'active' => true,
                                'title' => 'پرسش و پاسخ',
                                'slug' => 'ns_questions',
                                'priority' => 35
                            ],
                            [
                                'active' => true,
                                'title' => 'حمل و نقل',
                                'slug' => 'shipping',
                                'priority' => 12
                            ],
                            [
                                'active' => true,
                                'title' => 'اطلاعات فروشنده',
                                'slug' => 'seller',
                                'priority' => 90
                            ],
                        ],
                        'sortable' => false,
                    ],

                ]
            ],
            'product_comments' => [
                'title' => 'دیدگاه ها',
                'type' => 'tab',
                'options' => [
                    'comment_upload_files' => [
                        'type' => 'select',
                        'label' => 'ارسال تصویر در دیدگاه',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیر فعال'
                        ],
                    ],
                    'comment_title' => [
                        'type' => 'text',
                        'label' => 'عنوان ارسال دیدگاه',
                        'value' => 'شما هم می‌توانید در مورد این کالا نظر بدهید.'
                    ],
                    'comment_desc' => [
                        'type' => 'wp-editor',
                        'label' => 'توضیحات ارسال دیدگاه',
                        'value' => 'برای ثبت نظر، از طریق دکمه زیر اقدام نمایید. اگر این محصول را قبلا از نگارشاپ خریده باشید، نظر شما به عنوان مالک محصول ثبت خواهد شد.'
                    ],
                    'comment_rules_title' => [
                        'type' => 'text',
                        'label' => 'عنوان قوانین دیدگاه',
                        'value' => 'دیگران را با نوشتن نظرات خود، برای انتخاب این محصول راهنمایی کنید.'
                    ],
                    'comment_rules_desc' => [
                        'type' => 'wp-editor',
                        'label' => 'عنوان قوانین دیدگاه',
                        'value' => '
<p>لطفا پیش از ارسال نظر، خلاصه قوانین زیر را مطالعه کنید:</p>
<p>فارسی بنویسید و از کیبورد فارسی استفاده کنید. بهتر است از فضای خالی (Space) بیش‌از‌حدِ معمول، شکلک یا ایموجی استفاده نکنید و از کشیدن حروف یا کلمات با صفحه‌کلید بپرهیزید.</p>
<p>نظرات خود را براساس تجربه و استفاده‌ی عملی و با دقت به نکات فنی ارسال کنید؛ بدون تعصب به محصول خاص، مزایا و معایب را بازگو کنید و بهتر است از ارسال نظرات چندکلمه‌‌ای خودداری کنید.</p>
<p>بهتر است در نظرات خود از تمرکز روی عناصر متغیر مثل قیمت، پرهیز کنید.</p>
<p>به کاربران و سایر اشخاص احترام بگذارید. پیام‌هایی که شامل محتوای توهین‌آمیز و کلمات نامناسب باشند، حذف می‌شوند.</p>'
                    ],
                ]
            ],
            'product_survey' => [
                'title' => 'نظرسنجی',
                'type' => 'tab',
                'options' => [
                    'ps_active' => [
                        'type' => 'select',
                        'label' => 'وضعیت نمایش',
                        'value' => 'true',
                        'choices' => [
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ],
                    ],
                    'ps_question' => [
                        'type' => 'text',
                        'label' => 'متن سوال نظرسنجی',
                        'value' => 'آیا از قیمت های ما رضایت دارید؟'
                    ],
                    'ps_ans1' => [
                        'type' => 'text',
                        'label' => 'متن گزینه اول',
                        'value' => 'بله'
                    ],
                    'ps_ans2' => [
                        'type' => 'text',
                        'label' => 'متن گزینه دوم',
                        'value' => 'خیر'
                    ],
                    'ps_desc' => [
                        'type' => 'text',
                        'label' => 'متن توضیحات',
                        'value' => 'این کالا را با چه قیمتی دیده‌اید؟'
                    ],
                    'ps_desc2' => [
                        'type' => 'text',
                        'label' => 'متن توضیحات دوم',
                        'value' => ''
                    ],
                    'ps_thanks' => [
                        'type' => 'text',
                        'label' => 'متن تشکر',
                        'value' => 'از شما بابت همکاری متشکریم...'
                    ],
                ]
            ],
            'product_ribbons_tab' => [
                'title' => 'ریبون ها',
                'type' => 'tab',
                'options' => [
                    'ribb_stock_color' => [
                        'type' => 'color-picker',
                        'value' => '#999999',
                        'label' => 'رنگ ریبون ناموجود'
                    ],
                    'ribb_sale_color' => [
                        'type' => 'color-picker',
                        'value' => '#999999',
                        'label' => 'رنگ ریبون تخفیف'
                    ],
                    'ribb_3d_color' => [
                        'type' => 'color-picker',
                        'value' => '#999999',
                        'label' => 'رنگ ریبون سه بعدی'
                    ],

                    'product_ribbons' => [
                        'type' => 'addable-box',
                        'label' => 'ریبون های سفارشی',
                        'box-options' => [
                            'active' => [
                                'type' => 'checkbox',
                                'label' => 'وضعیت',
                                'value' => true,
                                'text' => 'فعال',
                            ],
                            'def' => [
                                'type' => 'checkbox',
                                'label' => 'پیشفرض روی همه محصولات اعمال شود',
                                'value' => false,
                                'text' => 'فعال',
                            ],
                            'color' => [
                                'type' => 'color-picker',
                                'value' => '#999999',
                                'label' => 'رنگ'
                            ],
                            'title' => ['type' => 'text', 'label' => 'نام'],
                            'icon' => ['type' => 'icon', 'label' => 'آیکن'],
                        ],
                        'template' => '{{- title }}',
                        'value' => [],
                        'sortable' => true,
                    ],
                ]
            ]
        ],
    ]
];