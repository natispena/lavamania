<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

/**
  * Custom post types
  */
if ( !function_exists('ltb_add_custom_post_types') ) {

	function ltb_add_custom_post_types() {

		$cpt = array(

			'booking' 	=> true,
			'points' 	=> true,
			'cars' 	=> true,
			'tariffs' 	=> true,
			'services' 	=> true,
		);

		foreach ($cpt as $item => $enabled) {

			$cpt_include = ltbGetLocalPath( '/post_types/' . $item . '.php' );
			if ( $enabled AND file_exists( $cpt_include ) ) {

				include_once $cpt_include;
			}
		}	
	}
}
add_action( 'after_setup_theme', 'ltb_add_custom_post_types' );

if ( !function_exists('ltb_rewrite_flush' )) {

	function ltb_rewrite_flush() {

	    ltx_add_custom_post_types();
	    flush_rewrite_rules();
	}
}
add_action( 'after_switch_theme', 'ltb_rewrite_flush' );

