<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Services Shortcode
 */

$args = get_query_var('like_sc_services');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= ' layout-'.$args['layout'];

$query_args = array(
	'post_type' => 'services',
	'post_status' => 'publish',
	'posts_per_page' => (int)($args['limit']),
);



if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'services-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['cat'])),
		)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$swiper_item_class = '';
	if ( !empty($args['swiper']) OR $args['layout'] == 'slider' ) {

		$atts['swiper_pagination'] = 'fraction';
		$swiper_item_class = 'swiper-slide';
		echo ltx_vc_swiper_get_the_container('ltx-services-sc', $atts, $class, $id);
		echo '<div class="swiper-wrapper">';
	}
		else {

		echo '<div class="ltx-ltx-services-sc-wrapper ltx-services-sc '.esc_attr($class).'" '.$id.'><div class=" row centered">';
		$swiper_item_class = ' col-lg-4 col-md-6 ';
	}	

	while ( $query->have_posts() ) {

		$query->the_post();

		$subheader = fw_get_db_post_option(get_The_ID(), 'header');
		$price = fw_get_db_post_option(get_The_ID(), 'price');
		$cut = fw_get_db_post_option(get_The_ID(), 'cut');
		$image = fw_get_db_post_option(get_The_ID(), 'image');
		$header = get_the_title();
		$link = fw_get_db_post_option(get_The_ID(), 'link');
		$link_more = fw_get_db_post_option(get_The_ID(), 'link_more');
		$link_header = fw_get_db_post_option(get_The_ID(), 'link_header');
		$more_header = fw_get_db_post_option(get_The_ID(), 'more_header');

		if ( empty($link) ) {

			$link = get_the_permalink();
		}		

		if ( $args['layout'] == 'slider' ) {

			echo '<div class="swiper-slide">';
				echo '<div class="container">';

					$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

					echo '<div class="row">';

						echo '<div class="col-lg-8 div-image" style="background-image: url('.esc_url($image[0]).')">';
//							if ( !empty($image) ) echo '<img src="' . $image[0] . '" class="slider-image" alt="'. esc_attr(get_the_title()) .'">';
						echo '</div>';
						echo '<div class="col-lg-4 div-content">';
							echo do_shortcode(get_the_content());
						echo '</div>';

					echo '</div>';		

				echo '</div>';
			echo '</div>';			
		}

		if ( $args['layout'] == 'photos' ):

			?>
			<div class="ltx-item <?php echo esc_attr($swiper_item_class); ?>">
				<div class="ltx-item-inner">
					<a href="<?php echo esc_url( $link ); ?>" class="ltx-image">
						<?php the_post_thumbnail('aqualine-blog'); ?>
						<span class="ltx-photo-overlay"></span>
					</a>
				    <div class="description">
				        <a href="<?php echo esc_url( $link ); ?>" class="header">
				        	<h5 class="header"><?php echo wp_kses_post($header); ?></h5>
				        </a>
			        	<p>
			        		<?php echo wp_kses_post(nl2br(ltx_header_parse($cut))); ?>
			        	</p>
			        	<a href="<?php echo esc_url( $link ); ?>" class="ltx-more"></a>
				    </div>
				</div>
			</div>
			<?php

		endif;		

	}

	if ( !empty($args['swiper']) OR $args['layout'] == 'slider' ) {

		echo '</div>';	
		echo '<div class="swiper-pagination"></div>';
	}
		

	echo '</div></div>';


	wp_reset_postdata();
}

