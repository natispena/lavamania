<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Config
 */

$ltx_cfg = array(

	'path'	=> plugin_dir_path(__DIR__),
	'base' 	=> plugin_basename(__DIR__),
	'url'	=> plugin_dir_url(__FILE__),

	'ltx_sections'	=> array(),
);


add_action( 'after_setup_theme', 'ltx_vc_config', 4 );
if ( !function_exists('ltx_vc_config')) {

	function ltx_vc_config() {

		global $ltx_cfg;

	    $value = array();
	    $value = apply_filters( 'ltx_get_vc_config', $value );

	    $ltx_cfg = array_merge($ltx_cfg, $value);

	    return $value;
	}
}

add_action( 'plugins_loaded', 'ltx_load_plugin_textdomain' );
if ( !function_exists('ltx_load_plugin_textdomain')) {
	function ltx_load_plugin_textdomain() {

		apply_filters ('ltx_filter_custom_css', array());

		load_plugin_textdomain( 'lt-ext', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}
}



add_action( 'widgets_init', 'ltx_action_widgets_init' );
if ( !function_exists('ltx_action_widgets_init')) {

	function ltx_action_widgets_init() {

		$paths = array();

		/**
		 * Widgets list
		 */
		$parent_widgets = array(
			'icons',
			'blogposts',
			'navmenu',
		);
		$parent_path = LTX_PLUGIN_DIR . 'widgets' ;

		/**
		 * Generating widgets include array
		 */
		$items = array();
		if ( !empty( $parent_widgets ) ) {

			foreach ( $parent_widgets as $item ) {

				$items[] = array( 'path' => $parent_path . '/' . $item , 'name' => $item );
			}
		}

		$included_widgets = array();
		if ( !empty( $items ) ) {

			foreach ( $items as $item ) {

				if ( isset( $included_widgets[ $item['name'] ] ) ) {
					// this happens when a widget in child theme wants to overwrite the widget from parent theme
					continue;
				} else {
					$included_widgets[ $item['name'] ] = true;
				}

				include_once ( $item['path'] . '/class-widget-' . $item['name'] . '.php' );

				$widget_class = 'ltx_Widget_' . ltx_widget_classname( $item['name'] );
				if ( class_exists( $widget_class ) ) {

					register_widget( $widget_class );
				}
			}
		}
	}

	function ltx_widget_classname( $widget_name ) {
		
		$class_name = explode( '-', $widget_name );
		$class_name = array_map( 'ucfirst', $class_name );
		$class_name = implode( '_', $class_name );

		return $class_name;
	}	
}


$options = add_filter(
	'fw_post_options:sliders', function() {

		return array(

			'main' => array(
				'title'   => 'Additonal',
				'type'    => 'box',
				'options' => array(
					'image'    => array(
						'label' => esc_html__( 'Pagination Image', 'aqualine' ),
						'type'  => 'upload',
					),				
					'header'    => array(
						'label' => esc_html__( 'Pagination Header', 'aqualine' ),
						'type'  => 'text',
					),				
				),
			),

		);
	},
	100
);
