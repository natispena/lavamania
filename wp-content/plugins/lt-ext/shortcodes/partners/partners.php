<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Partners
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_partners_params' ) ) {

	function ltx_vc_partners_params() {

		$fields = array(

			array(
				"param_name" => "type",
				"heading" => esc_html__("Style", 'lt-ext'),
				"std" => "simple",
				"value" => array(
//					esc_html__('With border', 'lt-ext') 		=> 'border',
					esc_html__('Simple', 'lt-ext') 		=> 'simple',
				),
				"type" => "dropdown"
			),	
			array(
				"param_name" => "target",
				"heading" => esc_html__("Link Target", 'lt-ext'),
				"std" => "self",
			
				"value" => array(
					esc_html__('Current window', 'lt-ext') 		=> 'self',
					esc_html__('New window', 'lt-ext') 	=> 'blank',
				),
				"type" => "dropdown"
			),	

			/*
			array(
				"param_name" => "animation",
				"heading" => esc_html__("Animation", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default partners', 'lt-ext') 	=> 'default',
					esc_html__('Static data', 'lt-ext') 		=> 'static',
				),
				"type" => "dropdown"
			),	
*/			
			array(
				'type' => 'param_group',
				'param_name' => 'list',
				'heading' => esc_html__( 'Partners Items', 'lt-ext' ),
				'value' => 'header',
				'params' => array(
					array(
						'param_name' => 'image',
						'heading' => esc_html__( 'Upload logo', 'lt-ext' ),
						"type" => "attach_image",
						'admin_label' => true,
					),
					array(
						'param_name' => 'href',
						'heading' => esc_html__( 'Href', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),	
					array(
						'param_name' => 'header',
						'heading' => esc_html__( 'Title', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),		
				),
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_partners' ) ) {

	function like_sc_partners($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_header', $atts, array_merge( array(

			'type'		=> '',
			'animation'	=> '',
			'align'		=> '',			
			'icons' 	=> '',
			'list' 		=> '',
			'target' 		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['list'] = json_decode ( urldecode( $atts['list'] ), true );

		if (!empty($atts['list'])) {

			return like_sc_output('partners', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_partners", "like_sc_partners");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_partners_add')) {

	function ltx_vc_partners_add() {
		
		vc_map( array(
			"base" => "like_sc_partners",
			"name" 	=> esc_html__("Partners", 'lt-ext'),
			"description" => esc_html__("Partners Logos Slider", 'lt-ext'),
			"class" => "like_sc_icons",
			//"icon"	=>	ltxGetPluginUrl('/shortcodes/partners/partners.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_partners_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_partners_add', 30);
}


