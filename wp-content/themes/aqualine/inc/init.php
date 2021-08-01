<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class aqualine_Theme_Includes {

	private static $rel_path = null;

	private static $include_isolated_callable;

	private static $initialized = false;

	public static function init() {

		if ( self::$initialized ) {
			return;
		} else {
			self::$initialized = true;
		}

		/**
		 * Include a file isolated, to not have access to current context variables
		 */

		/**
		 * Both frontend and backend
		 */
		{
			self::include_child_first( '/helpers.php' );
			self::include_child_first( '/hooks.php' );
			self::include_child_first( '/woocommerce.php' );


			self::include_all_child_first( '/includes' );

			add_action( 'init', array( __CLASS__, 'aqualine_action_init' ) );
		}

		/**
		 * Only frontend
		 */
		if ( ! is_admin() ) {
			
			add_action('wp_enqueue_scripts', array( __CLASS__, 'aqualine_action_enqueue_scripts' ), 20 );
		}
	}

	private static function get_includes_files_list($dir_rel_path){
		
		$path  	= self::get_parent_path($dir_rel_path). '/'; 

		$includes_files_list = array(
			
			$path.'content-width.php',
		);	
		
		$custom_list =  apply_filters ('aqualine_filter_init_includes_custom_files', array());
		
		if ( !empty($custom_list) ){
			
			$prefixed_files = array();
			$child_path = self::get_child_path($dir_rel_path). '/';
			
			foreach ($custom_list as $file) {

				$prefixed_files[] = $child_path . $file;
			}	
					
			unset($custom_list);
			
			$includes_files_list = array_merge($includes_files_list, $prefixed_files);	
			
			unset($prefixed_files);
		}
		
		return $includes_files_list;
	}

	private static function get_rel_path($append = '') {

		if (self::$rel_path === null) {
			self::$rel_path = '/inc';
		}

		return self::$rel_path . $append;
	}

	private static function include_all_child_first($dir_rel_path) {

		$files 	= self::get_includes_files_list($dir_rel_path);

		foreach ($files as $file) {

			if (file_exists( $file )){
				
				self::include_isolated( $file );
				
			}
		}
		unset($files);
	}

	public static function get_parent_path( $rel_path ) {
		return get_template_directory() . self::get_rel_path( $rel_path );
	}

	public static function get_child_path( $rel_path ) {
		if ( ! is_child_theme() ) {
			return null;
		}

		return get_stylesheet_directory() . self::get_rel_path( $rel_path );
	}

	public static function include_isolated( $path ) {
		include $path;
	}

	public static function include_child_first( $rel_path ) {
		if ( is_child_theme() ) {
			$path = self::get_child_path( $rel_path );

			if ( file_exists( $path ) ) {
				self::include_isolated( $path );
			}
		}

		{
			$path = self::get_parent_path( $rel_path );

			if ( file_exists( $path ) ) {
				self::include_isolated( $path );
			}
		}
	}

	/**
	 * @internal
	 */
	public static function aqualine_action_enqueue_scripts() {
		self::include_child_first( '/static.php' );
	}

	/**
	 * @internal
	 */
	public static function aqualine_action_init() {
		self::include_child_first( '/menus.php' );
		self::include_child_first( '/posts.php' );
	}

}

aqualine_Theme_Includes::init();

