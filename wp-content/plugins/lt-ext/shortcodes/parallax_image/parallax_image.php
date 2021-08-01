<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Configuration
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_parallax_image_params' ) ) {

	function ltx_vc_parallax_image_params() {

		$fields = array(
/*			
			array(
				"param_name" => "type",
				"heading" => esc_html__("Type", 'lt-ext'),
				"std" => "single",
				"value" => array(
					esc_html__('Single image', 'lt-ext') => 'single',
					esc_html__('Two split images', 'lt-ext') => 'split',
				),
				"type" => "dropdown"
			),				
*/			
			array(
				"param_name" => "image",
				"heading" => esc_html__("Image", 'lt-ext'),
				"admin_label" => true,
				"type" => "attach_image"
			),
/*			
			array(
				"param_name" => "image2",
				"heading" => esc_html__("Image Background", 'lt-ext'),
				"admin_label" => true,
				"type" => "attach_image",
				'dependency' => array(
					'element' => 'type',
					'value' => 'split',
				),					
			),			

*/			
			array(
				"param_name" => "factor",
				"heading" => esc_html__("Factor", 'lt-ext'),
				"admin_label" => true,				
				"type" => "textfield",
				"value" => "0.3",
				'dependency' => array(
					'element' => 'type',
					'value' => 'single',
				),							
			),				
			array(
				"param_name" => "direction",
				"heading" => esc_html__("Direction", 'lt-ext'),
				"std" => "vertical",
				"value" => array(
					esc_html__('Vertical', 'lt-ext') => 'vertical',
					esc_html__('Heading Horizontal', 'lt-ext') => 'horizontal',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'single',
				),						
			),	

			array(
				"param_name" => "top",
				"heading" => esc_html__("Top Position", 'lt-ext'),
				"description" => esc_html__("Will change theme default position", 'lt-ext'),				
				"admin_label" => true,				
				"type" => "textfield",
				"value" => "",
				'dependency' => array(
					'element' => 'type',
					'value' => 'single',
				),						
			),			

			array(
				"param_name" => "left",
				"heading" => esc_html__("Left Position", 'lt-ext'),
				"description" => esc_html__("Will change theme default position", 'lt-ext'),				
				"admin_label" => true,				
				"type" => "textfield",
				"value" => "",
				'dependency' => array(
					'element' => 'type',
					'value' => 'single',
				),						
			),		

			array(
				"param_name" => "right",
				"heading" => esc_html__("Right Position", 'lt-ext'),
				"description" => esc_html__("Will change theme default position", 'lt-ext'),				
				"admin_label" => true,				
				"type" => "textfield",
				"value" => "",
				'dependency' => array(
					'element' => 'type',
					'value' => 'single',
				),						
			),											
			array(
				"param_name" => "bottom",
				"heading" => esc_html__("Bottom Position", 'lt-ext'),
				"description" => esc_html__("Will change theme default position", 'lt-ext'),				
				"admin_label" => true,				
				"type" => "textfield",
				"value" => "",
				'dependency' => array(
					'element' => 'type',
					'value' => 'single',
				),						
			),				
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_parallax_image' ) ) {

	function like_sc_parallax_image($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_parallax_image', $atts, array_merge( array(

			'image'		=> '',
			'image2'		=> '',
			'factor'		=> '',
			'direction'		=> '',
			'type'		=> 'single',
			'top'		=> '',
			'bottom'		=> '',
			'left'		=> '',
			'right'		=> '',
			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		wp_enqueue_script( 'paroller', ltxGetPluginUrl('/shortcodes/parallax_image/jquery.paroller.min.js'), array('jquery'), null, true );

		return like_sc_output('parallax_image', $atts, $content);
	}


	if (ltx_vc_inited()) add_shortcode("like_sc_parallax_image", "like_sc_parallax_image");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_parallax_image_add')) {

	function ltx_vc_parallax_image_add() {
		
		vc_map( array(
			"base" => "like_sc_parallax_image",
			"name" 	=> esc_html__("Parallax Scroll Image", 'lt-ext'),
//			"description" => esc_html__("Background changing with Ken Burns effect", 'lt-ext'),
			"class" => "like_sc_parallax_image",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/parallax_image/parallax_image.png'),
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_parallax_image_params(),
				ltx_vc_default_params()
			),
		) );

	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_parallax_image_add', 30);
}


