<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_google_maps_params' ) ) {

	function ltx_vc_google_maps_params() {

		$fields = array(

			array(
				"param_name" => "lat",
				"heading" => esc_html__("Latitude", 'lt-ext'),
				"type" => "textfield",
				"std" => "40.7058253",
			),
			array(
				"param_name" => "lng",
				"heading" => esc_html__("Longitude", 'lt-ext'),
				"type" => "textfield",
				"std" => "-74.1180862",
			),
			array(
				"param_name" => "zoom",
				"heading" => esc_html__("Zoom", 'lt-ext'),
				"type" => "textfield",
				"std" => "11",
			),					
			array(
				"param_name" => "width",
				"heading" => esc_html__("Width", 'lt-ext'),
				"type" => "textfield",
				"std" => "100%",
			),
			array(
				"param_name" => "height",
				"heading" => esc_html__("Height", 'lt-ext'),
				"type" => "textfield",
				"std" => "400px",
			),		

		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_google_maps' ) ) {

	function like_sc_google_maps($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_google_maps', $atts, array_merge( array(

			'style'		=> 'default',
			'zoom'		=> '11',
			'lat'		=> '',
			'lng'		=> '',
			'width'		=> '100%',
			'height'	=> '200px',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		if (!empty($atts['lat']) AND !empty($atts['lng'])) {

			return like_sc_output('google_maps', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_google_maps", "like_sc_google_maps");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_google_maps_add')) {

	function ltx_vc_google_maps_add() {
		
		vc_map( array(
			"base" => "like_sc_google_maps",
			"name" 	=> esc_html__("Google Maps Styled", 'lt-ext'),
			"description" => esc_html__("Google_maps", 'lt-ext'),
			"class" => "like_sc_google_maps",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/google_maps/google_maps.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_google_maps_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_google_maps_add', 30);
}


