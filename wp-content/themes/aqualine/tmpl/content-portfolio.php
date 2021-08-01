<?php

$item_class = get_query_var( 'aqualine_item_class' );

if ( empty($item_class) ) {

	$item_class = ' col-xl-2 col-lg-3 col-md-4 col-ms-6 col-xs-12';
}

$year = fw_get_db_post_option(get_The_ID(), 'year');
$rate = fw_get_db_post_option(get_The_ID(), 'rate');
$link = fw_get_db_post_option(get_The_ID(), 'link');
$header = get_the_title();

$comments = get_comments_number();

if ( empty($link) ) {

	$link = get_the_permalink();
}		

?>
<article class="ltx-item <?php echo esc_attr($item_class); ?>">
	<?php 
		if ( has_post_thumbnail() ) {

		    echo '<a href="'.esc_url(get_the_permalink()).'" class="photo">';
			    the_post_thumbnail('aqualine-portfolio');
		    echo '</a>';
		}
	?>
    <div class="ltx-description">
        <a href="<?php esc_url( the_permalink() ); ?>">
        	<h6 class="header"><?php echo wp_kses($header, 'header'); ?></h6>
        </a>
        <?php

        	if ( !empty($year) ) {

	        	echo '<span class="year">'.esc_html($year).'</span>';
        	}

        	if ( !is_null($comments) ) {

        		echo '<span class="comments">'.esc_html($comments).'</span>';
        	}

        	if ( !empty($rate) ) {

        		echo '<span class="rate">'.esc_html($rate).'</span>';
        	}
        ?>
    </div>    
</article>	
