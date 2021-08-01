<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_before_after_params' ) ) {

	function ltx_vc_before_after_params() {

		$fields = array(
			array(
				"param_name" => "header-before",
				"heading" => esc_html__("Header Before", 'lt-ext'),
				"description"	=>	esc_html__("Use brackets to highlight word", 'lt-ext'),				
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "header-after",
				"heading" => esc_html__("Header After", 'lt-ext'),
				"description"	=>	esc_html__("Use brackets to highlight word", 'lt-ext'),				
				"admin_label" => true,
				"type" => "textfield"
			),		
			array(
				'type' => 'param_group',
				'param_name' => 'items',
				'heading' => esc_html__( 'Items', 'lt-ext' ),
				'value' => urlencode( json_encode( array(
					array(
						'header' => '',
					),
				) ) ),
				'params' => array(
					array(
						'param_name' => 'subheader',
						'heading' => esc_html__( 'SubHeader', 'lt-ext' ),
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
						"param_name" => "image-before",
						"heading" => esc_html__("Image Before", 'lt-ext'),
						"type" => "attach_image"
					),					
					array(
						"param_name" => "image-after",
						"heading" => esc_html__("Image After", 'lt-ext'),
						"type" => "attach_image"
					),
					array(
						'param_name' => 'btn_text',
						'heading' => esc_html__( 'Button Text', 'lt-ext' ),
						"description"	=>	esc_html__("Hidden if empty", 'lt-ext'),
						'type' => 'textfield',
						'admin_label' => false,
					),					
					array(
						'param_name' => 'btn_href',
						'heading' => esc_html__( 'Button Href', 'lt-ext' ),
						'type' => 'textfield',
						'admin_label' => false,
					),					
				)
			),

		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_before_after' ) ) {

	function like_sc_before_after($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_before_after', $atts, array_merge( array(

			'header-before'		=> '',
			'header-after'		=> '',
			'items'		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )

		);

		$atts['items'] = json_decode ( urldecode( $atts['items'] ), true );

		wp_enqueue_script( 'before-after', ltxGetPluginUrl('/shortcodes/before_after/before-after.js'), array('jquery', 'aqualine-scripts'), null, true );

		if (!empty($atts['items'])) {

			return like_sc_output('before_after', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_before_after", "like_sc_before_after");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_before_after_add')) {

	function ltx_vc_before_after_add() {
		
		vc_map( array(
			"base" => "like_sc_before_after",
			"name" 	=> esc_html__("Before/After", 'lt-ext'),
			"description" => esc_html__("Image overlay", 'lt-ext'),
			"class" => "like_sc_before_after",
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_before_after_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_before_after_add', 30);
}


