<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Products Shortcode
 */

$args = get_query_var('like_sc_products');

$query_args = array(
	'post_type' => 'product',
	'post_status' => 'publish',
	'posts_per_page' => (int)($args['limit']),
);

$class = $id = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['category_filter']) ) {

	$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'product_cat',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['category_filter'])),
			),
		    array(
		        'taxonomy' => 'product_visibility',
		        'field'    => 'name',
		        'terms'    => 'exclude-from-catalog',
		        'operator' => 'NOT IN',
		    ),			
    );

	$query_args['posts_per_page'] = (int)($args['limit']);
}


if ( !empty($args['featured']) ) {

	$query_args['post__in'] = wc_get_featured_product_ids();
}

$cols = 3;
if ( !empty($args['cols']) ) {

	$cols = $args['cols'];
}

if ( !empty($args['orderby']) ) {

	$query_args['orderby'] = $args['orderby'];
	if ( $query_args['orderby'] = 'menu_order title' ) {

		$query_args['orderby'] = 'menu_order';
	}

	$query_args['order'] = $args['orderway'];
}		

$query = new WP_Query( $query_args );
$currency = get_woocommerce_currency_symbol();

if ( $query->have_posts() ) {

	if ( $args['layout'] == 'large' ) {

		add_filter( 'ltx_wc_excerpt_size', function() { return 250; } );
    }	
    	else {

		add_filter( 'ltx_wc_excerpt_size', function() { return false; } );
   	}

	$item_class = '';
	if ( $args['rate'] == 'hidden' ) $item_class .= 'products-hide-rate ';
	if ( $args['price'] == 'hidden' ) $item_class .= 'ltx-products-hide-price ';


	if ( !empty($args['swiper']) ) {

		echo ltx_vc_swiper_get_the_container('woocommerce ltx-products-slider ltx-products-sc ltx-products-sc-'.esc_attr($args['layout']).' ltx-products-bg-'.esc_attr($args['bg']), $atts, $class, $id);
		echo '<ul class="products swiper-wrapper">';

		$item_class .= 'swiper-slide ';
	}
		else {

		echo '<div class="ltx-products-sc-wrapper"><div class="woocommerce">
		<ul class="products columns-'.esc_attr($args['cols']).' ltx-products-sc ltx-products-sc-'.esc_attr($args['layout']).' ltx-products-bg-'.esc_attr($args['bg']).'">';
	}

	while ( $query->have_posts() ):

		$query->the_post();

		if ( isset($single_cat->term_id) ) $current_cat = $single_cat->term_id;
		if ( empty($current_cat) ) $current_cat = '';

		$product = $item = wc_get_product( get_the_ID() );

		?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(esc_attr($item_class)); ?>>
			<?php

				if ( $args['layout'] == 'simple' ) {

					do_action( 'woocommerce_before_shop_loop_item' );

					do_action( 'woocommerce_before_shop_loop_item_title' );

					do_action( 'woocommerce_shop_loop_item_title' );

					do_action( 'woocommerce_after_shop_loop_item_title' );

					do_action( 'woocommerce_after_shop_loop_item' );
				}
					else
				if ( $args['layout'] == 'large' ) {

					set_query_var( 'ltx-wc-attr', true );
					set_query_var( 'ltx-wc-excerpt', true );

					echo '<div class="row">';

						echo '<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ltx-img">';
							if ( has_post_thumbnail() ) {

							    echo '<a href="'.esc_url(get_the_permalink()).'" class="ltx-photo">';
								    the_post_thumbnail('full');

								    if ( !empty($args['image']) ) {

								    	$img = wp_get_attachment_image_src( $args['image'], 'full' );
								    	echo '<img src="'.esc_url($img[0]).'" class="ltx-product-label" alt="wc-label">';
								    }

							    echo '</a>';
							}
						echo '</div>';
						echo '<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 ltx-descr">';

					        echo '<a href="'.esc_url( get_the_permalink() ) .'">
					        	<h3 class="header">'.get_the_title().'</h3>
					        ';

					        /**
					         * Getting the excerpt and price. Already has </a> tag
					         */
					        do_action( 'woocommerce_after_shop_loop_item_title' ); 

							/**
							 * Getting correct WC button
							 */
							ob_start();
							do_action( 'woocommerce_after_shop_loop_item' );
							$button = str_replace(array('</div>', 'btn-xs btn-transparent color-main', 'btn', 'add_to_cart_button'), array('', 'btn-main', 'btn btn-lg', 'add_to_cart_button btn-lg'), ob_get_clean());
							echo $button;

						echo '</div>';

					echo '</div>';

					set_query_var( 'ltx-wc-attr', false);
					set_query_var( 'ltx-wc-excerpt', false );
				}

			?>
		</li>
		<?php 
		?>
	<?php
	endwhile;

	echo '</ul></div></div>';	

	if ( $args['layout'] == 'large' ) {

    }

	wp_reset_postdata();
}


