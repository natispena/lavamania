<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * WPBakery Page Builder functions
 */

if ( aqualine_is_vc() ) {

	/**
	 * Changing path of templates
	 */
	if (function_exists('vc_set_shortcodes_templates_dir') ) {

		$dir = get_template_directory_uri() . '/vc-templates';
		vc_set_shortcodes_templates_dir( $dir );
	}

	if (!function_exists('aqualine_vc_theme_init')) {

		function aqualine_vc_theme_init() {

			add_filter( 'vc_iconpicker-type-fontawesome', 'aqualine_vc_iconpicker_type_fontawesome' );
		}
		add_action( 'after_setup_theme', 'aqualine_vc_theme_init', 9 );
	}
		
	/**
	 * Adding Fontello icons to VC Fontawesome library
	 * https://kb.wpbakery.com/docs/developers-how-tos/adding-icons-to-vc_icon/
	 */
	if ( !function_exists( 'aqualine_vc_iconpicker_type_fontawesome' ) ) {

		function aqualine_vc_iconpicker_type_fontawesome($icons) {

			if ( function_exists('FW')) {

				$file = aqualine_get_fontello_css();
				$fontello = aqualine_get_fontello_path();				

				if ( !empty($file) ) {

					$list = aqualine_get_fontello_icons( $file );
				}
			}		

			if ( empty($list) ) {

				return $icons;
			}
				else {

				$items = array();
				foreach ($list as $item) {

					$items[] = array(

						$item => str_replace('icon-', '', $item)
					);
				}

				return array_merge( $icons, array( esc_html__('Aqualine Icons', 'aqualine' ) => $items ) );
			}
		}

		add_filter( 'vc_iconpicker-type-fontawesome', 'aqualine_vc_iconpicker_type_fontawesome' );
	}


}


/**
 * Parses fontello css file and generates array with icons names
 */
if ( !function_exists( 'aqualine_get_fontello_icons' ) ) {

	function aqualine_get_fontello_icons( $css_uri ) {

		static $list = false;

		if ( !is_array($list) ) {

			$list = array();

			if ( is_admin() )  {

				$fontello = $css_uri;
				$file = aqualine_get_contents_array( $fontello );

				if ( empty($file) ) return $list;


				foreach ($file as $row) {

					if ( substr($row, 0, 1 ) == '.') {

						$i = explode(':', $row);

						if ( !empty($i[0]) ) {

							$list[] = substr($i[0], 1);
						}
					}
				}				
			}
		}

		return $list;
	}
}

/**
 * Getting file contents as array
 * https://codex.wordpress.org/Filesystem_API
 */
if ( !function_exists('aqualine_get_contents_array') ) {

	function aqualine_get_contents_array( $file ) {

		global $wp_filesystem;

		if ( !empty($file) AND !empty($wp_filesystem) AND is_object($wp_filesystem) ) {

			$file = str_replace( ABSPATH, $wp_filesystem->abspath(), $file );
			$list = $wp_filesystem->get_contents_array($file);

			return $list;
		}

		return array();
	}
}

/**
 * Get Fontello packs path
 */
if ( !function_exists('aqualine_get_fontello_path') ) {

	function aqualine_get_fontello_path() {

		$fontello_local = fw_get_db_settings_option( 'fontello-local' );

		if ( $fontello_local AND is_child_theme() AND file_exists(get_stylesheet_directory() . '/assets/fontello/') ) {

			$fontello['css']['url'] = get_stylesheet_directory_uri() . '/assets/fontello/ltx-aqualine-codes.css';
			$fontello['eot']['url'] = get_stylesheet_directory_uri() . '/assets/fontello/ltx-aqualine.eot';
			$fontello['ttf']['url'] = get_stylesheet_directory_uri() . '/assets/fontello/ltx-aqualine.ttf';
			$fontello['woff']['url'] = get_stylesheet_directory_uri() . '/assets/fontello/ltx-aqualine.woff';
			$fontello['woff2']['url'] = get_stylesheet_directory_uri() . '/assets/fontello/ltx-aqualine.woff2';
			$fontello['svg']['url'] = get_stylesheet_directory_uri() . '/assets/fontello/ltx-aqualine.svg';
		}

		if ( $fontello_local AND empty($fontello) AND file_exists(get_template_directory() . '/assets/fontello/') ) {

			$fontello['css']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-aqualine-codes.css';
			$fontello['eot']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-aqualine.eot';
			$fontello['ttf']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-aqualine.ttf';
			$fontello['woff']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-aqualine.woff';
			$fontello['woff2']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-aqualine.woff2';
			$fontello['svg']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-aqualine.svg';
		}
			else
		if ( empty($fontello) ) {

			$fontello['css'] = fw_get_db_settings_option( 'fontello-css' );
			$fontello['eot'] = fw_get_db_settings_option( 'fontello-eot' );
			$fontello['ttf'] = fw_get_db_settings_option( 'fontello-ttf' );
			$fontello['woff'] = fw_get_db_settings_option( 'fontello-woff' );
			$fontello['woff2'] = fw_get_db_settings_option( 'fontello-woff2' );
			$fontello['svg'] = fw_get_db_settings_option( 'fontello-svg' );
		}	
		
		return $fontello;	
	}
}

/**
 * Get Fontello CSS file
 */
if ( !function_exists('aqualine_get_fontello_css') ) {

	function aqualine_get_fontello_css() {

		$fontello_local = fw_get_db_settings_option( 'fontello-local' );

		if ( $fontello_local AND is_child_theme() AND file_exists(get_stylesheet_directory() . '/assets/fontello/ltx-aqualine-codes.css') ) {

			$file = get_stylesheet_directory() . '/assets/fontello/ltx-aqualine-codes.css';
		}
			else
		if ( $fontello_local AND file_exists(get_template_directory() . '/assets/fontello/') ) {

			$file = get_template_directory() . '/assets/fontello/ltx-aqualine-codes.css';
		}
			else {

			$fontello['css'] = fw_get_db_settings_option( 'fontello-css' );
			if ( !empty($fontello['css']['attachment_id']) ) {

				$file = get_attached_file($fontello['css']['attachment_id']);
			}
		}	
		
		if ( !empty($file) AND file_exists($file) ) {

			return $file;	
		}
			else {

			return false;
		}
	}
}


/**
 * Generating Fontello inline style and FontAwesome 5
 */
if ( !function_exists('aqualine_get_fontello_generate') ) {

	function aqualine_get_fontello_generate($admin_style = false) {
	
		$fontello = aqualine_get_fontello_path();	

		if ( !empty($fontello['css']) AND !empty( $fontello['eot']) AND  !empty( $fontello['ttf']) AND  !empty( $fontello['woff']) AND  !empty( $fontello['woff2']) AND  !empty( $fontello['svg']) ) {

			wp_enqueue_style(  'aqualine-fontello',  $fontello['css']['url'], array(), wp_get_theme()->get('Version') );

			wp_deregister_style( 'font-awesome' );
			wp_enqueue_style(  'font-awesome',  get_template_directory_uri().'/assets/fonts/font-awesome/css/all.min.css', array(), wp_get_theme()->get('Version') );
			wp_enqueue_style(  'font-awesome-shims',  get_template_directory_uri().'/assets/fonts/font-awesome/css/v4-shims.min.css', array(), wp_get_theme()->get('Version') );

			$randomver = wp_get_theme()->get('Version');
			$css_content = "@font-face {
			font-family: 'aqualine-fontello';
			  src: url('". esc_url ( $fontello['eot']['url']. "?" . $randomver )."');
			  src: url('". esc_url ( $fontello['eot']['url']. "?" . $randomver )."#iefix') format('embedded-opentype'),
			       url('". esc_url ( $fontello['woff2']['url']. "?" . $randomver )."') format('woff2'),
			       url('". esc_url ( $fontello['woff']['url']. "?" . $randomver )."') format('woff'),
			       url('". esc_url ( $fontello['ttf']['url']. "?" . $randomver )."') format('truetype'),
			       url('". esc_url ( $fontello['svg']['url']. "?" . $randomver )."#" . pathinfo(wp_basename( $fontello['svg']['url'] ), PATHINFO_FILENAME)  . "') format('svg');
			  font-weight: normal;
			  font-style: normal;
			}";

			if ( $admin_style )  {

				wp_add_inline_style( 'aqualine-fontello', $css_content );

			}
				else {

				wp_add_inline_style( 'aqualine-theme-style', $css_content );
			}

		}
	}
}


