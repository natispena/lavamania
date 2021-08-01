<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Sections
*/ 
$labels = array(
	'name'               => esc_html__( 'Sections', 'lt-ext' ),
	'singular_name'      => esc_html__( 'Section', 'lt-ext' ),
	'menu_name'          => esc_html__( 'Sections', 'lt-ext' ),
	'name_admin_bar'     => esc_html__( 'Sections', 'lt-ext' ),
	'add_new'            => esc_html__( 'Add New', 'lt-ext' ),
	'add_new_item'       => esc_html__( 'Add New Section', 'lt-ext' ),
	'new_item'           => esc_html__( 'New Section', 'lt-ext' ),
	'edit_item'          => esc_html__( 'Edit Section', 'lt-ext' ),
	'view_item'          => esc_html__( 'View Section', 'lt-ext' ),
	'all_items'          => esc_html__( 'All Sections', 'lt-ext' ),
	'search_items'       => esc_html__( 'Search Section', 'lt-ext' ),
	'parent_item_colon'  => esc_html__( 'Parent Section:', 'lt-ext' ),
	'not_found'          => esc_html__( 'No items found.', 'lt-ext' ),
	'not_found_in_trash' => esc_html__( 'No items found in Trash.', 'lt-ext' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'menu_icon'			 => 'dashicons-tagcloud',	
	'query_var'          => true,
	'rewrite'            => false,
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => 21,
	'supports'			 => array( 'title', 'editor')
);

register_post_type( 'sections', $args );	
