<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Portfolio
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_portfolio_params' ) ) {

	function ltx_vc_portfolio_params() {

		
		$cats = ltxGetCats('portfolio-category');
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
				"std" => "default",
				"value" => array(
					esc_html__('Grid', 'lt-ext') => 'grid',
					esc_html__('Slider', 'lt-ext') => 'slider',
//					esc_html__('Static', 'lt-ext') => 'static',
//					esc_html__('Category Filter (without slider)', 'lt-ext') => 'filter',
				),
				"type" => "dropdown"
			),		

			array(
				"param_name" => "ids",
				"heading" => esc_html__("Filter IDs", 'lt-ext'),
				"description" => __("Enter IDs to show, separated by comma", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),						
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Total Items", 'lt-ext'),
				"description" => esc_html__("Number of portfolio to show", 'lt-ext'),
				"std"	=>	"6",				
				"admin_label" => true,
				"type" => "textfield"
			),
/*			
			array(
				"param_name" => "more_text",
				"heading" => esc_html__("More Button", 'lt-ext'),
				"type" => "textfield",
				"std" => "Read more",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('grid'),
				),					
			),				
*/			
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_portfolio' ) ) {

	function like_sc_portfolio($atts, $content = null) {

		$atts = like_sc_atts_parse('like_sc_portfolio', $atts, array_merge( array(

			'layout' 		=> 'grid',
			'ids' 			=> '',
			'limit' 		=> '',
			'highlight' 		=> '',
			'style' 		=> 'bg-gray',
			'cat' 			=> '',
			'more_text' 			=> '',

			), array_fill_keys(array_keys(ltx_vc_swiper_params(true)), null), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('portfolio', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_portfolio", "like_sc_portfolio");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_portfolio_add')) {

	function ltx_vc_portfolio_add() {

		add_filter('ltx_vc_swiper_params', 'ltx_portfolio_swiper');
		
		vc_map( array(
			"base" => "like_sc_portfolio",
			"name" 	=> esc_html__("Portfolio", 'lt-ext'),
			"description" => esc_html__("Portfolio Posts slider", 'lt-ext'),
			"class" => "like_sc_portfolio",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/portfolio/portfolio.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_portfolio_params(),
				ltx_vc_swiper_params(),				
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_portfolio_add', 30);
}

if (!function_exists('ltx_portfolio_swiper')) {

	function ltx_portfolio_swiper($fields) {

		$fields['swiper_breakpoint_xl']['std'] = 4;
		$fields['swiper_breakpoint_sm']['std'] = 3;
		$fields['swiper_breakpoint_xs']['std'] = 1;

		return $fields;
	}
}

