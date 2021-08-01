<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_social_icons_params' ) ) {

	function ltx_vc_social_icons_params() {

		$fields = array(

			array(
				"param_name" => "type",
				"heading" => esc_html__("List type", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('List with icons and text on right side', 'lt-ext') 		=> 'icons-list',
					esc_html__('XLarge icons full-width list', 'lt-ext') 	=> 'icons-inline-xlarge',
					esc_html__('Large icons inline list', 'lt-ext') 	=> 'icons-inline-large',
					esc_html__('Small icons inline list', 'lt-ext') 	=> 'icons-inline-small',
				),
				"type" => "dropdown"
			),	
/*			
			array(
				"param_name" => "style",
				"heading" => esc_html__("Icon style", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Transparent', 'lt-ext') 	=> 'default',
					esc_html__('Square', 'lt-ext') 		=> 'square',
				),
				"type" => "dropdown"
			),
*/			
			array(
				"param_name" => "weight",
				"heading" => esc_html__("Font Weight", 'lt-ext'),
				"std" => "bold",
				"value" => array(
					esc_html__('Normal', 'lt-ext') 	=> 'default',
					esc_html__('Bold', 'lt-ext') 		=> 'bold',
				),
				"type" => "dropdown"
			),					
			array(
				"param_name" => "size",
				"heading" => esc_html__("Font Size", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default', 'lt-ext') 	=> 'default',
					esc_html__('Small', 'lt-ext')		=> 'small',
				),
				"type" => "dropdown"
			),					
			array(
				"param_name" => "align",
				"heading" => esc_html__("Item align", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Left', 'lt-ext') 		=> 'default',
					esc_html__('Center', 'lt-ext') 		=> 'center',
				),
				"type" => "dropdown"
			),		

			array(
				"param_name" => "bg",
				"heading" => esc_html__("Icon Background", 'lt-ext'),
				"std" => "bg-main",
				"value" => array(
					esc_html__('Main', 'lt-ext') 			=> 'bg-main',
					esc_html__('Second', 'lt-ext') 			=> 'bg-second',
				),
				"type" => "dropdown"
			),	

			array(
				'type' => 'param_group',
				'param_name' => 'icons',
				'heading' => esc_html__( 'Icons', 'lt-ext' ),
				"description" => wp_kses_data( __("Select icons, specify title and/or description for each item", 'lt-ext') ),
				'value' => urlencode( json_encode( array(
					array(
						'header' => '',
						'size' => 'default',
						'href' => '',
						'icon_fontawesome' => 'empty',
					),
				) ) ),
				'params' => array(
					array(
						'param_name' => 'header',
						'heading' => esc_html__( 'Header', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => true,
					),
					array(
						"param_name" => "size",
						"heading" => esc_html__("Icon size", 'lt-ext'),
						"std" => "default",
						"value" => array(
							esc_html__('Default', 'lt-ext') 		=> 'default',
							esc_html__('Large', 'lt-ext') 		=> 'large',
						),
						"type" => "dropdown"
					),
						
					array(
						'param_name' => 'href',
						'heading' => esc_html__( 'Href', 'lt-ext' ),
						'type' => 'textfield',
						'description' => esc_html__( 'URL to list item', 'lt-ext' ),
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
				),
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_social_icons' ) ) {

	function like_sc_social_icons($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_social_icons', $atts, array_merge( array(

			'type'		=> 'default',
			'align'		=> '',			
			'style'		=> '',			
			'bg'		=> '',			
			'weight'	=> 'bold',			
			'size'		=> '',			
			'icons' 	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['icons'] = json_decode ( urldecode( $atts['icons'] ), true );

		if (!empty($atts['icons'])) {

			return like_sc_output('social-icons', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_social_icons", "like_sc_social_icons");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_social_icons_add')) {

	function ltx_vc_social_icons_add() {
		
		vc_map( array(
			"base" => "like_sc_social_icons",
			"name" 	=> esc_html__("Social Icons", 'lt-ext'),
			"description" => esc_html__("Social Icons", 'lt-ext'),
			"class" => "like_sc_icons",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/social-icons/social-icons.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_social_icons_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_social_icons_add', 30);
}


