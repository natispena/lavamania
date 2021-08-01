<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Events Shortcode
 */

$args = get_query_var('like_sc_events_calendar');

$query_args = array(
	'post_type' => 'tribe_events',
	'post_status' => 'publish',
	'posts_per_page' => (int)($atts['limit']),
);

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'tribe_events_cat',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['cat'])),
			)
    );
}

$class = 'ltx-scroll';

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$cols = 1;

	echo '<div class="events-sc '.esc_attr($class).'" '.$id.'>';

	while ( $query->have_posts() ) {

		$query->the_post();
		$subheader = str_replace(array('{{', '}}'), array('<strong>', '</strong>'), fw_get_db_post_option(get_The_ID(), 'subheader'));
		$cut = str_replace(array('{{', '}}'), array('<strong>', '</strong>'), nl2br(get_the_excerpt()));


		$item_cats = wp_get_post_terms( get_the_ID(), 'tribe_events_cat' );
		$item_term = '';
		if ( $item_cats && !is_wp_error ( $item_cats ) ) {
			
			foreach ($item_cats as $cat) {

				$item_term = $cat->name;
			}
		}

		$venue = tribe_get_venue();

		$date = array();
		if (function_exists('tribe_get_start_date')) {

			$date['d'] = tribe_get_start_date(get_The_ID(), false, 'd');
			$date['M'] = tribe_get_start_date(get_The_ID(), false, 'M');
			$date['Y'] = tribe_get_start_date(get_The_ID(), false, 'Y');

			$date['time'] = tribe_get_start_date(get_The_ID(), false, 'H:i');
		}

		echo '<div class="item">';
			echo '<div class="row">';		
				echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 div-info">
						<div class="in">';
							echo '<div class="date">';
								echo '<span class="date-day">'.esc_html($date['d']).'</span><span class="date-my">'.esc_html($date['M']).'</span>';
							echo '</div>';

							echo '<div class="ltx-header-wrapper">
								<h5><a href="'.get_the_permalink().'">'. get_the_title() .'</a></h5>';

							if ( !empty( $venue) ) {

								echo '<h6><span class="fa fa-map-marker"></span>'.esc_html($venue).'</h6>';
							}


							echo '</div>
						</div>
					</div>';				
				echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 div-more">
						<div class="in">';

							if ( !empty($subheader) ) {

								echo '<span class="ltx-price">'.esc_html($subheader).'</span>';
							}

							echo '<a href="'.get_the_permalink().'" class="btn color-hover-white">'.esc_html($atts['btn_text']).'</a>
						</div>
					</div>';
			echo '</div>';
		echo '</div>';
	}

	echo '</div>';

	wp_reset_postdata();
}

