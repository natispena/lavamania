<?php
/**
 * The Template for displaying all single services posts
 */

$aqualine_sidebar_hidden = false;
$aqualine_sidebar = 'hidden';
$blog_wrap_class = 'col-xl-8 col-lg-8 col-md-12 col-xs-12';

if ( function_exists( 'FW' ) ) {

	$aqualine_sidebar = fw_get_db_settings_option( 'services_post_sidebar' );

	if ( $aqualine_sidebar == 'left' ) {

		$blog_wrap_class = 'col-xl-8 col-xl-push-4 col-lg-9 col-lg-push-3 col-lg-offset-0 col-md-12 col-xs-12';	
	}
		else
	if ( $aqualine_sidebar == 'hidden' ) {

		$blog_wrap_class = 'col-xl-8 col-lg-10 col-md-12 col-xs-12';	
		$aqualine_sidebar_hidden = true;
	}
}

get_header(); ?>
<div class="inner-page margin-default">
    <div class="row <?php if ( $aqualine_sidebar_hidden ) echo 'centered'; ?>">  
        <div class="<?php echo esc_attr( $blog_wrap_class ); ?>">
            <section class="blog-post">
				<?php
					while ( have_posts() ) : 

						the_post();

						get_template_part( 'tmpl/content-services-full', get_post_format() );

						if ( comments_open() || get_comments_number() ) {

							comments_template();
						}

					endwhile;
				?>                    
            </section>
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
