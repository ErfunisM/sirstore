<?php defined('ABSPATH') || die;
/**
 * RTL Care Unit Plugin
 *
 * @package           RTL-CareUnit
 * @author            RTL-Theme
 * @copyright         RTL-Theme
 * @license           RTL-Theme
 *
 * @wordpress-plugin
 *
 * Plugin Name:         RTL license management
 * Plugin URI:          https://www.rtl-theme.com/
 * Description:         A plugin to activate, update and take care of RTL WordPress products
 * Version:             1.7.7
 * Requires at least:   5.0
 * Requires PHP:        7.2
 * Author:              RTL-Theme
 * Author URI:          https://www.rtl-theme.com/
 * License:             RTL-Theme License
 * License URI:         https://www.rtl-theme.com/
 * Text Domain:         rtltheme
 * Domain Path:         /languages
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

register_activation_hook(__FILE__, 'rcuPluginActivationAction');
