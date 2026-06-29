<?php

defined('ABSPATH') OR die('Payzito Wordpress Restricted Access');

@include PA_WP_ROOT.DS.'includes'.DS.'libraries'.DS.'base.php';
if(!class_exists('PAConnector'))
{
    return;
}

include_once PA_WP_ROOT.DS.'addons'.DS.'loader'.DS.'loader.php';

include_once PA_WP_ROOT.DS.'addons'.DS.'payment'.DS.'payment.php';
include_once PA_WP_ROOT.DS.'addons'.DS.'sales'.DS.'sales.php';
include_once PA_WP_ROOT.DS.'addons'.DS.'tracking'.DS.'tracking.php';
include_once PA_WP_ROOT.DS.'addons'.DS.'managewallet'.DS.'managewallet.php';

add_action('init',function(){
    PAGeneral::registerQueryVars();
    PAGeneral::registerRewriteRules();
});

add_action('in_admin_header',function(){
    PAGeneral::removeAdminNotices();
},9999);

if(PAGeneral::isBackend())
{
    PAGeneral::handleBackend();
}
else
{
    PAGeneral::handleFrontend();
}

add_filter('site_transient_update_plugins',function($value){
    unset($value->response[plugin_basename(dirname(__FILE__).DS.'payzito.php')]);
    return $value;
});