<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_products_categories_params' ) ) {

	function ltx_vc_products_categories_params() {

		$order_by_values = ltxProductOrderByValues();

		$fields = array(
/*
			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Slider', 'lt-ext') 	=> 'default',
					esc_html__('Categories headers filter', 'lt-ext') 	=> 'filter-headers',
					esc_html__('Categories icons filter', 'lt-ext') 	=> 'filter-icons',
					esc_html__('Simple Products', 'lt-ext') 	=> 'simple',
				),
				"type" => "dropdown"
			),		
*/						
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order by', 'lt-ext' ),
				'param_name' => 'orderby',
				'value' => $order_by_values,
				'std' => 'menu_order title',
				// Default WC value
				'save_always' => true,
				'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'lt-ext' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),			
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Items limit", 'lt-ext'),
//				"description" => esc_html__("If empty or null - no slider will be active", 'lt-ext'),
				"std"	=>	"4",
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "columns",
				"heading" => esc_html__("Columns", 'lt-ext'),
				"std" => "4",
				"value" => array(1,2,3,4),
				"type" => "dropdown",				
			),		

			array(
				'type' => 'autocomplete',
				'heading' => __( 'Categories', 'lt-ext' ),
				'param_name' => 'ids',
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
				),
				'save_always' => true,
				'description' => esc_html__( 'If empty - displays all', 'lt-ext' ),
			),
	/*
			array(
				"param_name" => "more_text",
				"heading" => esc_html__("More Button", 'lt-ext'),
				"type" => "textfield",
				"std" => "Read more",					
			),				
*/	
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_products_categories' ) ) {

	function like_sc_products_categories($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_products_categories', $atts, array_merge( array(

			'ids' 			=> '',
			'limit' 		=> '',
			'more_text' 		=> '',
			'columns' 		=> '4',
			'orderby' 		=> '',
			'layout' 		=> 'simple',	
			'category_filter' 		=> '0',	
			'per_slide' 	=> '',
			'autoplay' 		=> '0',

			), array_fill_keys(array_keys(ltx_vc_swiper_params(true)), null), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		if ( ltx_is_wc('wc_active') ) return like_sc_output('products_categories', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_products_categories", "like_sc_products_categories");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_products_categories_add')) {

	function ltx_vc_products_categories_add() {
		
		vc_map( array(
			"base" => "like_sc_products_categories",
			"name" 	=> esc_html__("Products Categories", 'lt-ext'),
			"description" => esc_html__("Products Customized List", 'lt-ext'),
			"class" => "like_sc_products_categories",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/products_categories/products_categories.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_products_categories_params(),
				ltx_vc_swiper_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_products_categories_add', 30);
}



