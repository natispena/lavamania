<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

/**
  * Custom post types
  */
function ltx_add_custom_post_types() {

	$cpt = array(

		'testimonials' 	=> true,
//		'portfolio' 		=> true,
		'sections' 		=> true,
		'services' 		=> true,
		'sliders' 		=> true,
//		'events' 		=> true,
//		'menu' 			=> true,
		'gallery' 		=> true,
		'team' 			=> true,
//		'faq' 			=> true,
//		'albums' 	=> true,
	);

	foreach ($cpt as $item => $enabled) {

		$cpt_include = ltxGetLocalPath( '/post_types/' . $item . '/' . $item . '.php' );
		if ( $enabled AND file_exists( $cpt_include ) ) {

			include_once $cpt_include;
		}
	}	
}
add_action( 'after_setup_theme', 'ltx_add_custom_post_types' );


function ltx_rewrite_flush() {
    ltx_add_custom_post_types();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ltx_rewrite_flush' );

