<?php
/**
 * Full blog post
 */

if ( function_exists( 'FW' ) ) {

	$gallery_files = fw_get_db_post_option(get_The_ID(), 'gallery');
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content clearfix" id="entry-div">
	<?php
		if ( !empty( $gallery_files ) ) {

			$atts['swiper_arrows'] = 'sides';
			$atts['swiper_autoplay'] = fw_get_db_settings_option( 'blog_gallery_autoplay' );
		
			echo ltx_vc_swiper_get_the_container('ltx-post-gallery', $atts, '', ' id="ltx-slide-'.get_the_ID().'" ');
			echo '<div class="swiper-wrapper">';

			foreach ( $gallery_files as $item ) {

				echo '<a href="'.esc_url(get_the_permalink()).'" class="swiper-slide">';
					echo wp_get_attachment_image( $item['attachment_id'], 'aqualine-post' );
				echo '</a>';
			}

			echo '</div>
			</div>
			</div>';
		}
			else	
		if ( has_post_thumbnail() ) {

			echo '<div class="image">';
				
				the_post_thumbnail( 'aqualine-post' );

			echo '</div>';
		}
	?>
    <div class="blog-info blog-info-post-top">
		<?php

            echo '<div class="blog-info-left">';

				aqualine_get_the_post_headline();

            echo '</div>';

            echo '<div class="blog-info-right">';

            	aqualine_the_post_info('visible');

            echo '</div>';

        ?>
    </div>	
    <div class="ltx-description">
        <div class="text text-page">
			<?php

				the_content();

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'aqualine' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
			<div class="clear"></div>
        </div>
    </div>	    
    <div class="clearfix"></div>
    <?php if ( has_tag() OR shortcode_exists('ltx-share-icons') OR (in_array( 'category', get_object_taxonomies( get_post_type() ) ) && aqualine_categorized_blog() && sizeof(get_the_category()) > 3 )) : ?>
    <div class="blog-info-post-bottom">
		<?php
			if ( has_tag() OR shortcode_exists('ltx-share-icons') ) {

				$tags_many_class = '';
				if ( has_tag() AND sizeof( wp_get_post_tags( get_The_ID() ) ) > 5 ) {

					$tags_many_class = ' tags-many-wrapper';
				}

				echo '<div class="tags-line'.esc_attr($tags_many_class).'">';

					echo '<div class="tags-line-left">';
						if ( has_tag() AND sizeof( wp_get_post_tags( get_The_ID() ) ) <= 5 ) {

							echo '<span class="tags">';
								echo '<span class="tags-header">'.esc_html__( 'Tags:', 'aqualine' ).'</span>';
								the_tags( '<span class="tags-short">', '', '</span>' );
							echo '</span>';
						}		
							else
						if ( has_tag() AND sizeof( wp_get_post_tags( get_The_ID() ) ) > 5 ) {
							
							echo '<span class="tags tags-many">';
								the_tags( '<span class="tags-short">', '', '</span>' );
							echo '</span>';
						}	

					echo '</div>';
					echo '<div class="tags-line-right">';

						if ( shortcode_exists('ltx-share-icons') ) {

							echo do_shortcode( '[ltx-share-icons header="'.esc_html__( 'Share', 'aqualine' ).'"]' );
						}

					echo '</div>';

				echo '</div>';
			}

			if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && aqualine_categorized_blog() && sizeof(get_the_category()) > 3 ) {

				echo '<div class="ltx-cats cats-many">';
					echo '<span class="cats-many-header">'.esc_html__( 'Categories:', 'aqualine' ).'</span>';
					echo get_the_category_list( esc_html_x( ' | ', 'Used between list items, there is a space after the comma.', 'aqualine' ) );
				echo '</div>';
			}				

		?>	
    </div>	
	<?php endif; ?>
    <?php 
		aqualine_author_bio();

		aqualine_related_posts(get_the_ID());
    ?>
    </div>
</article>
