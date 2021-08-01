<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Zoom Slider Shortcode
 */

$args = get_query_var('like_sc_zoom_slider');

$class = array();
if ( !empty($args['class']) ) $class[] = ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class[] = ' zoom-'. esc_attr($atts['zoom']);
$class[] = ' zoom-style-'. esc_attr($atts['style']);
$class[] = ' zoom-origin-'. esc_attr($atts['zs_origin']);
$class[] = ' ltx-zs-overlay-'. esc_attr($atts['overlay']);
$class[] = ' bullets-'. esc_attr($atts['bullets']);
$class[] = ' zoom-content-effect-' . esc_attr($atts['zs_content_effect']);
$class[] = ' zoom-arrows-'. esc_attr($atts['arrows']);
$class[] = ' zoom-blur-'. esc_attr($atts['blur']);

if ( !empty($atts['margin']) AND $atts['margin'] == 'true' ) {

	$class[] = ' zoom-margin-top ';
}


if ( !empty($atts['shadow']) AND $atts['shadow'] == 'enabled' ) {

	$class[] = ' zoom-shadow';
}

if (!empty($atts['bullets']) AND ( $atts['bullets'] === true OR $atts['bullets'] === 'right' ) ) $atts['bullets'] = 'right';

if ($atts['zoom'] == 'out' OR $atts['zoom'] == 'fade') {

	$init_zoom = '1.0';
}
	else {

	$init_zoom = '1.2';
}

$query_args = array(
	'post_type' => 'sliders',
	'post_status' => 'publish',
	'posts_per_page' => 0,	
);

if ( !empty($args['category_filter']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'sliders-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['category_filter'])),
		)
    );
}

$query = new WP_Query( $query_args );
if ( $query->have_posts() ) {

	$json = array();
	$html = array();
	$key = 0;

	$ltx_custom_css = '';
	while ( $query->have_posts() ) {

		$query->the_post();		

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		if ( !empty($image) ) {

			$json[] = $image[0];
		}
			else {

			$json[] = '';
		}

		$html[] = str_replace('ltx-sr', '', apply_filters('the_content', get_the_content()));

		$shortcodes_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {

		    $ltx_custom_css .= strip_tags( $shortcodes_custom_css );
		}
	}

	wp_add_inline_style( 'zoomslider', $ltx_custom_css );

	$json = json_encode( $json );

	echo '<div class="slider-zoom '. esc_attr( implode(' ', $class) ) .'"'. $id .' data-zs-prev="'. esc_attr( $args['arrow_left'] ) .'" data-zs-next="'. esc_attr( $args['arrow_right'] ) .'" data-zs-overlay="'. esc_attr( $args['overlay'] ) .'" data-zs-initzoom="'. esc_attr( $init_zoom ) .'" data-zs-speed="'. esc_attr($args['zs_speed']) .'" data-zs-interval="'. esc_attr($args['zs_interval']) .'" data-zs-switchSpeed="7000" data-zs-arrows="'.esc_attr($atts['arrows']).'" data-zs-bullets="'.esc_attr($atts['bullets']).'" data-zs-src=\''. filter_var( $json, FILTER_SANITIZE_SPECIAL_CHARS ) .'\'>';

		if ( !empty($atts['social']) AND $atts['social'] === 'true' ) {

			echo do_shortcode('[ltx-social]');
		}

		echo '<div class="container ltx-zs-slider-wrapper">';
			
			foreach ( $html as $key => $item ) {

				if ( $key == 0 ) $class = ' inited visible '; else $class = '';
				echo '<div class="ltx-zs-slider-inner '.$class.' ltx-zs-slide-'.esc_attr($key).'" data-index="'.esc_attr($key).'">';
					echo $item;
				echo '</div>';				
			}

		echo '</div>';

		if ( !empty($args['arrow_down']) ) {

			echo '<span class="ltx-arrow-down"></span>';
		}
	echo '</div>';
	
}

?>
