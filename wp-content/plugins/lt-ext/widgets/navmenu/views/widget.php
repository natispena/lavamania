<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * @var string $before_widget
 * @var string $after_widget
 */
echo wp_kses_post( $before_widget );

if ( !empty($params['title']) )  {

	echo wp_kses_post( $before_title ) . esc_html( apply_filters( 'widget_title', $params['title'] ) ) . wp_kses_post( $after_title );
}

$nav_menu = ! empty( $params['menu'] ) ? wp_get_nav_menu_object( $params['menu'] ) : false;

if ( ! $nav_menu ) {
	return;
}

$nav_menu_args = array(
	'fallback_cb'	=> '',
	'depth'			=> 1,
	'menu'       	=> $nav_menu
);

wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu ) );

echo wp_kses_post( $after_widget ) ?>
