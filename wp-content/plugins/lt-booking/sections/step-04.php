<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

/**
 * Time Table
 */

if ( !function_exists( 'lt_booking_step_04_shortcode' ) ) {

	function lt_booking_step_04_shortcode( $atts ) {


		$out = '';
		$num = '04';

		$id = $atts['id'];

		$config = fw_get_db_post_option( $id );			

		if ( !empty($config['step-04-hidden']) ) {

			return false;
		}
		
		$out = ltb_section_start( $config, $num );

		$calendar = array();
		$calendar['dates'] = array();

		$calendar['days_limit'] = $config['days_limit'] - 1;

		$interval = 'PT'.ltb_get_time_interval($config).'M';
		
		$date = new DateTime(date("Y-m-d"));

		// Generating table headers
		for ( $x = 0; $x <= $calendar['days_limit']; $x++ ) {

			$calendar['dates'][$x] = $date->format('d');
			$calendar['dates_headers'][$x] = date_i18n('l', $date->getTimestamp());			
			$calendar['week_num'][$x] = $date->format('N');
			$calendar['week_date'][$date->format('N')] = $date->format('Y-m-d');
			$calendar['week_date_reverse'][$date->format('Y-m-d')] = ($date->format('N') - 1);
			$calendar['dates_stamp'][$x] = $date->format('Y-m-d');
			$calendar['dates_total'][$x] = $date->format('d').' '.date_i18n('F', $date->getTimestamp()).' '.$date->format('Y');

			$date->modify('+1 day');
		}

		$calendar['week_date_end'] = $date->format('Y-m-d');
		$date->modify('-'. ($config['days_limit'] + 1) .' day');
		$calendar['week_date_start'] = $date->format('Y-m-d');

		// Looking for an earliest time
		$time = 2400;
/*		
		Disabled becuase of many possible issues with different start time and non-standard intervals

		for ( $d = 0; $d <= 6; $d++ ) {

			$from = (int)(str_replace(':', '', $config['working-time-'.($d + 1)]['from']));
			if ( ($config['working-time-'.($d + 1)]['from'] == '00:00' OR $from > 0) AND $from < $time ) {

				$time = $from;
				$earliest = $d;
			}
		}
*/

		// Generating all time periods array
		$today = date('Y-m-d');

		for ( $d = 0; $d <= 6; $d++ ) {

			$from = $config['working-time-'.($d + 1)]['from'];
			$to = $config['working-time-'.($d + 1)]['to'];

			if ( !empty($from) AND !empty($to) ) {

				$end_date = new DateTime($today . ' ' . esc_attr($to));
				$end_date->modify('+'.ltb_get_time_interval($config).' minutes'); 
				$end_date = $end_date->format('Y-m-d H:i'); 
			}

			if ( !empty($from) AND !empty($to) ) {

				$period = new DatePeriod(
//					new DateTime($today . ' ' . esc_attr($config['working-time-'.($earliest + 1)]['from'])),
					new DateTime($today . ' ' . esc_attr($config['working-time-'.($d + 1)]['from'])),
					new DateInterval($interval),
					new DateTime($end_date)
				);

				$time_format = get_option('time_format');
				if ( empty($time_format) ) {

					$time_format = 'H:i';
				}

				foreach ($period as $key => $value) {

					$calendar['time'][$d][$value->format('Hi')] = array(

						'disabled'		=>	true,
						'datetime'		=>	$calendar['week_date'][($d + 1)].' '.$value->format('H:i'),
						'time'			=>	$value->format($time_format)
					);

					$calendar['time_intervals_all'][$d][$value->format('Hi')] = 1;
				}

				// Activating working hours for each day
				$period = new DatePeriod(
///					new DateTime($today . ' ' . esc_attr($from)),
//					new DateTime($today . ' ' . esc_attr($config['working-time-'.($earliest + 1)]['from'])),
					new DateTime($today . ' ' . esc_attr($config['working-time-'.($d + 1)]['from'])),					

					new DateInterval($interval),
					new DateTime($end_date)
				);		

				foreach ($period as $key => $value) {

					$calendar['time'][$d][$value->format('Hi')]['disabled'] = false;				
				}		
			}

			// Exluding break time
			$from = $config['break-time-'.($d + 1)]['from'];
			$to = $config['break-time-'.($d + 1)]['to'];			
			if ( !empty($from) AND !empty($to) ) {

				$period = new DatePeriod(
					new DateTime($today . ' ' . esc_attr($from)),
					new DateInterval($interval),
					new DateTime($today . ' ' . esc_attr($to))
				);		

				foreach ($period as $key => $value) {

					if ( isset($calendar['time'][$d][$value->format('Hi')]) ) {
					
						$calendar['time'][$d][$value->format('Hi')]['disabled'] = true;
					}
				}					
			}
		}

		// Excluding already booked periods
		$calendar['booked'] = array();
		$calendar['disabled'] = array();

		if ( !empty($config['booking-slots']) ) {

			$query_args = array(
			  'post_type' => 'lt-booking', 
			  'posts_per_page' => -1,
			  'date_query' => array(
			    'column' => 'post_date',
			    'after' => $calendar['week_date_start'],
			    'before' => $calendar['week_date_end'] 
			  ),
			  'post_status' => 'publish'
			);

			$query = new WP_Query( $query_args );
			if ( $query->have_posts() ) {

				$time_interval = ltb_get_time_interval($config);

				while ( $query->have_posts() ) {

					$query->the_post();

					$order_id = get_the_ID();

					$order_date = new DateTime(date("Y-m-d H:i", get_post_time()));

					$duration = fw_get_db_post_option($order_id, 'duration');
					$current_pid = fw_get_db_post_option($order_id, 'point');
					$confirmed = fw_get_db_post_option($order_id, 'confirmed');

					if ( !empty($confirmed) AND $confirmed == 1 ) continue;

					if ( $id != $current_pid ) continue;

					$slots = ceil($duration / $time_interval);

					for ( $t = 0; $t < $slots; $t++ ) {


						if ( $t > 0 ) $order_date->modify('+'.(int)($time_interval).' minutes');

						$booked_date = $order_date->format('Y-m-d H:i');

						if ( empty($calendar['time_intervals_all'][($order_date->format('N') - 1)][$order_date->format('Hi')])) {

							$slots++;
						}


						if ( empty($calendar['booked'][$booked_date]) ) {

							$calendar['booked'][$booked_date] = 0;
						}

						$calendar['booked'][$booked_date]++;

						if ( $calendar['booked'][$booked_date] >= $config['booking-slots'] AND 
							 isset($calendar['time'][$calendar['week_date_reverse'][$order_date->format('Y-m-d')]][$order_date->format('Hi')]) ) {

							//$calendar['time'][$calendar['week_date_reverse'][$order_date->format('Y-m-d')]][$order_date->format('Hi')]['disabled'] = true;
							//$calendar['disabled']
						}
					}
					
				}
			}
		}

		// Excluding today's passed time
		$today_day = date('N') - 1;
		$period = new DatePeriod(

			new DateTime($today . ' ' . esc_attr($config['working-time-'.($today_day + 1)]['from'])),			
			new DateInterval($interval),
			new DateTime($today . ' ' . date_i18n('H:i'))
		);	

		foreach ($period as $key => $value) {

			if ( isset($calendar['time'][$today_day][$value->format('Hi')]) ) {

				//$calendar['time'][$today_day][$value->format('Hi')]['disabled'] = true;
				$calendar['disabled'][$today][$value->format('Hi')]['disabled'] = true;
			}
		}

		// Excluding global break periods
		if ( !empty($config['break_periods']) ) {

			foreach ($config['break_periods'] as $breakInfo) {

				if ( !empty($breakInfo['breakFrom']) AND !empty($breakInfo['breakTo']) ) {

					$period = new DatePeriod(
						new DateTime(date_i18n('Y-m-d H:i', strtotime($breakInfo['breakFrom']))),
						new DateInterval($interval),
						new DateTime(date_i18n('Y-m-d H:i', strtotime($breakInfo['breakTo'])))
					);

					foreach ($period as $key => $value) {

						$calendar['disabled'][$value->format('Y-m-d')][$value->format('Hi')]['disabled'] = true;
/*
						foreach ( $calendar['time'] as $d => $days ) {

							foreach ( $days as $t => $times ) {

								if ( $times['datetime'] == $value->format('Y-m-d H:i') ) {

									$calendar['time'][$d][$t]['disabled'] = true;
									$calendar['disabled'][$d][$t]['disabled'] = true;

								}
							}
						}
*/						
					}						
				}
			}
		}

		// Calendar output
		$out .= '<div class="ltb-calendar-nav"><a href="#" class="ltb-calendar-left"></a><span class="ltb-current-month">'.date_i18n('F Y').'</span><a href="#" class="ltb-calendar-right"></a></div>';
		$out .= '<table class="ltb-calendar" cellspacing="0" cellpadding="0" data-exceed="'.esc_attr($config['exceed_warn']).'" data-step-minutes="'.esc_attr(ltb_get_time_interval($config)).'" data-days-limit="'.esc_attr($calendar['days_limit'] + 1).'">';
			$out .= '<thead>';
				$out .= '<tr>';

				$x = 0;
				foreach ( $calendar['dates'] as $d => $day ) {

					$th_class = 'ltb-day';
					if ( $d == 0 ) {

						$th_class .= ' ltb-day-current';
					}

					if ( !empty($config['weekend']) AND $config['weekend'] == $calendar['week_num'][$d] ) {

						$th_class .= ' ltb-weekend';
					}

					$out .= '<th class="'.esc_attr($th_class).'" data-current="'.esc_attr(date_i18n('F Y', strtotime($calendar['dates_stamp'][$x]))).'"><span>';
						$out .= esc_html($day);
						$out .= '<span class="ltb-day">'.esc_html($calendar['dates_headers'][$d]).'</span>';
					$out .= '</span></th>';

					$x++;
				}

				$out .= '</tr>';
			$out .= '</thead>';

			$out .= '<tbody>';
			
				$out .= '<tr>';

				$x = 0;
				foreach ( $calendar['week_num'] as $d ) {

					if ( !empty($calendar['time'][($d - 1)]) ) {

						$out .= '<td>';

						foreach ( $calendar['time'][($d - 1)] as $time ) {

							$class = '';
							if ( !empty($time['disabled']) ) {

								$class = ' disabled';
							}

							$booked_date = date('Y-m-d H:i', strtotime($calendar['dates_stamp'][$x].' '.$time['time']));
							if ( !empty($calendar['booked'][$booked_date]) AND $calendar['booked'][$booked_date] >= $config['booking-slots'] ) {

								$class = ' disabled';
							}

							if ( !empty($calendar['disabled'][date('Y-m-d', strtotime($calendar['dates_stamp'][$x]))][date('Hi', strtotime($calendar['dates_stamp'][$x].' '.$time['time']))]['disabled']) ) {

								$class = ' disabled';
							} 

							$out .= '<span class="ltb-time'.esc_attr($class).'" data-time="'.esc_attr($time['time']).'" data-stamp="'.esc_attr(strtotime($calendar['dates_stamp'][$x].' '.$time['time'])).'" data-date="'.esc_attr($calendar['dates_total'][$x]).'">'.esc_html($time['time']);


							if ( empty($calendar['booked'][$booked_date]) ) {

								$calendar['booked'][$booked_date] = 0;
							}

							if ( !empty($config['display-slots-left']) AND $config['booking-slots'] > 1 ) {

								$out .= '<div class="ltb-slots-left" data-total="'.esc_attr($config['booking-slots']).'" data-booked="'.esc_attr($calendar['booked'][$booked_date]).'"></div>';								
							}

							$out .= '</span>';
						}

						$out .= '</td>';
					}
						else {

						if ( $config['weekend'] == $d ) {

							$out .= '<td class="ltb-closed">'.esc_html($config['weekend-header']).'</td>';
						}
							else {

							$out .= '<td class="ltb-closed">'.esc_html($config['closed-header']).'</td>';
						}
					}

					$x++;
				}

				$out .= '</tr>';

			$out .= '</tbody>';

		$out .= '</table>';

		$config['calendar-descr'] = str_replace('{{***}}', '<span class="ltb-slots-left-descr"><span></span><span></span><span></span><span></span><span></span></span>', $config['calendar-descr']);
		$out .= '<div class="ltb-calendar-descr">'.wp_kses_post(nl2br(ltb_header_parse($config['calendar-descr']))).'</div>';

		$out .= ltb_section_end( $config, $num );

		return $out;
	}

	// Returns time interval for current point
	function ltb_get_time_interval($config) {

		if ( empty($config['time_interval']) OR (int)($config['time_interval']) == 0 OR (int)($config['time_interval']) < 1 ) {

			return 60;
		}
			else {
			
			return (int)($config['time_interval']);
		}
	}
}
add_shortcode( 'lt-booking-step-04', 'lt_booking_step_04_shortcode' );


