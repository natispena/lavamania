<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Products Shortcode
 */

$args = get_query_var('like_sc_portfolio_categories');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$query_args = array(
     'taxonomy'     => 'portfolio-category',
     'orderby'      => 'name',
     'show_count'   => 0,
     'pad_counts'   => 0,
     'hierarchical' => 1,
     'title_li'     => '',
     'hide_empty'   => 0
);

if ( !empty($args['ids']) ) {

	$query_args['include'] = esc_attr($args['ids']);
}

if ( !empty($args['orderby']) ) {

	$query_args['orderby'] = $args['orderby'];
}		

if ( !empty($args['limit'])) {

	$query_args['number'] = $args['limit'];
	$query_args['number'] = 100;
}



$cats = array();
$list = get_categories( $query_args );

foreach ($list as $cat) {

	if (esc_html($cat->name) == 'Uncategorized' OR empty($cat->name) ) continue;

	$thumbnail_id = get_term_meta( $cat->term_id, 'image', true ); 
	$image = fw_get_db_term_option( $cat->term_id, 'portfolio-category', 'image' );
	$icon = fw_get_db_term_option( $cat->term_id, 'portfolio-category', 'icon' );

	$term = get_term( $cat->term_id, 'portfolio-category' );

	if ($cat->category_parent == 0) {

	    $cats[$cat->term_id]['href'] = get_term_link($cat->slug, 'portfolio-category');
	    $cats[$cat->term_id]['name'] = $cat->name;
	    $cats[$cat->term_id]['description'] = $cat->description;
	    $cats[$cat->term_id]['image'] = $image;
	    $cats[$cat->term_id]['icon'] = $icon;
	    $cats[$cat->term_id]['count'] = $term->count;
	}
		else {

	    $cats[$cat->category_parent]['child'][$cat->term_id] = array(

	    	'href' => get_term_link($cat->slug, 'product_cat'),
	    	'name' => $cat->name,
	    	'image' => $image,
	    	'icon' => $icon,
	    );		    
	}
}	

$cols = '';
/*
if ( $args['columns'] == 1) {

	$cols = 'col-xs-12';
}
	else
if ( $args['columns'] == 2) {

	$cols = 'col-lg-6 col-md-6 col-sm-6 col-ms-12 col-xs-12';
}
	else
if ( $args['columns'] == 3) {

	$cols = 'col-lg-4 col-md-4 col-sm-6 col-ms-12 col-xs-12';
}
	else
if ( $args['columns'] == 4) {
*/
	$cols = 'col-lg-2 col-md-6 col-sm-6 col-ms-12 col-xs-12';
//}

if ( !empty($cats) ) {

	if ( !empty($args['swiper']) ) {

		$item_class = 'swiper-slide';
		echo ltx_vc_swiper_get_the_container('ltx-portfolio-cats-sc', $atts, $class, $id);
		echo '<div class="swiper-wrapper">';
	}
		else {

		echo '<div><div class="ltx-portfolio-cats-sc row centered '.esc_attr($class).'" '.$id.'><div>';	
	}

	foreach ( $cats as $tid => $item ) {

		echo '<div class="'.esc_attr($item_class).'">';

		$header = fw_get_db_term_option($tid, 'product_cat', 'subheader');

		if ( !empty( $header) )  {

			$header = str_replace(array('{{', '}}'), array('<span>', '</span>'), $header);
		}
			else {

			$header = $item['name'];
		}

		echo '<a href="'.esc_url($item['href']).'" class="ltx-item">';
			
			if ( !empty($item['icon']['icon-class']) ) {

				echo '<span class="ltx-icon '.$item['icon']['icon-class'].'"></span>';
			}
				else
			if ( !empty($item['image']) ) {

				echo '<span class="image"><img src="'.esc_url($item['image']['url']).'" alt="'.esc_attr($item['name']).'"></span>';
			}

			$count = '';
			if ( !empty($item['count']) ) {

				$count .= ' <span>('.$item['count'].')</span>';
			}
			
			echo '<h6 class="header">'.wp_kses_post($header).$count.'</h6>';
/*
			echo '<p>'.esc_html($item['description']).'</p>';

			if ( !empty( $args['more_text'] ) ) {

				echo '<span class="btn btn-xs btn-second">'.esc_html($args['more_text']).'</span>';
			}
*/
		echo '</a>';
		echo '</div>';		
	} 

	echo '</div>
	</div>
	</div>';
}


