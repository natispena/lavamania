<?php
/**
 * The default template for displaying standard post format
 */

$post_class = '';
$display_excerpt = 'visible';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>
	<?php 

		if ( has_post_thumbnail() ) {

			$aqualine_photo_class = 'ltx-photo';
        	$aqualine_layout = get_query_var( 'aqualine_layout' );
        	$display_excerpt = 'visible';

			$aqualine_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'full' );

			if ($aqualine_image_src[2] > $aqualine_image_src[1]) $aqualine_photo_class .= ' vertical';
			
		    echo '<a href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($aqualine_photo_class).'">';

		    	if ( empty($aqualine_layout) OR $aqualine_layout == 'classic'  ) {

		    		the_post_thumbnail('full');
		    		$display_excerpt = 'visible';
		    	}
		    		else
		    	if ( $aqualine_layout == 'two-cols'  ) {	    	

		    		the_post_thumbnail();
		    	}
		    		else {

					$sizes_hooks = array( 'aqualine-blog', 'aqualine-blog-full' );
					$sizes_media = array( '1199px' => 'aqualine-blog' );

					aqualine_the_img_srcset( get_post_thumbnail_id(), $sizes_hooks, $sizes_media );
	    		}

	    		echo '<span class="ltx-photo-overlay"></span>';

		    echo '</a>';
		}
	?>
    <div class="ltx-description">
    	<?php
			aqualine_get_the_post_headline();    		
    	?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="ltx-header"><h3><?php the_title(); ?></h3></a>
			<?php

				$display_excerpt_q = get_query_var( 'ltx_display_excerpt' );

				if ( isset($display_excerpt_q) AND $display_excerpt_q === false ) {

					$display_excerpt = 'hidden';
				}

				if ( !empty( $display_excerpt ) AND $display_excerpt == 'visible' ) {

        			echo '<div class="ltx-excerpt">';

					set_query_var( 'aqualine_excerpt_activity', 'enable' );
					add_filter( 'the_content', 'aqualine_excerpt' );

				    if( strpos( $post->post_content, '<!--more-->' ) ) {

				        the_content( esc_html__( 'Read more', 'aqualine' ) );
				    }
				    	else  {

				    	the_excerpt();			    	
				    }	

				    set_query_var( 'aqualine_excerpt_activity', 'disable' );

				    echo '</div>';
				}
			?>
        <?php 

			aqualine_the_post_info();

        ?>
    </div>    
</article>