<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Sliders Shortcode
 */

$args = get_query_var('like_sc_media_element');

if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( $atts['autoplay'] == 'on') $autoplay = 1; else $autoplay = 0;

$number_escaped = '';
if ( !empty($atts['number']) ) {

	$number_escaped = '<span>'.esc_html($atts['number']).'</span>';	
} 

if ( $atts['layout'] == 'track') {

	echo '<div '. $id .' class="ltx-media-element">
		<div class="row">
			<div class="col-sm-6">
				<div class="meta">
					<h6 class="header">'.$number_escaped.esc_html($atts['title']).'</h6>
					<span class="author">'.esc_html($atts['author']).'</span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="media-content">
					'. do_shortcode('[audio src="'.esc_url(wp_get_attachment_url($atts['file'])).'" autoplay="'.esc_attr($autoplay).'"]').'
				</div>
			</div>
		</div>		
		
	</div>';
}
	else 
if ( $atts['layout'] == 'title') {

	echo '<div '. $id .' class="ltx-media-element ltx-layout-'.esc_attr($atts['layout']).'">
		<div class="row">
			<div class="col-sm-6">
				<div class="meta">
					<h6 class="header">'.$number_escaped.esc_html($atts['title']).'</h6>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="media-content">
					'. do_shortcode('[audio src="'.esc_url(wp_get_attachment_url($atts['file'])).'" autoplay="'.esc_attr($autoplay).'"]').'
				</div>
			</div>
		</div>		
		
	</div>';
}

