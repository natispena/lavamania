<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

if ( !function_exists('ltb_enqueue_admin_styles') ) {

	function ltb_enqueue_admin_styles() {   

		ltb_wp_enqueue('style', 'lt-booking-admin', 'assets/css/lt-booking-admin.css');
	}
}

if ( is_admin() ) {

	add_action('admin_enqueue_scripts', 'ltb_enqueue_admin_styles', 100);
}


if ( !function_exists('ltb_enqueue_scripts') ) {

	function ltb_enqueue_scripts() {   

		ltb_wp_enqueue('style', 'lt-booking', 'assets/css/lt-booking.css');
		ltb_wp_enqueue('script', 'lt-booking', 'assets/js/lt-booking.js', array('jquery', 'aqualine-scripts'));

		wp_enqueue_script ( 'stripe-v3', 'https://js.stripe.com/v3/' );

		wp_localize_script( 'lt-booking', 'ltbAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
}

if ( !is_admin() ) {

	add_action( 'wp_enqueue_scripts', 'ltb_enqueue_scripts', 999 );
}

function ltb_include_unyson_custom_option_types() {
    require_once dirname(__FILE__) . '/class-fw-option-type-bootstrap-date.php';
}
add_action('fw_option_types_init', 'ltb_include_unyson_custom_option_types');

