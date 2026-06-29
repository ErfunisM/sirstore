<?php
/*
Plugin Name: پِی زیتو
Description: افزونه جامع پرداخت و امور مالی وردپرس که تمام پلاگین‌ها را به همه درگاه های پرداخت متصل می کند و امکانات بی نظیر دیگری در اختیار شما قرار می دهد.
Author: پِی زیتو
Version: 1.1.24
Author URI: https://payzito.net
Requires at least: 4.0
Requires PHP: 7.4
*/

defined('ABSPATH') OR die('Payzito Wordpress Restricted Access');

defined('DS') OR define('DS',DIRECTORY_SEPARATOR);
defined('PA_WP_ROOT') OR define('PA_WP_ROOT',__DIR__);

require_once PA_WP_ROOT.DS.'main.php';
require_once PA_WP_ROOT.DS.'script.php';