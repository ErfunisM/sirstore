<?php if (!defined('FW')) {
    die('Forbidden');
}
if (!function_exists('WC')) {
    return;
}

$options = array(
    'factor_tab' => array(
        'title' => 'فاکتور ساز',
        'type' => 'tab',
        'options' => array(
            'factor_data' => array(
                'title' => 'اطلاعات',
                'type' => 'tab',
                'options' => array(
                    'factor_logo' => array(
                        'type' => 'upload',
                        'images_only' => true,
                        'label' => 'عکس لوگو',
                        'value' => array(
                            'url' => get_theme_file_uri('statics/images/logo.png')
                        ),
                    ),
                    'factor_header_label' => [
                        'type' => 'text',
                        'label' => 'نوشته سربرگ',
                        'value' => get_bloginfo('name') . ' - ' . get_bloginfo('description'),
                    ],
                    'factor_mobile_number' => [
                        'type' => 'text',
                        'label' => 'شماره تماس',
                        'value' => '',
                    ],
                    'factor_barcode' => [
                        'type' => 'select',
                        'label' => 'نمایش بارکد',
                        'value' => 'true',
                        'choices' => [
                            'false' => 'غیرفعال',
                            'true' => 'فعال',
                        ],
                    ],
                    'factor_footer_label' => [
                        'type' => 'text',
                        'label' => 'نوشته پابرگ',
                        'value' => get_bloginfo('description'),
                    ],
                )
            ),
            'factor_post' => array(
                'title' => 'اطلاعات پست',
                'type' => 'tab',
                'options' => array(
                    'factor_post_sender' => [
                        'type' => 'text',
                        'label' => 'نام فرستنده',
                        'value' => get_bloginfo('name'),
                    ],
                    'factor_post_address' => [
                        'type' => 'text',
                        'label' => 'نشانی پستی',
                        'value' => empty(WC()->countries) ? '' : WC()->countries->get_base_address(),
                    ],
                    'factor_post_pcode' => [
                        'type' => 'text',
                        'label' => 'کد پستی',
                        'value' => empty(WC()->countries) ? '' : WC()->countries->get_base_postcode(),
                    ],
                    'factor_post_mobile' => [
                        'type' => 'text',
                        'label' => 'شماره تماس برای پست',
                        'value' => '',
                    ],
                )
            ),
        )
    ),
);