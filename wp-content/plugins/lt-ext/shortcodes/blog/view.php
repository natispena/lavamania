<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Testimonials Shortcode
 */

$args = get_query_var('like_sc_blog');

$query_args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => $args['limit'],
);

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) $query_args['category__and'] = esc_attr($args['cat']);


if ( !empty($args['orderby']) ) {

	$query_args['orderby'] = $args['orderby'];
}		

if ( !empty($args['orderway']) ) {

	$query_args['order'] = $args['orderway'];
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	set_query_var( 'ltx_display_excerpt', false );
	if ( $args['excerpt_display'] == 'visible' ) {

		set_query_var( 'ltx_display_excerpt', true );
	}	

	set_query_var( 'ltx_sc_excerpt_size', false );
	if ( !empty( $args['excerpt'] ) ) {

		set_query_var( 'ltx_sc_excerpt_size', $args['excerpt'] );
	}	

	$cols = '';
	if ( $args['columns'] == 1) {

		$cols = 'col-xs-12';
	}
		else
	if ( $args['columns'] == 2) {

		$cols = 'col-lg-6 col-md-12 col-sm-12 col-ms-12 col-xs-12';
	}
		else
	if ( $args['columns'] == 3) {

		$cols = 'col-lg-4 col-md-4 col-sm-6 col-ms-12 col-xs-12';
	}
		else
	if ( $args['columns'] == 4) {

		$cols = 'col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12';
	}


	$class = array();
	$class[] = 'layout-'.$atts['layout'];
	$class[] = 'size-'.$atts['size'];
	$class[] = 'layout-cols-'.$args['columns'];

	echo '<div class="blog blog-sc row centered '.esc_attr(implode(' ', $class)).'">';

	$x = 0;
	while ( $query->have_posts() ) {

		$query->the_post();	
		$x++;

		if ( $args['layout'] == 'featured' ) {

			$class = '';
			if ( $x == 1 ) {

				echo '<div class="ltx-featured-large col-lg-6 col-md-12 col-sm-12 col-ms-12 col-xs-12">';
					echo get_template_part( 'tmpl/post-formats/list-featured' );
				echo '</div>';
			}
				else {

				echo '<div class="ltx-featured-small  col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12">';
					echo get_template_part( 'tmpl/post-formats/list-featured' );
				echo '</div>';
			}
		}
			else
		if ( $args['layout'] == 'list' ) {

			echo '<div class="'.esc_attr($cols).'">';
				echo get_template_part( 'tmpl/post-formats/list-left' );
			echo '</div>';				
		}		
			else				
		if ( $args['layout'] == 'simple' ) {

			echo '<div class="'.esc_attr($cols).'">';
				echo get_template_part( 'tmpl/post-formats/list-simple' );
			echo '</div>';				
		}		
			else
		if ( $args['layout'] == 'short' ) {

			echo '<div class="'.esc_attr($cols).'">';
				echo get_template_part( 'tmpl/post-formats/list-short' );
			echo '</div>';				
		}
			else {

				echo '<div class="items '.esc_attr($cols).'">';
					echo get_template_part( 'tmpl/post-formats/list' );
				echo '</div>';
		}

	}

	echo '</div>';
	echo '<div class="clear"></div>';

	wp_reset_postdata();
	set_query_var( 'ltx_display_excerpt', false );
	set_query_var( 'ltx_sc_excerpt_size', false );
}

