<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Gallery Shortcode
 */

$args = get_query_var('like_sc_gallery');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= ' '.$args['layout'];

if ( $args['layout'] == 'albums' ) {

	$query_args = array(
		'post_type' => 'gallery',
		'post_status' => 'publish',
		'posts_per_page' => 4,
	);

	if ( !empty($args['cat']) ) {

		$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'gallery-category',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['cat'])),
			)
	    );
	}

	$query = new WP_Query( $query_args );
	if ( $query->have_posts() ) {

		echo '<div class="gallery-sc '.esc_attr($class).'" '.$id.'>';
			echo '<div class="row">';

			$reverse = false;
			$key = 0;
			while ( $query->have_posts() ) {

				$query->the_post();		
				$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
				$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'aqualine-gallery-big' );

				$key++;

				$class = 'col-lg-6 col-sm-12';
				if ( $key == 2) {

					$class = 'col-lg-12';
				}

				if ( $key == 2 ) {

					echo '<div class="col-lg-6 col-sm-12"><div class="row">';
				}

				?>
				<div class="<?php echo esc_attr($class); ?> col-img">
					<div class="item" style="background-image: url(<?php echo $image_src[0]; ?>)"></div>
					<a href="<?php echo esc_url( the_permalink() ); ?>" class="photo">
						<span class="descr">
							<span class="subheader"><?php echo $subheader; ?></span>
							<span class="header"><?php echo get_the_title(); ?></span>
						</span>
					</a>
				</div>
				<?php

				if ( $key == 4 ) {

					echo '</div></div>';
				}
			}

			echo '</div>';
		echo '</div>';
	}
}
	else {

	$list = fw_get_db_post_option( $args['album'], 'photos' );

	if ( !empty($list) ) {

		echo '<div class="gallery-sc swiper-gallery swiper-container '.esc_attr($class).'" data-autoplay="'.esc_attr($atts['autoplay']).'" '.$id.'>';
			echo '<div class="swiper-wrapper">';
	?>
		<?php foreach ( $list as $item ) : ?>
		<div class="swiper-slide">
			<a href="<?php echo esc_url( $item['url'] ); ?>" class="swipebox photo ">

				<span>
				<?php

					if ( $args['layout'] == 'grid-big' ) {

						echo wp_get_attachment_image( $item['attachment_id'], 'aqualine-gallery-grid-big' );
					}
						else {

						echo wp_get_attachment_image( $item['attachment_id'], 'aqualine-gallery-grid' );
					}

				?>
				</span>
			</a>
		</div>
		<?php endforeach; ?>

	<?php

		echo '</div>
		</div>';
	}
}

