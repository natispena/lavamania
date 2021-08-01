<?php
/**
 * Full blog post
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
			if ( has_post_thumbnail() ) {

				echo '<div class="image">';
				the_post_thumbnail( 'aqualine-post' );
				echo '</div>';
			}
		?>
	    <div class="description">
	        <div class="text text-page">
				<?php
					the_content();
				?>
	        </div>
	    </div>	    
	</article>
