<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * TGM Plugin Activation
 */

require_once get_template_directory() . '/inc/tgm-plugin-activation/class-tgm-plugin-activation.php';

if ( !function_exists('aqualine_action_theme_register_required_plugins') ) {

	function aqualine_action_theme_register_required_plugins() {

		$config = array(

			'id'           => 'aqualine',
			'menu'         => 'aqualine-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => false,
			'is_automatic' => false,
		);

		tgmpa( array(

			array(
				'name'      => esc_html__('Unyson', 'aqualine'),
				'slug'      => 'unyson',
				'source'   	=> 'http://updates.like-themes.com/plugins/unyson/unyson-fork.zip',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('LT Extension', 'aqualine'),
				'slug'      => 'lt-ext',
				'source'   	=> get_template_directory() . '/inc/plugins/lt-ext.zip',
				'version'   => '2.4.4',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('LT Booking', 'aqualine'),
				'slug'      => 'lt-booking',
				'source'   	=> get_template_directory() . '/inc/plugins/lt-booking.zip',
				'version'   => '1.4.1',
				'required'  => true,
			),			
			array(
				'name'      => esc_html__('WPBakery Page Builder', 'aqualine'),
				'slug'      => 'js_composer',
				'source'   	=> 'http://updates.like-themes.com/plugins/js_composer/js_composer.zip',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Envato Market', 'aqualine'),
				'slug'      => 'envato-market',
				'source'   	=> get_template_directory() . '/inc/plugins/envato-market.zip',
				'required'  => false,
			),													
			array(
				'name'      => esc_html__('Breadcrumb-navxt', 'aqualine'),
				'slug'      => 'breadcrumb-navxt',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Contact Form 7', 'aqualine'),
				'slug'      => 'contact-form-7',
				'required'  => false,
			),
			array(
				'name'       => esc_html__('MailChimp for WordPress', 'aqualine'),
				'slug'       => 'mailchimp-for-wp',
				'required'   => false,
			),		
			array(
				'name'       => esc_html__('WooCommerce', 'aqualine'),
				'slug'       => 'woocommerce',
				'required'   => false,
			),
			array(
				'name'      => esc_html__('Post-views-counter', 'aqualine'),
				'slug'      => 'post-views-counter',
				'required'  => false,
			),			
			array(
				'name'      => esc_html__('User Profile Picture', 'aqualine'),
				'slug'      => 'metronet-profile-picture',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Instagram Widget by WPZOOM', 'aqualine'),
				'slug'      => 'instagram-widget-by-wpzoom',
				'required'  => false,
			),										
		), $config);
	}
}

add_action( 'tgmpa_register', 'aqualine_action_theme_register_required_plugins' );

