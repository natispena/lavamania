<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Display
 */

$args = get_query_var('like_sc_parallax_image');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$image = ltx_get_attachment_img_url($atts['image']);
$image2 = ltx_get_attachment_img_url($atts['image2']);

$style = array();

if ( $args['type'] == 'single' ):

	if ( !empty($args['top']) OR $args['top'] === '0' ) $style[] = 'top: '.esc_attr($args['top']).';';
	if ( !empty($args['left']) OR $args['left'] === '0' ) $style[] = 'left: '.esc_attr($args['left']).';';
	if ( !empty($args['right']) OR $args['right'] === '0' ) $style[] = 'right: '.esc_attr($args['right']).';';
	if ( !empty($args['bottom']) OR $args['bottom'] === '0' ) $style[] = 'bottom: '.esc_attr($args['bottom']).';';

	if ( !empty( $style ) ) $style = ' style="'.implode($style).'" '; else $style = '';

	?>
	<div data-factor="<?php echo esc_attr($atts['factor']); ?>" data-direction="<?php echo esc_attr($atts['direction']); ?>" <?php echo $style; ?> class="ltx-scroll-parallax <?php echo esc_attr($class); ?>" <?php echo $id; ?>>
		<img alt="ltx-parallax-layer" src="<?php echo esc_url($image[0]); ?>" >
	</div>
<?php
else:

	$style[] = 'min-height: '.esc_attr($image[2]).'px;';

	if ( !empty( $style ) ) $style = ' style="'.implode($style).'" '; else $style = '';

	?>
	<div class="ltx-split-parallax"  <?php echo $style; ?>>
		<div data-factor="0.15" data-direction="vertical" class="ltx-scroll-parallax ltx-scroll-parallax-foreground <?php echo esc_attr($class); ?>" <?php echo $id; ?>>
			<img alt="ltx-parallax-layer" src="<?php echo esc_url($image[0]); ?>" >
		</div>
	</div>
<?php
endif;
?>