<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * LTB Plugin Functions
 */

/**
 * Get Local Path of include file
 */
if ( !function_exists('ltbGetLocalPath')) {

	function ltbGetLocalPath($file) {

		global $ltb_cfg;

		return $ltb_cfg['path'].$ltb_cfg['base'].$file;
	}
}

/**
 * Get Plugin Url
 */
if ( !function_exists('ltbGetPluginUrl')) {

	function ltbGetPluginUrl($file) {

		global $ltb_cfg;

		return $ltb_cfg['url'].$file;
	}
}

/**
 * Enqueue file with latest version from filemtime
 */
if ( !function_exists('ltb_wp_enqueue')) {

	function ltb_wp_enqueue($type = null, $handle = null, $src = null, $deps = array()) {

		if ( empty($type) OR empty($handle) OR empty($src) ) {

			return false;
		}

		if ( $type == 'script' ) {

			wp_enqueue_script( $handle, ltbGetPluginUrl($src), $deps, filemtime(ltbGetLocalPath('/'.$src)), true );

		}
			else
		if ( $type == 'style' ) {

			wp_enqueue_style( $handle, ltbGetPluginUrl($src), $deps, filemtime(ltbGetLocalPath('/'.$src)) );
		}
	}
}

/**
 * Return current currency symbol
 */
if ( !function_exists('ltb_get_the_currency') ) {

	function ltb_get_the_currency( $config ) {

		return esc_html($config['currency']);
	}
}

/**
 * Display simple price with currency
 */
if ( !function_exists('ltb_the_price') ) {

	function ltb_the_price( $price, $config ) {

		$out = '';
		if ( $config['currency-pos'] == 'before' ) {

			$out .= '<span class="ltb-currency ltb-currency-before">'.ltb_get_the_currency( $config ).'</span>';
		}

		$out .= '<span class="ltb-price-val">'.esc_html($price).'</span>';

		if ( $config['currency-pos'] == 'after' ) {

			$out .= '<span class="ltb-currency ltb-currency-after">'.ltb_get_the_currency( $config ).'</span>';
		}

		return $out;
	}

	function ltb_the_price_simple( $price, $config ) {

		$out = '';
		if ( $config['currency-pos'] == 'before' ) {

			$out .= ltb_get_the_currency( $config );
		}

		$out .= $price;

		if ( $config['currency-pos'] == 'after' ) {

			$out .= ltb_get_the_currency( $config );
		}

		return $out;
	}	
}

/**
 * Display extended price with currency
 */
if ( !function_exists('ltb_the_price_full') ) {

	function ltb_the_price_full( $price, $config ) {

		$price = explode('.', $price);

		$out = '';

		if ( $config['currency-pos'] == 'before' ) {

			$out .= '<span class="ltb-currency ltb-currency-before">'.ltb_get_the_currency( $config ).'</span>';
		}

		$out .= '<span class="ltb-price-val">'.esc_html($price[0]).'</span>';
		if ( sizeof($price) > 1 ) {

			$out .= '<span class="ltb-dec">.'.esc_html($price[1]).'</span>';
		}			


		if ( $config['currency-pos'] == 'after' ) {

			$out .= '<span class="ltb-currency ltb-currency-after">'.ltb_get_the_currency( $config ).'</span>';
		}

		return $out;
	}
}

/**
 * Replaces specials chars in string to span tags
 */
if (!function_exists('ltb_header_parse')) {

	function ltb_header_parse($item) {

		$item = str_replace(array('{{', '}}'), array('<span>', '</span>'), $item);
		$item = str_replace(array('{+}'), array('<span class="ul-yes fa fa-check"></span>'), $item);
		$item = str_replace(array('{-}'), array('<span class="ul-no fa fa-close"></span>'), $item);

		return $item;
	}
}

/**
 * Generates section wrapper start
 */
if (!function_exists('ltb_section_start')) {

	function ltb_section_start( $config, $num ) {

		$bg = '';
		if ( !empty($config['bg-image-'.$num]) ) {

			$bg = ' style="background-image: url('.esc_url($config['bg-image-'.$num]['url']).')"';
		}

		$class = array();
		$class[] = 'ltb-step-'.$num;
		$class[] = 'ltb-section-bg-'.$config['bg-color-'.$num];

		if ( !empty($config['bulb-'.$num]) ) {

			$class[] = 'ltb-bulb ltb-bulb-'.esc_attr($config['bulb-'.$num]);
		}

		if ( !empty($config['bg-repeat-'.$num]) ) {

			$class[] = 'ltb-bg-'.esc_attr($config['bg-repeat-'.$num]);
		}


		$container = 'container';
		if ( !empty($config['container']) AND $config['container'] == 'none' ) {

			$container = 'container-none';
		}

		$out = '<section class="ltb-section '.esc_attr(implode(' ', $class)).'"'.$bg.'>
		<div class="'.esc_attr($container).'">';

			$out .= '
			<div class="heading header-subheader align-center subcolor-main has-subheader heading-tag-h4">
				<h6 class="subheader">'.esc_html($config['subheader-'.$num]).'</h6>
				<h4 class="header">'.esc_html($config['header-'.$num]).'</h4>
			</div>';

			if ( !empty( $config['text-'.$num] ) ) {

				$out .= '<div class="ltb-header-descr">'.esc_html($config['text-'.$num]).'</div>';
			}

		return $out;
	}
}


/**
 * Generates section wrapper end
 */
if (!function_exists('ltb_section_end')) {

	function ltb_section_end( $config, $num ) {

		$out = '
			</div>
			</section>';

		return $out;
	}
}

/**
 * Returns default sections config array
 */
if (!function_exists('ltb_section_config_array')) {

	function ltb_section_config_array( $num ) {

		$array = array(

			'subheader-'.$num    => array(
				'label' => esc_html__( 'Step Header', 'lt-booking' ),
				'type'  => 'text',
			),				
			'header-'.$num    => array(
				'label' => esc_html__( 'Header', 'lt-booking' ),
				'type'  => 'text',
			),
			'text-'.$num    => array(
				'label' => esc_html__( 'Description', 'lt-booking' ),
				'type'  => 'textarea',
			),			
			'bg-color-'.$num => array(
				'label' => esc_html__('Background Color', 'lt-booking'),
				'type' => 'select',
				'choices' => array(

					'white'	=>	esc_html__('White', 'lt-booking'),
					'gray'	=>	esc_html__('Gray', 'lt-booking'),
					'black'	=>	esc_html__('Black', 'lt-booking'),
				),
			),								
			'bg-image-'.$num => array(
				'label' => esc_html__('Background Image', 'lt-booking'),
				'type' => 'upload'
			),			
			'bg-repeat-'.$num => array(
				'label' => esc_html__('Background Repeat', 'lt-booking'),
				'type' => 'select',
				'choices' => array(
					false		=>	esc_html__('No Repeat', 'lt-booking'),
					'cover'		=>	esc_html__('Cover', 'lt-booking'),
					'repeat'	=>	esc_html__('Repeat', 'lt-booking'),
				),								
			),									
			'bulb-'.$num => array(
				'label' => esc_html__('Bottom Bulb', 'lt-booking'),
				'type' => 'select',
				'choices' => array(
					false	=>	esc_html__('Disabled', 'lt-booking'),
					'white'	=>	esc_html__('White', 'lt-booking'),
					'gray'	=>	esc_html__('Gray', 'lt-booking'),
					'black'	=>	esc_html__('Black', 'lt-booking'),
				),								
			),
		);

		return $array;
	}
}

/**
 * Returns array with latest posts
 */
if (!function_exists('ltbGetPosts')) {

	function ltbGetPosts( $type ) {

		$posts = get_posts( array(
			'nopaging'                  => true,
			'post_type' => $type,
			'posts_per_page'	=>	100,
		) );

		$cat = array();

		if ( !empty($posts) ) {

			foreach ( $posts as $post ) {

				$info = fw_get_db_post_option( $post->ID );

				if ( !empty($info['admin-header']) ) {

					$cat[$post->ID] = esc_html($info['admin-header']);
				}
					else {

					$cat[$post->ID] = $post->post_title;
				}
			}
		}

		wp_reset_postdata();

		return $cat;
	}
}

/**
 * Gets all tariffs IDs for all current cars
 */
if (!function_exists('ltbGetTarrifsIds')) {

	function ltbGetTarrifsIds( $config ) {

		$cars = get_posts( array(
			'nopaging'                  => true,
			'post_type' => 'lt-booking-car',
			'post__in'	=>	$config['cars'],
		) );

		$ids = $cat = array();
		if ( !empty( $cars ) ) {

			foreach ( $cars as $car ) {

				$tariff = fw_get_db_post_option( $car->ID );

				$cat[$car->ID] = $tariff['tariffs'];
				$ids = array_merge($ids, $tariff['tariffs']);
			}
		}

		wp_reset_postdata();

		return array( 'cars' => $cat, 'ids' => $ids );
	}
}


/**
 * Generates grid with all total information
 */
if (!function_exists('ltb_the_total_grid')) {

	function ltb_the_total_grid( $config ) {

		$items = array(

			'ltb-booking-type'	=>	'-',
			'ltb-booking-plan'	=>	'',
			'ltb-booking-date'	=>	'-',
			'ltb-booking-time'	=>	'-',
			'ltb-total-time'	=>	'-',
			'ltb-total-price'	=>	'-',
		);

		$out = '';

		if ( empty($config['hours_mode']) ) $config['hours_mode'] = 0;

		$out .= '<div class="ltb-grid" data-thd-sep="'.esc_attr($config['thd_sep']).'" data-hours-mode="'.esc_attr($config['hours_mode']).'" data-hours="'.esc_attr($config['hours']).'" data-minutes="'.esc_attr($config['minutes']).'" data-currency="'.esc_attr($config['currency']).'" data-currency-pos="'.esc_attr($config['currency-pos']).'" data-plan-placeholder="'.esc_attr($config['total-placeholder-2']).'" data-time-placeholder="'.esc_attr($config['total-placeholder-4']).'">';

			$x = 1;
			foreach ( $items as $class => $item) {

				$icon = '';
				if ( !empty($config['total-icon-'.$x])) {

					$icon = ' '.$config['total-icon-'.$x]['icon-class'];
				}

				$style_escaped = '';

				if ( !empty($config['step-02-hidden']) AND ($x == 2) ) {

					 $style_escaped = ' style="display: none;"';
				}				

				if ( !empty($config['step-04-hidden']) AND ($x == 3 OR $x == 4) ) {

					 $style_escaped = ' style="display: none;"';
				}				

				$out .= '<div class="ltb-grid-item" '.$style_escaped.'><div class="ltb-grid-content '.esc_attr($class).'">';
					$out .= '
					<div class="ltb-wrapper">
						<span class="ltb-icon'.esc_attr($icon).'"></span>
						<span class="ltb-header">'.esc_html($config['total-header-' . $x]).'</span>
						<span class="ltb-value">'.esc_html($item).'</span>';
						
						if ( $x == 2 ){

							$out .= '
							<div class="ltb-additional">
								<span class="ltb-plus">+</span>
								<span class="ltb-icon fas fa-cog"></span>
								<div class="ltb-floating">
									<h6 class="header">'.esc_html__('Additional Services', 'lt-booking').'</h6>
									<div class="ltb-list-wrapper">
										<ul class="ltb-list check"></ul>
									</div>
								</div>
							</div>';
						}
					$out .= '</div>
					';
				$out .= '</div></div>';

				$x++;
			}

		$out .= '</div>';

		return $out;
	}
}

/**
 * Generates total form
 */
if (!function_exists('ltb_the_form')) {

	function ltb_the_form( $config, $id ) {

		$out = '';

		$bg = '';
		if ( !empty($config['form-bg-image']) ) {

			$bg = ' style="background-image: url('.esc_url($config['form-bg-image']['url']).')"';
		}

		$out .= '<div class="ltb-form"'.$bg.'>';
			$out .= '<h5 class="header">'.wp_kses_post(ltb_header_parse($config['form-header'])).'</h5>';
			if ( !empty( $config['form-text'] ) ) {

				$out .= '<div class="ltb-header-descr">'.esc_html($config['form-text']).'</div>';
			}

			$out .= '<form id="ltb-booking-form" method="POST" action="">';
				$out .= '
				<input type="hidden" id="ltb-sid" name="ltb-sid" value="'.esc_attr($config['ltb-sid']).'" />

				<input type="hidden" id="ltb-point" name="ltb-point" value="'.esc_attr($id).'" />
				<input type="hidden" id="ltb-car-type" name="ltb-car-type" />
				<input type="hidden" id="ltb-plan" name="ltb-plan" />
				<input type="hidden" id="ltb-services" name="ltb-services" />
				<input type="hidden" id="ltb-services-count" name="ltb-services-count" />
				<input type="hidden" id="ltb-booking-date" name="ltb-booking-date" />
				<input type="hidden" id="ltb-booking-time" name="ltb-booking-time" />
				<input type="hidden" id="ltb-duration" name="ltb-duration" />
				<input type="hidden" id="ltb-price" name="ltb-price" />
				';

				ob_start();
				wp_nonce_field('ltb-booking','ltb-booking');
				$out .= ob_get_clean();

				$out .= '<div class="row">';

				if ( !empty($config['form-fields']) ) {

					foreach ( $config['form-fields'] as $key => $item ){

						$cols = 'col-lg-12 col-xs-12';
						if ( $item['cols'] == 'half' ) {

							$cols = 'col-lg-6 col-sm-6 col-ms-6 col-xs-12';
						}

						$required = '';
						if ( !empty($item['required']) ) {

							$required = ' required';
						}						

						$out .= '<div class="'.esc_attr($cols).'">';

						if ( $item['type'] == 'text') {

							$out .= '<input type="text" name="ltb-form-field-'.esc_attr($key).'" id="ltb-form-field-'.esc_attr($key).'" placeholder="'.esc_attr($item['label']).'"'.$required.' />';
						}

						if ( $item['type'] == 'textarea') {

							$out .= '<textarea name="ltb-form-field-'.esc_attr($key).'" id="ltb-form-field-'.esc_attr($key).'" placeholder="'.esc_attr($item['label']).'"'.$required.'></textarea>';
						}		

						if ( $item['type'] == 'checkbox') {

							$out .= '<label class="lte-checkbox"><input type="checkbox" name="ltb-form-field-'.esc_attr($key).'" id="ltb-form-field-'.esc_attr($key).'"'.$required.' /> '.esc_html($item['label']).'</label>';
						}										

						$out .= '</div>';
					}

					$out .= '
					<div class="col-lg-12 col-xs-12 ltb-div-submit">
						<input type="submit" id="ltb-form-submit" class="btn btn-lg btn-main color-hover-white" value="'.esc_html($config['form-submit-header']).'">
					</div>
					';
				}

				$out .= '</div>';
			$out .= '</form>';

		$out .= '</div>';

		return $out;
	}
}

/**
 * Submits booking and sends emails
 */
if ( !function_exists('ltb_make_booking') ) {

	function ltb_make_booking() {

		parse_str($_POST['bookingInfo'], $booking);

		$post_data = array(
			'post_status'   => 'publish',
			'post_type'  => 'lt-booking',
//			'post_date'  => esc_html($booking['booking-date']),
		);

		$config = fw_get_db_post_option( $booking['ltb-point'] );

		if ( empty($config) OR empty($booking['ltb-booking']) OR !wp_verify_nonce( $booking['ltb-booking'], 'ltb-booking') ) {

			die('Invalid Form');
		}

		$post_id = wp_insert_post( $post_data );

		$fields = array();
		if ( !empty($config['form-fields']) ) {

			foreach ( $config['form-fields'] as $key => $item ) {

				if ( $item['field'] == 'custom' AND !empty($booking['ltb-form-field-' . $key]) ) {

					if ( empty($fields[$item['field']]) ) $fields[$item['field']] = ''; else $fields[$item['field']] .= "\n";

					$fields[$item['field']] .= $item['label'].': '.$booking['ltb-form-field-' . $key];
				}
					else
				if ( !empty($booking['ltb-form-field-' . $key] ) ) {

					if ( empty($fields[$item['field']]) ) $fields[$item['field']] = ''; else $fields[$item['field']] .= ' ';

					$fields[$item['field']] .= $booking['ltb-form-field-' . $key];
				}
			}
		}

		if ( !empty($booking['ltb-services']) ) {

			$booking['ltb-services'] = explode(',', str_replace(' ', '', $booking['ltb-services']));
		}
			else {

			$booking['ltb-services'] = null;
		}

		if ( !empty($config['services-multiple']) ) {

			$posts = get_posts( array(
				'nopaging'                  => true,
				'post_type' => 'lt-booking-service',
				'posts_per_page'	=>	-1,
			) );

			$services = array();
			if ( !empty($posts) ) {

				foreach ( $posts as $post ) {

					$services[$post->ID] = $post->post_title;
				}
			}

			wp_reset_postdata();


			$custom_add = '';
			if ( !empty($booking['ltb-services-count']) ) {

				foreach ( explode(',', str_replace(' ', '', $booking['ltb-services-count'])) as $k => $num ) {

					
					$custom_add .= $services[$booking['ltb-services'][$k]] ." x " .$num . "\n";
				}
				
			}
		
			if ( !empty($fields['custom']) ) $fields['custom'] .= "\n\n";

			$fields['custom'] .= $custom_add;
		}

		foreach ( $fields as $field => $val ) {

			fw_set_db_post_option($post_id, $field, $val);
		}

		if ( !is_array($booking['ltb-services']) ) $booking['ltb-services'] = null;

		$time_format = get_option('time_format');
		if ( empty($time_format) ) {

			$time_format = 'H:i';
		}

		$time_format = 'H:i';

		fw_set_db_post_option($post_id, 'sid', $booking['ltb-sid']);
		fw_set_db_post_option($post_id, 'point', $booking['ltb-point']);
		fw_set_db_post_option($post_id, 'car-type', $booking['ltb-car-type']);
		fw_set_db_post_option($post_id, 'tariff', $booking['ltb-plan']);
		fw_set_db_post_option($post_id, 'services', $booking['ltb-services']);
		fw_set_db_post_option($post_id, 'price', $booking['ltb-price']);
		fw_set_db_post_option($post_id, 'duration', $booking['ltb-duration']);
		$booking['ltb-booking-date'] = (int)($booking['ltb-booking-date']);
		fw_set_db_post_option($post_id, 'booking-date', date('Y-m-d ' . $time_format, $booking['ltb-booking-date']));

		// Manual confirmatoin of the order
		if ( !empty($config['confirmation'] ) ) {

			fw_set_db_post_option($post_id, 'confirmed', 1);
		}
			else {

			fw_set_db_post_option($post_id, 'confirmed', 2);
		}

		$order_title = array();
		$order_title[] = '#'.$post_id;
		if ( !empty($fields['name']) ) $order_title[] = $fields['name'];
		if ( !empty($fields['email']) ) $order_title[] = $fields['email'];
		if ( !empty($fields['phone']) ) $order_title[] = $fields['phone'];

		wp_update_post ( array( 'ID' => $post_id, 'post_title' => esc_html(implode(' ', $order_title)), 'post_date' => date('Y-m-d H:i', $booking['ltb-booking-date'] ) ) );

		add_filter( 'wp_mail_content_type', 'ltb_mail_html' );
		function ltb_mail_html( $content_type ) {

			return 'text/html';
		}

		add_filter( 'wp_mail_from_name', 'ltb_mail_from_name' );
		function ltb_mail_from_name( $from_name ){

			parse_str($_POST['bookingInfo'], $booking);
			$config = fw_get_db_post_option( $booking['ltb-point'] );

			if ( !empty( $config['email_from_name'] )) {

				$from_name = $config['email_from_name'];
			}

			return $from_name;
		}

		add_filter( 'wp_mail_from', 'ltb_mail_from' );
		function ltb_mail_from( $from_email ){

			parse_str($_POST['bookingInfo'], $booking);
			$config = fw_get_db_post_option( $booking['ltb-point'] );

			if ( !empty( $config['email_from'] )) {

				$from_email = $config['email_from'];
			}

			return $from_email;
		}

		if ( !empty($config['email_admin']) ) {

			ob_start();
			require_once LTB_PLUGIN_DIR . 'inc/email-template-admin.php';

			$message = ob_get_contents();
			ob_end_clean();

			$emails = explode(',', $config['email_admin']);
			foreach ( $emails as $email ) {

				$to = trim($email);

				$subject = ltb_parse_email_fields($post_id, $config, $config['admin-subject']);

				wp_mail( $to, $subject, $message );
			}
		}

		if ( !empty($fields['email']) AND filter_var($fields['email'], FILTER_VALIDATE_EMAIL) ) {
 
			ob_start();
			require_once LTB_PLUGIN_DIR . 'inc/email-template-client.php';

			$message = ob_get_contents();
			ob_end_clean();

			$to = trim($fields['email']);
			$subject = ltb_parse_email_fields($post_id, $config, $config['client-subject']);

			wp_mail( $to, $subject, $message );
		}		

		echo '<h5 class="header" id="ltb-booking-done" data-point="'.esc_attr($booking['ltb-point']).'" data-booking="'.esc_attr($post_id).'">'.wp_kses_post(ltb_header_parse($config['submit-header'])).'</h5>';
		echo '<div class="ltb-header-descr">' . wp_kses_post(nl2br($config['submit-text'])) .'</div>';

		if ( $config['payments']['payments'] == 'redirect' AND !empty($config['payments']['redirect']['redirect-link']) ) {

			echo '<script>window.location.href = "'.esc_url($config['payments']['redirect']['redirect-link']).'";</script>';
		}

		die();
	}
}
add_action('wp_ajax_make_booking', 'ltb_make_booking');	
add_action('wp_ajax_nopriv_make_booking', 'ltb_make_booking');	


/**
 * Parse fields for e mail template
 */
if ( !function_exists('ltb_parse_email_fields') ) {

	function ltb_parse_email_fields( $post_id, $config, $string = '' ) {

		if ( !empty($string) ) {

			$item = fw_get_db_post_option( $post_id );

			$replace = array(

				'{order_id}' 				=>	'#'.$post_id,
				'{name}' 					=>	$item['name'],
				'{location}' 				=>	$config['location'],
				'{google_calendar_link}' 	=>	ltb_google_calendar_link( $config, $item ),

				'{order_info}'		=>	ltb_order_info( $config, $item, $config['order-info'] ),

			);

			$string = str_replace( array_keys($replace), array_values($replace), $string );

			$string = ltb_order_info( $config, $item, $string );
		}

		return $string;
	}
}

if ( !function_exists('ltb_order_info') ) {

	function ltb_order_info( $config, $item, $string ) {

		$cars = ltbGetPosts('lt-booking-car');
		$tariffs = ltbGetPosts('lt-booking-tariff');
		$services = ltbGetPosts('lt-booking-service');

		if ( !empty($item['services']) ) {

			$services_out = array();
			foreach ( $item['services'] as $l ) {

				$services_out[] = $services[$l];
			}

			$services_out = implode(', ', $services_out);
		}
			else {

			$services_out = '-';
		}

		$time_format = get_option('time_format');
		if ( empty($time_format) ) {

			$time_format = 'H:i';
		}

		$date_format = get_option('date_format');
		if ( empty($date_format) ) {

			$date_format = 'Y-m-d';
		}

		$replace = array();
		parse_str($_POST['bookingInfo'], $booking);
		foreach ( $config['form-fields'] as $key => $it ) {

			if ( !empty($it['custom-var']) AND !empty($booking['ltb-form-field-' . $key]) ) {

				$replace['{'.$it['custom-var'].'}'] = $booking['ltb-form-field-' . $key];
			}

		}

		$string = str_replace( array_keys($replace), array_values($replace), $string );


		if ( ($item['duration'] / 60) > 4 AND !empty($config['hours']) ) {

			$duration = esc_html(esc_html(ltb_time_to_hours($item['duration'], $config)));
		}
			else {

			$duration = $item['duration'].' '.esc_html($config['minutes']);
		}

		$replace = array(

			'{name}'			=>	$item['name'],
			'{email}'			=>	$item['email'],
			'{phone}'			=>	$item['phone'],
			'{custom}'			=>	$item['custom'],
			'{car-type}'		=>	$cars[$item['car-type']],
			'{tariff}'			=>	$tariffs[$item['tariff']],
			'{services}'		=>	$services_out,
			'{duration}'		=>	$duration,
			'{price}'			=>	ltb_the_price_simple($item['price'], $config),
			'{booking-date}'	=>	date( $date_format .' '.$time_format, strtotime($item['booking-date'])),
		);	

		$string = str_replace( array_keys($replace), array_values($replace), $string );

		return $string;
	}
}

/**
 * Generates google calendar add link
 */
if ( !function_exists('ltb_google_calendar_link') ) {

	function ltb_google_calendar_link( $config, $item ) {

		$link = '';

		$gmt = get_option('gmt_offset');
		if ( $gmt == 0 ) {

			$gmt = 'UTC';
		}
			else
		if ( $gmt > 0 ) {

			$gmt = '+'.get_option('gmt_offset');
		}

		$date = new DateTime(date("Y-m-d H:i", strtotime($item['booking-date'])), new DateTimeZone($gmt));

		$date->setTimezone(new DateTimeZone('UTC'));

		$glink = 'https://www.google.com/calendar/render?action=TEMPLATE&';
		$glink .= 'text='.$config['google-title'].'&';
		$glink .= 'details='.$config['google-descr'].'&';
		$glink .= 'location='.$config['location'].'&';
		$glink .= 'dates='.$date->format('Ymd\\THi00\\Z').'%2F';

		$date->modify('+'.(int)($item['duration']).' minutes'); 
		$glink .= $date->format('Ymd\\THi00\\Z');

		$link .= '<a href="'.esc_url($glink).'">';
		$link .= esc_html($config[ 'google-calendar-header']);
		$link .= '</a>';

		return $link;
	}
}


if ( !function_exists('ltb_get_local_url') ) {

	function ltb_get_local_url($url, $domain) {

		if ( !empty($url) ) {

			if ( substr($url, 0, 4) == 'http' ) {

				$return_url = $url;
			} 
				else {

				$return_url = $domain . $url;
			}
		}
			else {

			$return_url = $domain;
		}   

		return $return_url;
	}
}


/**
 * Generates google calendar add link
 */
if ( !function_exists('ltb_time_to_hours') ) {

	function ltb_time_to_hours( $time, $config ) {

		$item['time'] = (int)($time);

		$out = '';
		if ( (int)($item['time'] / 60) != 0 ) $out .= (int)($item['time'] / 60).' '.esc_html($config['hours']);

		if ( $item['time'] / 60 != (int)($item['time'] / 60) ) {

			$min = $item['time'] - ((int)($item['time'] / 60) * 60);

			if ( !empty($out) ) $out .= ' ';
			$out .= $min.' '.esc_html($config['minutes']);
		}

		return $out;
	}

}
