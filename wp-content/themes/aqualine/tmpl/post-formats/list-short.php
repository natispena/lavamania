<?php
/**
 * The default template for displaying standard post format
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="ltx-description">
        <?php
            aqualine_get_the_post_headline();          
        ?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="ltx-header"><h3><?php the_title(); ?></h3></a>
            <?php

                $display_excerpt = 'visible';

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