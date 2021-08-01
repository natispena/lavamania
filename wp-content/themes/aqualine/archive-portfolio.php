<?php
/**
 * The Services template file
 *
 */

$aqualine_layout = '';
$aqualine_sidebar_hidden = true;
$aqualine_sidebar = 'right';
$wrap_class = 'col-xl-12 col-lg-12 col-md-12 col-xs-12';	

get_header(); ?>
<div class="inner-page margin-default">
	<div class="row <?php if ( $aqualine_sidebar_hidden ) { echo 'centered'; } ?>">
        <div class="<?php echo esc_attr( $wrap_class ); ?>">
            <div class="ltx-portfolio">
				<?php

            	echo '<div class="row centered">';
				if ( $wp_query->have_posts() ) :

					while ( $wp_query->have_posts() ) : the_post();

							get_template_part( 'tmpl/content-portfolio' );

					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'tmpl/content', 'none' );

				endif;
				echo '</div>';
				?>
	        </div>
			<?php
			if ( have_posts() ) {

				aqualine_paging_nav();
			}
            ?>	        
	    </div>
	</div>
</div>
<?php

get_footer();

