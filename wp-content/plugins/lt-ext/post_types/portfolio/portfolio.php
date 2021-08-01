<?php


// Portfolios
$labels = array(
	'name'               => esc_html__( 'Portfolios', 'lt-ext' ),
	'singular_name'      => esc_html__( 'Portfolio', 'lt-ext' ),
	'menu_name'          => esc_html__( 'Portfolios', 'lt-ext' ),
	'name_admin_bar'     => esc_html__( 'Portfolios', 'lt-ext' ),
	'add_new'            => esc_html__( 'Add New', 'lt-ext' ),
	'add_new_item'       => esc_html__( 'Add New Portfolio', 'lt-ext' ),
	'new_item'           => esc_html__( 'New Portfolio', 'lt-ext' ),
	'edit_item'          => esc_html__( 'Edit Portfolio', 'lt-ext' ),
	'view_item'          => esc_html__( 'View Portfolio', 'lt-ext' ),
	'all_items'          => esc_html__( 'All Portfolios', 'lt-ext' ),
	'search_items'       => esc_html__( 'Search Portfolios', 'lt-ext' ),
	'parent_item_colon'  => esc_html__( 'Parent Portfolios:', 'lt-ext' ),
	'not_found'          => esc_html__( 'No items found.', 'lt-ext' ),
	'not_found_in_trash' => esc_html__( 'No items found in Trash.', 'lt-ext' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'menu_icon'			 => 'dashicons-portfolio',	
	'query_var'          => true,
	'rewrite'            => array( 'slug' => 'portfolios' ),
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'menu_position'      => null,
	'show_in_rest' => true,
	'supports'           => array( 'title', 'editor', 'thumbnail', 'comments')
);

register_post_type( 'portfolio', $args );	


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
	'menu_name'         => __( 'Categories', 'lt-ext' ),
);

$args = array(
	'hierarchical'      => true,
	'labels'            => $labels,
	'show_ui'           => true,
	'show_admin_column' => true,	
	'query_var'         => true,
//		'rewrite'           => array( 'slug' => 'Category' ),
);

register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );	

/*
$labels = array(
	'name'              => __( 'Stars', 'lt-ext' ),
	'singular_name'     => __( 'Star', 'lt-ext' ),
	'search_items'      => __( 'Search Stars', 'lt-ext' ),
	'all_items'         => __( 'All Stars', 'lt-ext' ),
	'parent_item'       => __( 'Parent Star', 'lt-ext' ),
	'parent_item_colon' => __( 'Parent Star', 'lt-ext' ) . ':',
	'edit_item'         => __( 'Edit Star', 'lt-ext' ),
	'update_item'       => __( 'Update Star', 'lt-ext' ),
	'add_new_item'      => __( 'Add New Star', 'lt-ext' ),
	'new_item_name'     => __( 'New Star Name', 'lt-ext' ),
	'menu_name'         => __( 'Stars', 'lt-ext' ),
);

$args = array(
	'hierarchical'      => true,
	'labels'            => $labels,
	'Portfolio_ui'           => true,
	'Portfolio_admin_column' => true,
	'query_var'         => true,
	'supports'           => array( 'title',  'thumbnail')	
//		'rewrite'           => array( 'slug' => 'Category' ),
);

register_taxonomy( 'portfolio-stars', array( 'portfolio' ), $args );	

*/
