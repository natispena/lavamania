<?php
/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style', 11 );

function enqueue_parent_theme_style() {
	wp_enqueue_style( 'aqualine-parent-style', get_template_directory_uri().'/style.css' );
	
	wp_enqueue_style( 'aqualine-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'aqualine-parent-style' ),
        wp_get_theme()->get('Version')
    );
}

/**
 * Add your custom functions below
 */
