<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Gallery
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_gallery_params' ) ) {

	function ltx_vc_gallery_params() {

		$albums = ltxGetGalleryPosts();

		$cats = ltxGetGalleryCats();
		$cat = array();
		foreach ($cats as $catId => $item) {

			$cat[$item['name']] = $catId;
		}

		$fields = array(

			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "masonry",
				"value" => array(
					esc_html__('Horizontal Gallery Slider', 'lt-ext') => 'grid',
					esc_html__('Large grid with 4 Albums', 'lt-ext') => 'albums',
				),
				"type" => "dropdown",
			),	
			array(
				"param_name" => "cat",
				"heading" => esc_html__("Category", 'lt-ext'),
				"value" => array_merge(array(esc_html__('--', 'lt-ext') => 0), $cat),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'albums',
				),					
			),						
			array(
				"param_name" => "album",
				"heading" => esc_html__("Album", 'lt-ext'),
				"value" => $albums,
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'grid',
				),					
			),
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Limit", 'lt-ext'),
				"std"	=>	"8",
				"admin_label" => true,
				"type" => "textfield",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'grid',
				),					
			),	
			array(
				"param_name" => "autoplay",
				"heading" => esc_html__("Autoplay", 'lt-ext'),
				"description" => esc_html__("Enter timeout in ms (0 - disabled)", 'lt-ext'),
				"std" => "4000",
				"type" => "textfield",
				'dependency' => array(
					'element' => 'layout',
					'value' => 'grid',
				),						
			),											
		
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_gallery' ) ) {

	function like_sc_gallery($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_gallery', $atts, array_merge( array(

			'limit' 		=> '8',
			'album' 			=> '',
			'cat' 			=> '',
			'autoplay' 			=> '',
			'layout' 		=> 'grid',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('gallery', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_gallery", "like_sc_gallery");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_gallery_add')) {

	function ltx_vc_gallery_add() {
		
		vc_map( array(
			"base" => "like_sc_gallery",
			"name" 	=> esc_html__("Gallery Photos", 'lt-ext'),
			"description" => esc_html__("Last photos from LTx Gallery", 'lt-ext'),
			"class" => "like_sc_gallery",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/gallery/gallery.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_gallery_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_gallery_add', 30);
}


