<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Content_width
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_content_width_params' ) ) {

	function ltx_vc_content_width_params() {

		$fields = array(		

			array(
				"type" => "dropdown",
				"heading" => esc_html__("Content Align", 'lt-ext'),
				"param_name" => "align",
				"std"	=>	"center",
				"value" => array(
					esc_html__( "Left", 'lt-ext' ) => "left",
					esc_html__( "Center", 'lt-ext' ) => "center",
					esc_html__( "Right", 'lt-ext' ) => "right",
				),			
			),		

			array(
				"type" => "dropdown",
				"heading" => esc_html__("Block Align", 'lt-ext'),
				"param_name" => "block-align",
				"std"	=>	"left",
				"value" => array(
					esc_html__( "Left", 'lt-ext' ) => "left",
					esc_html__( "Center", 'lt-ext' ) => "center",
					esc_html__( "Right", 'lt-ext' ) => "right",
				),			
			),						
			array(
				"param_name" => "max_width",
				"heading" => esc_html__("Max Width", 'lt-ext'),
				"type" => "textfield",
				"std"	=>	"500",
			),								
		);

		return $fields;

	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_content_width' ) ) {

	function like_sc_content_width($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_content_width', $atts, array_merge( array(

			'max_width'		=> '',
			'align'			=> 'center',
			'block-align'			=> 'left',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('content_width', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_content_width", "like_sc_content_width");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_content_width_add')) {

	function ltx_vc_content_width_add() {
		
		vc_map( array(
			"base" => "like_sc_content_width",
			"name" 	=> esc_html__("Content Width", 'lt-ext'),
			"description" => esc_html__("Text Width Limitation", 'lt-ext'),
			"class" => "like_sc_content_width",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/content_width/content_width.png'),
			"is_container" => true,
			"js_view" => 'VcColumnView',
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_content_width_params(),
				ltx_vc_default_params()
			),
		) );

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		    class WPBakeryShortCode_like_sc_content_width extends WPBakeryShortCodesContainer {
		    }
		}
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_content_width_add', 30);
}


