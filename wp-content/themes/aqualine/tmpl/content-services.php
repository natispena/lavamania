<?php
/**
 * Events List
 */

$iteration = get_query_var( 'aqualine_iteration' );
$odd1 = $odd2 = '';
if ( $iteration % 2 == 0) { $odd1 = ' col-lg-push-6 '; $odd2 = ' col-lg-pull-6 '; }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
	    <a href="<?php the_permalink(); ?>" class="photo col-lg-6 <?php echo esc_attr($odd1); ?>">
	        <?php
	        	 echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'aqualine-service', false  );
	        ?>    
	    </a>
	    <div class="col-lg-6 <?php echo esc_attr($odd2); ?>">
	    	<div class="description">
		        <a href="<?php esc_url( the_permalink() ); ?>" class="heading "><h3 class="header"><?php the_title(); ?></h3></a>
				<?php

					add_filter( 'the_content', 'aqualine_excerpt' );
					the_content( esc_html__( 'Read more &rarr;', 'aqualine' ) );
				?>
				<a href="<?php esc_url( the_permalink() ); ?>" class="btn color-hover-second"><?php echo esc_html__( 'Read more &rarr;', 'aqualine' ); ?></a>
			</div>
	    </div>
	</div>
</article>
