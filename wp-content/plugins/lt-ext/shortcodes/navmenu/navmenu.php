<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Menu
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_navmenu_params' ) ) {

	function ltx_vc_navmenu_params() {

        $menus_ = wp_get_nav_menus();
        $menus = array();
        if ( !empty($menus_) ) {

            foreach ($menus_ as $item) {

                $menus[$item->term_id] = $item->name;
            }
        }

		$fields = array(	

			array(
				"param_name" => "menu",
				"heading" => esc_html__("Menu", 'lt-ext'),
				"value" => $menus,
				"type" => "dropdown"
			),	
			array(
				'param_name' => 'depth',
				'heading' => esc_html__( 'Depth', 'lt-ext' ),	
				"value" => 1,			
				'type' => 'textfield',
			),						
			array(
				"param_name" => "visibilty",
				"heading" => esc_html__("Visible", 'lt-ext'),
				"std" => "desktop",
				"value" => array(
					esc_html__('Always', 'lt-ext') => 'always',
					esc_html__('Desktop only', 'lt-ext') => 'desktop',
				),
				"type" => "dropdown"
			),	
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_navmenu' ) ) {

	function like_sc_navmenu($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_navmenu', $atts, array_merge( array(

			'menu'			=> '',
			'depth'			=> '',
			'visibilty'			=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('navmenu', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_navmenu", "like_sc_navmenu");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_navmenu_add')) {

	function ltx_vc_navmenu_add() {
		
		vc_map( array(
			"base" => "like_sc_navmenu",
			"name" 	=> esc_html__("Navbar Menu", 'lt-ext'),
			"description" => esc_html__("Show inline menu", 'lt-ext'),
			"class" => "like_sc_navmenu",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/navmenu/navmenu.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_navmenu_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_navmenu_add', 30);
}


