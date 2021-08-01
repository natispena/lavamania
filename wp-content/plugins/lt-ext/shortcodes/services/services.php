<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Services
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_services_params' ) ) {

	function ltx_vc_services_params() {

		$cats = ltxGetServicesCats();
		$cat = array();
		foreach ($cats as $catId => $item) {

			$cat[$item['name']] = $catId;
		}

		$fields = array(
			array(
				"param_name" => "cat",
				"heading" => esc_html__("Category", 'lt-ext'),
				"value" => array_merge(array(esc_html__('--', 'lt-ext') => 0), $cat),
				"type" => "dropdown"
			),

			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "photos",
				"value" => array(
					esc_html__('Services', 'lt-ext') => 'photos',
					esc_html__('Slider', 'lt-ext') => 'slider',
//					esc_html__('Products', 'lt-ext') => 'product',
//					esc_html__('Icons', 'lt-ext') => 'icons',
				),
				"type" => "dropdown"
			),			

/*				
			array(
				"param_name" => "style",
				"heading" => esc_html__("Style", 'lt-ext'),
				"std" => "gray",
				"value" => array(
					esc_html__('Gray', 'lt-ext') => 'gray',
					esc_html__('Colored', 'lt-ext') => 'colored',
				),
				"type" => "dropdown"
			),					
*/			
			array(
				"param_name" => "ids",
				"heading" => esc_html__("Filter IDs", 'lt-ext'),
				"description" => __("Enter IDs to show, separated by comma", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),						
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Total Services", 'lt-ext'),
				"description" => esc_html__("Number of services to show", 'lt-ext'),
				"std"	=>	"4",				
				"admin_label" => true,
				"type" => "textfield"
			),
/*			
			array(
				"param_name" => "label_of",
				"heading" => esc_html__("Label of", 'lt-ext'),
				"description" => esc_html__("Will be hidden if empty", 'lt-ext'),
				"std" => "of",
				"type" => "textfield",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'list',
				),					
			),				
*/
/*
			array(
				"param_name" => "more_text",
				"heading" => esc_html__("More Button", 'lt-ext'),
				"type" => "textfield",
				"std" => "Submit now",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('photos'),
				),					
			),				
*/	
/*
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
				'dependency' => array(
					'element' => 'layout',
					'value' => 'slider',
				),						
			),
*/
/*
			array(
				"param_name" => "popular_text",
				"heading" => esc_html__("Popular Text", 'lt-ext'),
				"type" => "textfield",
				"std" => "most {{ popular }}",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'slider',
				),								
			),					
*/			
/*			
			array(
				"param_name" => "image",
				"heading" => esc_html__("Watermark", 'lt-ext'),
				"type" => "attach_image"
			),				
		
/*
			array(
				"param_name" => "style",
				"heading" => esc_html__("Style", 'lt-ext'),
				"std" => "bg-black",
				"value" => array(
					esc_html__('White Background', 'lt-ext') => 'bg-white',
					esc_html__('Black background', 'lt-ext') => 'bg-black',
				),
				"type" => "dropdown"
			),				
			array(
				"param_name" => "per_slide",
				"heading" => esc_html__("Services per Slide", 'lt-ext'),
				"description" => esc_html__("If empty or null - no slider will be active", 'lt-ext'),
				"std"	=>	"3",
				"admin_label" => true,
				"type" => "textfield"
			),
*/							

		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_services' ) ) {

	function like_sc_services($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_services', $atts, array_merge( array(

			'layout' 		=> 'photos',
			'ids' 			=> '',
			'image' 			=> '',
			'icon_fontawesome' 			=> '',			
			'limit' 		=> '',
			'highlight' 		=> '',
			'style' 		=> 'gray',
			'per_slide' 	=> '',
			'cat' 			=> '',
			'label_of' 			=> '',
			'more_text' 			=> 'read more',
			'popular_text' 			=> 'most {{ popular }}',
			'autoplay' 		=> '0',


			), array_fill_keys(array_keys(ltx_vc_swiper_params(true)), null), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('services', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_services", "like_sc_services");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_services_add')) {

	function ltx_vc_services_add() {
		
		vc_map( array(
			"base" => "like_sc_services",
			"name" 	=> esc_html__("Services", 'lt-ext'),
			"description" => esc_html__("Services Posts slider", 'lt-ext'),
			"class" => "like_sc_services",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/services/services.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_services_params(),
				ltx_vc_swiper_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_services_add', 30);
}


