<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode
 */

$args = get_query_var('like_sc_before_after');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

echo '<div class="ltx-before-after'.esc_attr($class).'">';

	$atts['swiper_effect'] = 'fade';
	$atts['simulate_touch'] = 'false';
	$swiper_item_class = 'swiper-slide';
	echo ltx_vc_swiper_get_the_container('ltx-before-after-sc', $atts, $class, $id);
	echo '<div class="swiper-wrapper">';

	foreach ($args['items'] as $key => $item) {

		echo '<div class="swiper-slide">';

			echo '<div class="row">';

				echo '<div class="col-md-4 div-content">';

					if ( !empty($item['header']) ) {

						echo '
						<div class="heading header-subheader align-left subcolor-main has-subheader heading-tag-h4">
							<h6 class="subheader">'.esc_html($item['subheader']).'</h6>
							<h4 class="header">'.esc_html($item['header']).'</h4>
						</div>';
					}

					if ( !empty($item['btn_text']) ) {

						echo '<a href="'.esc_html($item['btn_href']).'" class="btn btn-lg btn-main color-hover-white">
							<span class="ltx-btn-inner">
								'.esc_html($item['btn_text']).'
								<span class="ltx-btn-after"></span>
							</span>
						</a>';
					}

				echo '</div>';
				echo '<div class="col-md-8 div-ba">';

					if ( !empty($args['header-before']) ) {

						echo '<div class="ltx-before-header">'.esc_html($args['header-before']).'</div>';
					}

					echo '<div class="ltx-wrap">';

						echo '<div class="ltx-ba-wrap" data-filter="'.esc_attr($key).'">';

							$image_before = ltx_get_attachment_img_url($item['image-before']);
							$image_after = ltx_get_attachment_img_url($item['image-after']);
							echo '<div class="after item" style="background-image: url(' . esc_attr($image_after[0]) . ')"></div>';
							echo '<div class="before item" style="background-image: url(' . esc_attr($image_before[0]) . ')"></div>';
							echo '<img src="' . $image_before[0] . '" class="ltx-ba-before" alt="After/Before">';
							echo '<div class="handle"></div>';

						echo '</div>';

					echo '</div>';

					if ( !empty($args['header-after']) ) {

						echo '<div class="ltx-after-header">'.esc_html($args['header-after']).'</div>';
					}

				echo '</div>';
			echo '</div>';

		echo '</div>';
	}
	echo '</div>';	

	echo '</div>
	</div>';

echo '</div>';

