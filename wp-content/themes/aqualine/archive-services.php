<?php
/**
 * The Services template file
 *
 */

$aqualine_layout = '';
$aqualine_sidebar_hidden = false;
$aqualine_sidebar = 'right';
$wrap_class = 'col-lg-8 col-md-8 col-xs-12';

if ( function_exists( 'FW' ) ) {

	$aqualine_layout = fw_get_db_settings_option( 'services_list_layout' );
	$aqualine_sidebar = fw_get_db_settings_option( 'services_list_sidebar' );

	if ( $aqualine_sidebar == 'hidden' ) {

		$aqualine_sidebar_hidden = true;
	}

	if ($aqualine_layout == 'three-cols') {

		$aqualine_sidebar_hidden = true;
	}

	if ( $aqualine_sidebar == 'left' ) {

		$wrap_class = 'col-xl-8 col-xl-push-4 col-lg-9 col-lg-push-3 col-lg-offset-0 col-md-12 col-xs-12';
	}

	$row_class = '';
	if ( $aqualine_layout == 'two-cols' OR $aqualine_layout == 'three-cols' ) {

		$row_class = 'masonry';
		if ( $aqualine_sidebar_hidden ) $wrap_class = 'col-lg-12 col-xs-12';
	}
		else {

		if ( $aqualine_sidebar_hidden ) $wrap_class = 'col-xl-8 col-lg-10 col-md-12 col-xs-12';	
	}
}

get_header(); ?>
<div class="inner-page margin-default">
	<div class="row <?php if ( $aqualine_sidebar_hidden ) { echo 'centered'; } ?>">
        <div class="<?php echo esc_attr( $wrap_class ); ?>">
            <div class="blog blog-block layout-<?php echo esc_attr($aqualine_layout); ?>">
				<?php

				if ( get_query_var( 'paged' ) ) {

					$paged = get_query_var( 'paged' );

				} elseif ( get_query_var( 'page' ) ) {

					$paged = get_query_var( 'page' );
					
				} else {

					$paged = 1;
				}

				$wp_query = new WP_Query( array(
					'post_type' => 'services',
					'paged' => (int) $paged,
				) );

            	echo '<div class="row '.esc_attr($row_class).'">';
				if ( $wp_query->have_posts() ) :

					while ( $wp_query->have_posts() ) : the_post();

						if ( !function_exists( 'fw_get_db_settings_option' ) ) {

							get_template_part( 'tmpl/content-post-one-col', $wp_query->get_post_format() );
						}
							else {

							set_query_var( 'aqualine_layout', $aqualine_layout );

							if ($aqualine_layout == 'three-cols') {

								get_template_part( 'tmpl/content-post-three-cols', $wp_query->get_post_format() );
							}
								else
							if ($aqualine_layout == 'two-cols') {

								get_template_part( 'tmpl/content-post-two-cols', $wp_query->get_post_format() );
							}
								else {

								get_template_part( 'tmpl/content-post-one-col', $wp_query->get_post_format() );
							}
						}

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
	    <?php
	    if ( !$aqualine_sidebar_hidden ) {

            if ( $aqualine_sidebar == 'left' ) {

            	get_sidebar( 'left' ); 
            }
            	else  {

            	get_sidebar();
            }
	    }
	    ?>
	</div>
</div>
<?php

get_footer();
