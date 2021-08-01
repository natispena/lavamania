<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Portfolio Inner
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_portfolio_inner_params' ) ) {

	function ltx_vc_portfolio_inner_params() {

		$stars = get_terms( 'portfolio-stars' );

		$fields = array(
	
			array(
		
				"param_name" => "type",
				"heading" => esc_html__("Element to Display", 'lt-ext'),
				"std" => "poster",
				"value" => array(
					esc_html__('Header', 'lt-ext') => 'header',
					esc_html__('Poster', 'lt-ext') => 'poster',
					esc_html__('Director/Rate', 'lt-ext') => 'director',
					esc_html__('Info Icons', 'lt-ext') => 'icons',
					esc_html__('Starring', 'lt-ext') => 'starring',
					esc_html__('Gallery', 'lt-ext') => 'gallery',
					esc_html__('Comments Block', 'lt-ext') => 'comments',
				),
				"admin_label" => true,
				"type" => "dropdown"
			),		

		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_portfolio_inner' ) ) {

	function like_sc_portfolio_inner($atts, $content = null) {

		$atts = like_sc_atts_parse('like_sc_portfolio_inner', $atts, array_merge( array(

			'type' 		=> 'poster',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('portfolio_inner', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_portfolio_inner", "like_sc_portfolio_inner");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_portfolio_inner_add')) {

	function ltx_vc_portfolio_inner_add() {
		
		vc_map( array(
			"base" => "like_sc_portfolio_inner",
			"name" 	=> esc_html__("Portfolio Inner", 'lt-ext'),
			"description" => esc_html__("Portfolio Inner Page Elements", 'lt-ext'),
			"class" => "like_sc_portfolio_inner",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/portfolio_inner/portfolio_inner.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_portfolio_inner_params(),	
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_portfolio_inner_add', 30);
}


