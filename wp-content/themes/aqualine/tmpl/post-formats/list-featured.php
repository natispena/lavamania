<?php
/**
 * The default template for displaying standard post format
 */

$post_class = '';
$featured = get_query_var( 'aqualine_featured_disabled' );
if ( function_exists( 'FW' ) AND empty ( $featured ) ) {

	$post_class = 'ltx-featured-post';
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
					echo wp_get_attachment_image( $item['attachment_id'], 'aqualine-blog-full' );
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

			$aqualine_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'aqualine-blog-featured' );

			if ($aqualine_image_src[2] > $aqualine_image_src[1]) $aqualine_photo_class .= ' vertical';
			
		    echo '<div href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($aqualine_photo_class).'" style="background-image: url('.esc_url($aqualine_image_src[0]).')">';

		    echo '<a href="'.esc_url(get_the_permalink()).'" class="ltx-photo-overlay-href"></a>';
			    echo '<span class="ltx-photo-overlay"></span>';
			    echo '<span class="ltx-photo-overlay-gradient"></span>';

	    		echo '<div class="ltx-description-featured">';

					aqualine_get_the_post_headline();    		

		    		echo '<h3>'.get_the_title().'</h3>';
		    	echo '</div>';

		    echo '</div>';
		}
	?>
</article>