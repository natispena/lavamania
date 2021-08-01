<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Portfolio
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_portfolio_categories_params' ) ) {

	function ltx_vc_portfolio_categories_params() {

		$fields = array(
				
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Total Portfolio", 'lt-ext'),
				"description" => esc_html__("Number of portfolio_categories to show", 'lt-ext'),
				"std"	=>	"6",				
				"admin_label" => true,
				"type" => "textfield"
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_portfolio_categories' ) ) {

	function like_sc_portfolio_categories($atts, $content = null) {

		$atts = like_sc_atts_parse('like_sc_portfolio_categories', $atts, array_merge( array(

			'layout' 		=> 'posts',
			'ids' 			=> '',
			'limit' 		=> '',
			'highlight' 		=> '',
			'style' 		=> 'bg-gray',
			'per_slide' 	=> '',
			'cat' 			=> '',
			'autoplay' 		=> '0',
			'more_text' 			=> '',

			), array_fill_keys(array_keys(ltx_vc_swiper_params(true)), null), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('portfolio_categories', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_portfolio_categories", "like_sc_portfolio_categories");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_portfolio_categories_add')) {

	function ltx_vc_portfolio_categories_add() {

		add_filter('ltx_vc_swiper
			_params', 'ltx_portfolio_categories_swiper');
		
		vc_map( array(
			"base" => "like_sc_portfolio_categories",
			"name" 	=> esc_html__("Portfolio Categories", 'lt-ext'),
			"description" => esc_html__("Portfolio Categories", 'lt-ext'),
			"class" => "like_sc_portfolio_categories",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/portfolio_categories/portfolio_categories.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_portfolio_categories_params(),
				ltx_vc_swiper_params(),				
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_portfolio_categories_add', 30);
}

if (!function_exists('ltx_portfolio_categories_swiper')) {

	function ltx_portfolio_categories_swiper($fields) {

		$fields['swiper_breakpoint_xl']['std'] = 6;
		$fields['swiper_breakpoint_sm']['std'] = 3;
		$fields['swiper_breakpoint_xs']['std'] = 1;

		return $fields;
	}
}

