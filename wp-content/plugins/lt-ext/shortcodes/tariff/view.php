<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Tariff Shortcode
 */

$args = get_query_var('like_sc_tariff');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['layout']) ) $class .= ' layout-'.$args['layout'];
if ( $args['layout'] == 'default' ) $class .= ' ';
if ( !empty($args['vip']) ) $class .= ' vip';

if ( !empty($args['icon_text']) ) {

	$class .= ' hasIconText';
}

$bg_image_style = '';
if ( !empty($args['bg_image']) ) {

	$image = ltx_get_attachment_img_url( $args['bg_image'] );
	$bg_image_style = ' style="background-image: url('.$image[0].');"';
}

echo '<div class="tariff-item item '.esc_attr($class).'" '.$id.''.$bg_image_style.'>';

	echo '<div class="ltx-header-wrapper">';

		$btn_color = ' btn-main color-hover-black';
		if ( !empty($args['vip']) ) {

			echo '<span class="label-vip">'. esc_html($args['vip_text']) .'<span class="ltx-triangle"></span></span>';
			$btn_color = ' btn-main color-hover-white';
		}

		if ( !empty($args['icon_text']) ) {
	 
			echo '<span class="icon-text countUp-item" style="'.$icon_image_style.'">'. wp_kses_post(str_replace('<span>', '<span class="countUp" id="'.esc_attr( $args['id'].'-count' ).'">', $args['icon_text']))	 .'</span>';
		}

		if ( !empty($args['subheader']) ) {

			echo '<h6 class="subheader">'. wp_kses_post(ltx_header_parse($args['subheader'])) .'</h6>';
		}

		if ( !empty($args['header']) ) {

			echo '<h5 class="header">'. wp_kses_post($args['header']) .'</h5>';
		}

		if ( !empty($args['price']) ) echo '<div class="price">' . wp_kses_post($args['price']) . '</div>';

	echo '</div>';	

	if ( !empty($args['icon']) ) {

		echo '<div class="image"><span class="heading-icon-fa '.esc_attr($args['icon']).' "></span></div>';
	}
		else
	if ( !empty($args['image'])) {

		$image = ltx_get_attachment_img_url( $args['image'] );
		if ( !empty($image[0])) {
		
			echo '<div class="image"><img src="' . $image[0] . '" class="full-width" alt="'. esc_attr($args['header']) .'"></div>';
		}
	}

	if ( !empty($args['descr']) ) echo '<div class="descr">'.wp_kses_post($args['descr']).'</div>';

	$limit = 0;
	$limit_class = '';
	if ( !empty($args['limit_list']) ) {

		$limit = $args['limit_list'];
		$limit_class = ' ltx-limit';
	}

	if ( !empty($args['text']) ) echo '<ul class="ltx-tariff-list'.esc_attr($limit_class).'" data-limit="'.esc_attr($args['limit_list']).'"><li>'. implode('</li><li>', explode(',', wp_kses_post($args['text']))) .'</li></ul>';

	if ( !empty($args['limit_list']) ) {

		echo '<div class="ltx-tariff-spoiler"><span>'.esc_html($args['spoiler_text']).'</span></div>';
		echo '<div class="ltx-tariff-spoiler-less"><span>'.esc_html($args['spoiler_less']).'</span></div>';
	}

	if ( !empty($args['icons']) ) {

		echo '<ul class="ltx-tariff-icons">';

			foreach ( $args['icons'] as $icon ) {

				if ( !empty($icon['icon']) ) {

					echo '<li><span class="ltx-icon '.esc_attr($icon['icon']).'"></span>'.esc_html($icon['header']).'</li>';
				}
			}

		echo '</ul>';
	}

	
	if ( !empty($args['btn_header']) ) {

		echo '<div>
			<a href="'.esc_url($args['btn_href']).'" class="btn btn-lg '.esc_attr($btn_color).'">
				<span class="ltx-btn-inner">'. esc_html($args['btn_header']) .'
					<span class="ltx-btn-after"></span>
				</span>
				</a>
		</div>';
	}

echo '</div>';


