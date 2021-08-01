<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Button Shortcode
 */

$args = get_query_var('like_sc_button');

$after = $attrAlign = $attr = '';
if ( !empty($args['size']) AND $args['size'] != 'default' ) $attr .= ' btn-'.$args['size'];
if ( !empty($args['color']) AND $args['color'] != 'default' ) $attr .= ' btn-'.$args['color'];

//if ( !empty($args['transform']) ) { $attr .= ' transform-'.$args['transform']; }
if ( !empty($args['color_text']) ) $attr .= ' color-text-'.$args['color_text'];
if ( !empty($args['color_hover']) ) $attr .= ' color-hover-'.$args['color_hover'];

if ( !empty($args['shadow']) AND $args['shadow'] != 'default' ) $attr .= ' btn-'.$args['shadow'];
if ( !empty($args['wide']) AND $args['wide'] != 'default') $attr .= ' btn-'.$args['wide'];

if ( !empty($args['align']) AND $args['align'] != 'default' ) { $attrAlign .= ' align-'.$args['align']; $attr .= ' align-'.$args['align']; }
if ( !empty($args['inline']) AND $args['inline'] != 'default' ) { $attrAlign .= ' btn-wrap-'.$args['inline']; }

if ( !empty($args['class']) ) $attr .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';


//if ( !empty($args['arrow']) AND $arrgs['arrow'] != 'hidden' ) $after = '<span class="fa fa-arrow-right"></span>';

$after = '<span class="ltx-btn-after"></span>';

$target = '';
if ( $args['target'] == 'blank') {

	$target = ' target="_blank" ';
}

if ( !empty($args['icon']) ) {

	$attr .= ' hasIcon';
}

echo '<div class="btn-wrap'. esc_attr( $attrAlign ) .'">
	<a href="'. esc_url($args['href']) .'" '.$target.' class="btn '. esc_attr( $attr ) .'"'.$id.'>';
		echo '<span class="ltx-btn-inner">';
			if ( !empty($args['icon']) ) {

				echo '<span class="l-icon '.esc_attr($args['icon']).'"></span>';
			}
			echo esc_html( $args['header'] );
			echo wp_kses_post($after);
		echo '</span>';
echo '</a></div>';

