<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_jplayer_params' ) ) {

	function ltx_vc_jplayer_params() {

		$fields = array(

			array(
				"param_name" => "image",
				"heading" => esc_html__("Default Album Cover", 'lt-ext'),
				"admin_label" => true,
				"type" => "attach_image"
			),	
			array(
				'type' => 'param_group',
				'param_name' => 'items',
				'heading' => esc_html__( 'Tracks', 'lt-ext' ),
				"description" => wp_kses_data( __("Add several tracks", 'lt-ext') ),
				'value' => urlencode( json_encode( array(
					array(
						'Author' => '',
						'Title' => '',
					),
				) ) ),
				'params' => array(

					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", 'lt-ext'),
						"admin_label" => true,
						"type" => "textfield"
					),		
					array(
						"param_name" => "author",
						"heading" => esc_html__("Author", 'lt-ext'),
						"admin_label" => true,
						"type" => "textfield"
					),					
					array(
						"param_name" => "file",
						"heading" => esc_html__("Select Media", 'lt-ext'),
						"admin_label" => true,
						"type" => "file_picker"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Track cover", 'lt-ext'),
						"admin_label" => true,
						"type" => "attach_image"
					),						

				),
			),						
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_jplayer' ) ) {

	function like_sc_jplayer($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_jplayer', $atts, array_merge( array(

			'items'			=> '',
			'image'			=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['items'] = json_decode ( urldecode( $atts['items'] ), true );

		wp_enqueue_script( 'jplayer', ltxGetPluginUrl('/shortcodes/jplayer/jquery.jplayer.min.js'), array('jquery'), null, true );
		wp_enqueue_script( 'jplayer-playlist', ltxGetPluginUrl('/shortcodes/jplayer/jplayer.playlist.min.js'), array('jquery', 'jplayer'), null, true );

		if (!empty($atts['items'])) {

			return like_sc_output('jplayer', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_jplayer", "like_sc_jplayer");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_jplayer_add')) {

	function ltx_vc_jplayer_add() {
		
		vc_map( array(
			"base" => "like_sc_jplayer",
			"name" 	=> esc_html__("Audio Playlist", 'lt-ext'),
			"description" => esc_html__("Playlist Player", 'lt-ext'),
			"class" => "like_sc_jplayer",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/jplayer/jplayer.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_jplayer_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_jplayer_add', 30);
}


