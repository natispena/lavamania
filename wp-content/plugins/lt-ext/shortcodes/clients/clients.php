<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Partners
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_clients_params' ) ) {

	function ltx_vc_clients_params() {

		$fields = array(
			array(
				'type' => 'param_group',
				'param_name' => 'list',
				'heading' => esc_html__( 'Clients Items', 'lt-ext' ),
				'value' => 'header',
				'params' => array(
					array(
						'param_name' => 'image',
						'heading' => esc_html__( 'Image', 'lt-ext' ),
						"type" => "attach_image",
						'admin_label' => true,
					),
					array(
						'param_name' => 'header',
						'heading' => esc_html__( 'Header', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),		
					array(
						'param_name' => 'href',
						'heading' => esc_html__( 'Href', 'lt-ext' ),
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
if ( !function_exists( 'like_sc_clients' ) ) {

	function like_sc_clients($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_header', $atts, array_merge( array(

			'type'		=> '',
			'animation'	=> '',
			'align'		=> '',			
			'icons' 	=> '',
			'list' 		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['list'] = json_decode ( urldecode( $atts['list'] ), true );

		if (!empty($atts['list'])) {

			return like_sc_output('clients', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_clients", "like_sc_clients");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_clients_add')) {

	function ltx_vc_clients_add() {
		
		vc_map( array(
			"base" => "like_sc_clients",
			"name" 	=> esc_html__("Clients", 'lt-ext'),
			"description" => esc_html__("Clients Slider", 'lt-ext'),
			"class" => "like_sc_icons",
			//"icon"	=>	ltxGetPluginUrl('/shortcodes/clients/clients.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_clients_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_clients_add', 30);
}


