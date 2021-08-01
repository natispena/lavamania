<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Block Icons Shortcode
 */

if ( !empty($atts['header_type']) ) $tag = 'h'.$atts['header_type']; else $tag = 'h5';

$class = '';
if ( !empty($atts['class']) ) $class .= ' '. esc_attr($atts['class']);
if ( !empty($atts['id']) ) $id = ' id="'. esc_attr($atts['id']). '"'; else $id = '';

$mid = mt_rand(1000, 2000);
$icons_count = sizeof($atts['icons']);

$row = '';
if ($atts['layout'] == 'layout-cols2' OR $atts['layout'] == 'layout-cols3' OR $atts['layout'] == 'layout-cols4' OR $atts['layout'] == 'layout-cols6') {

	$row .= ' row centered';
}

if ( $atts['layout'] == 'layout-cols3-colored' ) {

	$atts['layout'] = 'layout-cols3';
	$class .= ' ltx-colored-icons ';
}

foreach ( $atts['icons'] as $item ) {

	if ( !empty($item['descr']) ) {

		$class .= ' has-descr ';

		break;
	}	
}

$ul_class = array();
$ul_class[] = $class;
$ul_class[] = 'icons-count-' . $icons_count;
$ul_class[] = 'align-' . $atts['align'];
$ul_class[] = 'ltx-icon-color-' . $atts['icon-color'];
$ul_class[] = 'ltx-icon-size-' . $atts['icon-size'];
$ul_class[] = 'ltx-header-color-' . $atts['header-color'];
$ul_class[] = 'ltx-icon-type-' . $atts['icon-type'];
$ul_class[] = 'ltx-bg-color-'.$atts['bg-col'];
$ul_class[] = $atts['layout'];
$ul_class[] = $atts['type'];
$ul_class[] = $row;

if ( !empty($atts['icon-div']) ) {

	$ul_class[] = 'ltx-icon-div-enabled';
} 


echo '<ul class="ltx-block-icon '.esc_attr(implode(' ', $ul_class)).'" '.$id.'>';

	$x = 0;
	foreach ( $atts['icons'] as $item ) {

		$x++;
		$li_class = '';

		if ($atts['layout'] == 'layout-cols2') {

			$li_class .= 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12';
		}
			else
		if ($atts['layout'] == 'layout-cols3') {

			$li_class .= ' col-lg-4 col-md-4 col-sm-4 col-ms-4 col-xs-6';
		}
			else
		if ($atts['layout'] == 'layout-cols4') {

			if ( $atts['icon-type'] == 'circle') {

				$li_class .= ' col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12';
			}
				else
			if ( $icons_count == 4) {

				$li_class .= ' col-lg-3 col-md-3 col-sm-6 col-ms-6 col-xs-6';
			}
				else {

				$li_class .= ' col-lg-3 col-md-4 col-sm-6 col-ms-6 col-xs-6';
			}
		}
			else
		if ($atts['layout'] == 'layout-cols6') {

			if ($icons_count == 6 AND $atts['type'] == 'ltx-icon-top' ) {

				$li_class .= ' col-xl-2 col-lg-4 col-md-4 col-sm-4 col-ms-6 col-xs-12 ';
			}
				else
			if ( $icons_count == 6) {
				$li_class .= ' col-xl-2 col-lg-4 col-md-4 col-sm-4 col-ms-12 col-xs-12 ';
			}	
				else 
			if ( $icons_count == 4) {

				$li_class .= ' col-lg-3 col-md-3 col-sm-6 col-ms-6  col-xs-6col-xs-12 ';
			}
				else 
			if ( $icons_count == 3) {

				$li_class .= ' col-lg-4 col-md-4 col-sm-4 col-ms-6  col-xs-6col-xs-12 ';
			}
		}

		if (!empty($item['bold']) AND $item['bold'] == 'bold') $li_class .= ' item-bold ';


		if ( empty($item['header'])) {

			$item['header'] = '';
		}

		$item['header'] = str_replace(array('{{', '}}'), array('<span>', '</span>'), $item['header']);

		if (!empty($item['icon_fontawesome'])) {

			$a_class = $item['icon_fontawesome'];
		}
			else
		if (!empty($item['icon_image'])) {

			$a_class = 'ltx-icon-image';
			$li_class .=  ' ltx-icon-image';
		}		
			else {

			$a_class = 'ltx-icon-text';
		}

		if ($atts['layout'] == 'layout-inline') {

			$a_class .= ' ';			
			$in_class = '';
		}
			else {

			$in_class = 'in';
		}


		if ( $atts['type'] == 'ltx-price-grid' ) {

			$in_class = 'in';
			if ( $icons_count == 4 ) {

				$li_class = ' col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12 ';
			}
				else
			if ( $icons_count == 3 ) {

				$li_class = ' col-lg-4  col-md-12  col-sm-12  col-ms-12 col-xs-12';
			}
				else
			if ( $icons_count == 2 ) {

				$li_class = ' col-lg-6 col-md-6 col-sm-12  col-ms-12 col-xs-12';
			}			
		}

		if ( $atts['type'] == 'ltx-grid-hover' ) {

			$in_class = 'in';
			if ( $icons_count == 4 ) {

				$li_class = ' col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12 ';
			}
				else
			if ( $icons_count == 3 ) {

				$li_class = 'col-lg-4 col-md-4 col-sm-12 col-ms-12 col-xs-12';
			}
				else
			if ( $icons_count == 2 ) {

				$li_class = ' col-lg-6 col-md-6 col-sm-12  col-ms-12 col-xs-12';
			}			
		}


		if ( !empty($atts['bg']) ) {

			$a_class .= ' '.esc_attr($atts['bg']);
		}

		if ( !empty($atts['bg-col']) ) $a_class .= ' bg-'.esc_attr($atts['bg-col']);


		$href_tag1 = $href_tag2 = '';
		$div_tag1 = $div_tag2 = '';
		$image_tag = '';

		if ($atts['type'] == 'ltx-icon-ht-right' OR $atts['type'] == 'ltx-icon-ht-left' OR $atts['layout'] == 'layout-inline'  OR $atts['type'] == 'ltx-icon-large-descr') {

			$div_tag1 = '<div class="block-right">';
			$div_tag2 = '</div>';

			if (!empty($item['href'])) {

				$div_tag1 = '</a><a href="'. esc_url( $item['href'] ) .'" class="block-right">';
				$div_tag2 = '</a>';
			}
		}

		if (empty($item['icon_text'])) $item['icon_text'] = '';
		$href_tag1 = '<span class="ltx-icon '. esc_attr( $a_class ) . '">' . esc_html( $item['icon_text'] );
		$href_tag2 = '</span>';

		if ( !empty($item['icon_image']) ) {

			$image = ltx_get_attachment_img_url( $item['icon_image'] );
			$image_tag = '<img src="' . $image[0] . '" class="ltx-icon-image" alt="'.esc_attr($item['header']).'">';
			$image_src = $image[0];
		}

		if ( !empty($item['header']) ) {

			if ( $atts['header_type'] == 'text-small' ) {

				$item['header'] = ' <strong class="ltx-header"> ' . wp_kses_post( nl2br($item['header']) )  .  ' </strong> ';
			}
				else {

				$item['header'] = ' <'. esc_attr($tag) .' class="header"> ' . wp_kses_post( nl2br($item['header']) )  .  ' </'. esc_attr($tag) .'> ';
			}
		}

		if ( empty($item['descr'])) $item['descr'] = '';

		if ($atts['layout'] == 'layout-cols3' AND $x == 3) {

			$li_class .= ' ';
		}		

		if ( !empty($li_class) ) $li_class = ' class="'.esc_attr($li_class).'"';

		$descr = '';
		if ( !empty($item['descr']) ) {

			if ( $atts['type'] == 'ltx-icon-top' ) {

				$item['descr'] = nl2br($item['descr']);
			}

			$descr = '<div class="descr">'. wp_kses_post( ltx_header_parse ( $item['descr'] ) ) . '</div>';
		}

		if (!empty($item['href'])) {

			$wrap_tag1 = 'a href="'. esc_url( $item['href'] ) .'" ';
			$wrap_tag2 = '</a>';

			if ( !empty($div_tag2) ) {

				$wrap_tag2 = '';
			}
		}
			else {

			$wrap_tag1 = 'div ';
			$wrap_tag2 = '</div>';
		}

		if ( empty($item['header']) AND empty($descr) ) {

			$div_tag1 = $div_tag2 = '';
		}

		if ( $atts['type'] == 'ltx-grid-hover' ) {

			$bg = '';
			if ( !empty($image_src)) {

				$bg = ' style="background-image: url('.esc_url($image_src).');" ';
			}

			echo '<li'.$li_class.' >
				<div class="in">
					<div class="ltx-flip">
						<div class="side-a"><a href="'. esc_url( $item['href'] ) .'">' . $href_tag1 . $href_tag2 
							. $div_tag1 . $item['header'] . wp_kses_post( $descr ) . $div_tag2 . '
						</a></div>
						<div class="side-b"'.$bg.'><a href="'. esc_url( $item['href'] ) .'">' . $href_tag1 . $href_tag2 
							. $div_tag1 . $item['header'] . wp_kses_post( $descr ) . $div_tag2 . '
						</a></div>						
					</div>
				</div>
			</li>';
		}
			else {

			echo '<li'.$li_class.' ><'.$wrap_tag1.
			'  class="'.esc_attr($in_class).'">' . $href_tag1 . $image_tag . $href_tag2 
			. $div_tag1 . $item['header'] . wp_kses_post( $descr ) . $div_tag2 . $wrap_tag2 . '</li>';
		}
	}

echo '</ul>';


