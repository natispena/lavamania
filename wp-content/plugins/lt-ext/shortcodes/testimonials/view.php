<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Testimonials Shortcode
 */

$args = get_query_var('like_sc_testimonials');

$query_args = array(
	'post_type' => 'testimonials',
	'post_status' => 'publish',
	'posts_per_page' => (int)($atts['limit']),
);

$class = 'layout-'.esc_attr($atts['layout']);
if ( !empty($args['background']) ) $class .= ' bg-'.$args['background'];
if ( !empty($args['arrows']) ) $class .= ' arrows-'.$args['arrows'];
if ( !empty($args['font_weight']) ) $class .= ' font-weight-'.$args['font_weight'];

if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$arrow_span_left = $arrow_span_right = '';
if ( !empty($args['arrows']) AND $args['arrows'] == 'text' ) {

	$arrow_span_left = esc_html__('prev', 'lt-ext');
	$arrow_span_right = esc_html__('next', 'lt-ext');
}

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'testimonials-category',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['cat'])),
			)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$swiper_item_class = '';
	if ( !empty($args['swiper']) ) {

		$swiper_item_class = 'swiper-slide';
		echo ltx_vc_swiper_get_the_container('ltx-testimonials-list', $atts, $class, $id);
		echo '<div class="swiper-wrapper">';
	}
		else {

		echo '<div class="ltx-testimonials-list-wrapper '.esc_attr($class).'" '.$id.'><div class="ltx-testimonials-list">';
	}

	set_query_var( 'ltx-testimonials-sc', true );

	while ( $query->have_posts() ) {

		$query->the_post();

		$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
		$rate = fw_get_db_post_option(get_The_ID(), 'rate');

		if ( !empty($atts['cut'])) {

			set_query_var( 'ltx-testimonials-sc-cut', $atts['cut'] );
		}

		echo '<div class="ltx-item '.esc_attr($swiper_item_class).'">';
			get_template_part( 'tmpl/content', 'testimonials' );
		echo '</div>';			
	}

	if ( !empty($args['swiper']) ) {

		echo '</div>';	
	}
		
	echo '</div></div>';

	set_query_var( 'ltx-testimonials-sc', false);
	set_query_var( 'ltx-testimonials-sc-cut', false );

	wp_reset_postdata();
}

