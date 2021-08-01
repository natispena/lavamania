<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode locations
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_locations_params' ) ) {

	function ltx_vc_locations_params() {

		$fields = array(

			array(
				"param_name" => "slider",
				"heading" => esc_html__("Slider", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Enabled', 'lt-ext') 	=> 'default',
					esc_html__('Disabled', 'lt-ext') 	=> 'disabled',
				),
				"type" => "dropdown"
			),					
			array(
				"param_name" => "per_row",
				"heading" => esc_html__("Columns", 'lt-ext'),
				"std"	=>	"3",
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "per_col",
				"heading" => esc_html__("Items per column", 'lt-ext'),
				"std"	=>	"2",
				"admin_label" => true,
				"type" => "textfield"
			),			
			array(
				'type' => 'param_group',
				'param_name' => 'list',
				'heading' => esc_html__( 'Locations', 'lt-ext' ),
				'value' => 'header',
				'params' => array(
					array(
						'param_name' => 'image',
						'heading' => esc_html__( 'Upload logo', 'lt-ext' ),
						"type" => "attach_image",
						'admin_label' => true,
					),
					array(
						'param_name' => 'header',
						'heading' => esc_html__( 'Title', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),		
					array(
						'param_name' => 'descr',
						'heading' => esc_html__( 'Description', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => false,
					),
					array(
						'param_name' => 'href',
						'heading' => esc_html__( 'Href', 'lt-ext' ),
						"description" => esc_html__("(not required)", 'lt-ext'),
						'type' => 'textfield',
						'admin_label' => false,
					),										
				),
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_locations' ) ) {

	function like_sc_locations($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_header', $atts, array_merge( array(

			'slider'		=> '',
			'animation'	=> '',
			'align'		=> '',			
			'icons' 	=> '',
			'per_row' 	=> '',
			'per_col' 	=> '',
			'list' 		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['list'] = json_decode ( urldecode( $atts['list'] ), true );

		if (!empty($atts['list'])) {

			return like_sc_output('locations', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_locations", "like_sc_locations");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_locations_add')) {

	function ltx_vc_locations_add() {
		
		vc_map( array(
			"base" => "like_sc_locations",
			"name" 	=> esc_html__("Locations", 'lt-ext'),
			"description" => esc_html__("Locations Slider", 'lt-ext'),
			"class" => "like_sc_locations",
			//"icon"	=>	ltxGetPluginUrl('/shortcodes/locations/locations.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_locations_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_locations_add', 30);
}


