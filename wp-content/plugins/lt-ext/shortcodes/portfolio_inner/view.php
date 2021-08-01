<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Portfolio Shortcode
 */

$args = get_query_var('like_sc_portfolio_inner');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';


if ( $args['type'] == 'poster' ) {

	echo '<div class="ltx-portfolio-poster">'.wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false  ).'</div>';
}
	else
if ( $args['type'] == 'comments' ) {

	if ( comments_open() || get_comments_number() ) {

		comments_template();
	}
}
	else
if ( $args['type'] == 'header' ) {

	echo '<h2 class="ltx-inner-header header">'.esc_html(get_the_title()).'</h2>';
}
	else
if ( $args['type'] == 'director' ) {

	$director = fw_get_db_post_option(get_The_ID(), 'director');
	$rate = fw_get_db_post_option(get_The_ID(), 'rate');

	echo '<p class="header ltx-short-info">';
		if ( !empty($director) ) echo '<strong><span class="color-main">'.esc_html__('Director:', 'lt-ext').'</span> '.esc_html($director).'</strong><br>';
		if ( !empty($rate) ) echo '<strong><span class="color-main">'.esc_html__('Imdb:', 'lt-ext').'</span> <span class="fa fa-star">&nbsp;</span> '.esc_html($rate).'</strong>';
	echo '</p>';
}
	else
if ( $args['type'] == 'icons' ) {

	$year = fw_get_db_post_option(get_The_ID(), 'year');
	$duration = fw_get_db_post_option(get_The_ID(), 'duration');	

	$item_cats = wp_get_post_terms( get_the_ID(), 'portfolio-category' );

	$cats = '';
	if ( !empty($item_cats) ) {

		foreach ($item_cats as $cat) {

			$cats = $cat->name;
			break;
		}
	}

	echo '<ul class="ltx-block-icon  icons-count-3 align-left ltx-icon-color-main ltx-icon-size-sm ltx-header-color-default ltx-icon-type-circle ltx-bg-color-transparent layout-inline ltx-icon-h-right ">';

	if ( !empty($year) ) 
	echo '<li><div>
			<span class="ltx-icon fa fa-calendar bg-transparent"></span>
			<div class="block-right"> <h6 class="header">'.esc_html($year).'</h6></div>
			</div>
		</li>';

	if ( !empty($duration) ) 
	echo '<li><div>
			<span class="ltx-icon fa fa-clock-o bg-transparent"></span>
			<div class="block-right"> <h6 class="header">'.esc_html($duration).'</h6></div>
			</div>
		</li>';

	if ( !empty($cats) ) 		
	echo '<li><div>
			<span class="ltx-icon fa fa-film bg-transparent"></span>
			<div class="block-right"> <h6 class="header">'.esc_html($cats).'</h6></div>
			</div>
		</li>';
	echo '</ul>';

}
	else
if ( $args['type'] == 'starring' ) {

	$item_stars = wp_get_post_terms( get_the_ID(), 'portfolio-stars' );

	if ( !empty($item_stars) ) {

		echo '<ul class="ltx-portfolio-stars">';

		foreach ($item_stars as $cat) {	

			$term_link = get_term_link($cat->term_id);
			$image = fw_get_db_term_option($cat->term_id, 'portfolio-stars', 'image');
			$image = wp_get_attachment_image( $image['attachment_id'], 'aqualine-gallery-grid' );
			echo '<li><a href="'.esc_url($term_link).'">'.$image.esc_html($cat->name).'</a></li>';
		}

		echo '</ul>';
	}
}
	else
if ( $args['type'] == 'gallery' ) {

	$list = fw_get_db_post_option( get_the_ID(), 'photos' );
	if ( !empty($list) ):
	?>
	<div class="ltx-gallery">
		<div class="row">
			<?php foreach ( $list as $item ) : ?>
			<div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
				<div class="item">
					<a href="<?php echo esc_url( $item['url'] ); ?>" class="swipebox photo">
						<?php echo wp_get_attachment_image( $item['attachment_id'], 'aqualine-gallery-grid' ); ?><span class="fa fa-search"></span>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>	
	<?php
	endif;
}



