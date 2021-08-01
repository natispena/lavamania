<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Bookings
*/ 
	
$labels = array(
	'name'               => esc_html__( 'Bookings', 'lt-booking' ),
	'singular_name'      => esc_html__( 'Booking', 'lt-booking' ),
	'menu_name'          => esc_html__( 'Car Washing', 'lt-booking' ),
	'name_admin_bar'     => esc_html__( 'Booking', 'lt-booking' ),
	'add_new'            => esc_html__( 'Add New', 'lt-booking' ),
	'add_new_item'       => esc_html__( 'Add New Booking', 'lt-booking' ),
	'new_item'           => esc_html__( 'New Booking', 'lt-booking' ),
	'edit_item'          => esc_html__( 'Edit Booking', 'lt-booking' ),
	'view_item'          => esc_html__( 'View Booking', 'lt-booking' ),
	'all_items'          => esc_html__( 'Bookings', 'lt-booking' ),
	'search_items'       => esc_html__( 'Search Bookings', 'lt-booking' ),
	'parent_item_colon'  => esc_html__( 'Parent Booking:', 'lt-booking' ),
	'not_found'          => esc_html__( 'No bookings found.', 'lt-booking' ),
	'not_found_in_trash' => esc_html__( 'No bookings found in Trash.', 'lt-booking' )
);

$args = array(
	'labels'             => $labels,
	'public'             => false,
	'publicly_queryable' => false,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'menu_icon'			 => LTB_PLUGIN_URL . '/assets/images/favicon.png',	
	'query_var'          => false,
	'rewrite'            => false,
	'capability_type'    => 'post',
	'capabilities' => array(
//		'create_posts' => 'do_not_allow',
	),
	'map_meta_cap' => true,
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => 3,
	'supports'           => array( 'title', 'page-attributes' )
);

register_post_type( 'lt-booking', $args );

add_filter(
	'fw_post_options:lt-booking', function() {

		global $ltb_cfg;
		$time_format = get_option('time_format');
		if ( empty($time_format) ) {

			$time_format = 'H:i';
		}

		$time_format = 'H:i'; // does not support am/pm

		return array(

			'parent' => array(
				'title'   => '',
				'type'    => 'box',
				'options' => array(

					'point' => array(
						"label" => esc_html__( "Point", 'lt-booking' ),
						"type" => "select",
						'choices' => ltbGetPosts('lt-booking-point'),
					),	
					'name' => array(
						"label" => esc_html__( "Name", 'lt-booking' ),
						"type" => "text"
					),	
					'phone' => array(
						"label" => esc_html__( "Phone", 'lt-booking' ),
						"type" => "text"
					),	
					'email' => array(
						"label" => esc_html__( "Email", 'lt-booking' ),
						"type" => "text"
					),	

					'car-type' => array(
						"label" => esc_html__( "Car Type", 'lt-booking' ),
						"type" => "select",
						'choices' => ltbGetPosts('lt-booking-car'),
					),	
					'tariff' => array(
						"label" => esc_html__( "Plan", 'lt-booking' ),
						"type" => "select",
						'choices' => ltbGetPosts('lt-booking-tariff'),
					),	
					'services' => array(
						"label" => esc_html__( "Services", 'lt-booking' ),
						"type" => "select-multiple",
						'choices' => ltbGetPosts('lt-booking-service'),
					),	
					'price' => array(
						"label" => esc_html__( "Price", 'lt-booking' ),
						"type" => "text"
					),			
					'duration' => array(
						"label" => esc_html__( "Duration, min", 'lt-booking' ),
						"type" => "text"
					),				
					'payment' => array(
						"label" => esc_html__( "Payment", 'lt-booking' ),
						"type" => "select",
						'choices' => $ltb_cfg['payments'],
					),			
					'confirmed' => array(
						"label" => esc_html__( "Status", 'lt-booking' ),
						"type" => "select",
						'choices' => $ltb_cfg['confirmed'],
					),			
/*
					'booking-date' => array(
						"label" => esc_html__( "Booking Date", 'lt-booking' ),
						"type" => 'datetime-picker',
						'datetime-picker' => array(
						    'format'        => 'Y-m-d '.$time_format,
						    'maxDate'       => false,
						    'minDate'       => false,
						    'timepicker'    => true,
						    'datepicker'    => true,
						    //'defaultTime'   => '12:00',
						    //'step'			=> 15,
						),						
					),		

*/
					'booking-date' => array(
						"label" => esc_html__( "Booking Date", 'lt-booking' ),
						"type" => 'bootstrap-date',
				
					),						
					
					'custom' => array(
						"label" => esc_html__( "Additional Info", 'lt-booking' ),
						"type" => "textarea"
					),	

				),
			),
		);
	},
	100
);


if ( !function_exists('ltb_booking_custom_columns') ) {

	function ltb_booking_custom_columns($columns) {

	    unset( $columns['title'] );
	    unset( $columns['date'] );
	    $points = wp_count_posts('lt-booking-point');

	    if ( !empty($points) && $points->publish > 1 ) {
	    
	    	$columns['point'] = esc_html__( 'Point', 'lt-booking' );
	   	}

	    $columns['name'] = esc_html__( 'Name', 'lt-booking' );
	    $columns['phone'] = esc_html__( 'Phone', 'lt-booking' );

	    $columns['car-type'] = esc_html__( 'Car Type', 'lt-booking' );
	    $columns['tariff'] = esc_html__( 'Plan', 'lt-booking' );
	    $columns['price'] = esc_html__( 'Price', 'lt-booking' );

	    $columns['duration'] = esc_html__( 'Duration, min', 'lt-booking' );
	    $columns['payment'] = esc_html__( 'Payment', 'lt-booking' );
	    $columns['confirmed'] = esc_html__( 'Status', 'lt-booking' );
	    $columns['booking-date'] = esc_html__( 'Date and Time', 'lt-booking' );

	    return $columns;
	}
}
add_filter( 'manage_lt-booking_posts_columns', 'ltb_booking_custom_columns' );



if ( !function_exists('ltb_booking_sortable_columns') ) {

	function ltb_booking_sortable_columns($columns) {

	    $columns['booking-date'] = 'post_date';
	  
	    return $columns;
	}
}
add_filter( 'manage_edit-lt-booking_sortable_columns', 'ltb_booking_sortable_columns' );

if ( !function_exists('ltb_booking_custom_column_data') ) {

	function ltb_booking_custom_column_data( $column, $post_id ) {

		global $ltb_cfg;

		$item = fw_get_db_post_option( $post_id );
		$cars = ltbGetPosts('lt-booking-car');
		$points = ltbGetPosts('lt-booking-point');
		$tariffs = ltbGetPosts('lt-booking-tariff');

		$time_format = get_option('time_format');
		if ( empty($time_format) ) {

			$time_format = 'H:i';
		}

		$time_format = 'H:i';

	    switch ( $column ) {

	        case 'point' :
	        	if ( !empty($points[$item['point']]) )
	        		echo esc_html($points[$item['point']]); 
	            break;
	        case 'name' :
	            echo esc_html($item['name']); 
	            break;	            
	        case 'phone' :
	            echo esc_html($item['phone']); 
	            break;
	        case 'car-type' :
	        	if ( !empty($cars[$item['car-type']]) )
	        		echo esc_html($cars[$item['car-type']]); 
	            break;
	        case 'tariff' :
	        	if ( !empty($tariffs[$item['tariff']]) )
	        		echo esc_html($tariffs[$item['tariff']]);
	            break;	      
	        case 'price' :
	            echo $item['price']; 
	            break;
	        case 'duration' :
	            echo $item['duration']; 
	            break;
	        case 'payment' :
	        	if ( !empty($ltb_cfg['payments'][$item['payment']]) )
	            	echo $ltb_cfg['payments'][$item['payment']]; 
	            break;	 	 
	        case 'confirmed' :
	        	if ( !empty($ltb_cfg['confirmed'][$item['confirmed']]) )
	            	echo $ltb_cfg['confirmed'][$item['confirmed']]; 
	            break;		                       
	        case 'booking-date' :
	            if ( !empty($item['booking-date']) ) {

	            	if ( is_numeric($item['booking-date']) ) {

		            	echo esc_html(date('Y-m-d '. $time_format, $item['booking-date'])); 
	            	}
	            		else {

		            	echo esc_html($item['booking-date']); 
            		}
	            }
	            break;	  
	    }
	}
}

add_action( 'manage_lt-booking_posts_custom_column' , 'ltb_booking_custom_column_data', 10, 2 );


add_action( 'save_post_lt-booking', 'ltb_booking_save_postdata', 10, 3 );
function ltb_booking_save_postdata( $post_id, $post, $update ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;
	}

	if ( $update && 'trash' != get_post_status( $post_id ) ) {

		if ( !empty($_POST['fw_options']) ) {

			$item = $_POST['fw_options'];
		}
			else {

			$item = fw_get_db_post_option( $post_id );
		}

		remove_action( 'save_post_lt-booking', 'ltb_booking_save_postdata' );

		$order_title = array();
		$order_title[] = '#'.$post_id;
		if ( !empty($item['name'] ) ) {

			$order_title[] = $item['name'];
		}

		if ( !empty($item['email']) ) {

			$order_title[] = $item['email'];
		}

		if ( !empty($item['phone']) ) {

			$order_title[] = $item['phone'];
		}

		wp_update_post( array(

				'ID' => $post_id,
				'post_title' => esc_html(implode(' ', $order_title)),
				'post_date' => esc_html(date('Y-m-d H:i', strtotime($item['booking-date'])))
			)
		);

		add_action( 'save_post_lt-booking', 'ltb_booking_save_postdata', 10, 3 );
	}
}


