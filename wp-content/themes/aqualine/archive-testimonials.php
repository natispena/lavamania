<?php
/**
 * Testimonials page
 */

get_header();


?>
<div class="inner-page margin-default">
<?php

while ( have_posts() ) {

	the_post();
	the_content();
}

?>
	<div class="ltx-testimonials-list ltx-testimonials-inner row masonry">
		<?php

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		}
			elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' );
		}
			else {

			$paged = 1;
		}

		$wp_query = new WP_Query( array(
			'post_type' => 'testimonials',
			'paged' => (int) $paged,
		) );

		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();

				echo '<div class="col-lg-6 item">';
					get_template_part( 'tmpl/content', 'testimonials' );
				echo '</div>';

			endwhile;
		else :
			// If no content, include the "No posts found" template.
			get_template_part( 'tmpl/content', 'none' );
		endif;
		?>        
	</div>  
	<?php
	if ( have_posts() ) {

		aqualine_paging_nav();
	}
	?>     
</div>
<?php get_footer(); ?>
