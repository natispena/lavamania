<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_team_slider_params' ) ) {

	function ltx_vc_team_slider_params() {

		$cat = array();
		$cats = ltxGetTeamCats();
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
				"param_name" => "type",
				"heading" => esc_html__("Style", 'lt-ext'),
				"std" => "circle",
				"value" => array(
					esc_html__('Static', 'lt-ext') 		=> 'static',
					esc_html__('Slider', 'lt-ext') 	=> 'slider',
				),
				"type" => "dropdown"
			),
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Team Limit", 'lt-ext'),
				"std"	=>	"4",				
				"admin_label" => true,
				"type" => "textfield"
			),			
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_team_slider' ) ) {

	function like_sc_team_slider($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_team_slider', $atts, array_merge( array(

			'cat'		=> '',
			'type'		=> 'static',
			'limit'		=> '4',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('team_slider', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_team_slider", "like_sc_team_slider");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_team_slider_add')) {

	function ltx_vc_team_slider_add() {
		
		vc_map( array(
			"base" => "like_sc_team_slider",
			"name" 	=> esc_html__("Team", 'lt-ext'),
			"description" => esc_html__("Show Team from CPT", 'lt-ext'),
			"class" => "like_sc_team_slider",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/header/icon.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_team_slider_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_team_slider_add', 30);
}


