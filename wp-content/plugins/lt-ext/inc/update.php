<?php

add_action( 'vc_before_init', 'ltx_vcSetAsTheme' );

function ltx_vcSetAsTheme() {

    vc_set_as_theme();
}

add_filter( 'pre_transient__wc_activation_redirect', 'ltx_vc_disable_welcome' );
add_filter( 'pre_transient__vc_page_welcome_redirect',  'ltx_vc_disable_welcome' );

function ltx_vc_disable_welcome() {

    return 0;
}

add_action( 'admin_init', 'ltx_vc_disable_update', 99 );

function ltx_vc_disable_update() {

	$vc_updater = false;
	$vc_auto_updater = false;

    global $vc_manager;

    if ($vc_manager && function_exists('vc_plugin_name')) {

        $vc_updater = $vc_manager->updater();

        if ($vc_updater) {

            $vc_auto_updater = $vc_updater->updateManager();

            if ($vc_auto_updater) {

                remove_action('in_plugin_update_message-' . vc_plugin_name(), array($vc_auto_updater, 'addUpgradeMessageLink'));
                remove_filter('upgrader_pre_download', array($vc_updater, 'upgradeFilterFromEnvato'), 10);
            }
        }
    }
}

add_filter('site_transient_update_plugins', 'ltx_push_update', 100 );
function ltx_push_update( $transient ){

	global $wp_filter;


	if ( empty($transient->checked ) ) {

        return $transient;
	}

	if ( ! function_exists( 'get_plugins' ) ) {
	    require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	 
	$all_plugins = get_plugins();
 
	$plugins = [

		'js_composer/js_composer.php'	=>	'http://updates.like-themes.com/plugins/js_composer/info.json',
		'unyson/unyson.php'	=>	'http://updates.like-themes.com/plugins/unyson/info.json',
	];

	foreach ( $plugins as $plugin => $json ) {

		$slug = explode( '/', $plugin );
		$slug = $slug[0];

		if ( false == $remote = get_transient( 'ltx_upgrade_' . $slug ) ) {
	 
			$remote = wp_remote_get( $json, array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				) )
			);
	 
			if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
				
	            set_transient( 'ltx_upgrade_' . $slug, $remote, 43200 );
			}
		}
	 
		if ( !empty($remote['body']) ) {

			$remote = json_decode($remote['body']);

			$plugin_data = $all_plugins[$plugin];

			if ( $remote && version_compare( $plugin_data['Version'], $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {

				$res = new stdClass();
				$res->slug = $slug;
				$res->plugin = $plugin;
				
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = $remote->download_url;           	
	           	$transient->response[$res->plugin] = $res;
			}
	 
		}
	}


	return $transient;
}


