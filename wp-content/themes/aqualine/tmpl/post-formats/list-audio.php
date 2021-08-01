<?php
/**
 * Audio Post Format
 */

$post_class = '';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>
	<div class="ltx-wrapper">
		<?php

		if ( has_post_thumbnail() ) {

			$aqualine_photo_class = 'ltx-photo';

		    echo '<a href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($aqualine_photo_class).'">';

				the_post_thumbnail('full');

		    echo '</a>';
		}

		$mp3 = aqualine_find_http(get_the_content());

		echo wp_audio_shortcode(
			array('src'	=>	esc_url($mp3))
		);
		?>
	</div>
    <div class="ltx-description">
    	<?php
			aqualine_get_the_post_headline();    		
    	?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="ltx-header"><h3><?php the_title(); ?></h3></a>
        <?php 

			aqualine_the_post_info();

        ?>
    </div>    	    	
</article>