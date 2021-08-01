<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * slider_full Shortcode
 */

$args = get_query_var('like_sc_slider_full');

$id = $class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$query_args = array(
	'post_type' => 'slider_full',
	'post_status' => 'publish',
	'posts_per_page' => 0,	
);

if ( !empty($args['category_filter']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'slider_full-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['category_filter'])),
		)
    );
}

//if ( !empty($atts['arrows']) AND $atts['arrows'] == 'enabled' ) $atts['arrows'] = true; else $atts['arrows'] = '';
//if ( !empty($atts['pagination']) AND $atts['pagination'] == 'enabled' ) $atts['pagination'] = true; else $atts['pagination'] = '';

if ( !empty($atts['items']) ) {
/*
	$cols = 4;
	if ( sizeof($atts['items']) == 3 ) $cols = 3;
	if ( sizeof($atts['items']) == 2 ) $cols = 2;
	if ( sizeof($atts['items']) == 1 ) $cols = 1;
*/
	$atts['fc'] = true;
	$atts['space_between'] = "0";

//	echo ltx_vc_swiper_get_the_container('ltx-slider-vert', $atts, $class, $id);

	echo '<div class="ltx-slider-vert">';

		foreach ( $atts['items'] as $item ) {

			$image = wp_get_attachment_image_src( $item['image'], 'full' );

			$item['header'] = str_replace(array('{{', '}}'), array('<span>', '</span>'), $item['header']);

			if ( !empty($image) ) {

				if ( empty($item['href']) ) {

					$item['href'] = '#';
				}

				echo '<div class="ltx-item">';
					echo '<a href="'.esc_url($item['href']).'" class="inner" style="background-image: url('.$image[0].');">';

						if ( !empty($item['price']) ) {

							echo '<div class="ltx-price">'.ltx_header_parse($item['price']).'</div>';
						}

						echo '<div class="info">';
							echo '<div class="info-inner">';
							echo '<h3>'.wp_kses_post($item['header']).'</h3>';
								echo '<h4>'.wp_kses_post($item['header']).'</h4>';
								if ( !empty($item['descr']) ) {
								
									echo '<p>'.wp_kses_post(nl2br($item['descr'])).'</p>';
								}

								echo '<div class="hidden-div">';

									if ( !empty($args['readmore']) ) {

										echo '<span class="btn btn-white color-hover-second">'.esc_html($args['readmore']).'</span>';
									}
								echo '</div>';
							echo '</div>';

						echo '</div>';
					echo '</a>';
				echo '</div>';
			}
		}

	echo '</div>';	
}


