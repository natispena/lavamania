<?php
/**
 * The Template for displaying sliders preview
 */

$margin_layout = 'margin-default';
$wrapper_class = 'col-xl-12 col-xs-12';

get_header(); ?>

	<!-- Content -->
	<div class="inner-page text-page <?php echo esc_attr( $margin_layout ); ?>">
        <div class="row centered">
            <div class="<?php echo esc_attr($wrapper_class); ?> text-page">
				<?php
				while ( have_posts() ) : 

					the_post();

					get_template_part( 'tmpl/content', 'page' );

				endwhile;
				?>
            </div>
        </div>
	</div>

<?php

get_footer();
