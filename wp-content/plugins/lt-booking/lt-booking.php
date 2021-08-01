<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
Plugin Name: LT-Booking
Description: Car Washing Booking Plugin by Like Themes
Version: 1.4.1
Author: Like-Themes
Email: support@like-themes.com
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

define( 'LTB_PLUGIN_DIR', dirname( __FILE__ ) . '/' );
define( 'LTB_PLUGIN_URL', plugins_url( "", __FILE__ ) . '/' );

/*
	Requires Unyson Plugin
*/
if ( !in_array( 'unyson/unyson.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	function ltb_error_unyson(){

		echo '<div class="notice notice-error is-dismissible"><p>'. esc_html__( 'LT-Booking plugin requires the Unyson plugin installed and activated!', 'lt-ext' ) .'</p></div>';
	}
	add_action('admin_notices', 'ltb_error_unyson');
}
	else {

	require_once LTB_PLUGIN_DIR . 'config.php';

	//require_once LTB_PLUGIN_DIR . 'inc/checkout.php';

	require_once LTB_PLUGIN_DIR . 'inc/functions.php';

	require_once LTB_PLUGIN_DIR . 'inc/init.php';

	require_once LTB_PLUGIN_DIR . 'post-types.php';

	require_once LTB_PLUGIN_DIR . 'sections/sections.php';	
}


