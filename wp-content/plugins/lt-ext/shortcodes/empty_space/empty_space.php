<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode empty_space
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_empty_space_params' ) ) {

	function ltx_vc_empty_space_params() {

		$fields = array(

			array(
				'param_name' => 'height_xl',
				'heading' => esc_html__( 'Height Extra Large Desktop (>1600px)', 'lt-ext' ),
				"description" => esc_html__("Set vertical space block", 'lt-ext'),						
				'type' => 'textfield',
				"std"	=>	"64px",
				'admin_label' => true,
			),
			array(
				'param_name' => 'height_lg',
				'heading' => esc_html__( 'Height for Desktop (>1200px)', 'lt-ext' ),
				"description" => esc_html__("By default inherit from larger", 'lt-ext'),				
				'type' => 'textfield',
				"std"	=>	"",
				'admin_label' => true,
			),
			array(
				'param_name' => 'height_md',
				'heading' => esc_html__( 'Height for Notebook (>1024px)', 'lt-ext' ),
				"description" => esc_html__("By default inherit from larger", 'lt-ext'),				
				'type' => 'textfield',
				"std"	=>	"",
				'admin_label' => true,
			),			
			array(
				'param_name' => 'height_sm',
				'heading' => esc_html__( 'Height for Tablet (<1024px)', 'lt-ext' ),
				"description" => esc_html__("By default inherit from larger", 'lt-ext'),				
				'type' => 'textfield',
				"std"	=>	"",
				'admin_label' => true,
			),
			array(
				'param_name' => 'height_ms',
				'heading' => esc_html__( 'Height for Mobile Horizontal (<770px)', 'lt-ext' ),
				"description" => esc_html__("By default inherit from larger", 'lt-ext'),				
				'type' => 'textfield',
				"std"	=>	"32px",
				'admin_label' => true,
			),					
			array(
				'param_name' => 'height_xs',
				'heading' => esc_html__( 'Height for Mobile (<480px)', 'lt-ext' ),
				"description" => esc_html__("By default inherit from larger", 'lt-ext'),				
				'type' => 'textfield',
				"std"	=>	"",
				'admin_label' => true,
			),						
					
		);

		return $fields;

	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_empty_space' ) ) {

	function like_sc_empty_space($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_header', $atts, array_merge( array(

			'height_xl'		=> '',
			'height_lg'		=> '',
			'height_md'		=> '',			
			'height_sm'		=> '',			
			'height_ms'		=> '',			
			'height_xs' 	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('empty_space', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_empty_space", "like_sc_empty_space");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_empty_space_add')) {

	function ltx_vc_empty_space_add() {
		
		vc_map( array(
			"base" => "like_sc_empty_space",
			"name" 	=> esc_html__("Empty Space Responsive", 'lt-ext'),
			"description" => esc_html__("Advanced Empty Space", 'lt-ext'),
			"class" => "like_sc_empty_space",
			'icon' => 'icon-wpb-ui-empty_space',
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_empty_space_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_empty_space_add', 30);
}


