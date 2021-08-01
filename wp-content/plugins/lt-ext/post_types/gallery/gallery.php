<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Gallery
*/ 
$labels = array(
	'name'               => esc_html__( 'Gallery', 'lt-ext' ),
	'singular_name'      => esc_html__( 'Gallery', 'lt-ext' ),
	'menu_name'          => esc_html__( 'Gallery', 'lt-ext' ),
	'name_admin_bar'     => esc_html__( 'Gallery', 'lt-ext' ),
	'add_new'            => esc_html__( 'Add New', 'lt-ext' ),
	'add_new_item'       => esc_html__( 'Add New Gallery', 'lt-ext' ),
	'new_item'           => esc_html__( 'New Gallery', 'lt-ext' ),
	'edit_item'          => esc_html__( 'Edit Gallery', 'lt-ext' ),
	'view_item'          => esc_html__( 'View Gallery', 'lt-ext' ),
	'all_items'          => esc_html__( 'All Galleries', 'lt-ext' ),
	'search_items'       => esc_html__( 'Search Gallery', 'lt-ext' ),
	'parent_item_colon'  => esc_html__( 'Parent Gallery:', 'lt-ext' ),
	'not_found'          => esc_html__( 'No items found.', 'lt-ext' ),
	'not_found_in_trash' => esc_html__( 'No items found in Trash.', 'lt-ext' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'menu_icon'			 => 'dashicons-images-alt',	
	'query_var'          => true,
/*		'rewrite'            => array( 'slug' => 'gallery' ),*/
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'menu_position'      => null,
	'supports'           => array( 'title', 'thumbnail')
);

register_post_type( 'gallery', $args );	



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
	'query_var'         => true,
//		'rewrite'           => array( 'slug' => 'Category' ),
);

register_taxonomy( 'gallery-category', array( 'gallery' ), $args );	

