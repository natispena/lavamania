<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Menu Shortcode
 */

$args = get_query_var('like_sc_menu');

$query_args = array(
	'post_type' => 'menu',
	'post_status' => 'publish',
	'posts_per_page' => 300,	
);

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));

$cats = ltxGetMenuCats();
if ( !empty($atts['cat']) ) {
/*
	$sub_cats = get_term_children( $args['cat'], 'menu-category' );
	if ( !empty($sub_cats) ) {

		$query_args['post_parent__in'] = $sub_cats;
	}
		else {

		$query_args['post_parent'] = array(esc_attr($args['cat']));
	}
//	print_r($sub_cats);

*/
	$query_args['post_parent'] = array(esc_attr($args['cat']));
	$cats = $cats[$atts['cat']]['child'];
}


if ( empty($args['except']) ) $args['except'] = 70;

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	echo '<div class="menu ltx-menu-sc ltx-filter-container ltx-menu-layout-'.esc_attr($args['layout']).'">';

		if ( !empty($cats) ) {

			echo '<ul class="cats ltx-tabs-cats menu-filter menu-filter-'.esc_attr($args['tabs']).'">';

			foreach ($cats as $catId => $cat) {

				echo '<li class="ltx-cat" data-filter="'.esc_attr($catId).'"><span class="ltx-item">'.esc_html($cat['name']).'</span></li>';
			}

			echo '</ul>';
		}

		echo '<div class="ltx-items">';
			echo '<div class="row">';

			while ( $query->have_posts() ):

				$query->the_post();
				$price = fw_get_db_post_option(get_The_ID(), 'price');	
				$link = fw_get_db_post_option(get_The_ID(), 'link');	
				$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');	

				$filter_cat = '';
				$item_cats = wp_get_post_terms( get_the_ID(), 'menu-category' );
				if ( $item_cats && !is_wp_error ( $item_cats ) ) {
					foreach ($item_cats as $cat) {

						$filter_cat .= ' ltx-filter-item ltx-filter-id-'.$cat->term_id;
					}
				}

				$col_class = 'col-lg-6 col-md-6';
		?>
				<article class="<?php echo esc_attr($filter_cat.' '.$col_class); ?>">
					<div class="ltx-inner">

						<?php

							if ( !empty($link) ) {

								echo '<a href="'.esc_url($link).'">';
							}

							$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'aqualine-tiny-square' );
							echo '<img src="'.esc_url( $image_src[0] ).'" alt="'.esc_attr(get_the_title()).'">';

							if ( !empty($link) ) {

								echo '</a>';
							}
						?>

						<?php if (!empty($price)): ?><h4 class="ltx-price"><?php echo esc_html($price); ?></h4><?php endif; ?>
						<?php if ( !empty($link) ) {

								echo '<a href="'.esc_url($link).'">';
						} ?>
						<h4 class="ltx-header"><?php the_title(); ?></h4>
						<?php if ( !empty($link) ) {

								echo '</a>';
						} ?>						
						<?php if (!empty($subheader)): ?><h5 class="ltx-subheader"><?php echo esc_html($subheader); ?></h5><?php endif; ?>
						<?php if (!empty($price)): ?><h4 class="ltx-price price-hidden"><?php echo esc_html($price); ?></h4><?php endif; ?>
						<p><?php echo ltx_cut_text( get_the_content(), $args['except'], ''); ?></p>
					</div>
				</article>
		<?php
			endwhile;

			echo '</div>';
		echo '</div>';
	echo '</div>';

	wp_reset_postdata();
}


