<?php
/**
	Testimonials Single Item
 */

$rate_display = false;
$subheader_display = true;

$class = '';
if ( function_exists( 'FW' ) ) {

	$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
	$rate = fw_get_db_post_option(get_The_ID(), 'rate');	
	$short = fw_get_db_post_option(get_The_ID(), 'short');	

	$sc = get_query_var( 'ltx-testimonials-sc' );
	$sc_cut = get_query_var( 'ltx-testimonials-sc-cut' );

	if ( !empty($short) AND empty($sc) ) {

		$class = ' ltx-short';
	}
}


?>
<div class="inner <?php echo esc_attr($class); ?>">
	<?php

		if ( !empty($rate_display) ) {

			echo '<div class="rate">';
			for ($x = 1; $x<= (int)($rate); $x++) {

				echo '<span class="fa fa-star"></span>';
			}
			echo '</div>';
		}

		echo '<div class="ltx-descr">';

			if ( !empty($sc_cut) ) {

				echo '<p>'. aqualine_cut_text(get_the_content(), $sc_cut, '.') .'</p>';
			}
				else {

				echo '<p>'. get_the_content() .'</p>';
			}
		echo '</div>';

		if ( empty($short) OR !empty($sc)) {

			echo '<div class="image">';
				the_post_thumbnail('aqualine-tiny-square');
			echo '</div>';
		}

		echo '<div class="header">'. get_the_title() .'</div>';

		if ( !empty($subheader_display) AND !empty($subheader) ) {

			echo '<div class="subheader">'. wp_kses($subheader, 'header') .'</div>';
		}

	?>
</div>
