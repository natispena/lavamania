<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * ES Shortcode
 */

$class = "";
if ( !empty($atts['class']) ) $class .= ' '. esc_attr($atts['class']);
if ( !empty($atts['id']) ) $id = ' id="'. esc_attr($atts['id']). '"'; else $id = '';

$class .= " ltx-col-align-" . esc_attr($atts['align']);
$class .= " ltx-block-align-" . esc_attr($atts['block-align']);

$style = "";
if ( !empty($atts['max_width']) ) $style = ' style="max-width: '.esc_attr(ltx_vc_get_metric($atts['max_width'])).'"';

echo '<div class="ltx-content-width'.esc_attr($class).'"'.$id.$style.'>';
	echo '<div class="ltx-wrapper">'.do_shortcode( $content ).'</div>';
echo '</div>';


