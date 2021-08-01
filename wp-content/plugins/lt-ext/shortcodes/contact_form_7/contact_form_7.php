<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_contact_form_7_params' ) ) {

	function ltx_vc_contact_form_7_params() {

		$contact_forms = array();

		$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		if ( $cf7 ) {

			foreach ( $cf7 as $cform ) {

				$contact_forms[ $cform->post_title ] = $cform->ID;
			}
		}
			else {

			$contact_forms[ esc_html__( 'No contact forms found', 'lt-ext' ) ] = 0;
		}

		$fields = array(

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Select contact form', 'lt-ext' ),
				'param_name' => 'form_id',
				'value' => $contact_forms,
				'admin_label' => true,
				'save_always' => true,
				'description' => esc_html__( 'Choose previously created contact form from the drop down list.', 'lt-ext' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Header', 'lt-ext' ),
				'param_name' => 'title',
				'admin_label' => true,
			),
/*			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Form Scheme", 'lt-ext'),
				"param_name" => "form_style",
				"std"	=>	"default",
				"value" => array(
					esc_html__( "Default Colors", 'lt-ext' ) => "default",
					esc_html__( "Secondary Color", 'lt-ext' ) => "secondary",
				),
			),
*/			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Form Padding", 'lt-ext'),
				"param_name" => "form_padding",
				"std"	=>	"default",
				"value" => array(
					esc_html__( "Default", 'lt-ext' ) => "default",
					esc_html__( "No Padding", 'lt-ext' ) => "none",
				),
			),				
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Align", 'lt-ext'),
				"param_name" => "form_align",
				"std"	=>	"center",
				"value" => array(
					esc_html__( "Center", 'lt-ext' ) => "center",
					esc_html__( "Left", 'lt-ext' ) => "left",
					esc_html__( "Right", 'lt-ext' ) => "right",
				),
			),			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Form Background", 'lt-ext'),
				"param_name" => "form_bg",
				"std"	=>	"gray",
				"value" => array(
					esc_html__( "White", 'lt-ext' ) => "white",
					esc_html__( "Gray", 'lt-ext' ) => "gray",
					esc_html__( "Black", 'lt-ext' ) => "black",
					esc_html__( "Transparent", 'lt-ext' ) => "transparent",
				),
			),

			array(
				"param_name" => "image",
				"heading" => esc_html__("Background Image", 'lt-ext'),
				"type" => "attach_image",
			),	

			array(
				"type" => "dropdown",
				"heading" => esc_html__("Inline Form", 'lt-ext'),
				"param_name" => "form_inline",
				"std"	=>	"default",
				"value" => array(
					esc_html__( "Disabled", 'lt-ext' ) => "default",
					esc_html__( "Enabled", 'lt-ext' ) => "inline",
				),
			),				

			/*
			array(
				"param_name" => "wide",
				"heading" => esc_html__("Buttons Wide", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default', 'lt-ext') 	=> 'default',
					esc_html__('Wide', 'lt-ext') 	=> 'wide',
				),
				"type" => "dropdown"
			),		
			array(
				"param_name" => "shadow",
				"heading" => esc_html__("Buttons Shadow", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Disabled', 'lt-ext') 	=> 'default',
					esc_html__('Visible', 'lt-ext') 	=> 'shadow',
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
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_contact_form_7' ) ) {

	function like_sc_contact_form_7($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_contact_form_7', $atts, array_merge( array(

			'form_style'	=> '',
			'form_padding' 	=> '',
			'form_align' 	=> '',
			'form_bg' 		=> '',
			'form_id' 		=> '',
			'image' 		=> '',
			'title' 		=> '',
			'form_inline' 	=> '',
			'wide' 			=> '',
			'shadow' 		=> '',
			'transform' 	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('contact_form_7', $atts, $content);

	}

	if (ltx_vc_inited()) add_shortcode("like_sc_contact_form_7", "like_sc_contact_form_7");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_contact_form_7_add')) {

	function ltx_vc_contact_form_7_add() {
		
		vc_map( array(
			"base" => "like_sc_contact_form_7",
			"name" 	=> esc_html__("Contact Form 7 Customized", 'lt-ext'),
			"description" => esc_html__("Contact Form 7 Customized Block", 'lt-ext'),
			"class" => "like_sc_contact_form_7",
			"icon"	=>	"icon-wpb-contactform7",
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_contact_form_7_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_contact_form_7_add', 30);
}


