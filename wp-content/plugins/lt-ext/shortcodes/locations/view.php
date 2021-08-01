<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Locations Shortcode
 */

$args = get_query_var('like_sc_locations');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

echo '<div class="ltx-locations '.esc_attr($class).'"'.$id.'>';

	if ( !empty($args['slider']) AND $args['slider'] == 'default' ) {

		$args['cols'] = 3;
	
		echo '<div class="swiper-container ltx-locations-slider" data-cols="'.esc_attr($args['per_row']).'" data-per-col="'.esc_attr($args['per_col']).'" data-autoplay="0">
			<div class="swiper-wrapper">';
	}
		else {

		echo '<div class="row centered">';
	}
		$div_class = '';

		if ( sizeof($atts['list']) == 6 ) $div_class = ' col-md-2 ';
			else
		if ( sizeof($atts['list']) == 5 ) $div_class = ' col-lg-5ths ';
			else				
		if ( sizeof($atts['list']) == 4 ) $div_class = ' col-md-3 ';
			else
		if ( sizeof($atts['list']) == 3 ) $div_class = ' col-md-4 ';

		foreach ( $atts['list'] as $k => $item ) {

			if ( empty( $item['header'] ) ) $item['header'] = '.';

			echo '
				<div class="'.esc_attr($div_class).' col-sm-4 col-ms-6 col-xs-6 locations-wrap swiper-slide  center-flex" data-mh="ltx-locations">
					<div class="locations-item item center-flex">';

						if ( empty( $item['header']) ) {

							$item['header'] = '';
						}

						$image = ltx_get_attachment_img_url( $item['image'], 'aqualine-locations' );
						if ( !empty($item['href']) ) {

							echo '<a href="'.esc_url( $item['href'] ).'">
								<span class="photo"><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($item['header']).'"></span>';

								echo '<h5>'.esc_html($item['header']).'</h5>';
								if (!empty($item['descr'])) {

									echo '<span class="descr">'.esc_html($item['descr']).'</span>';
								}								
							echo '</a>';
						}
							else {

							echo '<div class="photo">
								<span class="photo"><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($item['header']).'"></span>';
							
							echo '<h5>'.esc_html($item['header']).'</h5>';
							if (!empty($item['descr'])) {

								echo '<span class="descr">'.esc_html($item['descr']).'</span>';
							}

							echo '</div>';
						}

					echo '</div>
				</div>';
		}

		if ( !empty($args['slider']) AND $args['slider'] == 'default' ) {
		
			echo 
			'</div>
			<div class="arrows">
				<a href="#" class="arrow-left"></a>
				<a href="#" class="arrow-right"></a>
			</div>';
			echo '</div>';
		}
			else {

			echo '</div>';
		}

echo '</div>';

