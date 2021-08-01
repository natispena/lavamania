<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Alert Shortcode
 */

$args = get_query_var('like_sc_alert');

echo '<div class="ltx-alert  ltx-alert-'.esc_attr($args['type']).'">';

	echo '<a href="#" class="fa fa-times close"></a>';

	$icon = '';
	if (!empty($args['icon_fontawesome'])) {

		$icon = '<span class="'. esc_attr( $args['icon_fontawesome'] ) .'"></span>';
	}

	if ( !empty($args['header']) ) echo '<div class="header">' . $icon . esc_html($args['header']) .'</span></div>';
	if ( !empty($args['text']) ) echo '<p>'. wp_kses_post($args['text']) .'</p>';
	
echo '</div>';


