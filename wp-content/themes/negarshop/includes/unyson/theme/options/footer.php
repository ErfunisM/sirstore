<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'footer-tab' => array(
        'title' => 'پابرگ',
        'type' => 'tab',
        'options' => array(
            'footer-design-tab' => array(
                'title' => 'طراحی',
                'type' => 'tab',
                'options' => array(
                    'footer-type' =>  array(
                        'type'  =>  'select',
                        'label' =>  'طرح پابرگ',
                        'value' => 'elementor',
                        'choices' => array(
                            'def' => 'ساده',
                            'elementor' => 'المنتور',
                        ),
                    ),
                    'footer-type-picker' => array(
                        'type' => 'multi-picker',
                        'picker' => 'footer-type',
                        'choices' => array(
                            'def' => array(
                                'footer_logo' => array(
                                    'type' => 'upload',
                                    'images_only' => true,
                                    'label' => 'عکس لوگو',
                                    'value' => array(
                                        'url' => get_theme_file_uri('statics/images/logo.png')
                                    ),
                                ),
                            ),
                        )
                    ),
                )
            ),
            'footer-totop-tab' => array(
                'title' => 'بالابر',
                'type' => 'tab',
                'options' => array(
                    'to_top' =>  array(
                        'type'  =>  'select',
                        'label' =>  'بخش بالابر',
                        'value' => 'true',
                        'choices' => array(
                            'true' => 'فعال',
                            'false' => 'غیرفعال',
                        ),
                    ),
                    'to_top_picker' => array(
                        'type' => 'multi-picker',
                        'picker' => 'to_top',
                        'choices' => array(
                            'true' => array(
                                'style' =>  array(
                                    'type'  =>  'select',
                                    'label' =>  'طرح',
                                    'value' => 'style-1',
                                    'choices' => array(
                                        'style-1' => 'طرح اول',
                                        'style-2' => 'طرح دوم',
                                    ),
                                ),
                                'cart' => array(
	                                'type' => 'checkbox',
	                                'label' => 'سبد خرید',
	                                'value' =>  true,
	                                'text'  => 'فعال',
                                ),
                                'favs' => array(
	                                'type' => 'checkbox',
	                                'label' => 'علاقه مندی ها',
	                                'value' =>  true,
	                                'text'  => 'فعال',
                                ),
                                'compare' => array(
                                    'type' => 'checkbox',
                                    'label' => 'مقایسه',
                                    'value' =>  true,
                                    'text'  => 'فعال',
                                ),
                            )
                        ),
                    )
                )
            ),
        ),
    )
);