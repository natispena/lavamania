<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Album`s
*/ 
	
$labels = array(
	'name'               => esc_html__( 'Albums', 'lt-ext' ),
	'singular_name'      => esc_html__( 'Album', 'lt-ext' ),
	'menu_name'          => esc_html__( 'Albums', 'lt-ext' ),
	'name_admin_bar'     => esc_html__( 'Album', 'lt-ext' ),
	'add_new'            => esc_html__( 'Add New', 'lt-ext' ),
	'add_new_item'       => esc_html__( 'Add New Album', 'lt-ext' ),
	'new_item'           => esc_html__( 'New Album', 'lt-ext' ),
	'edit_item'          => esc_html__( 'Edit Album', 'lt-ext' ),
	'view_item'          => esc_html__( 'View Album', 'lt-ext' ),
	'all_items'          => esc_html__( 'All Albums', 'lt-ext' ),
	'search_items'       => esc_html__( 'Search Album', 'lt-ext' ),
	'parent_item_colon'  => esc_html__( 'Parent Album:', 'lt-ext' ),
	'not_found'          => esc_html__( 'No items found.', 'lt-ext' ),
	'not_found_in_trash' => esc_html__( 'No items found in Trash.', 'lt-ext' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'menu_icon'			 => 'dashicons-format-audio',	
	'query_var'          => true,
	'rewrite'            => false,
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'menu_position'      => null,
	'supports'           => array( 'title', 'editor', 'thumbnail')
);

register_post_type( 'albums', $args );

$labels = array(
	'name'              => __( 'Categories', 'lt-ext' ),
	'singular_name'     => __( 'Category', 'lt-ext' ),
	'search_items'      => __( 'Search Categories', 'lt-ext' ),
	'all_items'         => __( 'All Categories', 'lt-ext' ),
	'parent_item'       => __( 'Parent Category', 'lt-ext' ),
	'parent_item_colon' => __( 'Parent Category', 'lt-ext' ) . ':',
	'edit_item'         => __( 'Edit Category', 'lt-ext' ),
	'update_item'       => __( 'Update Category', 'lt-ext' ),
	'add_new_item'      => __( 'Add New Category', 'lt-ext' ),
	'new_item_name'     => __( 'New Category Name', 'lt-ext' ),
	'menu_name'         => __( 'Category', 'lt-ext' ),
);

$args = array(
	'hierarchical'      => true,
	'labels'            => $labels,
	'show_ui'           => true,
	'show_admin_column' => true,
	//'rewrite'           => array( 'slug' => 'Category' ),
);

register_taxonomy( 'album-category', array( 'albums' ), $args );