<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_events_calendar_params' ) ) {

	function ltx_vc_events_calendar_params() {

		$cats = ltxGetCPTCats('tribe_events_cat');
		$cat = array();
		foreach ($cats as $catId => $item) {

			$cat[$item['name']] = $catId;
		}

		$fields = array(
			/*
			array(
				"param_name" => "cat",
				"heading" => esc_html__("Category", 'lt-ext'),
				"value" => array_merge(array(esc_html__('--', 'lt-ext') => 0), $cat),
				"type" => "dropdown"
			),
			array(
				"param_name" => "image",
				"heading" => esc_html__("Clock Icon", 'lt-ext'),
				"type" => "attach_image"
			),				
			*/		
			array(
				"param_name" => "btn_text",
				"heading" => esc_html__("Button Text", 'lt-ext'),
				"std" => "find more",
				"type" => "textfield"
			),			
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Limit", 'lt-ext'),
				"std" => "5",
				"type" => "textfield"
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_events_calendar' ) ) {

	function like_sc_events_calendar($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_events_calendar', $atts, array_merge( array(

			'limit'			=> '',
			'btn_text'			=> '',
			'image'			=> '',
			'cat'			=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);


		return like_sc_output('events_calendar', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_events_calendar", "like_sc_events_calendar");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_events_calendar_add')) {

	function ltx_vc_events_calendar_add() {
		
		vc_map( array(
			"base" => "like_sc_events_calendar",
			"name" 	=> esc_html__("Events Calendar", 'lt-ext'),
			"description" => esc_html__("Events Calendar List", 'lt-ext'),
			"class" => "like_sc_events_calendar",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/events_calendar/events_calendar.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_events_calendar_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_events_calendar_add', 30);
}


