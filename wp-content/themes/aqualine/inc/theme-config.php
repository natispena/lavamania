<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Theme Configuration and Custom CSS initializtion
 */

/**
 * Global theme config for header/footer/sections/colors/fonts
 */
if ( !function_exists('aqualine_theme_config') ) {

	add_filter( 'ltx_get_theme_config', 'aqualine_theme_config', 10, 1 );
	function aqualine_theme_config() {

	    return array(
	    	'navbar'	=>	array(
				'white'  	=> esc_html__( 'White with Red Line', 'aqualine' ),
				'white-border'  	=> esc_html__( 'White Simple', 'aqualine' ),
				'transparent'  	=> esc_html__( 'Transparent on Dark Background', 'aqualine' ),
				'transparent-overlay'  	=> esc_html__( 'Transparent with Overlay', 'aqualine' ),
				'hamburger-transparent'  => esc_html__( 'Hamburger Transparent', 'aqualine' ),		
			),
			'navbar-default' => 'white',

			'footer' => array(
				'default'  => esc_html__( 'Default', 'aqualine' ),		
				'copyright'  => esc_html__( 'Copyright Only', 'aqualine' ),
				'copyright-transparent'  => esc_html__( 'Copyright Transparent', 'aqualine' ),						
			),
			'footer-default' => 'default',

			'color_main'	=>	'#E81C2E',
			'color_second'	=>	'#CCB686',
			'color_black'	=>	'#19191B',
			'color_gray'	=>	'#F2F2F2',
			'color_white'	=>	'#FFFFFF',
			'color_red'		=>	'#D12323',
			'color_green'	=>	'#39b972',

			
			'color_main_header'	=>	esc_html__( 'Red', 'aqualine' ),

			'logo_height'		=>	80,
			'navbar_dark'		=>	'rgba(0,0,0,0.75)',

			'font_main'					=>	'Ubuntu',
			'font_main_var'				=>	'regular',
			'font_main_weights'			=>	'300,400,400i,700,700i',
			'font_headers'				=>	'Barlow Semi Condensed',
			'font_headers_var'			=>	'700',
			'font_headers_weights'		=>	'700,600',
			'font_subheaders'			=>	'Barlow Semi Condensed',
			'font_subheaders_var'		=>	'700',
			'font_subheaders_weights'	=>	'700,600',
		);
	}
}

/**
 *  Editor Settings
 */
function aqualine_editor_settings() {

	$cfg = aqualine_theme_config();

    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'Main', 'aqualine' ),
            'slug' => 'main-theme',
            'color' => $cfg['color_main'],
        ),
        array(
            'name' => esc_html__( 'Gray', 'aqualine' ),
            'slug' => 'gray',
            'color' => $cfg['color_gray'],
        ),
        array(
            'name' => esc_html__( 'Black', 'aqualine' ),
            'slug' => 'black',
            'color' => $cfg['color_black'],
        ),
        array(
            'name' => esc_html__( 'Pale Pink', 'aqualine' ),
            'slug' => 'pale-pink',
            'color' => '#f78da7',
        ),        
    ) );

	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => esc_html__( 'small', 'aqualine' ),
			'shortName' => esc_html__( 'S', 'aqualine' ),
			'size'      => 14,
			'slug'      => 'small'
		),
		array(
			'name'      => esc_html__( 'regular', 'aqualine' ),
			'shortName' => esc_html__( 'M', 'aqualine' ),
			'size'      => 16,
			'slug'      => 'regular'
		),
		array(
			'name'      => esc_html__( 'large', 'aqualine' ),
			'shortName' => esc_html__( 'L', 'aqualine' ),
			'size'      => 24,
			'slug'      => 'large'
		),
	) );    
}
add_action( 'after_setup_theme', 'aqualine_editor_settings', 10 );

/**
 * Get Google default font url
 */
if ( !function_exists('aqualine_font_url') ) {

	function aqualine_font_url() {

		$cfg = aqualine_theme_config();
		$q = array();
		foreach ( array('font_main', 'font_headers', 'font_subheaders') as $item ) {

			if ( !empty($cfg[$item]) ) {

				$w = '';
				if ( !empty($cfg[$item.'_weights']) ) {

					$w .= ':'.$cfg[$item.'_weights'];
				}
				$q[] = $cfg[$item].$w;
			}
		}

		$query_args = array( 'family' => implode('%7C', $q), 'subset' => 'latin' );

		$font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return esc_url( $font_url );
	}
}

/**
 * Config used for lt-ext plugin to set Visual Composer configuration
 */
if ( !function_exists('aqualine_vc_config') ) {

	add_filter( 'ltx_get_vc_config', 'aqualine_vc_config', 10, 1 );
	function aqualine_vc_config( $value ) {

	    return array(
	    	'sections'	=>	array(
				esc_html__("Overflow visible section", 'aqualine') 	=> "displaced-top",				
				esc_html__("Background move on hover", 'aqualine') 	=> "ltx-mouse-move",				
				esc_html__("Locations Row", 'aqualine') 	=> "ltx-locations-row",
				esc_html__("Before After Icons Row", 'aqualine') 	=> "ltx-ba-icons-row",
			),
			'background' => array(
				esc_html__( "Main", 'aqualine' ) => "theme_color",	
				esc_html__( "Second", 'aqualine' ) => "second",	
				esc_html__( "Gray", 'aqualine' ) => "gray",
				esc_html__( "White", 'aqualine' ) => "white",
				esc_html__( "Black", 'aqualine' ) => "black",			
				esc_html__( "True Black", 'aqualine' ) => "true-black",			
			),
			'overlay'	=> array(
				esc_html__( "Black Overlay (80%)", 'aqualine' ) => "black",
				esc_html__( "Dark Overlay (60%)", 'aqualine' ) => "dark",
				esc_html__( "Gray Overlay (40%)", 'aqualine' ) => "xblack",
				esc_html__( "Light Overlay (20%)", 'aqualine' ) => "white",
				esc_html__( "White Overlay (50%)", 'aqualine' ) => "gray",

				esc_html__( "Bulb Main Color", 'aqualine' ) => "bulb-main",
				esc_html__( "Bulb Second Color", 'aqualine' ) => "bulb-second",
				esc_html__( "Bulb White Color", 'aqualine' ) => "bulb-white",
				esc_html__( "Bulb Black Color", 'aqualine' ) => "bulb-black",
				esc_html__( "Bulb Gray Color", 'aqualine' ) => "bulb-gray",
			),
		);
	}
}


/*
* Adding additional TinyMCE options
*/
if ( !function_exists('aqualine_mce_before_init_insert_formats') ) {

	add_filter('mce_buttons_2', 'aqualine_wpb_mce_buttons_2');
	function aqualine_wpb_mce_buttons_2( $buttons ) {

	    array_unshift($buttons, 'styleselect');
	    return $buttons;
	}

	add_filter( 'tiny_mce_before_init', 'aqualine_mce_before_init_insert_formats' );
	function aqualine_mce_before_init_insert_formats( $init_array ) {  

	    $style_formats = array(

	        array(  
	            'title' => esc_html__('Main Color', 'aqualine'),
	            'block' => 'span',  
	            'classes' => 'color-main',
	            //'wrapper' => true,
	        ),  
	        array(  
	            'title' => esc_html__('White Color', 'aqualine'),
	            'block' => 'span',  
	            'classes' => 'color-white',
	            'wrapper' => true,   
	        ),
	        array(  
	            'title' => esc_html__('Medium Text', 'aqualine'),
	            'block' => 'span',  
	            'classes' => 'text-md',
	            'wrapper' => true,
	        ),    	        
	        array(  
	            'title' => esc_html__('Large Text', 'aqualine'),
	            'block' => 'span',  
	            'classes' => 'text-lg',
	            'wrapper' => true,
	        ),    
	        array(  
	            'title' => 'List Checkbox',
	            'selector' => 'ul',
	            'classes' => 'check',
	        ),     
	        array(  
	            'title' => 'List Checkbox Inverted',
	            'selector' => 'ul',
	            'classes' => 'check-invert',
	        ),     	        
	        array(  
	            'title' => 'List Bullets',
	            'selector' => 'ul',
	            'classes' => 'disc',
	        ),     	        
	        array(  
	            'title' => 'Multi-Column List',
	            'selector' => 'ul',
	            'classes' => 'multicol',
	        ),	          
	    );  
	    $init_array['style_formats'] = json_encode( $style_formats );  
	     
	    return $init_array;  
	} 
}


/**
 * Register widget areas.
 *
 */
if ( !function_exists('aqualine_action_theme_widgets_init') ) {

	add_action( 'widgets_init', 'aqualine_action_theme_widgets_init' );
	function aqualine_action_theme_widgets_init() {

		$span_class = 'widget-icon';

		$header_class = $theme_icon = '';
		if ( function_exists('FW') ) {

			if ( !empty($theme_icon['icon-class']) ) $header_class = 'hasIcon';
		}


		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Default', 'aqualine' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Displayed in the right/left section of the site.', 'aqualine' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="ltx-sidebar-header"><h3 class="header-widget '.esc_attr($header_class).'"><span class="'.esc_attr($span_class).'"></span>',
			'after_title'   => '<span class="last '.esc_attr($span_class).'"></span></h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar WooCommerce', 'aqualine' ),
			'id'            => 'sidebar-wc',
			'description'   => esc_html__( 'Displayed in the right/left section of the site.', 'aqualine' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="ltx-sidebar-header"><h3 class="header-widget '.esc_attr($header_class).'"><span class="'.esc_attr($span_class).'"></span>',
			'after_title'   => '<span class="last '.esc_attr($span_class).'"></span></h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 1', 'aqualine' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'aqualine' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget '.esc_attr($header_class).'"><span class="'.esc_attr($span_class).'"></span>',
			'after_title'   => '<span class="last '.esc_attr($span_class).'"></span></h3>',
		) );			

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 2', 'aqualine' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'aqualine' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget '.esc_attr($header_class).'"><span class="'.esc_attr($span_class).'"></span>',
			'after_title'   => '<span class="last '.esc_attr($span_class).'"></span></h3>',
		) );			

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 3', 'aqualine' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'aqualine' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget '.esc_attr($header_class).'"><span class="'.esc_attr($span_class).'"></span>',
			'after_title'   => '<span class="last '.esc_attr($span_class).'"></span></h3>',
		) );			

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'aqualine' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'aqualine' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget '.esc_attr($header_class).'"><span class="'.esc_attr($span_class).'"></span>',
			'after_title'   => '<span class="last '.esc_attr($span_class).'"></span></h3>',
		) );			

	}
}



/**
 * Additional styles init
 */
if ( !function_exists('aqualine_css_style') ) {

	add_action( 'wp_enqueue_scripts', 'aqualine_css_style', 10 );
	function aqualine_css_style() {

		global $wp_query;

		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap-grid.css', array(), '1.0' );

		wp_enqueue_style( 'aqualine-plugins', get_template_directory_uri() . '/assets/css/plugins.css', array(), wp_get_theme()->get('Version') );

		wp_enqueue_style( 'aqualine-theme-style', get_stylesheet_uri(), array( 'bootstrap', 'aqualine-plugins' ), wp_get_theme()->get('Version') );
	}
}


/**
 * Wp-admin styles and scripts
 */
if ( !function_exists('aqualine_admin_init') ) {

	add_action( 'after_setup_theme', 'aqualine_admin_init' );
	function aqualine_admin_init() {

		add_action("admin_enqueue_scripts", 'aqualine_admin_scripts');
	}

	function aqualine_admin_scripts() {

		if ( function_exists('fw_get_db_settings_option') ) {

			aqualine_get_fontello_generate(true);

			wp_enqueue_script( 'aqualine-theme-admin', get_template_directory_uri() . '/assets/js/scripts-admin.js', array( 'jquery' ) );
		}
	}
}



