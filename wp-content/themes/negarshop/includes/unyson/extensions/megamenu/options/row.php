<?php if (!defined('FW')) die('Forbidden');
$menus = negarshop_get_nav_menus_array();
$options = array(
    'mega_menu_ajax' => array(
        'type' => 'select',
        'label' => 'منوی آژاکس',
        'value' =>  'true',
        'choices' => array(
            'true' => 'فعال',
            'false' => 'غیرفعال',
        ),
    ),
    'mega_menu_type' => array(
        'type' => 'select',
        'label' => 'نوع زیر منو',
        'value' =>  'menu',
        'choices' => array(
            'menu' => 'فهرست',
            'product' => 'محصول',
            'two_level' => 'فهرست دو مرحله'
        ),
    ),
    'multi-picker' => array(
        'type' => 'multi-picker',
        'picker' => 'mega_menu_type',
        'choices' => array(
            'menu' => array(
                'menu'=>array(
                    'type'  => 'multi-select',
                    'population' => 'array',
                    'label' =>  'فهرست جهت نمایش',
                    'desc'  =>  'فهرست کنونی را انتخاب نکنید!',
                    'limit' => 1,
                    'choices' => $menus,
                ),
                'col' => array(
                    'type'    => 'select',
                    'label'   =>  'تعداد ستون ها',
                    'value'     => '4',
                    'choices' => array(
                        '3'   =>  'سه ستون',
                        '4'   =>  'چهار ستون',
                        '5'   =>  'پنج ستون',
                    ),
                ),
                'image'=>array(
                    'type'  => 'upload',
                    'label' =>  'عکس زمینه',
                    'images_only' => true,
                )
            ),

            'product' => array(
                'tabs' => array(
                    'type'  => 'addable-box',
                    'label' => 'تب ها',
                    'box-options' => array(
                        'title' => array( 'type' => 'text', 'label' =>  'عنوان' ),
                        'link' => array( 'type' => 'text', 'label' =>  'لینک' ),
                        'products_type_picker' => array(
                            'type' => 'multi-picker',
                            'picker' => array(
                                'products_type' => array(
                                    'type'    => 'select',
                                    'label'   =>  'کوئری نمایش محصولات',
                                    'value'     => 'news',
                                    'choices' => array(
                                        'news'   =>  'جدید ترین ها',
                                        'category'   =>  'دسته بندی خاص',
                                        'ids'   =>  'شناسه محصولات',
                                    ),
                                ),
                            ),
                            'label' =>  false,
                            'choices' => array(
                                'category'  =>  array(
                                    'woo_categories'    =>  array(
                                        'type'  => 'multi-select',
                                        'label' =>  'دسته بندی ها',
                                        'population' => 'taxonomy',
                                        'source' => 'product_cat',
                                    )
                                ),
                                'ids'  =>  array(
                                    'product_ids'   =>  array(
                                        'type'  =>  'text',
                                        'label' =>  'شناسه ها',
                                        'desc'  =>  'مثال: 1,2,3,4'
                                    )
                                ),
                            )
                        ),
                        'products_count'   =>  array(
                            'type'  =>  'text',
                            'label' =>  'تعداد جهت نمایش',
                            'value' =>  '5'
                        )
                    ),
                    'template' => '{{- title }}',
                    'limit' => 20,
                    'sortable' => true,
                )
            ),

            'two_level' => array(
                'tabs' => array(
                    'type'  => 'addable-box',
                    'label' => 'تب ها',
                    'box-options' => array(
                        'title' => array( 'type' => 'text', 'label' =>  'عنوان' ),
                        'link' => array( 'type' => 'text', 'label' =>  'لینک' ),

                        'menu'=>array(
                            'type'  => 'multi-select',
                            'population' => 'array',
                            'label' =>  'فهرست جهت نمایش',
                            'desc'  =>  'فهرست کنونی را انتخاب نکنید!',
                            'limit' => 1,
                            'choices' => $menus,
                        ),
                        'col' => array(
                            'type'    => 'select',
                            'label'   =>  'تعداد ستون ها',
                            'value'     => '4',
                            'choices' => array(
                                '3'   =>  'سه ستون',
                                '4'   =>  'چهار ستون',
                                '5'   =>  'پنج ستون',
                            ),
                        ),
                    ),
                    'template' => '{{- title }}',
                    'limit' => 50,
                    'sortable' => true,
                ),
                'image'=>array(
                    'type'  => 'upload',
                    'label' =>  'عکس زمینه',
                    'images_only' => true,
                )
            ),
        )
    ),
);
