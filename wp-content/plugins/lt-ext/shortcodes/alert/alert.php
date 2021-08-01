<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_alert_params' ) ) {

	function ltx_vc_alert_params() {

		$fields = array(

			array(
				"param_name" => "type",
				"heading" => esc_html__("Type", 'lt-ext'),
				"admin_label" => true,				
				"std" => "error",
				"value" => array(
					esc_html__('Error', 'lt-ext') => 'error',
					esc_html__('Success', 'lt-ext') => 'success',
					esc_html__('Important', 'lt-ext') => 'important',
					esc_html__('Warning', 'lt-ext') => 'warning',
				),
				"type" => "dropdown"
			),
			array(
				'param_name' => 'icon_fontawesome',
				'heading' => esc_html__( 'Icon', 'lt-ext' ),
				'type' => 'iconpicker',
				'admin_label' => true,						
				'value' => '',
				'settings' => array(
					'emptyIcon' => true,
					
					'type' => 'fontawesome'

				),
			),			
			array(
				"param_name" => "header",
				"heading" => esc_html__("Header", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "text",
				"heading" => esc_html__("Description", 'lt-ext'),
				"admin_label" => false,				
				"type" => "textarea"
			),

		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_alert' ) ) {

	function like_sc_alert($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_alert', $atts, array_merge( array(

			'type'		=> '',
			'header' 	=> '',
			'text' 		=> '',
			'icon_fontawesome' 	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('alert', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_alert", "like_sc_alert");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_alert_add')) {

	function ltx_vc_alert_add() {
		
		vc_map( array(
			"base" => "like_sc_alert",
			"name" 	=> esc_html__("Alert", 'lt-ext'),
			"description" => esc_html__("Alert Block", 'lt-ext'),
			"class" => "like_sc_alert",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/alert/alert.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_alert_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_alert_add', 30);
}


