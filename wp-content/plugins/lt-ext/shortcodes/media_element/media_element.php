<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_media_element_params' ) ) {

	function ltx_vc_media_element_params() {

		$fields = array(

			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "track",
				"admin_label" => true,				
				"value" => array(
					esc_html__('Two lines with author', 'lt-ext') => 'track',
					esc_html__('Title only', 'lt-ext') => 'title',
				),
				"type" => "dropdown"
			),	
			
			array(
				"param_name" => "number",
				"heading" => esc_html__("Track #", 'lt-ext'),
				"type" => "textfield",
				"admin_label" => true,
			),	
			array(
				"param_name" => "title",
				"heading" => esc_html__("Title", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),				
			array(
				"param_name" => "author",
				"heading" => esc_html__("Author", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),						
			array(
				"param_name" => "file",
				"heading" => esc_html__("Select Media", 'lt-ext'),
				"admin_label" => true,
				"type" => "file_picker"
			),	
/*			
			array(
				"param_name" => "autoplay",
				"heading" => esc_html__("Autoplay", 'lt-ext'),
				"description" => esc_html__("Can be used for background music on page", 'lt-ext'),
				"std" => "track",
				"admin_label" => true,				
				"value" => array(
					esc_html__('Off', 'lt-ext') => 'off',
					esc_html__('On', 'lt-ext') => 'on',
				),
				"type" => "dropdown"
			),								
*/			
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_media_element' ) ) {

	function like_sc_media_element($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_media_element', $atts, array_merge( array(

			'layout'		=> 'track',
			'file'			=> '',
			'number'		=> '',
			'author'		=> '',
			'title'			=> '',
			'autoplay'		=> 'off',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		if (!empty($atts['file'])) {

			return like_sc_output('media_element', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_media_element", "like_sc_media_element");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_media_element_add')) {

	function ltx_vc_media_element_add() {
		
		vc_map( array(
			"base" => "like_sc_media_element",
			"name" 	=> esc_html__("Audio Track", 'lt-ext'),
			"description" => esc_html__("Single audio track", 'lt-ext'),
			"class" => "like_sc_media_element",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/media_element/media_element.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_media_element_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_media_element_add', 30);
}


