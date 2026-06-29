<?php if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'default_page_options' => array(
        'type' => 'box',
        'title' =>  'تنظیمات برگه',
        'options' => array(
            'sidebar'   =>  array(
                'type'  => 'image-picker',
                'value' => 'full',
                'label' =>  'ستون بندی صفحه',
                'choices' => array(
                    'left' => get_template_directory_uri() .'/statics/images/left-sidebar.png',
                    'right' => get_template_directory_uri() .'/statics/images/right-sidebar.png',
                    'full' => get_template_directory_uri() .'/statics/images/full-width.png',
                )
            )
        )
    ),
);
if(get_the_id() != get_option( 'page_on_front' )) {
    global $theme_style_options;
    $theme_style_options['style_tab']['type'] = "box";
    $opts_temps = [
        'page_styles' => array(
            'type' => 'select',
            'label' => 'استایل اختصاصی صفحه',
            'value' => 'false',
            'choices' => array(
                'true' => 'فعال',
                'false' => 'غیرفعال'
            ),
        ),
    ];
    $opts_temps = is_array($theme_style_options['style_tab']['options'])?array_merge($opts_temps, $theme_style_options['style_tab']['options']):[];
    $theme_style_options['style_tab']['options'] = $opts_temps;
    $options['style_tab'] = $theme_style_options['style_tab'];
}