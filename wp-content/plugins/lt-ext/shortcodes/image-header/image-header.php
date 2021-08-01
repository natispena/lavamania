<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_image_header_params' ) ) {

	function ltx_vc_image_header_params() {

		$fields = array(

			array(
				"param_name" => "image",
				"heading" => esc_html__("Background Image", 'lt-ext'),
				"type" => "attach_image"
			),
/*			
			array(
				"param_name" => "image2",
				"heading" => esc_html__("Additional Image", 'lt-ext'),
				"type" => "attach_image"
			),			
*/
/*			
			array(
				"param_name" => "header_type",
				"heading" => esc_html__("Header Type", 'lt-ext'),
				"std" => "4",
				"value" => array(
					esc_html__('Heading 1', 'lt-ext') => '1',
					esc_html__('Heading 2', 'lt-ext') => '2',
					esc_html__('Heading 3', 'lt-ext') => '3',
					esc_html__('Heading 4', 'lt-ext') => '4',
					esc_html__('Heading 5', 'lt-ext') => '5',
					esc_html__('Heading 6', 'lt-ext') => '6'
				),
				'dependency' => array(
					'element' => 'layout',
					'value' => array( 'header' ),
				),				
				"type" => "dropdown"
			),	
*/				
/*		

*/			
/*					
			array(
				'param_name' => 'text',
				'heading' => esc_html__( 'Text', 'lt-ext' ),			
				'type' => 'textarea',
			),				
			array(
				'param_name' => 'subheader',
				'heading' => esc_html__( 'Icon SubHeader', 'lt-ext' ),			
				'type' => 'textfield',
			),	
*/			
			array(
				'param_name' => 'href',
				'std'	=> '#',
				'heading' => esc_html__( 'Href', 'lt-ext' ),
				'type' => 'textfield',
			),
/*
			array(
				'param_name' => 'style',
				'heading' => esc_html__( 'Style', 'lt-ext' ),
				"std" => "plain",
				"value" => array(
					esc_html__('Icon in center', 'lt-ext') => 'plain',
					esc_html__('Icon in corner', 'lt-ext') => 'descr',
				),				
				'type' => 'dropdown',
			),			
*/			

			array(
				'param_name' => 'subheader',
				'heading' => esc_html__( 'Sub Header', 'lt-ext' ),				
				'type' => 'textfield',
			),
			
			array(
				'param_name' => 'header',
				'heading' => esc_html__( 'Header', 'lt-ext' ),				
				'type' => 'textfield',				
			),


					/*
			array(
				'param_name' => 'layout',
				'heading' => esc_html__( 'Layout', 'lt-ext' ),
				"std" => "video",
				"value" => array(
					esc_html__('Background Image with Hover Scroll', 'lt-ext') => 'scroll',
					esc_html__('Background Image with Popup Video', 'lt-ext') => 'video',
				),				
				'type' => 'dropdown',
			),				

			array(
				'param_name' => 'height',
				'std'	=> '800px',
				'heading' => esc_html__( 'Block Height', 'lt-ext' ),
				'type' => 'textfield',
				'dependency' => array(
					'element' => 'layout',
					'value' => array( 'scroll' ),
				),							
			),								
*/
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_image_header' ) ) {

	function like_sc_image_header($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_image_header', $atts, array_merge( array(

			'header_type'	=>  '4',
			'header'		=>  '',
			'subheader'		=>  '',
			'text'			=>  '',						
			'height'		=>  '800px',
			'layout'		=>  'scroll',
			'style'			=>  'descr',
			'href'			=>  '',
			'image'			=>	'',
			'image2'			=>	'',
			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('image-header', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_image_header", "like_sc_image_header");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_image_header_add')) {

	function ltx_vc_image_header_add() {
		
		vc_map( array(
			"base" => "like_sc_image_header",
			"name" 	=> esc_html__("Scroll Images", 'lt-ext'),
			"description" => esc_html__("Used for multipage only", 'lt-ext'),
			"class" => "like_sc_image_header",
			"icon"	=>	"icon-wpb-single-image",
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_image_header_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_image_header_add', 30);
}


