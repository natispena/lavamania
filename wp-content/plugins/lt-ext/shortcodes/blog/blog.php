<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_blog_params' ) ) {

	function ltx_vc_blog_params() {

		$categories = json_decode(json_encode(get_categories()), TRUE);
		$cat = array();
		foreach ($categories as $item) {

			$cat[$item['name']] = $item['term_id'];
		}

		$fields = array(	
			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "posts",
				"admin_label" => true,
				"value" => array(
					esc_html__('(Default) Blog posts with top image', 'lt-ext') => 'posts',
					esc_html__('Featured Posts', 'lt-ext') => 'featured',
					esc_html__('Posts list with left image', 'lt-ext') => 'list',
					esc_html__('Simple (Image and Header)', 'lt-ext') => 'simple',
					esc_html__('Text only', 'lt-ext') => 'short',
//					esc_html__('(Default) Blog posts with top image', 'lt-ext') => 'posts',
				),
				"type" => "dropdown"
			),		
			array(
				"param_name" => "columns",
				"heading" => esc_html__("Columns", 'lt-ext'),
				"std" => "3",
				"value" => array(1,2,3,4),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('posts', 'short'),
				),					
			),			
/*							
			array(
				"param_name" => "size",
				"heading" => esc_html__("Header and text size", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default', 'lt-ext') => 'default',
					esc_html__('Small', 'lt-ext') => 'sm',
					esc_html__('Large', 'lt-ext') => 'lg',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('posts'),
				),					
			),					
*/			
			array(
				"param_name" => "excerpt_display",
				"heading" => esc_html__("Excerpt Display", 'lt-ext'),
				"std" => "hidden",
				"value" => array(
					esc_html__('Visible', 'lt-ext') => 'visible',
					esc_html__('Hidden', 'lt-ext') => 'hidden',
				),
				"type" => "dropdown",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('posts'),
				),					
			),									
			array(
				"param_name" => "excerpt",
				"heading" => esc_html__("Custom Excerpt Size", 'lt-ext'),
				"value" => "",
				"description" => esc_html__("By default global setting is used", 'lt-ext'),
				"type" => "textfield",
				'dependency' => array(
					'element' => 'excerpt_display',
					'value' => array('visible'),
				),					
			),	
/*					
			array(
				"param_name" => "readmore",
				"heading" => esc_html__("Header for read more link, will be hidden if empty", 'lt-ext'),
				"value" => "",
				"type" => "textfield"
			),
*/			
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Limit", 'lt-ext'),
				"admin_label" => true,
				"value" => "3",
				"type" => "textfield"
			),				
			array(
				"param_name" => "ids",
				"heading" => esc_html__("Filter IDs", 'lt-ext'),
				"description" => __("Enter IDs to show, separated by comma", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),						
			array(
				"param_name" => "cat",
				"heading" => esc_html__("Category", 'lt-ext'),
				"value" => array_merge(array(esc_html__('--', 'lt-ext') => 0), $cat),
				"admin_label" => true,
				"type" => "dropdown"
			),		

			array(
				"param_name" => "more_link",
				"heading" => esc_html__("More Link", 'lt-ext'),
				"type" => "textfield",
				"std" => "#",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('featured'),
				),					
			),						

			array(
				"param_name" => "more_text",
				"heading" => esc_html__("More Button", 'lt-ext'),
				"type" => "textfield",
				"std" => "All posts",
				'dependency' => array(
					'element' => 'layout',
					'value' => array('featured'),
				),					
			),						

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order by', 'lt-ext' ),
			'param_name' => 'orderby',
			'value' => array(
				'',
				esc_html__( 'Date', 'lt-ext' ) => 'date',
				esc_html__( 'ID', 'lt-ext' ) => 'ID',
				esc_html__( 'Author', 'lt-ext' ) => 'author',
				esc_html__( 'Title', 'lt-ext' ) => 'title',
				esc_html__( 'Modified', 'lt-ext' ) => 'modified',
				esc_html__( 'Random', 'lt-ext' ) => 'rand',
				esc_html__( 'Comment count', 'lt-ext' ) => 'comment_count',
				esc_html__( 'Menu order', 'lt-ext' ) => 'menu_order',
			),
			'description' => sprintf( esc_html__( 'Select how to sort retrieved posts. More at %s.', 'lt-ext' ), '<a href="https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Sort order', 'lt-ext' ),
			'param_name' => 'orderway',
			'value' => array(
				esc_html__( 'Descending', 'lt-ext' ) => 'DESC',
				esc_html__( 'Ascending', 'lt-ext' ) => 'ASC',
			),
			'description' => sprintf( esc_html__( 'Select ascending or descending order. More at %s.', 'lt-ext' ), '<a href="https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
		),

		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_blog' ) ) {

	function like_sc_blog($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_blog', $atts, array_merge( array(

			'layout'		=> 'images',
			'date_style'		=> 'bold',
			'columns'			=> '4',
			'excerpt_display'			=> 'hidden',
			'size'			=> 'default',
			'cat'			=> '',
			'readmore'		=> '',
			'readmore_style'		=> '',
			'thumb'			=> 'visible',
			'ids'			=> '',
			'limit'			=> '3',
			'cat'			=> '',
			'excerpt'		=> '',

			'orderby'		=> '',
			'orderway'		=> '',
			
			'more_text'			=> '',
			'more_link'			=> '',

			'all_posts'		=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('blog', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_blog", "like_sc_blog");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_blog_add')) {

	function ltx_vc_blog_add() {
		
		vc_map( array(
			"base" => "like_sc_blog",
			"name" 	=> esc_html__("Blog", 'lt-ext'),
			"description" => esc_html__("Blog posts slider", 'lt-ext'),
			"class" => "like_sc_blog",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/blog/blog.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_blog_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_blog_add', 30);
}


