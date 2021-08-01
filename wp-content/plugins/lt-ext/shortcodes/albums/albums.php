<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_albums_params' ) ) {

	function ltx_vc_albums_params() {

		$cats = ltxGetAlbumsCats();
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
			array(
				"param_name" => "image_vinyl",
				"heading" => esc_html__("Vinyl", 'lt-ext'),
				"admin_label" => true,
				"type" => "attach_image"
			),		
			array(
				"param_name" => "image_shadow",
				"heading" => esc_html__("Shadow", 'lt-ext'),
				"admin_label" => true,
				"type" => "attach_image"
			),		
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_albums' ) ) {

	function like_sc_albums($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_albums', $atts, array_merge( array(

			'category_filter'	=> '',
			'image_vinyl'	=> '',
			'image_shadow'	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);


		return like_sc_output('albums', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_albums", "like_sc_albums");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_albums_add')) {

	function ltx_vc_albums_add() {
		
		vc_map( array(
			"base" => "like_sc_albums",
			"name" 	=> esc_html__("Albums Slider", 'lt-ext'),
//			"description" => esc_html__("albums", 'lt-ext'),
			"class" => "like_sc_albums",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/albums/swiper_slider.png'),
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			"params" => array_merge(
				ltx_vc_albums_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_albums_add', 30);
}


