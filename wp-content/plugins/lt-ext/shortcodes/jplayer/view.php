<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

$args = get_query_var('like_sc_jplayer');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';


$image = ltx_get_attachment_img_url($atts['image']);

$items = array();
if ( !empty( $atts['items']) ) {

	foreach ( $atts['items'] as $item ) {

		if ( !empty($item['image']) ) {

			$image = ltx_get_attachment_img_url($item['image']);
		}

		$items[] = array(

			'title'	=>	esc_html($item['title']).'<span>'.esc_html($item['author']).'</span>',
			'file'	=>	esc_url(wp_get_attachment_url($item['file'])),
			'poster'	=>	$image[0],
		);
	}
}

$items = json_encode($items);
$rand = mt_rand();

echo '
<div id="ltx-tracks-player-'.esc_attr(mt_rand()).'" class="ltx-tracks-player" role="application" aria-label="media player" data-items="'.filter_var( $items, FILTER_SANITIZE_SPECIAL_CHARS ) .'">
	<div class="ltx-type-playlist">
		<div id="jquery_jplayer_'.esc_attr($rand).'" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-details">
				<div class="jp-title">&nbsp;</div>
			</div>				
			<div class="jp-interface">	
				<div class="jp-timeline">
					<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>	
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-previous" tabindex="0">previous</button>
						<button class="jp-play" tabindex="0">play</button>
						<button class="jp-pause" tabindex="0">pause</button>
						<button class="jp-next" tabindex="0">next</button>
					</div>				
				</div>
				<div class="jp-volume-controls">
					<button class="jp-mute" tabindex="0">mute</button>
					<button class="jp-unmute" tabindex="0">unmute</button>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				</div>					
			</div>
		</div>
		<div class="jp-playlist">
			<ul>
				<!-- The method Playlist.displayPlaylist() uses this unordered list -->
				<li></li>
			</ul>
		</div>
	</div>
</div>
';

