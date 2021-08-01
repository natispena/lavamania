<?php
/**
 * The default template for displaying standard post format
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php 

        $post_format = get_post_format();
        if ( $post_format == 'video' ) {

            $aqualine_photo_class = 'ltx-photo swipebox';

            echo '<div class="ltx-wrapper">';
                echo '<a href="'.esc_url(aqualine_find_http(get_the_content())).'" class="'.esc_attr($aqualine_photo_class).'">';

                    the_post_thumbnail('full');
                    
                    echo '<span class="ltx-icon-video"></span>';

                echo '</a>';
            echo '</div>';
        }
            else
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
        <a href="<?php esc_url( the_permalink() ); ?>" class="ltx-header"><h3><?php the_title(); ?></h3></a>
    </div>     
</article>