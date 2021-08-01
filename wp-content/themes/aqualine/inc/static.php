<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Include static files
 * Some theme-specific frontend styles are also included in theme-config.php
 */

if ( is_admin() ) {

	return;
}

/**
 * Importing icon packs
 */
if ( function_exists( 'FW' ) ) {

	fw()->backend->option_type( 'icon-v2' )->packs_loader->enqueue_frontend_css();
}
	else {
	
	wp_deregister_style( 'font-awesome' );
	wp_enqueue_style(  'font-awesome', get_template_directory_uri().'/assets/fonts/font-awesome/css/all.min.css', array(), wp_get_theme()->get('Version') );
	wp_enqueue_style(  'font-awesome-shims', get_template_directory_uri().'/assets/fonts/font-awesome/css/v4-shims.min.css', array(), wp_get_theme()->get('Version') );	
}

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

	wp_enqueue_script( 'comment-reply' );
}



/**
 * Loading javascript plugins and custom aqualine js scripts
 */
wp_enqueue_script('jquery-masonry');

wp_enqueue_script('matchheight', get_template_directory_uri() . '/assets/js/jquery.matchHeight.js', array( 'jquery' ), '', true );
wp_enqueue_script('nicescroll', get_template_directory_uri() . '/assets/js/jquery.nicescroll.js', array( 'jquery' ), '3.7.6.0', true );
wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '4.1.3', true );
wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper.min.js', array( 'jquery' ), '4.5.0', true );
wp_enqueue_script('scrollreveal', get_template_directory_uri() . '/assets/js/scrollreveal.js', array( 'jquery' ), '3.3.4', true );
wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr-2.6.2.min.js', array( 'jquery' ), '2.6.2', false );
wp_enqueue_script('waypoint', get_template_directory_uri() . '/assets/js/waypoint.js', array( 'jquery' ), '1.6.2', true );
wp_enqueue_script('parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array(), '1.1.3', true );

wp_enqueue_script('aqualine-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), wp_get_theme()->get('Version'), true );
wp_enqueue_script('aqualine-map-style', get_template_directory_uri() . '/assets/js/map-style.js', array( 'jquery' ), '1.0.0', true );

wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.js', array( 'jquery' ), '1.1.0', true );
wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '1.1.0' );


/**
 * Loading Pace Page Loader if enabled
 */
if ( function_exists( 'FW' ) ) {

	$aqualine_pace = fw_get_db_settings_option( 'page-loader' );
	if ( !empty($aqualine_pace) AND ((!empty($aqualine_pace['loader']) AND $aqualine_pace['loader'] != 'disabled') OR 
	( !empty($aqualine_pace) AND $aqualine_pace['loader'] != 'disabled') ) ) {

		wp_enqueue_script('pace', get_template_directory_uri() . '/assets/js/pace.js', array( 'jquery' ), '', true );
	}

}


/**
 * Customization
 */
if ( function_exists( 'FW' ) ) {

	require_once get_template_directory() . '/inc/theme-style/theme-style.php';
	wp_add_inline_style( 'aqualine-theme-style', aqualine_generate_css() );
}
	else {

	wp_enqueue_style( 'aqualine-google-fonts', aqualine_font_url(), array(), null );
}



