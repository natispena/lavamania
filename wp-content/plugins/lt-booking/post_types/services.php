<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Services
*/ 
$labels = array(
	'name'               => esc_html__( 'Services', 'lt-booking' ),
	'singular_name'      => esc_html__( 'Service', 'lt-booking' ),
	'menu_name'          => esc_html__( 'Washing Services', 'lt-booking' ),
	'name_admin_bar'     => esc_html__( 'Service', 'lt-booking' ),
	'add_new'            => esc_html__( 'Add New', 'lt-booking' ),
	'add_new_item'       => esc_html__( 'Add New Service', 'lt-booking' ),
	'new_item'           => esc_html__( 'New Service', 'lt-booking' ),
	'edit_item'          => esc_html__( 'Edit Service', 'lt-booking' ),
	'view_item'          => esc_html__( 'View Service', 'lt-booking' ),
	'all_items'          => esc_html__( 'Services', 'lt-booking' ),
	'search_items'       => esc_html__( 'Search Services', 'lt-booking' ),
	'parent_item_colon'  => esc_html__( 'Parent Service:', 'lt-booking' ),
	'not_found'          => esc_html__( 'No services found.', 'lt-booking' ),
	'not_found_in_trash' => esc_html__( 'No services found in Trash.', 'lt-booking' )
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
	'menu_position'      => 6,
	'supports'           => array( 'title')
);

register_post_type( 'lt-booking-service', $args );

add_filter(
	'fw_post_options:lt-booking-service', function() {

		return array(

			'parent' => array(
				'title'   => '',
				'type'    => 'box',
				'options' => array(
/*					
					'ltb-order' => array(
						"label" => esc_html__("Order", 'lt-booking'),
						"desc"	=>	esc_html__("Enter number for custom ordering. By default publish date is used.", 'lt-booking'),
						"type" => "text"
					),						
*/					
					'price' => array(
						"label" => esc_html__( "Price", 'lt-booking' ),
						"desc"	=>	esc_html__( "Only number", 'lt-booking' ),
						"type" => "text"
					),			
					'time' => array(
						"label" => esc_html__( "Time", 'lt-booking' ),
						"desc"	=>	esc_html__( "Integer number, minutes", 'lt-booking'),
						"type" => "text"
					),		
					'hours_mode' => array(
						"label" => esc_html__("Display Hours ", 'lt-booking'),
						"desc"	=>	esc_html__("Duration displayed in hours", 'lt-booking'),
						"type" => "switch"
					),							
					'text' => array(
						"label" => esc_html__( "Description", 'lt-booking' ),
						"type" => "textarea"
					),	
					'icon'    => array(
						'label' => esc_html__( "Icon", 'lt-booking' ),
						'type'  => 'icon-v2',
					),										
				),
			),
		);
	},
	100
);


