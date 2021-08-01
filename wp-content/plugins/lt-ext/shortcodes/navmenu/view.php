<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Navbar Menu Shortcode
 */

$args = get_query_var('like_sc_navmenu');

$nav_menu = ! empty( $args['menu'] ) ? wp_get_nav_menu_object( $args['menu'] ) : false;

if ( ! $nav_menu ) {
	return;
}

$nav_menu_args = array(
	'fallback_cb'	=> '',
	'depth'			=> (int)$args['depth'],
	'menu'       	=> $nav_menu
);

if ( $args['visibilty'] == 'desktop' ) $class = ' hidden-sm hidden-ms hidden-xs hidden-md'; else $class = '';

echo '<div class="ltx-navmenu-sc '.esc_attr($class).'">';
	wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu ) );
echo '</div>';


