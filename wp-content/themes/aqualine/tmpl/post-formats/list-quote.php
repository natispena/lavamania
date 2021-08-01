<?php
/**
 * Quote post format
 */

$post_class = '';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>
	<blockquote>
		<a href="<?php the_permalink(); ?>">
		<?php
		    echo strip_tags( get_the_content() );
		?>
		</a>
		<cite><?php echo get_the_title(); ?></cite>	
	</blockquote>
</article>
