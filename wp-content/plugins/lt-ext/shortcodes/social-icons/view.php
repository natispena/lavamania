<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Social Icons Shortcode
 */

$args = get_query_var('like_sc_social_icons');

$class = '';
if ( $atts['type'] == 'icons-list' ) $class = 'ltx-social-icons-list';
if ( $atts['type'] == 'icons-inline-xlarge' ) $class = 'ltx-social-xl';
if ( $atts['type'] == 'icons-inline-large' ) $class = 'ltx-social-big';
if ( $atts['type'] == 'icons-inline-small' ) $class = 'ltx-social-small';

$class_el = '';
if ( !empty($atts['class']) ) $class .= ' '. esc_attr($atts['class']);
if ( !empty($atts['id']) ) $id = ' id="'. esc_attr($atts['id']). '"'; else $id = '';

if ( !empty($atts['bg']) ) $class .= ' '.$atts['bg'].' ';

if ($atts['style'] != 'default') $class_el .= 'icon-style-'.$atts['style'];

if ($atts['style'] != 'default') $class .= ' icon-style-'.$atts['style'];
if ($atts['weight'] != 'default') $class .= ' icon-weight-'.$atts['weight'];
if ($atts['size'] != 'default') $class .= ' icon-size-'.$atts['size'];


echo '<div class="align-'. esc_attr($atts['align']) .' '. esc_attr( $class_el ) .'"><ul class="'. esc_attr($class) .'"'. $id .'>';
	foreach ( $atts['icons'] as $item ) {

		$li_class = ' ';
		if ($item['size'] == 'large') $li_class = 'large';

		if ( $atts['type'] == 'icons-list' ) {

			if ( empty( $item['href'] ) ) {

				echo '<li class="'. esc_attr($li_class) .'"><span class="'. esc_attr( $item['icon_fontawesome'] ) .'"></span><span class="head">'. wp_kses_post( str_replace( array('{{', '}}'), array('<strong>', '</strong>'), $item['header'] ) ) .'</span></li>';
			}
				else {

				echo '<li class="'. esc_attr($li_class) .'"><a href="'. esc_url( $item['href'] ) .'"><span class="'. esc_attr( $item['icon_fontawesome'] ) .'"></span><span class="head">'. wp_kses_post( str_replace( array('{{', '}}'), array('<strong>', '</strong>'), $item['header'] ) ) .'</span></a></li>';
			}
		}
			else {

			if (empty($item['href'])) $item['href'] = '#';

			echo '<li><a href="'. esc_url( $item['href'] ) .'" class="ltx-social-color '. esc_attr( $item['icon_fontawesome'] ) .'"></a></li>';
		}	
	}
echo '</ul></div>';

