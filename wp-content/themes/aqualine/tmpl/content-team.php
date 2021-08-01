<?php
/**
 * The template for displaying posts in the Gallery post format
 */

if ( function_exists( 'FW' ) ) {
	
	$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
	$social_icons = fw_get_db_post_option(get_The_ID(), 'items');
	$cut = fw_get_db_post_option(get_The_ID(), 'cut');
}

?>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-ms-12">
	<div class="item matchHeight team-item item-type-circle">
		<a href="<?php esc_url( the_permalink() ); ?>" class="image">
	        <?php
		        echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false  );
	        ?>  			
		</a>
		<div class="descr">
		<?php

			$item_cats = wp_get_post_terms( get_the_ID(), 'team-category' );
			$item_term = '';
			if ( $item_cats && !is_wp_error ( $item_cats ) ) {
				
				foreach ($item_cats as $cat) {

					$item_term = $cat->name;
				}
			}

			echo '<a href="'.esc_url( get_the_permalink() ).'"><h4 class="header">'. get_the_title().'</h4></a>';

			if (!empty($subheader)) {

				echo '<div class="subheader color-black">'. wp_kses($subheader, 'header') .'</div>';
			}

			if ( !empty($item_term) ) echo '<p class="subheader">'. wp_kses($item_term, 'header') .'</p>';

			if ( !empty($social_icons) ) {

				echo '<ul class="ltx-social">';
				foreach ($social_icons as $item) {

					echo '<li><a href="'.esc_url( $item['href'] ).'" class="'.esc_attr( $item['icon'] ) .'"></a></li>';
				}
				echo '</ul>';
			}

		?>
		</div>
	</div>
</div>
