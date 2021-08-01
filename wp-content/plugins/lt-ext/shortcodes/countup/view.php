<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * CountUp Shortcode
 */

$args = get_query_var('like_sc_countup');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( $args['animation'] == 'ltx-circle' ) {

}
	else {

	$class .= ' layout-'.esc_attr($args['type']);
}

$class .= ' animation-'.esc_attr($args['animation']);

$class .= ' style-'.esc_attr($args['style']);
$style = 'style-'.esc_attr($args['style']);


echo '<div class="ltx-countup '.esc_attr($class).'"'.$id.'>';
	echo '<div class="row">';

		$div_class = '';
		if ( sizeof($atts['list']) == 6 ) $div_class = ' col-md-2 ';
			else
		if ( sizeof($atts['list']) == 4 ) $div_class = ' col-lg-3 col-md-6 col-ms-12  col-xs-12 ';
			else
		if ( sizeof($atts['list']) == 3 ) $div_class = ' col-md-4 ';
			else
		if ( sizeof($atts['list']) == 2 ) $div_class = ' col-md-6 col-xs-12 ';

		foreach ( $atts['list'] as $k => $item ) {


			if ( !empty($item['descr']) ) {

				$div_class .= ' hasDescr';
			}

			$item['header'] = str_replace(array('{{', '}}'), array('<span>', '</span>'), $item['header']);
			if ( !empty($item['prefix']) ) $prefix = $item['prefix']; else $prefix = '';
			if ( !empty($item['postfix']) ) $postfix = $item['postfix']; else $postfix = '';

			$canvas = $mh = '';
			if ( $args['animation'] == 'default' ) {

				$item_class = 'countUp';
			}
				else
			if ( $args['animation'] == 'static' ) {

				$item_class = '';
			}
				else				
			if ( $args['animation'] == 'ltx-circle' ) {

				$item_class = 'countUp';
				$mh = '';
				$canvas = '<canvas id="'.esc_attr($args['id']).'-'.mt_rand(1000,9999).'-canvas" width="200" height="200"></canvas><div class="ltx-chart-doughnut '.esc_attr($style).'" data-percent="'.esc_attr($item['number']).'"></div>';
			}

			if ( $args['animation'] == 'ltx-circle' ) {

				echo '
					<div class="'.esc_attr($div_class).' col-sm-6 col-xs-12 center-flex countUp-wrap">
						<div class=" countUp-item item" '.$mh.'>
							<div class="ltx-canvas">
								'.$canvas.'
								<h2 class="header">'.esc_html($prefix).'<span class="'.esc_attr($item_class).'" id="'.esc_attr( $args['id'].'-'.$k ).'">'.esc_html($item['number']).'</span>'.esc_html($postfix).'</h2>
							</div>
							<div class="descr-wrapper">
								<h4 class="subheader">'.wp_kses_post($item['header']).'</h4>';
								if ( !empty($item['descr']) ) {


									echo '<div class="descr">'.wp_kses_post($item['descr']).'</div>';
								}

							echo '</div>';
						echo '</div>					
					</div>';
			}
				else {

				echo '
					<div class="'.esc_attr($div_class).' col-sm-6 col-ms-6 col-xs-12 center-flex countUp-wrap">
						<div class=" countUp-item item" '.$mh.'>
							<h2 class="header">'.esc_html($prefix).'<span class="'.esc_attr($item_class).'" id="'.esc_attr( $args['id'].'-'.$k ).'">'.esc_html($item['number']).'</span>'.esc_html($postfix).'</h2>
							<h4 class="subheader">'.wp_kses_post($item['header']).'</h4>';
							if ( !empty($item['descr']) ) echo '<div class="descr">'.wp_kses_post($item['descr']).'</div>';
						echo '</div>					
					</div>';
			}
		}


	echo '</div>';
echo '</div>';

