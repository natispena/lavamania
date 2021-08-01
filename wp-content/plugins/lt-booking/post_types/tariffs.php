<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Tariffs
*/ 
$labels = array(
	'name'               => esc_html__( 'Tariffs', 'lt-booking' ),
	'singular_name'      => esc_html__( 'Tariff', 'lt-booking' ),
	'menu_name'          => esc_html__( 'Washing Tariffs', 'lt-booking' ),
	'name_admin_bar'     => esc_html__( 'Tariff', 'lt-booking' ),
	'add_new'            => esc_html__( 'Add New', 'lt-booking' ),
	'add_new_item'       => esc_html__( 'Add New Tariff', 'lt-booking' ),
	'new_item'           => esc_html__( 'New Tariff', 'lt-booking' ),
	'edit_item'          => esc_html__( 'Edit Tariff', 'lt-booking' ),
	'view_item'          => esc_html__( 'View Tariff', 'lt-booking' ),
	'all_items'          => esc_html__( 'Tariffs', 'lt-booking' ),
	'search_items'       => esc_html__( 'Search Tariffs', 'lt-booking' ),
	'parent_item_colon'  => esc_html__( 'Parent Tariff:', 'lt-booking' ),
	'not_found'          => esc_html__( 'No tariffs found.', 'lt-booking' ),
	'not_found_in_trash' => esc_html__( 'No tariffs found in Trash.', 'lt-booking' )
);

$args = array(
	'labels'             => $labels,
	'public'             => false,
	'publicly_queryable' => false,
	'show_ui'            => true,
	'show_in_menu'       => 'edit.php?post_type=lt-booking',
	'query_var'          => false,
	'rewrite'            => false,
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => 5,
	'supports'           => array( 'title')
);

register_post_type( 'lt-booking-tariff', $args );

$options = add_filter(
	'fw_post_options:lt-booking-tariff', function() {

		return array(

			'parent' => array(
				'title'   => '',
				'type'    => 'box',
				'options' => array(
					'ltb-order' => array(
						"label" => esc_html__("Order", 'lt-booking'),
						"desc"	=>	esc_html__("Enter number for custom ordering. By default publish date is used.", 'lt-booking'),
						"type" => "text"
					),						
					'admin-header' => array(
						"label" => esc_html__("Admin Header", 'lt-booking'),
						"desc"	=>	esc_html__("Visible only in admin zone, can be a helper in selecting equal plans", 'lt-booking'),
						"type" => "text"
					),						
					'price' => array(
						"label" => esc_html__("Price", 'lt-booking'),
						"desc"	=>	esc_html__("Only number", 'lt-booking'),
						"type" => "text"
					),			
					'time' => array(
						"label" => esc_html__("Time", 'lt-booking'),
						"desc"	=>	esc_html__("Integer number, minutes", 'lt-booking'),
						"type" => "text"
					),		
					'hours_mode' => array(
						"label" => esc_html__("Display Hours ", 'lt-booking'),
						"desc"	=>	esc_html__("Duration displayed in hours", 'lt-booking'),
						"type" => "switch"
					),								
					'text' => array(
						"label" => esc_html__("Options", 'lt-booking'),
						"desc"	=>	esc_html__("To set yes prefix use {+}, to set no prefix use {-}", 'lt-booking'),				
						"type" => "textarea"
					),	
					'vip' => array(
						"label" => esc_html__("Vip", 'lt-booking'),
						"desc"	=>	esc_html__("Will be marked", 'lt-booking'),
						"type" => "checkbox"
					),		
					'vip-bg' => array(
						'label' => esc_html__('Vip Background', 'lt-booking'),
						'type' => 'upload'
					),											
				),
			),
		);
	},
	100
);

if ( !function_exists('ltb_tariffs_custom_columns') ) {

	function ltb_tariffs_custom_columns($columns) {

	    $columns['admin-header'] = esc_html__( 'Admin Header', 'lt-booking' );
//	    $columns['ltb-order'] = esc_html__( 'Order', 'lt-booking' );

	    return $columns;
	}
}
add_filter( 'manage_lt-booking-tariff_posts_columns', 'ltb_tariffs_custom_columns' );


if ( !function_exists('ltb_tariffs_custom_column_data') ) {

	function ltb_tariffs_custom_column_data( $column, $post_id ) {

		$item = fw_get_db_post_option( $post_id );

	    switch ( $column ) {

	        case 'admin-header' :

	            if ( !empty($item['admin-header']) ) {

	            	echo esc_html($item['admin-header']); 
	            }
	        break;	       
	        case 'ltb-order' :

	            if ( !empty($item['ltb-order']) ) {

	            	echo esc_html($item['ltb-order']); 
	            }
	        break;		           

	    }
	}
}
add_action( 'manage_lt-booking-tariff_posts_custom_column' , 'ltb_tariffs_custom_column_data', 10, 2 );
