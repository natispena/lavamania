<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * LT-Ext Dashboard Page
 */

if ( !function_exists('ltx_enqueue_admin_styles') ) {

	function ltx_enqueue_admin_styles() {   

		ltx_wp_enqueue('style', 'ltx-dashboard', 'assets/css/lt-ext.css');
	}
}

if ( is_admin() ) {

	add_action('admin_enqueue_scripts', 'ltx_enqueue_admin_styles');
}

if (!function_exists('ltx_custom_framework_settings_menu')) {

    function ltx_custom_framework_settings_menu($data) {
            add_submenu_page(
            	'ltx-dashboard',
                esc_html__( 'Theme Settings', 'lt-ext' ),
                esc_html__( 'Theme Settings', 'lt-ext' ),
                $data['capability'],
                $data['slug'],
                $data['content_callback']
            );	
    }

	add_action('fw_backend_add_custom_settings_menu', 'ltx_custom_framework_settings_menu');
}

if ( !function_exists('ltx_custom_remove_demo_link') ) {

	function ltx_custom_remove_demo_link() {

	}

	add_action( 'admin_menu', 'ltx_custom_remove_demo_link', 1000);
}


if ( !function_exists( 'ltx_dashboard_init' ) ) {

	function ltx_dashboard_init() {

		$theme = wp_get_theme();
			
		add_menu_page(
			esc_html__( 'Like Themes', 'lt-ext' ),
			esc_html__( 'Like Themes', 'lt-ext' ),
			'install_themes',
			'ltx-dashboard',
			'ltx_dashboard',
			LTX_PLUGIN_URL . '/assets/images/favicon.png',
			4
		);

		remove_menu_page(wp_get_theme()->get('TextDomain') . '_welcome');
	}

	add_action( 'admin_menu', 'ltx_dashboard_init' );
}


if ( !function_exists( 'ltx_plugin_activated' ) ) {

	function ltx_plugin_activated( $plugin ) {

        update_option( 'ltx_plugin_activated', 1 );
	}	
}


if ( !function_exists( 'ltx_plugin_open' ) ) {

	function ltx_plugin_open() {

		if ( is_admin() && get_option( 'ltx_plugin_activated' ) == 1 ) {

			update_option( 'ltx_plugin_activated', 0 );

			wp_safe_redirect( admin_url() . 'admin.php?page=ltx-dashboard' );
			exit;
		}
		
	}

	add_action( 'admin_init', 'ltx_plugin_open', 1000 );
}

/**
 * Generating output of LTX Dashboard
 */
if ( !function_exists( 'ltx_dashboard' ) ) {

	function ltx_dashboard() {

		$theme = wp_get_theme(get_template());

		echo '<div class="wrap">';

			$logo = get_template_directory_uri() . '/screenshot.png';

			echo '<h1>'.esc_html__( 'Welcome to', 'lt-ext' ).' '.esc_html($theme->name).'</h1>';
			echo '<div class="ltx-admin-section">';

				echo '<img src="'.esc_attr($logo).'" class="ltx-theme-logo" />';

				echo '<h2 class="ltx-theme-header">'.esc_html__( 'Welcome to', 'lt-ext' ).' '.esc_html($theme->name).' '.esc_html($theme->version).'</h2>';
				echo '<p class="align-center">'.esc_html__( 'Thank you for choosing our theme. Here we will help you with basic installation and configuration.', 'lt-ext' ).'</p>';

				$debug = false;

				/**
				 * Status 4 is ok and skip
				 * Status 3 is ok
				 * Status 2 is warning
				 * Status 1 is error
				 */
				$items[] = array(

					'header'	=>	esc_html__( 'WordPress Version', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s',
						esc_html__( 'Your WordPress version is outdated. Due to the security and compatability reasons it is recommended to use 5.x version.', 'lt-ext' )
					),
					'value'		=>	get_bloginfo('version'),
					'func'		=>	function() { 
						if ( get_bloginfo('version') < 5 ) {
							return 2;
						} elseif ( get_bloginfo('version') < 4 ) {
							return 1;
						} else {
							return 3;
						}
					}
				);

				$items[] = array(

					'header'	=>	esc_html__( 'PHP Version', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>. %4$s',
						esc_html__( 'Your PHP version is lower than recommended by ', 'lt-ext' ),
						esc_url( '//wordpress.org/about/requirements/' ),
						esc_html__( 'WordPress requirements', 'lt-ext' ),
						esc_html__( 'Due to the security and compatability reasons it is recommended to use 7.x version.', 'lt-ext' )
					),
					'value'		=>	phpversion(),
					'func'		=>	function() { 
						if ( phpversion() < 5.6 ) {
							return 1;
						} elseif ( phpversion() < 7 ) {
							return 2;
						} else {
							return 3;
						}
					}
				);

				$items[] = array(

					'header'	=>	esc_html__( 'PHP Multibyte Extension', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>.',
						esc_html__( 'Multibyte Extension is recommend to support UTF-8 encoding in theme and plugins. If you are using hosting panel you can try to enable it in ', 'lt-ext' ),
						esc_url( '//www.google.com/search?q=php+multibyte+extension+install+hosting' ),
						esc_html__( 'settings', 'lt-ext' )
					),
					'value'		=>	'+',
					'func'		=>	function() { 
						if ( extension_loaded('mbstring') ) {
							return 3;
						} else {
							return 2;
						}
					}
				);			

				$items[] = array(

					'header'	=>	esc_html__( 'PHP ZIP Module', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>.',
						esc_html__( 'Demo content installation requires Zip Module on your server. If you are using Cpanel you can try to enable it in ', 'lt-ext' ),
						esc_url( '//www.google.com/search#q=hosting+enable+php+zip' ),
						esc_html__( 'settings', 'lt-ext' )
					),
					'value'		=>	'+',
					'func'		=>	function() { 
						if ( extension_loaded('zip') ) {
							return 3;
						} else {
							return 1;
						}
					}
				);				

				$items[] = array(

					'header'	=>	esc_html__( 'LiteSpeed Server', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>. %4$s',
						esc_html__( 'Your website is hosted using the LiteSpeed web server. Please consult this', 'lt-ext' ),
						esc_url( '//like-themes.com/litespeed.html' ),
						esc_html__( 'article', 'lt-ext' ),
						esc_html__( 'if you have problems with Demo Content installation.', 'lt-ext' )
					),
					'value'		=>	'',
					'func'		=>	function() { 
						if ( isset( $_SERVER['SERVER_SOFTWARE'] ) && strpos( $_SERVER['SERVER_SOFTWARE'], 'LiteSpeed' ) !== false ) {

							if ( ! is_file( ABSPATH . '.htaccess' ) || ! preg_match( '/noabort/i', file_get_contents( ABSPATH . '.htaccess' ) ) ) {

								return 1;
							}

							return 2;
						} else {
							return 4;
						}
					}
				);	

				$items[] = array(

					'header'	=>	esc_html__( 'Unyson', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>%4$s',
						esc_html__( 'Unyson plugin is required for full theme functionality. Please install and activate it in', 'lt-ext' ),
						esc_url( admin_url() . 'plugins.php' ),
						esc_html__( 'plugins', 'lt-ext' ),
						esc_html__( ' menu.', 'lt-ext' )
					),
					'value'		=>	'+',
					'func'		=>	function() { 
						if ( !ltx_plugin_is_active('unyson') ) {
							return 1;
						} else {
							return 3;
						}
					}
				);	

				$items[] = array(

					'header'	=>	esc_html__( 'Unyson Backup Extension', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>%4$s',
						esc_html__( 'Unyson Backup Extension is required for demo content installation. Please install and activate it in', 'lt-ext' ),
						esc_url( admin_url() . 'admin.php?page=fw-extensions' ),
						esc_html__( 'Unyson', 'lt-ext' ),
						esc_html__( ' menu.', 'lt-ext' )
					),
					'value'		=>	'+',
					'func'		=>	function() { 
						if ( !function_exists('FW') OR !fw()->extensions->get('backups') ) {
							return 1;
						} else {
							return 3;
						}
					}
				);		

				$items[] = array(

					'header'	=>	esc_html__( 'Curl Extension', 'lt-ext' ),
					'warning'	=>	esc_html__( 'Curl extension is required for LT-Booking plugin in case you are planning to use payment gateways. You need to contact hosting support regarding this issue or try to enable it in your hosting panel.', 'lt-ext' ),
					'value'		=>	'+',
					'func'		=>	function() { 
						if ( !in_array('curl', get_loaded_extensions()) ) {
							return 1;
						} else {
							return 3;
						}
					}
				);	

				$items[] = array(

					'header'	=>	esc_html__( 'WPBakery Page Builder', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>%4$s',
						esc_html__( 'WPBakery Page Builder is strongly recommended for the full functionality of the theme. Please install and activate it in', 'lt-ext' ),
						esc_url( admin_url() . 'plugins.php' ),
						esc_html__( 'plugins', 'lt-ext' ),
						esc_html__( ' menu.', 'lt-ext' )
					),
					'value'		=>	'+',
					'func'		=>	function() { 
						if ( !ltx_plugin_is_active('unyson') ) {
							return 1;
						} else {
							return 3;
						}
					}
				);						

				$items[] = array(

					'header'	=>	esc_html__( 'PHP post_max_size', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>. %4$s',
						esc_html__( 'Minimum 32M is recommended. You can try to change it with ', 'lt-ext' ),
						esc_url( admin_url() . '//wordpress.org/plugins/custom-php-settings/' ),
						esc_html__( ' Custom PHP Settings plugin', 'lt-ext' ),
						esc_html__( "If it don't help you need to contact your hosting support.", 'lt-ext' )
					),
					'value'		=>	ini_get('post_max_size'),
					'func'		=>	function() { 
						if ( (int)(ini_get('post_max_size')) < 32) {
							return 1;
						} else {
							return 3;
						}
					}
				);	

				$items[] = array(

					'header'	=>	esc_html__( 'PHP upload_max_filesize', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>. %4$s',
						esc_html__( 'Minimum 32M is recommended. You can try to change it with ', 'lt-ext' ),
						esc_url( admin_url() . '//wordpress.org/plugins/custom-php-settings/' ),
						esc_html__( ' Custom PHP Settings plugin', 'lt-ext' ),
						esc_html__( "If it don't help you need to contact your hosting support.", 'lt-ext' )
					),
					'value'		=>	ini_get('upload_max_filesize'),
					'func'		=>	function() { 
						if ( (int)(ini_get('upload_max_filesize')) < 32) {
							return 1;
						} else {
							return 3;
						}
					}
				);	
				$items[] = array(

					'header'	=>	esc_html__( 'PHP max_execution_time', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>. %4$s',
						esc_html__( 'Minimum 600 is recommended to install demo content. You can try to change it with ', 'lt-ext' ),
						esc_url( admin_url() . '//wordpress.org/plugins/custom-php-settings/' ),
						esc_html__( ' Custom PHP Settings plugin', 'lt-ext' ),
						esc_html__( "If it don't help you need to contact your hosting support.", 'lt-ext' )
					),
					'value'		=>	ini_get('max_execution_time'),
					'func'		=>	function() { 
						if ( (int)(ini_get('max_execution_time')) < 600) {
							return 1;
						} else {
							return 3;
						}
					}
				);	
				$items[] = array(

					'header'	=>	esc_html__( 'PHP memory_limit', 'lt-ext' ),
					'warning'	=>	sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>. %4$s',
						esc_html__( 'Minimum 128M is recommended. You can try to change it with ', 'lt-ext' ),
						esc_url( admin_url() . '//wordpress.org/plugins/custom-php-settings/' ),
						esc_html__( ' Custom PHP Settings plugin', 'lt-ext' ),
						esc_html__( "If it don't help you need to contact your hosting support.", 'lt-ext' )
					),
					'value'		=>	ini_get('memory_limit'),
					'func'		=>	function() { 
						if ( (int)(ini_get('memory_limit')) < 128) {
							return 1;
						} else {
							return 3;
						}
					}
				);								

				echo '<div class="align-center">';
					echo '<h3 class="ltx-theme-header">'.esc_html__( 'System check', 'lt-ext' ).'</h2>';
					echo '<table class="ltx-ul">';

						$status_error = false;
						foreach ( $items as $item ) {

							$status = call_user_func($item['func']);

							if ( !empty( $debug) AND $status == 3 ) {

								$status = mt_rand(1,3);
							}

							if ( $status == 4 ) continue;

							if ( $status < 3 AND $item['value'] == '+' ) {

								$item['value'] = '<span class="not-found">-</span>';
							}
								else
							if ( $item['value'] == '+' ) {

								$item['value'] = '';
							}

							if ( $status < 3 ) $status_error = true;

							$class = 'ltx-status-'.$status;

							echo '<tr class=" '.esc_attr($class).'">';
								echo '<td class="ltx-header">'.$item['header'];'</td>';
								echo '<td class="ltx-value">'.$item['value'].'</td>';
								echo '<td class="ltx-stat"></td>';

							echo '<td class="ltx-warning">';

							if ( $status < 3 ) {
							
								echo $item['warning'];
							}			

							echo '</td>';

							echo '</tr>';		
						}

					echo '</table>';

					if ( !empty($status_error) ) {

						echo '<div class="ltx-notice">';
							echo esc_html__( 'Please note that WordPress and the theme could work on any configuration. All notices are only recommendations, but if you are experiencing any issues with demo content installation or the site, we recommend to check the table above. If you could not fix the server side issues by yourself, you need to contact hosting support and ask for help.', 'lt-ext' );
						echo '</div>';
					}

				echo '</div>';

				echo '<div class="ltx-helpers">';

					echo '<div class="ltx-item"><div class="ltx-inner">';
						echo '<h4>'.esc_html__( 'First steps' ).'</h4>';
						echo '<ol>';
							echo '<li>
								<a href="'.esc_url( admin_url() . 'tools.php?page=fw-backups-demo-content' ).'" target="_blank">'.esc_html__( 'Demo content installation', 'lt-ext' ).'</a><br>
								<span>('.wp_kses_post( 'if you experiencing difficulties check <a href="https://www.youtube.com/watch?v=D_NCgpiGckI" target="_blank">this video</a>, it suits any our theme', 'lt-ext' ).') </span>
							</li>';
							echo '<li><a href="'.esc_url( admin_url() . 'admin.php?page=fw-settings' ).'" target="_blank">'.esc_html__( 'Theme Settings', 'lt-ext' ).'</a></li>';
							echo '<li><a href="'.esc_url( admin_url() . 'customize.php' ).'" target="_blank">'.esc_html__( 'Color Customization', 'lt-ext' ).'</a>
								<span>'.wp_kses_post( '- '.esc_attr(wp_get_theme()->get('Name')).' Colors', 'lt-ext' ).' </span>
							</li>';
							echo '<li><a href="'.esc_url( admin_url() . 'customize.php' ).'" target="_blank">'.esc_html__( 'Favicon', 'lt-ext' ).'</a>
								<span>'.wp_kses_post( '- Site Identify', 'lt-ext' ).' </span>
							</li>';
						echo '</ol>';
					echo '</div></div>';			

					echo '<div class="ltx-item"><div class="ltx-inner">';
						echo '<h4>'.esc_html__( 'Documentation' ).'</h4>';
						echo '<p>'.wp_kses_post( 'If you have any issues please check the <a href="'.esc_url(wp_get_theme()->get('ThemeURI')).'documentation/" target="_blank">documentation of the theme</a>.', 'lt-ext' ).'</a></p>';
					echo '</div></div>';

					echo '<div class="ltx-item"><div class="ltx-inner">';
						echo '<h4>'.esc_html__( 'Support', 'lt-ext' ).'</h4>';
						echo '<p>'.wp_kses_post( 'If you have any issues with the theme please contact our support team by <a href="mailto:like.themes.wp@gmail.com" target="_blank">like.themes.wp@gmail.com.', 'lt-ext' ).'</a>.</p>';
						echo '<p>'.wp_kses_post( 'Check <a href="//themeforest.net/page/item_support_policy" class="_target">Envato Support Policy</a> regarding what is included into support. You also need to provide <a href="//help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">purchase code</a>.', 'lt-ext' ).'</p>';
						echo '<p>'.wp_kses_post( 'Please check the <a href="'.esc_url(wp_get_theme()->get('ThemeURI')).'/documentation/" target="_blank">documentation</a> before contacting us. According to the policy support response time can be up to <strong>2 business days</strong>.', 'lt-ext' ).'</p>';
					echo '</div></div>';		
						
				echo '</div>';


			echo '</div>';
		echo '</div>';
	}
}

