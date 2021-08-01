<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Contact_Form_7 Shortcode
 */

$args = get_query_var('like_sc_contact_form_7');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['form_inline']) AND $args['form_inline'] == 'inline'  ) $class .= ' form-input-group ';

$img = '';
if ( !empty($args['image']) ) {

	$img = wp_get_attachment_image_src( $args['image'], 'full' );
	$img = ' style="background-image: url('.esc_url($img[0]).');" ';
}

echo '<div class="ltx-contact-form-7 transform-'.esc_attr($args['transform']).' form-'.esc_attr($args['form_align']).' form-'.esc_attr($args['form_bg']).' form-bg-'.esc_attr($args['form_bg']).' form-style-'.esc_attr($args['form_style']).' form-btn-'.esc_attr($args['shadow']).' form-btn-'.esc_attr($args['wide']).' form-padding-'.esc_attr($args['form_padding']).' '. esc_attr( $class ) .'"  '.$img.' '. $id . '>';
	
	if ( !empty($args['title']) ) {

		echo '<h5 class="ltx-header">'.wp_kses_post(ltx_header_parse($args['title'])).'</h5>';
	}

	echo do_shortcode('[contact-form-7 id="'.esc_attr($args['form_id']).'"]');
	
echo '</div>';


