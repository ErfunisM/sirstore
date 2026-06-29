<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = [
    'compare_tab' => [
        'title' => 'مقایسه محصولات',
        'type' => 'tab',
        'options' => [
            'negarshop_compare' => [
                'type' => 'select',
                'label' => 'مقایسه محصولات اختصاصی نگارشاپ',
                'value' => 'true',
                'choices' => [
                    'true' => 'فعال',
                    'false' => 'غیر فعال'
                ],
            ],
            'exclude_compare_attributes' => [
                'type' => 'addable-option',
                'value' => [],
                'label' => 'استثنا کردن ویژگی ها از مقایسه',
                'desc' => 'نام ویژگی هایی که میخواهید در مقایسه محصول دیده نشوند را عین آن وارد کنید.',
                'option' => array('type' => 'text'),
                'add-button-text' => 'افزودن ویژگی جدید',
                'sortable' => false,
            ],
            'compare_count_limit' => [
                'type'  => 'slider',
                'value' => 5,
                'properties' => array(
                    'min' => 0,
                    'max' => 100,
                    'step' => 1
                ),
                'label' => 'محدودیت تعداد محصولات قابل مقایسه',
            ],
        ],
    ]
];