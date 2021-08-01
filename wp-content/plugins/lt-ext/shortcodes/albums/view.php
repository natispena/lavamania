<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Sliders Shortcode
 */

$args = get_query_var('like_sc_sliders');

$id = $class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$query_args = array(
	'post_type' => 'albums',
	'post_status' => 'publish',
	'posts_per_page' => 0,	
);

if ( !empty($args['category_filter']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'albums-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['category_filter'])),
		)
    );
}

$vinyl = ltx_get_attachment_img_url($atts['image_vinyl']);
$shadow = ltx_get_attachment_img_url($atts['image_shadow']);

$query = new WP_Query( $query_args );
if ( $query->have_posts() ) {

	echo '<div class="ltx-album-sc '.esc_attr($class).'" '.$id.'>';
	echo '	<div class="swiper-container ltx-gallery-top">';
	echo '		<div class="swiper-wrapper">';

	while ( $query->have_posts() ) {

		$query->the_post();		

		echo '<div class="swiper-slide">';
			echo '<div class="container">';
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

				echo '<div class="row">';

					echo '<div class="col-lg-6 div-image"><span>';
						if ( !empty($image) ) {

							echo '<img src="' . $image[0] . '" class="slider-image" alt="'. esc_attr(get_the_title()) .'">';
						}

						if ( !empty($vinyl) ) {

							echo '<img src="' . $vinyl[0] . '" class="ltx-vinyl" alt="'. esc_attr(get_the_title()) .'">';
						}

						if ( !empty($shadow) ) {

							echo '<img src="' . $shadow[0] . '" class="ltx-shadow" alt="'. esc_attr(get_the_title()) .'">';
						}

					echo '</span></div>';
					echo '<div class="col-lg-6 div-content">';
						echo do_shortcode(get_the_content());
					echo '</div>';

				echo '</div>';
		
			echo '</div>';
		echo '</div>';

	}

	echo '</div>
	</div>';

	echo '  <div class="swiper-container ltx-gallery-thumbs">
    <div class="swiper-wrapper">';

	while ( $query->have_posts() ) {

		$query->the_post();		

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

      	echo '<div class="swiper-slide">
      		<img src="' . $image[0] . '" class="slider-image" alt="'. esc_attr(get_the_title()) .'">
      	</div>';
    }

	echo '</div></div>';

	echo '</div>';	

}


