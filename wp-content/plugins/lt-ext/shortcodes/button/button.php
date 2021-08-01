<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Button
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_button_params' ) ) {

	function ltx_vc_button_params() {

		$fields = array(

			array(
				"param_name" => "header",
				"heading" => esc_html__("Header", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "href",
				"heading" => esc_html__("URL", 'lt-ext'),
				"type" => "textfield"
			),
			array(
				"param_name" => "size",
				"heading" => esc_html__("Size", 'lt-ext'),
				"std" => "lg",
				"value" => array(
					esc_html__('Large', 'lt-ext') => 'lg',
					esc_html__('Default', 'lt-ext') => 'default',
					esc_html__('Small', 'lt-ext') => 'xs',
//					esc_html__('Extra Small', 'lt-ext') => 'xxs',
				),
				"type" => "dropdown"
			),
			array(
				"param_name" => "align",
				"heading" => esc_html__("Alignment", 'lt-ext'),
				"description" => esc_html__("Horizontal Aligment", 'lt-ext'),
				"std" => "center",
				"value" => array(
					esc_html__('Left', 'lt-ext') => 'left',
					esc_html__('Center', 'lt-ext') => 'center',
					esc_html__('Right', 'lt-ext') => 'right'
				),
				"type" => "dropdown"
			),			
			array(
				"param_name" => "color",
				"heading" => esc_html__("Background color", 'lt-ext'),
				"std" => "default",
				"admin_label" => true,					
				"value" => array(
					esc_html__('Main', 'lt-ext') 	=> 'main',
					esc_html__('Main Bordered', 'lt-ext') 	=> 'main-bordered',					
					esc_html__('Secondary', 'lt-ext') 	=> 'second',
					esc_html__('Secondary Bordered', 'lt-ext') 	=> 'second-bordered',			
					esc_html__('White', 'lt-ext') 	=> 'white',
					esc_html__('White Bordered', 'lt-ext') 	=> 'white-bordered',
					esc_html__('Black', 'lt-ext') 	=> 'black',
					esc_html__('Black Bordered', 'lt-ext') 	=> 'black-bordered',
					esc_html__('Gray', 'lt-ext') 	=> 'gray',
					esc_html__('Transparent', 'lt-ext') 	=> 'transparent',
				),
				"type" => "dropdown"
			),
			/*
			array(
				"param_name" => "color_text",
				"heading" => esc_html__("Text Color", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default', 'lt-ext') 	=> 'default',
					esc_html__('White', 'lt-ext') 	=> 'white',
					esc_html__('Black', 'lt-ext') 	=> 'black',
				),
				"type" => "dropdown"
			),
			*/

			array(
				"param_name" => "color_hover",
				"heading" => esc_html__("Hover Background Color", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default', 'lt-ext') 	=> 'default',
					esc_html__('Main', 'lt-ext') 		=> 'main',
					esc_html__('Secondary', 'lt-ext') 	=> 'second',
					esc_html__('White', 'lt-ext') 	=> 'white',
					esc_html__('Black', 'lt-ext') 	=> 'black',
				),
				"type" => "dropdown"
			),			
/*
			array(
				"param_name" => "arrow",
				"heading" => esc_html__("Arrow style", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Add Arrow', 'lt-ext') 	=> 'default',
					esc_html__('Arrow hidden', 'lt-ext') 	=> 'hidden',
				),
				"type" => "dropdown"
			),		
*/			
/*			
			array(
				"param_name" => "shadow",
				"heading" => esc_html__("Shadow", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Disabled', 'lt-ext') 	=> 'default',
					esc_html__('Blured', 'lt-ext') 	=> 'shadow',
					esc_html__('Plain white', 'lt-ext') 	=> 'plain-white',
					esc_html__('Plain black', 'lt-ext') 	=> 'plain-black',
				),
				"type" => "dropdown"
			),		

			array(
				"param_name" => "transform",
				"heading" => esc_html__("Text transform", 'lt-ext'),
				"std" => "default",
				"admin_label" => true,				
				"value" => array(
					esc_html__('Default', 'lt-ext') 		=> 'default',
					esc_html__('Uppercase', 'lt-ext') 	=> 'uppercase',
					esc_html__('Lowercase', 'lt-ext') 	=> 'lowercase',
				),
				"type" => "dropdown"
			),			
			*/
			array(
				"param_name" => "inline",
				"heading" => esc_html__("Position", 'lt-ext'),
				"std" => "default",
			
				"value" => array(
					esc_html__('One in row', 'lt-ext') 		=> 'default',
					esc_html__('Inline buttons', 'lt-ext') 	=> 'inline',
				),
				"type" => "dropdown"
			),
			array(
				"param_name" => "icon",
				"heading" => esc_html__("Icon Before Button", 'lt-ext'),
				"type" => "iconpicker"
			),			
			array(
				"param_name" => "target",
				"heading" => esc_html__("Target", 'lt-ext'),
				"std" => "self",
			
				"value" => array(
					esc_html__('Current window', 'lt-ext') 		=> 'self',
					esc_html__('New window', 'lt-ext') 	=> 'blank',
				),
				"type" => "dropdown"
			),								
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_button' ) ) {

	function like_sc_button($atts, $content = null) {	
		
		$atts = like_sc_atts_parse('like_sc_button', $atts, array_merge( array(

			'size'		=> 'default',
			'color'		=> 'default',
//			'color_text'		=> 'default',
			'color_hover'		=> 'default',
			'inline'	=> 'default',			
			'transform'	=> 'default',			
//			'wide'		=> 'default',			
			'shadow'	=> 'default',			
			'arrow'	=> 'default',			
			'target'	=> '',
			'header'	=> 'Button',
			'href' 		=> '#',
			'align' 	=> 'default',
			'icon' 		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('button', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_button", "like_sc_button");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_button_add')) {

	function ltx_vc_button_add() {
		
		vc_map( array(
			"base" => "like_sc_button",
			"name" 	=> esc_html__("Button", 'lt-ext'),
			"description" => esc_html__("Custom Button", 'lt-ext'),
			"class" => "like_sc_button",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/button/button.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_button_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_button_add', 30);
}


