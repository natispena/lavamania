<?php
/**
 * The default template for displaying standard post format
 */

$post_class = '';
$display_excerpt = 'hidden';
$featured = get_query_var( 'aqualine_featured_disabled' );
if ( function_exists( 'FW' ) AND empty ( $featured ) ) {

	$featured_post = fw_get_db_post_option(get_The_ID(), 'featured');
	if ( !empty($featured_post) ) {

		$post_class = 'ltx-featured-post-none';
	}
}

if ( function_exists( 'FW' ) ) {

	$gallery_files = fw_get_db_post_option(get_The_ID(), 'gallery');
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>
	<?php 
	
		if ( !empty( $gallery_files ) ) {

			$atts['swiper_arrows'] = 'sides-tiny';
			$atts['swiper_autoplay'] = fw_get_db_settings_option( 'blog_gallery_autoplay' );
		
			echo ltx_vc_swiper_get_the_container('ltx-post-gallery', $atts, '', ' id="ltx-slide-'.get_the_ID().'" ');
			echo '<div class="swiper-wrapper">';

			foreach ( $gallery_files as $item ) {

				echo '<a href="'.esc_url(get_the_permalink()).'" class="swiper-slide">';
					the_post_thumbnail('full');
				echo '</a>';
			}

			echo '</div>
			</div>
			</div>';
		}
			else
		if ( has_post_thumbnail() ) {

			$aqualine_photo_class = 'ltx-photo';
        	$aqualine_layout = get_query_var( 'aqualine_layout' );
        	$display_excerpt = 'hidden';

			$aqualine_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'full' );

			if ($aqualine_image_src[2] > $aqualine_image_src[1]) $aqualine_photo_class .= ' vertical';
			
		    echo '<a href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($aqualine_photo_class).'">';

		    	if ( empty($aqualine_layout) OR $aqualine_layout == 'classic'  ) {

		    		the_post_thumbnail('full');
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
				if ( isset($display_excerpt_q) AND $display_excerpt_q === true ) {

					$display_excerpt = 'visible';
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
			aqualine_the_post_info( $display_excerpt );
        ?>
    </div>    
</article>