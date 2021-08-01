<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_tariff_params' ) ) {

	function ltx_vc_tariff_params() {

		$fields = array(

			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"admin_label" => true,
				"value" => array(
					esc_html__('Default', 'lt-ext') 			=> 'default',
//					esc_html__('Background icon', 'lt-ext') 	=> 'icon-bg',
				),
				"type" => "dropdown"
			),

			array(
				"param_name" => "header",
				"heading" => esc_html__("Header", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "price",
				"heading" => esc_html__("Price", 'lt-ext'),
				"description"	=>	esc_html__("Use brackets to set units as postfix (for ex: {{ /unit }} )", 'lt-ext'),
				"type" => "textfield"
			),			
			array(
				"param_name" => "text",
				"heading" => esc_html__("List", 'lt-ext'),
				"description"	=>	esc_html__("To set yes prefix use {+}, to set no prefix use {-}", 'lt-ext'),				
		
				"type" => "exploded_textarea"

			),	

			array(
				"param_name" => "limit_list",
				"heading" => esc_html__("Limit List Lines with Spoiler", 'lt-ext'),
				"description"	=>	esc_html__("0 for unlimited, by default", 'lt-ext'),
				"value"	=>	'0',
				"type" => "textfield"
			),	
			array(
				"param_name" => "spoiler_text",
				"heading" => esc_html__("Spoiler More", 'lt-ext'),
				"value"	=>	'Show More',
				"type" => "textfield"
			),
			array(
				"param_name" => "spoiler_less",
				"heading" => esc_html__("Spoiler Less", 'lt-ext'),
				"value"	=>	'Show Less',
				"type" => "textfield"
			),

			array(
				"param_name" => "icon_text",
				"heading" => esc_html__("Icon Text", 'lt-ext'),
				"type" => "textfield",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'icon-bg',
				),						
			),
/*			
			array(
				"param_name" => "subheader",
				"heading" => esc_html__("Subheader", 'lt-ext'),
				"description"	=>	esc_html__("Use brackets to mark the string (e.g. {{ string }} )", 'lt-ext'),
				"admin_label" => false,
				"type" => "textfield"
			),	
*/


/*			
			array(
				"param_name" => "descr",
				"heading" => esc_html__("Description", 'lt-ext'),
				"type" => "textarea"
			),			
*/			

			array(
				'type' => 'param_group',
				'param_name' => 'icons',
				'heading' => esc_html__( 'Icons', 'lt-ext' ),
				"description" => __("Select icons", 'lt-ext'),
				'value' => urlencode( json_encode( array(
					array(
						'header' => '',
					),
				) ) ),
				'params' => array(
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Icon", 'lt-ext'),
						"type" => "iconpicker"
					),		
					array(
						"param_name" => "header",
						"heading" => esc_html__("Header", 'lt-ext'),
						"type" => "textfield",
						'admin_label' => true,
					),
				)
			),			
			array(
				"param_name" => "btn_href",
				"heading" => esc_html__("Button Link", 'lt-ext'),
				"value"	=>	'#',
				"type" => "textfield"
			),				
			array(
				"param_name" => "btn_header",
				"heading" => esc_html__("Button Header", 'lt-ext'),
				"type" => "textfield"
			),				
							
			array(
				"param_name" => "vip",
				"heading" => esc_html__("Vip", 'lt-ext'),
				"description"	=>	esc_html__("Will be marked", 'lt-ext'),
				"admin_label" => true,						
				"type" => "checkbox"
			),	
			array(
				"param_name" => "vip_text",
				"heading" => esc_html__("Vip Label", 'lt-ext'),
				"type" => "textfield"
			),				
			array(
				"param_name" => "bg_image",
				"heading" => esc_html__("Background Image", 'lt-ext'),
				"type" => "attach_image",				
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_tariff' ) ) {

	function like_sc_tariff($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_tariff', $atts, array_merge( array(

			'layout'		=> 'default',
			'bg_image'			=> '',
			'icon_text'			=> '',
			'icons'			=> '',
			'limit_list'			=> '',
			'spoiler_text'			=> '',
			'spoiler_less'			=> 'Show Less',
			'image'			=> '',
			'subheader' 		=> '',
			'header' 		=> '',
			'descr' 			=> '',
			'text' 			=> '',
			'highlight' 		=> '',
			'price' 		=> '',
			'btn_header' 	=> '',
			'btn_href' 		=> '',
			'vip' 			=> '',
			'vip_text' 	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		wp_enqueue_script( 'counterup', ltxGetPluginUrl('/shortcodes/countup/jquery.counterup.min.js'), array('jquery'), null, true );

		$atts['icons'] = json_decode ( urldecode( $atts['icons'] ), true );		

		if (!empty($atts['header']) || !empty($atts['image'])) {

			return like_sc_output('tariff', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_tariff", "like_sc_tariff");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_tariff_add')) {

	function ltx_vc_tariff_add() {
		
		vc_map( array(
			"base" => "like_sc_tariff",
			"name" 	=> esc_html__("Tariff", 'lt-ext'),
			"description" => esc_html__("Tariff Single Block", 'lt-ext'),
			"class" => "like_sc_tariff",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/tariff/tariff.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_tariff_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_tariff_add', 30);
}


