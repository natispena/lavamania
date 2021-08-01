<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Clients Shortcode
 */

$args = get_query_var('like_sc_clients');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= ' layout-'.esc_attr($args['type']);
$class .= ' ltx-logos-'.sizeof($atts['list']);

echo '<div class="ltx-clients '.esc_attr($class).'"'.$id.'>
	<div class="swiper-container">';
		echo '<div class="swiper-wrapper">';

			foreach ( $atts['list'] as $k => $item ) {

				if ( empty( $item['header'] ) ) $item['header'] = '';

				echo '
					<div class="swiper-slide">';

							$image = ltx_get_attachment_img_url( $item['image'], 'aqualine-client' );
							if ( !empty($item['href']) ) {

								echo '<a href="'.esc_url( $item['href'] ).'" class="photo"><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($item['header']).'">';

									if ( !empty($item['header']) ){

										echo '<h5 class="header">' . esc_html($item['header']). '</h5>';
									}

								echo '</a>';
							}
								else {

								echo '<div class="photo">
									<span><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($item['header']).'"></span>';

									if ( !empty($item['header']) ){

										echo '<h5 class="header">' . esc_html($item['header']). '</h5>';
									}

								echo '</div>';
							}

						echo '
					</div>';
			}
		echo '</div>';
	echo '</div>';

	echo '<div class="arrows">
			<a href="#" class="arrow-left fa fa-chevron-left"></a>
			<a href="#" class="arrow-right fa fa-chevron-right"></a>
		</div>';

echo '</div>';


