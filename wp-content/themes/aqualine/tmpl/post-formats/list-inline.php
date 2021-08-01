<?php
/**
 * The default template for displaying inline posts
 */

?>
<article id="post-<?php the_ID(); ?>">
	<?php 
		if ( has_post_thumbnail() ) {

			$aqualine_photo_class = 'photo';
        	$aqualine_layout = get_query_var( 'aqualine_layout' );

			$aqualine_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'full' );

			if ($aqualine_image_src[2] > $aqualine_image_src[1]) $aqualine_photo_class .= ' vertical';
			
		    echo '<a href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($aqualine_photo_class).'">';

	    		the_post_thumbnail();

		    echo '</a>';
		}
	?>
    <div class="description">
   		<?php

   			aqualine_get_the_cats_archive();
   			
   		?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="header"><h3><?php the_title(); ?></h3></a>
        <?php if ( !has_post_thumbnail() ): ?>
        <div class="text text-page">
			<?php
				set_query_var( 'aqualine_excerpt_activity', 'enable' );
				add_filter( 'the_content', 'aqualine_excerpt' );
			    if( strpos( $post->post_content, '<!--more-->' ) ) {

			        the_content( esc_html__( 'Read more', 'aqualine' ) );
			    }
			    	else  {

			    	the_excerpt();
			    }	

			    set_query_var( 'aqualine_excerpt_activity', 'disable' );

			?>
        </div>            
    	<?php endif; ?>
    	<div class="blog-info">
    	<?php
			aqualine_the_post_info();
    	?>
    	</div>
    </div>  
</article>