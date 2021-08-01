<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Portfolio Shortcode
 */

$args = get_query_var('like_sc_portfolio');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= ' layout-'.$args['layout'];

$query_args = array(
	'post_type' => 'portfolio',
	'post_status' => 'publish',
	'posts_per_page' => (int)($args['limit']),
);

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'portfolio-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['cat'])),
		)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$item_class = '';

	if ( !empty($args['swiper']) AND $args['layout'] != 'filter' ) {

		$atts['swiper_center_slide'] = true;

		$item_class = 'swiper-slide';
		echo ltx_vc_swiper_get_the_container('ltx-portfolio-sc ltx-'.esc_attr($atts['layout']), $atts, $class, $id);
		echo '<div class="swiper-wrapper">';
	}
		else {

		echo '<div class="ltx-portfolio-sc-wrapper'.esc_attr($class).'" '.$id.'>';

			echo '<div class="ltx-portfolio-sc ltx-'.esc_attr($atts['layout']).' ">';

			echo '<div class="row">';

			$item_class = 'ltx-item col-lg-4 col-sm-6 col-xs-12';
	}

		while ( $query->have_posts() ):

			$query->the_post();

			$header = get_the_title();
			$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');

			if ( empty($link) ) {

				$link = get_the_permalink();
			}		

			$image = get_the_post_thumbnail_url();

			if ( $args['layout'] == 'grid' ) {

				echo '<div class="col-xl-4 col-lg-4 col-md-6 col-xs-12" style="background-image: url('.esc_attr($image).')">';

					echo '<div class="ltx-portfolio-wrapper">';

						echo '<div class="ltx-portfolio-inner">';

							echo '<div class="ltx-descr">';

								echo '<h4 class="ltx-header">'.get_the_title().'</h4>';
								the_content();

							echo '</div>';

							echo '<span class="ltx-overlay-top"></span><span class="ltx-overlay-bottom"></span>';

						echo '</div>';
					echo  '</div>';

				echo  '</div>';
			}

			if ( $args['layout'] == 'slider' ) {

				echo '<div class="'.esc_attr($item_class).'">';

					echo '<a href="'.esc_url($link).'" class="ltx-photo"><span class="ltx-photo-overlay"></span>';
						the_post_thumbnail();
					echo '</a>';

					echo '<a href="'.esc_url($link).'"><h4 class="ltx-header">'.get_the_title().'</h4></a>';

					if ( !empty($subheader) ) {

						echo '<h5 class="ltx-subheader">'.esc_html($subheader).'</h4>';
					}

				echo '</div>';
			}

			?>
			<?php

		endwhile;

	echo '</div>
	</div>
	</div>';

	wp_reset_postdata();
}

