<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * ES Shortcode
 */

$class = "";
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( $atts['height_xl'] !== '' ) $height_xl = ltx_vc_get_metric($atts['height_xl']); else $height_xl = 0;
if ( $atts['height_lg'] === '' ) $height_lg = $height_xl; else $height_lg = ltx_vc_get_metric($atts['height_lg']);
if ( $atts['height_md'] === '' ) $height_md = $height_lg; else $height_md = ltx_vc_get_metric($atts['height_md']);
if ( $atts['height_sm'] === '' ) $height_sm = $height_md; else $height_sm = ltx_vc_get_metric($atts['height_sm']);
if ( $atts['height_ms'] === '' ) $height_ms = $height_sm; else $height_ms = ltx_vc_get_metric($atts['height_ms']);
if ( $atts['height_xs'] === '' ) $height_xs = $height_ms; else $height_xs = ltx_vc_get_metric($atts['height_xs']);


echo '<div class="es-resp'.esc_attr($class).'"'.$id.'>';
if ( !empty($height_xl) ) echo '	<div class="visible-xl" style="height: '.esc_attr($height_xl).';"></div>';
if ( !empty($height_lg) ) echo '	<div class="hidden-xl hidden-md hidden-sm hidden-ms hidden-xs" style="height: '.esc_attr($height_lg).';"></div>';
if ( !empty($height_md) ) echo '	<div class="visible-md" style="height: '.esc_attr($height_md).';"></div>';
if ( !empty($height_sm) ) echo '	<div class="visible-sm " style="height: '.esc_attr($height_sm).';"></div>';
if ( !empty($height_ms) ) echo '	<div class="visible-ms" style="height: '.esc_attr($height_ms).';"></div>';
if ( !empty($height_xs) ) echo '	<div class="visible-xs" style="height: '.esc_attr($height_xs).';"></div>';

echo '</div>';'.esc_attr($height_lg).';

