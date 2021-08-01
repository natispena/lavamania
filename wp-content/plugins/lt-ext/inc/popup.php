<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * LT-Ext Popup message display
 */

if ( !function_exists('ltx_popup_display')) {

	function ltx_popup_display() {   

		$plugin_data = get_plugin_data( __FILE__ );

		$status = fw_get_db_settings_option('popup-status');

		if ( $status === 'enabled' ) {

			$content = fw_get_db_settings_option('popup-text');
			$bg = fw_get_db_settings_option('popup-bg');
			$yes = fw_get_db_settings_option('popup-yes');
			$yes_hours = fw_get_db_settings_option('popup-hours');
			$no = fw_get_db_settings_option('popup-no');
			$no_link = fw_get_db_settings_option('popup-no-link');

			echo '
			<div class="modal fade" id="ltx-modal" tabindex="-1" role="dialog">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content" style="background-image: url('.esc_url($bg['url']).')">
			            '.wp_kses_post($content).'
			            <div class="btns">
				            <span class="ltx-modal-yes btn btn-xs btn-main" data-period="'.esc_attr($yes_hours).'">'.esc_html($yes).'</span>
				            <span class="ltx-modal-no btn btn-xs btn-black color-hover-gray" data-no="'.esc_attr($no_link).'">'.esc_html($no).'</span>
				        </div>
			        </div>
			    </div>
			</div>
			';
		}
			else {

			return false;
		}
	}
}

if ( !function_exists('ltx_popup_init')) {

	function ltx_popup_init() {

		if ( function_exists( 'FW' ) ) {

			add_action('wp_footer', 'ltx_popup_display');
		}
	}
}
add_action( 'init', 'ltx_popup_init', 10 );


