<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Zoom Slider Shortcode
 */

$args = get_query_var('like_sc_parallax_slider');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$image = ltx_get_attachment_img_url($atts['image']);
$image_bg = ltx_get_attachment_img_url($atts['image_bg']);
$header = $atts['header'];


?>
<div class="ltx-home-slider">
	<div class="ltx-slider-inner"><?php echo do_shortcode( $content ); ?></div>
	<div class="ltx-parallax-slider">
		
		<div data-depth="0.6" class="ltx-layer header-bg">
			<?php if ( !empty($header) ): ?><h2><?php echo wp_kses_post( nl2br($header) ); ?></h2><?php endif; ?>
		</div>
		<?php if ( !empty($image) ): ?>
		<div data-depth="0.3" class="ltx-layer ltx-floating-image">
			<img class="" alt="bg" src="<?php echo esc_url($image[0]); ?>" >
		</div>		
		<?php endif; ?>
		<?php if ( !empty($image_bg) ): ?>
		<div data-depth="0.5" class="ltx-layer ltx-floating-image-bg">
			<img class="" alt="bg" src="<?php echo esc_url($image_bg[0]); ?>" >
		</div>		
		<?php endif; ?>
	</div>	
</div>