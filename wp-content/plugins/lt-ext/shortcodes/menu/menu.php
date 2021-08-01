<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Menu
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_menu_params' ) ) {

	function ltx_vc_menu_params() {


		$categories = json_decode(json_encode(ltxGetMenuCats()), TRUE);

		$cat = array();
		foreach ($categories as $term_id => $item) {

			$cat[$item['name']] = $term_id;
		}

		$fields = array(	

			array(
				"param_name" => "cat",
				"heading" => esc_html__("Category", 'lt-ext'),
				"value" => array_merge(array(esc_html__('--', 'lt-ext') => 0), $cat),
				"type" => "dropdown"
			),		
			
			array(
				"param_name" => "except",
				"heading" => esc_html__("Except size", 'lt-ext'),
				"value" => 70,
				"type" => "textfield"
			),
/*			
			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "scroll",
				"value" => array(
					esc_html__('Scroll', 'lt-ext') => 'scroll',
					esc_html__('Two Columns', 'lt-ext') => 'two-cols',
				),
				"type" => "dropdown"
			),					
			array(
				"param_name" => "tabs",
				"heading" => esc_html__("Tabs Style", 'lt-ext'),
				"std" => "plain",
				"value" => array(
					esc_html__('Active bordered', 'lt-ext') => 'border',
					esc_html__('Active plain', 'lt-ext') => 'plain',
				),
				"type" => "dropdown"
			),	
*/						
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'ltx_sc_menu' ) ) {

	function ltx_sc_menu($atts, $content = null) {	

		$atts = like_sc_atts_parse('ltx_sc_menu', $atts, array_merge( array(

			'cat'			=> '',
			'except'		=> 70,
			'layout'		=> 'scroll',
			'tabs'			=> 'plain',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('menu', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("ltx_sc_menu", "ltx_sc_menu");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_menu_add')) {

	function ltx_vc_menu_add() {
		
		vc_map( array(
			"base" => "ltx_sc_menu",
			"name" 	=> esc_html__("Menu", 'lt-ext'),
			"description" => esc_html__("Menu items", 'lt-ext'),
			"class" => "ltx_sc_menu",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/menu/menu.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_menu_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_menu_add', 30);
}


