<?php if (!defined('FW')) {
    die('Forbidden');
}
$menu_items = function_exists('negarshop_get_account_menu_items')?negarshop_get_account_menu_items():[];
$items_opt = [];
if(!empty($menu_items)){
    foreach ($menu_items as $key => $name){
        $items_opt["account_tab_".$key] = [
            'type' => 'checkbox',
            'label' => $name,
            'value' => true,
            'text' => 'فعال',
        ];
        $items_opt["account_tab_".$key."_name"] = [
            'type' => 'text',
            'label' => 'نام تب',
            'value' => $name,
        ];
    }
}
$options = array(
    'account_tab' => array(
        'title' => 'حساب کاربری',
        'type' => 'tab',
        'options' => array(
            'account_menus_tab' => array(
                'title' => 'زبانه ها',
                'type' => 'tab',
                'options' => $items_opt
            )
        )
    )
);
