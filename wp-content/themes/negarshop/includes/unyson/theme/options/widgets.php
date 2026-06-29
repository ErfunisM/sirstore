<?php if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'widgets_tab' => array(
        'title' => 'ابزارک ها',
        'type' => 'tab',
        'options' => array(
            'widgets_styles_tab' => array(
                'title' => 'طراحی',
                'type' => 'tab',
                'options' => array(
                    'wordpress_widgets_style' => [
                        'type'    => 'select',
                        'label'   => 'طرح ابزارک ها',
                        'value'   => 'classic',
                        'choices' => [
                            'classic'  => 'کلاسیک',
                            'simple' => 'ساده',
                            'underline' => 'خط پایین',
                            'bordered' => 'محصور',
                        ],
                    ],
                    'wordpress_widgets_header_style' => [
                        'type'    => 'select',
                        'label'   => 'طرح عنوان ابزارک ها',
                        'value'   => 'classic',
                        'choices' => [
                            'classic'  => 'کلاسیک',
                            'underline' => 'خط زیر',
                            'bold' => 'پر رنگ',
                        ],
                    ],
                )
            ),
            'sb_widgets_tab' => array(
                'title' => 'جایگاه های ابزارک',
                'type' => 'tab',
                'options' => array(
                    'sb_widget_items' => array(
                        'label' =>  'جایگاه ها',
                        'type'  => 'addable-box',
                        'template' => '{{- title }}',
                        'box-options' => array(
                            'title' => array( 'label'   =>  'عنوان', 'type' => 'text' ),
                        ),
                    )
                )
            ),
        )
    ),
);