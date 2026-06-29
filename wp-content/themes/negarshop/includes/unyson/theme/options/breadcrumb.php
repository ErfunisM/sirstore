<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'breadcrumb_tab' => [
        'title' => 'راهنمای مسیر',
        'type' => 'tab',
        'options' => [
            'breadcrumb_align' => array(
                'type' => 'select',
                'label' => 'چینش',
                'value' => 'right',
                'choices' => array(
                    'right' => 'راست',
                    'center' => 'وسط',
                    'left' => 'چپ',
                ),
            ),
            'breadcrumb_title' => array(
                'type' => 'switch',
                'label' => 'عنوان صفحه',
                'value' => 'no',
                'left-choice' => array(
                    'value' => 'no',
                    'label' => 'غیرفعال',
                ),
                'right-choice' => array(
                    'value' => 'yes',
                    'label' => 'فعال',
                ),
            ),
            'breadcrumb_text_color' => array(
                'type' => 'color-picker',
                'label' => 'رنگ متن',
                'value' => '#666'
            ),
            'breadcrumb_background' => array(
                'type' => 'select',
                'label' => 'زمینه',
                'value' => 'classic',
                'choices' => array(
                    'no' => 'غیرفعال',
                    'color' => 'رنگ',
                    'image' => 'تصویر',
                ),
            ),
            'breadcrumb_background-picker' => array(
                'type' => 'multi-picker',
                'picker' => 'breadcrumb_background',
                'choices' => array(
                    'color' => array(
                        'full' => array(
                            'type' => 'switch',
                            'label' => 'تمام صفحه',
                            'value' => 'yes',
                            'left-choice' => array(
                                'value' => 'no',
                                'label' => 'غیرفعال',
                            ),
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => 'فعال',
                            ),
                        ),
                        'padding' => array(
                            'type' => 'slider',
                            'label' => 'فاصله داخلی',
                            'value' => 60,
                            'properties' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 1
                            ),
                        ),
                        'color' => array(
                            'type' => 'color-picker',
                            'label' => 'رنگ',
                            'value' => '#f5f5f5'
                        )
                    ),

                    'image' => array(
                        'full' => array(
                            'type' => 'switch',
                            'label' => 'تمام صفحه',
                            'value' => 'yes',
                            'left-choice' => array(
                                'value' => 'no',
                                'label' => 'غیرفعال',
                            ),
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => 'فعال',
                            ),
                        ),
                        'padding' => array(
                            'type' => 'slider',
                            'label' => 'فاصله داخلی',
                            'value' => 60,
                            'properties' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 1
                            ),
                        ),
                        'custom' => array(
                            'type' => 'upload',
                            'images_only' => true,
                            'label' => 'تصویر زمینه',
                            'value' => [],
                        ),
                        'smart' => array(
                            'type' => 'switch',
                            'label' => 'استفاده از تصویر دسته بندی',
                            'value' => 'no',
                            'left-choice' => array(
                                'value' => 'no',
                                'label' => 'غیرفعال',
                            ),
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => 'فعال',
                            ),
                        ),
                    )
                )
            ),
        ]
    ]
);