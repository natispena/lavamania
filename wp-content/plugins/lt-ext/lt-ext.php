<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
Plugin Name: LT-Ext
Description: Requied plugin for Aqualine WordPress Theme
Version: 2.4.4
Author: Like-Themes
Email: support@like-themes.com
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

define( 'LTX_PLUGIN_DIR', dirname( __FILE__ ) . '/' );
define( 'LTX_PLUGIN_URL', plugins_url( "", __FILE__ ) . '/' );

register_activation_hook( __FILE__, 'ltx_plugin_activated' );

require_once LTX_PLUGIN_DIR . 'config.php';

require_once LTX_PLUGIN_DIR . 'inc/functions.php';

require_once LTX_PLUGIN_DIR . 'shortcodes/shortcodes.php';

require_once LTX_PLUGIN_DIR . 'post_types/post_types.php';

