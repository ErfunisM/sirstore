<?php if (!defined('FW')) {
    die('Forbidden');
}
$options = [
    fw()->theme->get_options('general'),
    fw()->theme->get_options('header'),
    fw()->theme->get_options('breadcrumb'),
    fw()->theme->get_options('footer'),
    fw()->theme->get_options('product'),
    fw()->theme->get_options('compare'),
    fw()->theme->get_options('account'),
    fw()->theme->get_options('widgets'),
    fw()->theme->get_options('pages'),
    fw()->theme->get_options('woocommerce'),
    fw()->theme->get_options('404'),
    fw()->theme->get_options('typography'),
    fw()->theme->get_options('style'),
    fw()->theme->get_options('pwa'),
    fw()->theme->get_options('sms'),
    fw()->theme->get_options('factor'),
];