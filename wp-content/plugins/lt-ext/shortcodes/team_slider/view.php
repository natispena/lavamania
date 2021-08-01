<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Team Shortcode
 */

$args = get_query_var('like_sc_team_slider');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['style']) ) $class .= $args['style'];

$query_args = array(
	'post_type' => 'team',
	'post_status' => 'publish',
	'posts_per_page' => (int)($atts['limit']),
);

if ( $args['type'] == 'slider' )  {

	$query_args['posts_per_page'] = 100;
}

if ( !empty($atts['cat']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'team-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($atts['cat'])),
		)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	if ( $args['type'] == 'slider' )  {

		echo '<div class="swiper-container slider-filter-container team-sc team-list ltx-team-slider '.esc_attr($class).'" data-cols="3" '.$id.'>';

		$cats = ltxGetTeamCats();
		if ( !empty($atts['category_filter']) ) {

			$cats = $cats[$atts['category_filter']]['child'];
		}

		if ( !empty($cats) AND sizeof($cats) > 1 ) {

			echo '<ul class="cats tabs-cats slider-filter">';
			foreach ($cats as $catId => $cat) {

				echo '<li><span class="cat" data-filter="'.esc_attr($catId).'">'.esc_html($cat['name']).'</span></li>';
			}
			echo '</ul>';
		}		

		echo '<div class="swiper-wrapper">';
	}
		else {

		echo '<div class="team-sc '.esc_attr($class).' row centered" '.$id.'>';
	}

	while ( $query->have_posts() ):

		$query->the_post();

		$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
		$cut = fw_get_db_post_option(get_The_ID(), 'cut');
		$items = fw_get_db_post_option(get_The_ID(), 'items');

		$filter_cat = 'swiper-slide	filter-item filter-type-0';
		$item_cats = wp_get_post_terms( get_the_ID(), 'team-category' );
		$item_term = '';
		if ( $item_cats && !is_wp_error ( $item_cats ) ) {
			
			foreach ($item_cats as $cat) {

				$filter_cat .= ' filter-type-'.$cat->term_id;
				$item_term = $cat->name;
			}
		}

		if ( $args['type'] == 'slider' )  {

			echo '<div class="swiper-slide '.esc_attr($filter_cat).'">';
		}
			else {

			echo '<div class="col-lg-3 col-md-6 col-sm-6	 col-ms-12">';
		}

			echo '<div class="team-item item item-type-'.esc_attr($atts['type']).' ">';

				echo '<a href="'.get_the_permalink().'" class="image">'.wp_get_attachment_image( get_post_thumbnail_id( get_The_ID()) , 'full').'</a>';

				echo '<div class="descr">';

					echo '<a href="'.get_the_permalink().'"><h5 class="header">'. get_the_title() .'</h5></a>';
					if ( !empty($item_term) ) echo '<p class="subheader">'. wp_kses_post($item_term) .'</p>';

				echo '</div>';
			echo '</div>';
		echo '</div>';	
		
?>
<?php
	endwhile;

	if ( $args['type'] == 'slider' )  {

			echo '</div>';
		echo '<div class="arrows">
				<a href="#" class="arrow-left fa fa-chevron-left"></a>
				<a href="#" class="arrow-right fa fa-chevron-right"></a>
			</div>';			
	}

	echo '</div>';

	wp_reset_postdata();
}

