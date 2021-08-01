<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * LT-Ext Plugin Functions
 */

//include LTX_PLUGIN_DIR . 'inc/popup.php';
include LTX_PLUGIN_DIR . 'inc/ltx-dashboard.php';
include LTX_PLUGIN_DIR . 'inc/post-cats.php';
include LTX_PLUGIN_DIR . 'inc/font-awesome-5.php';
include LTX_PLUGIN_DIR . 'inc/update.php';


// Get Local Path of include file
function ltxGetLocalPath($file) {

	global $ltx_cfg;

	return $ltx_cfg['path'].$ltx_cfg['base'].$file;
}

// Get Plugin Url
function ltxGetPluginUrl($file) {

	global $ltx_cfg;

	return $ltx_cfg['url'].$file;
}

// Get Visual Composer plugin status
if ( !function_exists( 'ltx_vc_inited' ) ) {

	function ltx_vc_inited() {
		
		return class_exists('Vc_Manager');
	}
}

// Generate img url
if (!function_exists('ltx_get_attachment_img_url')) {
	function ltx_get_attachment_img_url( $img, $size = 'full' ) {
		if ($img > 0) {

			return wp_get_attachment_image_src($img, $size);
		}
	}
}

if ( !function_exists( 'ltx_is_wc' ) ) {
	/**
	 * Return true|false is woocommerce conditions.
	 *
	 * @param string $tag
	 * @param string|array $attr
	 *
	 * @return bool
	 */
	function ltx_is_wc($tag, $attr='') {
		if( !class_exists( 'woocommerce' ) ) return false;
		switch ($tag) {
			case 'wc_active':
		        return true;
			
		    case 'woocommerce':
		        if( function_exists( 'is_woocommerce' ) && is_woocommerce() ) return true;
				break;
		    case 'shop':
		        if( function_exists( 'is_shop' ) && is_shop() ) return true;
				break;
			case 'product_category':
		        if( function_exists( 'is_product_category' ) && is_product_category($attr) ) return true;
				break;
		    case 'product_tag':
		        if( function_exists( 'is_product_tag' ) && is_product_tag($attr) ) return true;
				break;
		    case 'product':
		    	if( function_exists( 'is_product' ) && is_product() ) return true;
				break;
		    case 'cart':
		        if( function_exists( 'is_cart' ) && is_cart() ) return true;
				break;
		    case 'checkout':
		        if( function_exists( 'is_checkout' ) && is_checkout() ) return true;
				break;
		    case 'account_page':
		        if( function_exists( 'is_account_page' ) && is_account_page() ) return true;
				break;
		    case 'wc_endpoint_url':
		        if( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url($attr) ) return true;
				break;
		    case 'ajax':
		        if( function_exists( 'is_ajax' ) && is_ajax() ) return true;
				break;
		}

		return false;
	}
}

/**
 * Return allowabale or default metric
 */
function ltx_vc_get_metric($item) {

	$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
	// allowed metrics: http://www.w3schools.com/cssref/css_units.asp
	$regexr = preg_match( $pattern, $item, $matches );
	$value = isset( $matches[1] ) ? (float) $matches[1] : (float) $item;
	$unit = isset( $matches[2] ) ? $matches[2] : 'px';

	return $value . $unit;
}


/**
 * Fix for widgets without header
 */
add_filter( 'dynamic_sidebar_params', 'ltx_check_sidebar_params' );
function ltx_check_sidebar_params( $params ) {
	global $wp_registered_widgets;

	// Exclude for widget with default title
	if ( in_array( $params[0]['widget_name'], array( 'Categories', 'Archives', 'Meta', 'Pages', 'Recent Comments', 'Recent Posts' ) ) ) {

		return $params;
	}

	$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
/*
	var_dump($settings_getter->get_settings);
	$settings = $settings_getter->get_settings();
	$settings = $settings[ $params[1]['number'] ];

	if ( $params[0]['after_widget'] === '</div></aside>' && isset( $settings['title'] ) && empty( $settings['title'] ) ) {
		$params[0]['before_widget'] .= '<div class="content">';
	}
*/
	return $params;
}


/**
 * Cuts text by the number of characters
 */
if ( !function_exists( 'ltx_cut_text' ) ) {

	function ltx_cut_text( $text, $cut = 300, $aft = ' ...' ) {
		if ( empty( $text ) ) {
			return null;
		}

		if ( empty($cut) AND function_exists( 'fw' ) ) {
			$cut = (int) fw_get_db_settings_option( 'excerpt_wc_auto' );
		}

		$text = wp_strip_all_tags( $text, true );
		$text = strip_tags( $text );
		$text = preg_replace( "/<p>|<\/p>|<br>|(( *&nbsp; *)|(\s{2,}))|\\r|\\n/", ' ', $text );
		if ( mb_strlen( $text ) > $cut ) {
			$text = mb_substr( $text, 0, $cut, 'UTF-8' );
			return mb_substr( $text, 0, mb_strripos( $text, ' ', 0, 'UTF-8' ), 'UTF-8' ) . $aft;
		} else {
			return $text;
		}
	}
}


if ( !function_exists('ltx_enable_extended_upload') ) {

    function ltx_enable_extended_upload ( $mime_types =array() ) {

	    $mime_types['ttf']  = 'application/x-font-ttf';
	    $mime_types['woff']  = 'application/x-font-woff';
	    $mime_types['woff2'] = 'application/x-font-woff2';
	    $mime_types['svg'] = 'image/svg+xml';
	    $mime_types['eot'] = 'application/vnd.ms-fontobject';
	    $mime_types['css'] = 'text/plain';

	    return $mime_types;
    }

    if ( is_admin() )  {

	    add_filter('upload_mimes', 'ltx_enable_extended_upload');
    }
}

/**
 * Initialazing WP Filesystem
 * https://codex.wordpress.org/Filesystem_API
 */
if ( !function_exists('ltx_wp_filesystem') ) {

	function ltx_wp_filesystem() {

        if( !function_exists('WP_Filesystem') ) {

            require_once( ABSPATH .'/wp-admin/includes/file.php' );
        }

		if (is_admin()) {

			$creds = false;
			if ( function_exists('request_filesystem_credentials') ) {

				$url = wp_nonce_url('themes.php?page=example','example-theme-options');
				if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {

					return; // stop processing here
				}
			}
	
			if ( !WP_Filesystem( $creds ) ) {

				if ( function_exists('request_filesystem_credentials') ) {

					request_filesystem_credentials( $url, '', true, false );
				}

				return false;
			}
			
			return true; // Filesystem object successfully initiated.
		}
			else {

            WP_Filesystem();
		}

		return true;
	}

	add_action( 'after_setup_theme', 'ltx_wp_filesystem', 0);
}



/**
 * Autocomplete suggester to search product category by name/slug or id.
 * @since 4.4
 *
 * @param $query
 * @param bool $slug - determines what output is needed
 *      default false - return id of product category
 *      true - return slug of product category
 *
 * @return array
 */
if ( !function_exists('ltxProductCategoryCategoryAutocompleteSuggester')) {
	
	function ltxProductCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = __( 'Id', 'lt-ext' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'lt-ext' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'lt-ext' ) . ': ' . $value['slug'] : '' );
				$result[] = $data;
			}
		}

		return $result;
	}
}
//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_like_sc_products_categories_ids_callback', 
	'ltxProductCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_like_sc_products_categories_ids_render',
	'ltxProductCategoryCategoryRenderByIdExact', 10, 1 ); // Render exact category by id. Must return an array (label,value)


/**
 * Search product category by id
 * @since 4.4
 *
 * @param $query
 *
 * @return bool|array
 */
if ( !function_exists('ltxProductCategoryCategoryRenderByIdExact')) {

	function ltxProductCategoryCategoryRenderByIdExact( $query ) {
		$query = $query['value'];
		$cat_id = (int) $query;
		$term = get_term( $cat_id, 'product_cat' );

		return ltxProductCategoryTermOutput( $term );
	}
}

if ( !function_exists('ltxProductCategoryTermOutput')) {

	function ltxProductCategoryTermOutput( $term ) {

		$term_slug = $term->slug;
		$term_title = $term->name;
		$term_id = $term->term_id;

		$term_slug_display = '';
		if ( ! empty( $term_slug ) ) {
			$term_slug_display = ' - ' . __( 'Sku', 'lt-ext' ) . ': ' . $term_slug;
		}

		$term_title_display = '';
		if ( ! empty( $term_title ) ) {
			$term_title_display = ' - ' . __( 'Title', 'lt-ext' ) . ': ' . $term_title;
		}

		$term_id_display = __( 'Id', 'lt-ext' ) . ': ' . $term_id;

		$data = array();
		$data['value'] = $term_id;
		$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

		return ! empty( $data ) ? $data : false;
	}
}

if ( !function_exists('ltxProductOrderByValues')) {

	function ltxProductOrderByValues() {

		$order_by_values = array(
			'',
			__( 'Date', 'lt-ext' ) => 'date',
			__( 'ID', 'lt-ext' ) => 'ID',
			__( 'Author', 'lt-ext' ) => 'author',
			__( 'Title', 'lt-ext' ) => 'title',
			__( 'Modified', 'lt-ext' ) => 'modified',
			__( 'Random', 'lt-ext' ) => 'rand',
			__( 'Comment count', 'lt-ext' ) => 'comment_count',
			__( 'Menu order', 'lt-ext' ) => 'menu_order',
			__( 'Menu order & title', 'lt-ext' ) => 'menu_order title',
			__( 'Include', 'lt-ext' ) => 'include',
		);

		return $order_by_values;
	}
}

/**
 * Enqueue file with latest version from filemtime
 */
if ( !function_exists('ltx_wp_enqueue')) {

	function ltx_wp_enqueue($type = null, $handle = null, $src = null, $deps = array()) {

		if ( empty($type) OR empty($handle) OR empty($src) ) {

			return false;
		}

		if ( $type == 'script' ) {

			wp_enqueue_script( $handle, ltxGetPluginUrl($src), $deps, filemtime(ltxGetLocalPath('/'.$src)), true );

		}
			else
		if ( $type == 'style' ) {

			wp_enqueue_style( $handle, ltxGetPluginUrl($src), $deps, filemtime(ltxGetLocalPath('/'.$src)) );
		}
	}
}

/**
 * Checking active status of plugin
 */
if ( !function_exists( 'ltx_plugin_is_active' ) ) {
	
	function ltx_plugin_is_active( $plugin_var, $plugin_dir = null ) {

		if ( empty( $plugin_dir ) ) {

			$plugin_dir = $plugin_var;
		}

		return in_array( $plugin_dir . '/' . $plugin_var . '.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}
}


/**
 * Decodes multistring array
 */
if (!function_exists('ltx_html_decode')) {
	
	function ltx_html_decode($string) {
		if ( is_array($string) && count($string) > 0 ) {
			foreach ($string as $key => &$value) {
				if (is_string($value)) {

					$value = htmlspecialchars_decode($value, ENT_QUOTES);
				}
			}
		}
		return $string;
	}
}

add_filter( 'big_image_size_threshold', '__return_false' );

