<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_countup_params' ) ) {

	function ltx_vc_countup_params() {

		$fields = array(
	
			array(
				"param_name" => "animation",
				"heading" => esc_html__("Animation", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default countup', 'lt-ext') 	=> 'default',
					esc_html__('Circle Progress Bar', 'lt-ext') 	=> 'ltx-circle',
					esc_html__('Static data', 'lt-ext') 		=> 'static',
				),
				"type" => "dropdown"
			),	

			array(
				"param_name" => "style",
				"heading" => esc_html__("Section Style", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('White', 'lt-ext') 		=> 'white',
					esc_html__('Main Color', 'lt-ext') 		=> 'default',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'animation',
					'value' => array( 'ltx-circle' ),
				),					
			),	

			array(
				'param_name' => 'delay',
				'heading' => esc_html__( 'Animation Delay, ms', 'lt-ext' ),
				'type' => 'textfield',
				"std" => "0",
			),			
			array(
				'param_name' => 'time',
				'heading' => esc_html__( 'Animation Time, ms', 'lt-ext' ),
				'type' => 'textfield',
				"std" => "4000",
			),					
			array(
				'type' => 'param_group',
				'param_name' => 'list',
				'heading' => esc_html__( 'CountUp Items', 'lt-ext' ),
				"description" => wp_kses_data( __("Each item can will be counted up to specified number", 'lt-ext') ),
				'value' => 'header',
				'params' => array(
					array(
						'param_name' => 'number',
						'heading' => esc_html__( 'Number up to', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),
					array(
						'param_name' => 'prefix',
						'heading' => esc_html__( 'Number prefix', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),	
					array(
						'param_name' => 'postfix',
						'heading' => esc_html__( 'Number postfix', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),														
					array(
						'param_name' => 'header',
						'heading' => esc_html__( 'Header', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),		
					array(
						'param_name' => 'descr',
						'heading' => esc_html__( 'Text', 'lt-ext' ),
						'type' => 'textarea',
					),
				),
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_countup' ) ) {

	function like_sc_countup($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_countup', $atts, array_merge( array(

			'style'		=> 'default',
			'type'		=> 'default',
			'animation'	=> '',
			'align'		=> '',			
			'delay'		=> '10',
			'time'		=> '1000',			
			'icons' 	=> '',
			'list' 		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['list'] = json_decode ( urldecode( $atts['list'] ), true );

		wp_enqueue_script( 'chartjs', ltxGetPluginUrl('/shortcodes/countup/chart.min.js'), array('jquery'), null, true );
		wp_enqueue_script( 'counterup', ltxGetPluginUrl('/shortcodes/countup/jquery.counterup.min.js'), array('jquery'), null, true );
		wp_enqueue_script( 'countup-diagram', ltxGetPluginUrl('/shortcodes/countup/countup-diagram.js'), array('jquery','chartjs'), null, true );

		if (!empty($atts['list'])) {

			return like_sc_output('countup', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_countup", "like_sc_countup");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_countup_add')) {

	function ltx_vc_countup_add() {
		
		vc_map( array(
			"base" => "like_sc_countup",
			"name" 	=> esc_html__("CountUp", 'lt-ext'),
			"description" => esc_html__("Section with CountUp Numbers", 'lt-ext'),
			"class" => "like_sc_countup",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/countup/countup.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_countup_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_countup_add', 30);
}


