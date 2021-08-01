<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Topbar Icons
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_topbar_icons_params' ) ) {

	function ltx_vc_topbar_icons_params() {

		return array();
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_topbar_icons' ) ) {

	function like_sc_topbar_icons($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_topbar_icons', $atts, array_merge( array(

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('topbar-icons', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_topbar_icons", "like_sc_topbar_icons");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_topbar_icons_add')) {

	function ltx_vc_topbar_icons_add() {
		
		vc_map( array(
			"base" => "like_sc_topbar_icons",
			"name" 	=> esc_html__("Topbar Icons", 'lt-ext'),
			"description" => esc_html__("Topbar Search/Basket/Social Icons", 'lt-ext'),
			"class" => "like_sc_topbar_icons",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/topbar-icons/topbar-icons.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_topbar_icons_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_topbar_icons_add', 30);
}


