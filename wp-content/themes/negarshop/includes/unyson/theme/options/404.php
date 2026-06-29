<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    '404_tab' => array(
        'title' => 'صفحه 404',
        'type' => 'tab',
        'options' => array(
            '404_title' => array('type' => 'text', 'label' => 'عنوان', 'value' => 'صفحه مورد نظر شما یافت نشد!'),
            '404_description' => array(
                'type' => 'wp-editor',
                'label' => 'توضیحات صفحه',
                'value' => '<p>صفحه ای که به دنبال آن هستید پیدا نشد. این خطا میتواند به دلایل زیر باشد:</p>
                                    <ul>
                                        <li>صفحه به آدرس دیگری انتقال یافته است.</li>
                                        <li>صفحه حذف شده است.</li>
                                        <li>دسترسی به صفحه محدود شده است.</li>
                                    </ul>',
            ),
        )
    )
);
?>