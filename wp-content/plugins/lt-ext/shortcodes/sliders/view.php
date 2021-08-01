<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Sliders Shortcode
 */

$args = get_query_var('like_sc_sliders');

$id = $class = '';
$class = 'slider-sc-wrapper';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$query_args = array(
	'post_type' => 'sliders',
	'post_status' => 'publish',
	'posts_per_page' => 20,	
);

if ( !empty($args['category_filter']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'sliders-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['category_filter'])),
		)
    );
}

$query = new WP_Query( $query_args );
if ( $query->have_posts() ) {

//	$atts['swiper_center_slide'] = true;
//	$atts['space_between'] = 200;

	$atts['swiper_pagination'] = 'custom';

	$pagination = array();
	while ( $query->have_posts() ) {

		$query->the_post();		

		$image = fw_get_db_post_option(get_The_ID(), 'image');
		$header = fw_get_db_post_option(get_The_ID(), 'header');

		$pagination[] = array(

			'image'		=>	esc_url($image['url']),
			'header'	=>	esc_html($header),
		);
	}

	$swiper_item_class = 'swiper-slide';
	echo ltx_vc_swiper_get_the_container('ltx-tariff-sc', $atts, $class, $id);

	echo '<div class="swiper-pagination-custom"></div>';
	
	echo '<div class="swiper-wrapper" data-pagination=\''. filter_var( json_encode($pagination), FILTER_SANITIZE_SPECIAL_CHARS ) .'\'>';

	while ( $query->have_posts() ) {

		$query->the_post();		

		echo '<div class="swiper-slide">';

			$custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
			//echo '<style>'.$custom_css.'</style>';

			echo do_shortcode(get_the_content());

		echo '</div>';
	}

	echo '</div>';
	
	echo '</div>
	</div>';



	wp_reset_postdata();
}


