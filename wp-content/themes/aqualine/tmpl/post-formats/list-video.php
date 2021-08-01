<?php
/**
 * Video Post Format
 */

$post_class = '';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>	
	<?php
	if ( has_post_thumbnail() ) {

		$aqualine_photo_class = 'ltx-photo swipebox';

		echo '<div class="ltx-wrapper">';
		    echo '<a href="'.esc_url(aqualine_find_http(get_the_content())).'" class="'.esc_attr($aqualine_photo_class).'">';

				the_post_thumbnail('full');
				
			    echo '<span class="ltx-icon-video"></span>';

		    echo '</a>';
		echo '</div>';
	}
		else {

		if ( !empty(wp_oembed_get(aqualine_find_http(get_the_content()))) ) {

			echo '<div class="ltx-wrapper">';
				echo wp_oembed_get(aqualine_find_http(get_the_content()));	
			echo '</div>';
		}
	}

	$display_excerpt_q = get_query_var( 'ltx_display_excerpt' );
	if ( isset($display_excerpt_q) AND $display_excerpt_q === true ) {

		$display_excerpt = 'visible';
	}

	?>
    <div class="ltx-description">
    	<?php
			aqualine_get_the_post_headline();    		
    	?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="ltx-header"><h3><?php the_title(); ?></h3></a>
        <div class="ltx-excerpt">
			<?php
				if ( !empty( $display_excerpt ) AND $display_excerpt == 'visible' ) {

					set_query_var( 'aqualine_excerpt_activity', 'enable' );
					add_filter( 'the_content', 'aqualine_excerpt' );

				    if( strpos( $post->post_content, '<!--more-->' ) ) {

				        the_content( esc_html__( 'Read more', 'aqualine' ) );
				    }
				    	else  {

				    	the_excerpt();			    	
				    }	

				    set_query_var( 'aqualine_excerpt_activity', 'disable' );
				}
			?>
        </div>   
        <?php 

			aqualine_the_post_info();

        ?>
    </div>    
</article>