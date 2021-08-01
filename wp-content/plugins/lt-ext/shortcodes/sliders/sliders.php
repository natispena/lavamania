<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_sliders_params' ) ) {

	function ltx_vc_sliders_params() {

		$cats = ltxGetSlidersCats();
		$cat = array();
		foreach ($cats as $catId => $item) {

			$cat[$item['name']] = $catId;
		}

		$fields = array(

			array(
				"param_name" => "category_filter",
				"heading" => esc_html__("Categories Filter", 'lt-ext'),
				"value" => array_merge(array(esc_html__('All Parent', 'lt-ext') => 0), $cat),
				"admin_label" => true,				
				"type" => "dropdown"
			),
/*
			array(
				"param_name" => "type",
				"heading" => esc_html__("Type", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Full Screen', 'lt-ext') 	=> 'default',
					esc_html__('Services Slider', 'lt-ext') 	=> 'onescreen',
				),
				"type" => "dropdown"
			),		
*/			
/*			
			array(
				'param_name' => 'scroll_icon',
				'heading' => esc_html__( 'Scroll Icon', 'lt-ext' ),
				'type' => 'iconpicker',
				'admin_label' => true,						
				'value' => '',
				'settings' => array(
					'emptyIcon' => true,
					
					'type' => 'fontawesome'

				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),					
			),		
			array(
				'param_name' => 'scroll_header',
				'heading' => esc_html__( 'Scroll Header', 'lt-ext' ),
				'type' => 'textfield',

			),					
*/			
			/*
			array(
				"param_name" => "image_status",
				"heading" => esc_html__("Featured Image Visibility", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Allways Visible', 'lt-ext') 	=> 'visible',
					esc_html__('Desktop Only Visible', 'lt-ext') 	=> 'desktop',
					esc_html__('Hidden', 'lt-ext') 	=> 'hidden',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),					
			),	
			*/			
/*			
			array(
				"param_name" => "arrows",
				"heading" => esc_html__("Arrows", 'lt-ext'),
				"std" => "disabled",
				"value" => array(
					esc_html__('Enabled', 'lt-ext') 	=> 'enabled',
					esc_html__('Disabled', 'lt-ext') 	=> 'disabled',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),						
			),	
*/			
/*			
			array(
				"param_name" => "pagination",
				"heading" => esc_html__("Pagination", 'lt-ext'),
				"std" => "enabled",
				"value" => array(
					esc_html__('Enabled', 'lt-ext') 	=> 'enabled',
					esc_html__('Disabled', 'lt-ext') 	=> 'disabled',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),	
			),	
			array(
				"param_name" => "social",
				"heading" => esc_html__("Social Icons", 'lt-ext'),
				"std" => "enabled",
				"value" => array(
					esc_html__('Enabled', 'lt-ext') 	=> 'enabled',
					esc_html__('Disabled', 'lt-ext') 	=> 'disabled',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),	
			),				
*/			
			/*
			array(
				"param_name" => "effect",
				"heading" => esc_html__("Effect", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Fade', 'lt-ext') 	=> 'fade',
					esc_html__('Slide', 'lt-ext') 	=> 'slide',
				),
				"admin_label" => true,
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),						
			),	
			*/
/*			
			array(
				"param_name" => "autoplay",
				"heading" => esc_html__("Autoplay (ms)", 'lt-ext'),
				"description" => esc_html__("0 - autoplay is disabled", 'lt-ext'),
				"std"	=>	"4000",				
				"admin_label" => true,
				"type" => "textfield",			
			),
*/			
			/*			
			array(
				"param_name" => "background",
				"heading" => esc_html__("Background", 'lt-ext'),
				"description" => esc_html__("Will be used as background for all slides", 'lt-ext'),
				"type" => "attach_image",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),						
			),
			array(
				"param_name" => "background_status",
				"heading" => esc_html__("Common Background Visibility", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Allways Visible', 'lt-ext') 	=> 'visible',
					esc_html__('Desktop Only Visible', 'lt-ext') 	=> 'desktop',
					esc_html__('Hidden', 'lt-ext') 	=> 'hidden',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'type',
					'value' => 'default',
				),						
			),
			*/				
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_sliders' ) ) {

	function like_sc_sliders($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_sliders', $atts, array_merge( array(

			'arrows'			=> 'enabled',
			'pagination'		=> 'enabled',
			'effect'			=> 'flip',
			'image_status'		=> 'visible',
			'autoplay'		=> 0,
			'type'		=> 'default',
			'social'		=> '',
			'scroll_icon'		=>	'',
			'scroll_header'		=>	'',
			'background'		=> '',
			'background_status'	=> 'hidden',
			'category_filter'	=> '',

			), array_fill_keys(array_keys(ltx_vc_swiper_params(true)), null), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('sliders', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_sliders", "like_sc_sliders");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_sliders_add')) {

	function ltx_vc_sliders_add() {
		
		vc_map( array(
			"base" => "like_sc_sliders",
			"name" 	=> esc_html__("Swiper Slider", 'lt-ext'),
//			"description" => esc_html__("Sliders", 'lt-ext'),
			"class" => "like_sc_sliders",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/sliders/swiper_slider.png'),
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			"params" => array_merge(
				ltx_vc_sliders_params(),
				ltx_vc_swiper_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_sliders_add', 30);
}


