<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

if ( !function_exists( 'lt_booking_step_01_shortcode' ) ) {

	function lt_booking_step_01_shortcode( $atts ) {

		$out = '';
		$num = '01';
		$id = $atts['id'];

		$config = fw_get_db_post_option( $id );	

		$config['container'] = 'none';

		$out = ltb_section_start( $config, $num );

		if ( !empty($config['cars']) ) {

			$cars = get_posts( array(
				'nopaging'                  => true,
				'post_type' => 'lt-booking-car',
				'post_status' => 'publish',
				'post__in' => $config['cars'],
				'post_per_page' => 100,
			) );

			if ( !empty($cars) ) {

				$atts['swiper_loop'] = true;
				$atts['swiper_autoplay'] = 0;
	
				$atts['swiper_arrows'] = 'custom';
				$atts['swiper_pagination'] = 'custom';

				$car_types = $tariffs = $services = $pagination = array();
				foreach ( $cars as $car ) {

					$item = fw_get_db_post_option( $car->ID );

					$pagination[] = array(

						'image'		=>	'',
						'header'	=>	esc_html($car->post_title),
					);

					$tariffs[] = $item['tariffs'];

					if ( !empty($item['services-box']) AND $item['services-box']['service-type'] == 'choose' )  {

						$services[] = $item['services-box']['choose']['services'];
					}
						else {

						$services[] = null;
					}

					$car_types[] = array(
						'id'		=>	$car->ID,
						'header'	=>	$car->post_title
					);
				}

				// Swiper wrapper start
				ob_start();
				ltx_vc_swiper_get_the_container('ltb-cars', $atts, '', ' id="ltb-cars" ');
				$out .= ob_get_clean();

				$out .= '
				<div class="ltb-cars-arrows ltx-arrows ltx-arrows-sides">
					<a href="#" class="ltx-arrow-left" tabindex="0" role="button"></a>
					<a href="#" class="ltx-arrow-right" tabindex="0" role="button"></a>
				</div>';

				if ( is_array($services) ) {

					$services_attr_escaped = filter_var( json_encode($services), FILTER_SANITIZE_SPECIAL_CHARS );
				}

				$out .= '<div class="swiper-pagination-custom"></div>';
				$out .= '<div class="swiper-wrapper" data-cars="'.filter_var( json_encode($car_types), FILTER_SANITIZE_SPECIAL_CHARS ).'"  data-services="'.$services_attr_escaped.'" data-tariffs="'.filter_var( json_encode($tariffs), FILTER_SANITIZE_SPECIAL_CHARS ).'" data-pagination=\''. filter_var( json_encode($pagination), FILTER_SANITIZE_SPECIAL_CHARS ) .'\'>';

				foreach ( $cars as $car ) {

					$item = fw_get_db_post_option( $car->ID );

					$out .= '<div class="ltb-item ltb-item swiper-slide" data-car-type="'.esc_attr($car->post_title).'">';

						if ( !empty($item['image']) ) {

							$out .= '<img src="'.esc_url($item['image']['url']).'" alt="'.esc_attr($car->post_title).'">';
						}

					$out .= '</div>';
				}

				// Swiper wrapper close
				$out .= '</div>
				</div>
				</div>';
			}

			wp_reset_postdata();
		}

		$out .= ltb_section_end( $config, $num );		

		return $out;
	}
}
add_shortcode( 'lt-booking-step-01', 'lt_booking_step_01_shortcode' );


