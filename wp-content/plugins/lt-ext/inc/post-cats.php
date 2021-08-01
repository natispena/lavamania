<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * LT-Ext Post Categories Functions
 */

if (!function_exists('ltxGetCats')) {
	function ltxGetCats($taxonomy) {

		if ( empty($taxonomy) ) {

			return false;
		}

		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_categories( $args );
		foreach ($all_categories as $cat) {

			if (esc_html($cat->name) == 'Uncategorized' OR empty($cat->name) ) continue;

			if ($cat->category_parent == 0) {

			    $cats[$cat->term_id]['href'] = get_term_link($cat->slug, $taxonomy);
			    $cats[$cat->term_id]['name'] = $cat->name;
			}
				else {

			    $cats[$cat->category_parent]['child'][$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, $taxonomy),
			    	'name' => $cat->name,
			    );		    
			}
		}	

		return $cats;
	}
}


if (!function_exists('ltxGetGalleryPosts')) {
	function ltxGetGalleryPosts() {

		$posts = get_posts( array(
			'nopaging'                  => true,
			'post_type' => 'gallery',
			'posts_per_page'	=>	100,
		) );

		$cat = array();

		if ( !empty($posts) ) {

			foreach ( $posts as $post ) {

				$cat[$post->post_title] = $post->ID;
			}
		}

		wp_reset_postdata();

		return $cat;
	}
}

if (!function_exists('ltxGetProductsCats')) {
	function ltxGetProductsCats() {

		$taxonomy     = 'product_cat';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_categories( $args );
		foreach ($all_categories as $cat) {

			if (esc_html($cat->name) == 'Uncategorized' OR empty($cat->name) ) continue;

			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); 
		    if ( !empty($thumbnail_id) ) $image = wp_get_attachment_url( $thumbnail_id ); else $image = null;

			if ($cat->category_parent == 0) {

			    $cats[$cat->term_id]['href'] = get_term_link($cat->slug, 'product_cat');
			    $cats[$cat->term_id]['name'] = $cat->name;
			    $cats[$cat->term_id]['image'] = $image;
			}
				else {

			    $cats[$cat->category_parent]['child'][$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'product_cat'),
			    	'name' => $cat->name,
			    	'image' => $image,
			    );		    
			}
		}	

		return $cats;
	}
}

if (!function_exists('ltxGetMenuCats')) {
	function ltxGetMenuCats() {

		$taxonomy     = 'menu-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {

			if ($cat->parent == 0) {

			    $cats[$cat->term_id]['href'] = get_term_link($cat->slug, 'menu-category');
			    $cats[$cat->term_id]['name'] = $cat->name;
			}
				else {

			    $cats[$cat->parent]['child'][$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'menu-category'),
			    	'name' => $cat->name,
			    );		    
			}   
		}	

		return $cats;
	}
}


if (!function_exists('ltxGetCPTCats')) {
	function ltxGetCPTCats($taxonomy) {

		if ( empty($taxonomy) ) return false;

		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		if (!empty($all_categories)) {

			foreach ($all_categories as $cat) {
				if (!empty($cat->category_parent) AND $cat->category_parent == 0) {
				    $category_id = $cat->term_id;       
				    $cats[$cat->term_id] = array(

				    	'href' => get_term_link($cat->slug, $taxonomy),
				    	'name' => $cat->name,
				    );
				}       
			}
		}

		return $cats;
	}
}

if (!function_exists('ltxGetTeamCats')) {
	function ltxGetTeamCats() {

		$taxonomy     = 'team-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 1;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {

			if ($cat->category_parent == 0) {

			    $cats[$cat->term_id]['href'] = get_term_link($cat->slug, 'team-category');
			    $cats[$cat->term_id]['name'] = $cat->name;
			}
				else {

			    $cats[$cat->category_parent]['child'][$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'team-category'),
			    	'name' => $cat->name,
			    );		    
			}
		}	

		return $cats;
	}
}


if (!function_exists('ltxGetAlbumsCats')) {
	function ltxGetAlbumsCats() {

		$taxonomy     = 'albums-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {
			if ( isset($cat->category_parent) AND $cat->category_parent == 0) {
			    $category_id = $cat->term_id;       
			    $cats[$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'albums-category'),
			    	'name' => $cat->name,
			    );
			}       
		}	

		return $cats;
	}
}

if (!function_exists('ltxGetSlidersCats')) {
	function ltxGetSlidersCats() {

		$taxonomy     = 'sliders-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {
			if ($cat->category_parent == 0) {
			    $category_id = $cat->term_id;       
			    $cats[$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'sliders-category'),
			    	'name' => $cat->name,
			    );
			}       
		}	

		return $cats;
	}
}

if (!function_exists('ltxGetPortfolioCats')) {
	function ltxGetPortfolioCats() {

		$taxonomy     = 'portfolio-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {
			if ( isset($cat->category_parent) AND $cat->category_parent == 0) {
			    $category_id = $cat->term_id;       
			    $cats[$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'portfolio-category'),
			    	'name' => $cat->name,
			    );
			}       
		}	

		return $cats;
	}
}



if (!function_exists('ltxGetTestimonailsCats')) {
	function ltxGetTestimonailsCats() {

		$taxonomy     = 'testimonials-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {
			if ($cat->category_parent == 0) {
			    $category_id = $cat->term_id;       
			    $cats[$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'testimonials-category'),
			    	'name' => $cat->name,
			    );
			}       
		}	

		return $cats;
	}
}

if (!function_exists('ltxGetServicesCats')) {
	function ltxGetServicesCats() {

		$taxonomy     = 'services-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {
			if ($cat->category_parent == 0) {
			    $category_id = $cat->term_id;       
			    $cats[$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'services-category'),
			    	'name' => $cat->name,
			    );
			}       
		}	

		return $cats;
	}
}


if (!function_exists('ltxGetGalleryCats')) {
	function ltxGetGalleryCats() {

		$taxonomy     = 'gallery-category';
		$orderby      = 'name';  
		$show_count   = 0;
		$pad_counts   = 0;
		$hierarchical = 1;
		$title        = '';  
		$empty        = 0;

		$args = array(
		     'taxonomy'     => $taxonomy,
		     'orderby'      => $orderby,
		     'show_count'   => $show_count,
		     'pad_counts'   => $pad_counts,
		     'hierarchical' => $hierarchical,
		     'title_li'     => $title,
		     'hide_empty'   => $empty
		);

		$cats = array();
		$all_categories = get_terms( $args );
		foreach ($all_categories as $cat) {
			if ($cat->category_parent == 0) {
			    $category_id = $cat->term_id;       
			    $cats[$cat->term_id] = array(

			    	'href' => get_term_link($cat->slug, 'gallery-category'),
			    	'name' => $cat->name,
			    );
			}       
		}	

		return $cats;
	}
}

