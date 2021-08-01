<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/*
	Points
*/ 
$labels = array(
	'name'               => esc_html__( 'Points', 'lt-booking' ),
	'singular_name'      => esc_html__( 'Point', 'lt-booking' ),
	'menu_name'          => esc_html__( 'Washing Points', 'lt-booking' ),
	'name_admin_bar'     => esc_html__( 'Point', 'lt-booking' ),
	'add_new'            => esc_html__( 'Add New', 'lt-booking' ),
	'add_new_item'       => esc_html__( 'Add New Point', 'lt-booking' ),
	'new_item'           => esc_html__( 'New Point', 'lt-booking' ),
	'edit_item'          => esc_html__( 'Edit Point', 'lt-booking' ),
	'view_item'          => esc_html__( 'View Point', 'lt-booking' ),
	'all_items'          => esc_html__( 'Points', 'lt-booking' ),
	'search_items'       => esc_html__( 'Search Points', 'lt-booking' ),
	'parent_item_colon'  => esc_html__( 'Parent Point:', 'lt-booking' ),
	'not_found'          => esc_html__( 'No points found.', 'lt-booking' ),
	'not_found_in_trash' => esc_html__( 'No points found in Trash.', 'lt-booking' )
);

$args = array(
	'labels'             => $labels,
	'public'             => false,
	'publicly_queryable' => false,
	'show_ui'            => true,
	'show_in_menu'       => 'edit.php?post_type=lt-booking',
	'query_var'          => false,
	'rewrite'            => false,
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => 3,
	'supports'           => array( 'title')
);

register_post_type( 'lt-booking-point', $args );

add_filter(
	'fw_post_options:lt-booking-point', function() {

		$time_step = 60;

		$days_array = array(

			1	=>	esc_html__( 'Mon', 'lt-booking' ) ,
			2	=>	esc_html__( 'Tue', 'lt-booking' ) ,
			3	=>	esc_html__( 'Wed', 'lt-booking' ) ,
			4	=>	esc_html__( 'Thu', 'lt-booking' ) ,
			5	=>	esc_html__( 'Fri', 'lt-booking' ) ,
			6	=>	esc_html__( 'Sat', 'lt-booking' ) ,
			7	=>	esc_html__( 'Sun', 'lt-booking' ) ,
		);

		$time_format = get_option('time_format');
		if ( empty($time_format) ) {

			$time_format = 'H:i';
		}

		$time_format = 'H:i';

		$date_format = get_option('date_format');
		if ( empty($date_format) ) {

			$date_format = 'Y-m-d';
		}

		$full_date_format = $date_format.' '.$time_format;

		$working_hours_array = array();
		foreach ( $days_array as $num => $day ) {

			$working_hours_array[ 'form-box-'.$num ] = array(

				'title'   => $day,
				'type'    => 'box',
				'options' => array(								

					'working-time-'.$num => array(
						"label" => esc_html__( "Working Time", 'lt-booking' ),
						"type" => 'datetime-range',
						'datetime-pickers' => array(
						    'from' => array(
							    'format'        => $time_format,
							    'maxDate'       => false,
							    'minDate'       => false,
							    'datepicker'    => false,
							    'timepicker'    => true,
							    'step'			=> $time_step,
							    'defaultTime'   => '09:00'
						    ),
						    'to' => array(
							    'format'        => $time_format,
							    'maxDate'       => false,
							    'minDate'       => false,
							    'datepicker'    => false,
							    'timepicker'    => true,
							    'step'			=> $time_step,
							    'defaultTime'   => '18:00'
						    )
						),						
					),
					'break-time-'.$num => array(
						"label" => esc_html__( "Break Time", 'lt-booking' ),
						"type" => 'datetime-range',
						'datetime-pickers' => array(
						    'from' => array(
							    'format'        => $time_format,
							    'maxDate'       => false,
							    'minDate'       => false,
							    'datepicker'    => false,
							    'timepicker'    => true,
							    'step'			=> $time_step,
						    ),
						    'to' => array(
							    'format'        => $time_format,
							    'maxDate'       => false,
							    'minDate'       => false,
							    'datepicker'    => false,
							    'timepicker'    => true,
							    'step'			=> $time_step,
						    )
						),						
					),											
				),
			);
		}

		return array(

			'parent' => array(
				'title'   => '',
				'type'    => 'box',
				'options' => array(
				
					'general' => array(
						'title'   => 'General',
						'type'    => 'tab',
						'options' => array(	
			                'confirmation' => array(
			                    'label' => esc_html__( 'Requires manual confirmation', 'lt-booking' ),
								'desc'	=>	esc_html__('Each order must be confirmed by administrator before activation', 'lt-booking'),			                    
								'type' => 'switch',
			                ),							
			                'booking-slots' => array(
			                    'label' => esc_html__( 'Booking Slots', 'lt-booking' ),
								'type' => 'text',
								'value'	=>	'1',
								'desc'	=>	esc_html__('Limit of Simultaneous Orders per Period. Leave empty to remove the limit.', 'lt-booking'),
			                ),								                
			                'currency' => array(
			                    'label' => esc_html__( 'Currency', 'lt-booking' ),
								'type' => 'text',
								'value'	=>	'$',
			                ),
			                'currency-pos' => array(
			                    'label' => esc_html__( 'Currency position', 'lt-booking' ),
								'type' => 'select',
								'value'	=>	'before',
								'choices' => array(

									'before'	=>	esc_html__('Before', 'lt-booking'),
									'after'	=>	esc_html__('After', 'lt-booking'),
								),
			                ),
			                'minutes' => array(
			                    'label' => esc_html__( 'Minutes', 'lt-booking' ),
								'type' => 'text',
								'value'	=>	'min',
			                ),
			                'hours' => array(
			                    'label' => esc_html__( 'Hours', 'lt-booking' ),
								'type' => 'text',
								'value'	=>	'hours',
			                ),			
							'hours_mode' => array(
								"label" => esc_html__("Show total with hours", 'lt-booking'),
								"desc"	=>	esc_html__("By default minutes only displayed", 'lt-booking'),
								"type" => "switch"
							),		
			                'thd_sep' => array(
			                    'label' => esc_html__( 'Thousands Separator', 'lt-booking' ),
								'type' => 'text',
								'value'	=>	'',
			                ),												                                
			                'exceed_warn' => array(
			                    'label' => esc_html__( 'Duration Exceed Warning', 'lt-booking' ),
								'type' => 'text',
								'value'	=>	'Your order duration exceeds a free time for this booking slot.',
			                ),

							'email-box' => array(
								'title'   => esc_html__( 'Email Settings', 'lt-booking' ),
								'type'    => 'box',
								'options' => array(

					                'email_admin' => array(
					                    'label' => esc_html__( 'Administrator Email(s)', 'lt-booking' ),
					                    'desc'	=>	esc_html__('Can be several, coma separated. Used for booking orders.', 'lt-booking'),
										'type' => 'text',
										'value'	=>	'',
					                ),
					                'email_from' => array(
					                    'label' => esc_html__( 'From Email', 'lt-booking' ),
					                    'desc'	=>	esc_html__('Can also depend on local SMTP settings. In case if you have problems with sending email, check external SMTP plugins like WP Mail SMTP.', 'lt-booking'),
										'type' => 'text',
										'value'	=>	'',
					                ),
					                'email_from_name' => array(
					                    'label' => esc_html__( 'From Name', 'lt-booking' ),
										'type' => 'text',
										'value'	=>	'',
					                ),			
					            ),		                
				            ),


							'google-box' => array(
								'title'   => esc_html__( 'Google Calendar', 'lt-booking' ),
								'type'    => 'box',
								'options' => array(
					                'location' => array(
					                    'label' => esc_html__( 'Location Address', 'lt-booking' ),
										'type' => 'text',
					                    'desc'	=>	esc_html__('Used in google calendar and email variables.', 'lt-booking'),
										'value'	=>	'',
					                ),
					                'google-title' => array(
					                    'label' => esc_html__( 'Google Title', 'lt-booking' ),
										'type' => 'text',
					                    'value'	=>	esc_html__('Car Washing Booking', 'lt-booking'),
					                ),					                
					                'google-descr' => array(
					                    'label' => esc_html__( 'Google Description', 'lt-booking' ),
										'type' => 'text',
										'value'	=>	'',
					                ),					                

					                'google-calendar-header' => array(
					                    'label' => esc_html__( 'Google Calendar Link Header', 'lt-booking' ),
										'type' => 'text',
					                    'desc'	=>	esc_html__('If empty, link be hidden.', 'lt-booking'),
										'value'	=>	'Add to my google calendar',
					                ),				                		                
					            ),
					        ),
						),
					),		
		
					'step-01' => array(
						'title'   => 'Car Types (1)',
						'type'    => 'tab',
						'options' => array_merge(

							ltb_section_config_array('01'), 
							array(

								'cars' => array(
								    'type'  => 'select-multiple',
								    'label' => esc_html__('Car Types', 'lt-booking'),
								    'choices' => ltbGetPosts('lt-booking-car'),
								),	
							)			
						),
					),
					'step-02' => array(
						'title'   => 'Plans (2)',
						'type'    => 'tab',
						'options' => array_merge(

							array(
								'step-02-hidden' => array(
								    'type'  => 'switch',
								    'label' => esc_html__('Plans Disabled', 'lt-booking'),
								)
							),
							ltb_section_config_array('02'), 					
							array(
				                'plans-layout' => array(
				                    'label' => esc_html__( 'Plans Layout', 'lt-booking' ),
									'type' => 'select',
									'value'	=>	'default',
									'choices' => array(

										'default'		=>	esc_html__('Default', 'lt-booking'),
										'accordions'	=>	esc_html__('Accordions', 'lt-booking'),
									),
				                ),										
								'tariff-unselected'    => array(
									'label' => esc_html__( 'Unselected Header', 'lt-booking' ),
									'type'  => 'text',
									'value'	=> esc_html__( 'Select plan', 'lt-booking' ),
								),										
								'tariff-selected'    => array(
									'label' => esc_html__( 'Selected Header', 'lt-booking' ),
									'type'  => 'text',
									'value'	=> esc_html__( 'Selected', 'lt-booking' ),
								),										
							)
						),
					),
					'step-03' => array(
						'title'   => 'Services (3)',
						'type'    => 'tab',
						'options' => array_merge(

							array(
								'step-03-hidden' => array(
								    'type'  => 'switch',
								    'label' => esc_html__('Services Disabled', 'lt-booking'),
								)
							),

							ltb_section_config_array('03'), 
							array(
								'services' => array(
								    'type'  => 'select-multiple',
								    'label' => esc_html__('Services', 'lt-booking'),
								    'choices' => ltbGetPosts('lt-booking-service'),
								),
				                'services-layout' => array(
				                    'label' => esc_html__( 'Services Layout', 'lt-booking' ),
									'type' => 'select',
									'value'	=>	'default',
									'choices' => array(

										'default'		=>	esc_html__('Default Grid', 'lt-booking'),
										'accordions'	=>	esc_html__('Accordions', 'lt-booking'),
									),
				                ),
								'services-unselected'    => array(
									'label' => esc_html__( 'Unselected Header', 'lt-booking' ),
									'type'  => 'text',
									'value'	=> esc_html__( 'Select Service', 'lt-booking' ),
								),										
								'services-selected'    => array(
									'label' => esc_html__( 'Selected Header', 'lt-booking' ),
									'type'  => 'text',
									'value'	=> esc_html__( 'Selected', 'lt-booking' ),
								),	
								'services-multiple' => array(
								    'type'  => 'switch',
								    'label' => esc_html__('Multiple services order', 'lt-booking'),
								),																	
							)
						),
					),
					'step-04' => array(
						'title'   => 'Time Table (4)',
						'type'    => 'tab',
						'options' => array_merge(

							array(
								'step-04-hidden' => array(
								    'type'  => 'switch',
								    'label' => esc_html__('Time Table Disabled', 'lt-booking'),
								)
							),
							ltb_section_config_array('04'), 
							array(

								$working_hours_array,

						        'break_periods' => array(
						            'label' => esc_html__( 'Break Periods', 'lt-booking' ),
						            'type' => 'addable-box',
						            'value' => array(),
						            'box-options' => array(
										'breakFrom' => array(
											"label" => esc_html__( "Break From", 'lt-booking' ),
											"type" => 'datetime-picker',
											'datetime-picker' => array(
											    'format'        => $full_date_format,
											    'maxDate'       => false,
											    'minDate'       => false,
											    'datepicker'    => true,
											    'timepicker'    => true,
											    'step'			=> $time_step,
											),
										),	
										'breakTo' => array(
											"label" => esc_html__( "Break To", 'lt-booking' ),
											"type" => 'datetime-picker',
											'datetime-picker' => array(
											    'format'        => $full_date_format,
											    'maxDate'       => false,
											    'minDate'       => false,
											    'datepicker'    => true,
											    'timepicker'    => true,
											    'step'			=> $time_step,
											),
										),
								    ),
								    'template' => '{{- breakFrom }} - {{- breakTo }}',
						        ),
				                'weekend' => array(
				                    'label' => esc_html__( 'Weekend', 'lt-booking' ),
									'type' => 'select',
									'value'	=>	7,
									'choices' => $days_array,
				                ),
				                'days_limit' => array(
				                    'label' => esc_html__( 'Max Days to Show', 'lt-booking' ),
									'type' => 'text',
									'value'	=>	7,
									'desc'  => esc_html__( 'By default 7 days', 'lt-booking' ),
				                ),
				                'time_interval' => array(
				                    'label' => esc_html__( 'Time Interval, Minutes', 'lt-booking' ),
									'type' => 'text',
									'value'	=>	60,
									'desc'  => esc_html__( 'Any positive integer, starting from 0. (5,15,30,60,120). In case a wrong value entered, the 60 will be used.', 'lt-booking' ),
				                ),						                                
								'closed-header'    => array(
									'label' => esc_html__( 'Empty Day Header', 'lt-booking' ),
									'type'  => 'text',
									'value'  => esc_html__( 'Closed', 'lt-booking' ),
								),
								'weekend-header'    => array(
									'label' => esc_html__( 'Weekend Day Header', 'lt-booking' ),
									'type'  => 'text',
									'value'  => esc_html__( 'Closed', 'lt-booking' ),
								),
				                'display-slots-left' => array(
				                    'label' => esc_html__( 'Display number of empty slots per time', 'lt-booking' ),
									'type' => 'switch',
									'desc'  => esc_html__( 'Works only if you have more than 1 booking slots enabled at General tab', 'lt-booking' ),									
				                ),									
								'calendar-descr'    => array(
									'label' => esc_html__( 'Calendar Legend', 'lt-booking' ),
									'desc'  => esc_html__( 'Use brackets {{ to highlight }}', 'lt-booking' ),
									'type'  => 'textarea',
								),
							)			
						),
					),
					'step-05' => array(
						'title'   => 'Order Form (5)',
						'type'    => 'tab',
						'options' => array_merge(ltb_section_config_array('05'), 

							array(	
							
								'total-box' => array(
									'title'   => esc_html__( 'Total Box', 'lt-booking' ),
									'type'    => 'box',
									'options' => array(

										'total-header-1'    => array(
											'label' => esc_html__( 'Car Type Header', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Car Type', 'lt-booking' ),
										),
					                    'total-icon-1' => array(
					                        'label' => esc_html__( 'Car Type Icon', 'lt-booking' ),
					                        'type'  => 'icon-v2',
					                    ),

										'total-header-2'    => array(
											'label' => esc_html__( 'Washing Plan Header', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Washing Plan', 'lt-booking' ),
										),
					                    'total-icon-2' => array(
					                        'label' => esc_html__( 'Washing Plan Icon', 'lt-booking' ),
					                        'type'  => 'icon-v2',
					                    ),
										'total-placeholder-2'    => array(
											'label' => esc_html__( 'Washing Placeholder', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Choose Your Plan', 'lt-booking' ),
										),						                    

										'total-header-3'    => array(
											'label' => esc_html__( 'Booking Date Header', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Booking date', 'lt-booking' ),
										),
					                    'total-icon-3' => array(
					                        'label' => esc_html__( 'Booking Date Icon', 'lt-booking' ),
					                        'type'  => 'icon-v2',
					                    ),

										'total-header-4'    => array(
											'label' => esc_html__( 'Booking Time Header', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Booking time', 'lt-booking' ),
										),
					                    'total-icon-4' => array(
					                        'label' => esc_html__( 'Booking Time Icon', 'lt-booking' ),
					                        'type'  => 'icon-v2',
					                    ),
										'total-placeholder-4'    => array(
											'label' => esc_html__( 'Booking Time Placeholder', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Choose Booking Time', 'lt-booking' ),
										),					                    

										'total-header-5'    => array(
											'label' => esc_html__( 'Duration Header', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Duration', 'lt-booking' ),
										),
					                    'total-icon-5' => array(
					                        'label' => esc_html__( 'Duration Icon', 'lt-booking' ),
					                        'type'  => 'icon-v2',
					                    ),	

										'total-header-6'    => array(
											'label' => esc_html__( 'Total Header', 'lt-booking' ),
											'type'  => 'text',
											'value'  => esc_html__( 'Total Price', 'lt-booking' ),
										),
					                    'total-icon-6' => array(
					                        'label' => esc_html__( 'Total Price Icon', 'lt-booking' ),
					                        'type'  => 'icon-v2',
					                    ),						                    					                    
									),
								),							
								'form-box' => array(
									'title'   => esc_html__( 'Form Configuration', 'lt-booking' ),
									'type'    => 'box',
									'options' => array(

										'form-header'    => array(
											'label' => esc_html__( 'Form Header', 'lt-booking' ),
											'desc'  => esc_html__( 'Use brackets {{ to highlight }}', 'lt-booking' ),
											'type'  => 'text',
										),
										'form-text'    => array(
											'label' => esc_html__( 'Form Text', 'lt-booking' ),
											'type'  => 'textarea',
										),
										'submit-header'    => array(
											'label' => esc_html__( 'Header after order submit', 'lt-booking' ),
											'value'	=>	'Order completed',
											'type'  => 'textarea',
										),												
										'submit-text'    => array(
											'label' => esc_html__( 'Text after order submit', 'lt-booking' ),
											'value'	=>	'Please check your email with details and link to the Google Calendar. If you have not received email, please check the spam folder too. Thank you. ',
											'type'  => 'textarea',
										),											
										'form-bg-image' => array(
											'label' => esc_html__('From Background Image', 'lt-booking'),
											'type' => 'upload'
										),											
								        'form-fields' => array(
								            'label' => esc_html__( 'Form Fields', 'lt-booking' ),
								            'type' => 'addable-box',
								            'value' => array(),
								            'box-options' => array(
												'label' => array(
										            'label' => esc_html__( 'Label', 'lt-booking' ),
										            'type' => 'text',
										            'value' => '',
										        ),		  
								                'type' => array(
								                    'label' => esc_html__( 'Type', 'lt-booking' ),
													'type' => 'select',
													'choices' => array(

														'text'	=>	esc_html__('Text', 'lt-booking'),
														'textarea'	=>	esc_html__('Textarea', 'lt-booking'),
														'checkbox'	=>	esc_html__('Checkbox', 'lt-booking'),
													),
								                ),
								                'required' => array(
								                    'label' => esc_html__( 'Required', 'lt-booking' ),
													'type' => 'switch',
								                ),								                
								                'cols' => array(
								                    'label' => esc_html__( 'Width', 'lt-booking' ),
													'type' => 'select',
													'choices' => array(

														'full'	=>	esc_html__('Full width', 'lt-booking'),
														'half'	=>	esc_html__('Half width', 'lt-booking'),
													),
								                ),	
								                'field' => array(
								                    'label' => esc_html__( 'Predefined Field', 'lt-booking' ),
													'type' => 'select',
													'choices' => array(
														'custom'	=>	esc_html__('Custom', 'lt-booking'),
														'name'	=>	esc_html__('Name', 'lt-booking'),
														'email'	=>	esc_html__('Email', 'lt-booking'),
														'phone'	=>	esc_html__('Phone', 'lt-booking'),
													),
								                ),
								                'custom-var' => array(
								                    'label' => esc_html__( 'Custom Var name', 'lt-booking' ),
								                    'desc' => esc_html__( 'Used only for custom variables in templates', 'lt-booking' ),
													'type' => 'text',
								                ),									                
								            ),
								    		'template' => '{{- label }}',		                
								        ),	
										'form-submit-header'    => array(
											'label' => esc_html__( 'Button Header', 'lt-booking' ),
											'type'  => 'text',
											'value'	=>	'Send',
										),								        							
									),
								),

								'mail-box' => array(
									'title'   => esc_html__( 'Email Template', 'lt-booking' ),
									'type'    => 'box',
									'options' => array(

										'client-subject'    => array(
											'label' => esc_html__( 'Client subject', 'lt-booking' ),
											'value'	=>	'Your booking {order_id} confirmed',
											'desc'  => esc_html__( 'Use {order_id} to insert order number', 'lt-booking' ),
											'type'  => 'text',
										),
										'client-text'    => array(
											'label' => esc_html__( 'Client Text', 'lt-booking' ),
											'value'	=>	"Hello, {name}.

Thank you for your booking:

{order_info}

{google_calendar_link}

This order is used only for testing purposes.

--
lt-booking Washing Booking System
http://lt-booking.like-themes.com",
											'desc'  => esc_html__( 'You can use variables: {order_info], {name}, {location}, {google_calendar_link}.', 'lt-booking' ),			
											'type'  => 'textarea',
										),
										'order-info'    => array(
											'label' => esc_html__( 'Order Info Template', 'lt-booking' ),
											'value'	=>	
"Name: {name}
Email: {email}
Phone: {phone}

Car type: {car-type}
Plan: {tariff}
Services: {services}
Duration: {duration}
Price: {price}
Booking date: {booking-date}",
											'desc'  => esc_html__( 'You can use variables: {name}, {email}, {phone}, {car-type}, {tariff}, {services}, {duration}, {price}, {booking-date} and {custom} for all custom variables.', 'lt-booking' ),			
											'type'  => 'textarea',
										),	
										'admin-subject'    => array(
											'label' => esc_html__( 'Admin subject', 'lt-booking' ),
											'value'	=>	'New booking {order_id}',
											'desc'  => esc_html__( 'Use {order_id} to insert order number', 'lt-booking' ),
											'type'  => 'text',
										),
										'admin-text'    => array(
											'label' => esc_html__( 'Admin Text', 'lt-booking' ),
											'value'	=>	"New online order:

{order_info}

This order is used only for testing purposes.

--
lt-booking Washing Booking System
http://lt-booking.like-themes.com",
											'desc'  => esc_html__( 'Use {order_info} to insert detailed order information and {name} to insert client\'s name.', 'lt-booking' ),			
											'type'  => 'textarea',
										),																			
									),
								),
						
							)			
						),
					),

					'payments' => array(
					
						'title'   => 'Payments',
						'type'    => 'tab',
						'options' => array(



							'payments'        => array(
								'type'         => 'multi-picker',
								'label'        => false,
								'desc'         => false,
								'picker'       => array(
									'payments' => array(
										'label'   => esc_html__( 'Payments', 'lt-booking' ),
										'type'    => 'radio',
										'choices' => array(
											'disabled' => esc_html__( 'Disabled', 'lt-booking' ),
											'stripe'  => esc_html__( 'Stripe', 'lt-booking' ),
											'payfast'  => esc_html__( 'Payfast', 'lt-booking' ),
											'redirect'  => esc_html__( 'Redirect Link', 'lt-booking' ),
/*											'paypal'  => esc_html__( 'Paypal', 'lt-booking' ),*/
										),
									)
								),
								'choices'      => array(
									'stripe'  => array(
						                'stripe-pk' => array(
						                    'label' => esc_html__( 'Stripe Public Key', 'lt-booking' ),
											'type' => 'text',
											'desc'  => esc_html__( 'Get your key and activate your account on a https://stripe.com/. You can use test keys in order to check the functionality.', 'lt-booking' ),
						                ),
						                'stripe-sk' => array(
						                    'label' => esc_html__( 'Stripe Secret Key', 'lt-booking' ),
											'type' => 'text',
						                ),		 	
						                'stripe-tax-id' => array(
						                    'label' => esc_html__( 'Stripe Tax ID', 'lt-booking' ),
											'type' => 'text',
											'desc'  => esc_html__( 'Not required. Check the https://stripe.com/docs/billing/taxes/tax-rates. You can add Products -> Tax Rates -> Tax Rate ID key. ', 'lt-booking' ),											
						                ),		 			
						                'stripe-payment-method' => array(
						                    'label' => esc_html__( 'Stripe Payment Method', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	'card',
											'desc'  => esc_html__( 'The "card" by default. Can be separated with comas. Check the https://stripe.com/docs/api/payment_methods/object#payment_method_object-type for more info.', 'lt-booking' ),											
						                ),								                				                						
										'stripe-button-header' => array(
										    'type'  => 'text',
										    'label' => esc_html__('Payment Button Header', 'lt-booking'),
										    'value'	=>	"Proceed to Payment",
										),											
										'stripe-payment-name' => array(
										    'type'  => 'text',
										    'label' => esc_html__('Payment Product Name', 'lt-booking'),
										    'value'	=>	"Car Washing Service",
										),									
						                'stripe-currency' => array(
						                    'label' => esc_html__( 'Stripe Currency', 'lt-booking' ),
											'desc'  => esc_html__( 'Check the https://stripe.com/docs/currencies', 'lt-booking'),
											'type' => 'text',
										    'value'	=>	"USD",
						                ),		                		                
						                'stripe-success-url' => array(
						                    'label' => esc_html__( 'Success Payment URL', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	"/booking-payment-succeed/",
											'desc'  => esc_html__( 'Full link on this site to the page to which customer will be redirected after successful payment.', 'lt-booking' ),
						                ),			                
						                'stripe-cancel-url' => array(
						                    'label' => esc_html__( 'Cancel Payment URL', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	"/booking-payment-canceled/",								
											'desc'  => esc_html__( 'Full link on this site to the page to which customer will be redirected after cancel or error of the payment.', 'lt-booking' ),
						                ),										
									),									
									'redirect'  => array(
						                'redirect-link' => array(
						                    'label' => esc_html__( 'Redirect link', 'lt-booking' ),
											'type' => 'text',
											'desc'  => esc_html__( 'Enter link to which user will be automatically redirected after order done.', 'lt-booking' ),
						                ),
						            ),
									'payfast'  => array(
										'payfast-sandbox' => array(
										    'type'  => 'switch',
										    'label' => esc_html__('Sandbox mode', 'lt-booking'),
										),									
						                'payfast-id' => array(
						                    'label' => esc_html__( 'Merchant ID', 'lt-booking' ),
											'type' => 'text',
											'desc'  => esc_html__( 'Get your key and activate your account on a https://payfast.co.za/', 'lt-booking' ),
						                ),
						                'payfast-key' => array(
						                    'label' => esc_html__( 'Merchant Key', 'lt-booking' ),
											'type' => 'text',
						                ),
						                'payfast-salt' => array(
						                    'label' => esc_html__( 'Merchant Salt Passphrase', 'lt-booking' ),
											'type' => 'text',
						                ),						                				                						
										'payfast-button-header' => array(
										    'type'  => 'text',
										    'label' => esc_html__('Payment Button Header', 'lt-booking'),
										    'value'	=>	"Proceed to Payment",
										),											
										'payfast-payment-name' => array(
										    'type'  => 'text',
										    'label' => esc_html__('Payment Product Name', 'lt-booking'),
										    'value'	=>	"Car Washing Service",
										),	
						                'payfast-success-url' => array(
						                    'label' => esc_html__( 'Success Payment URL', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	"/booking-payment-succeed/",
											'desc'  => esc_html__( 'Full link on this site to the page to which customer will be redirected after successful payment.', 'lt-booking' ),
						                ),			                
						                'payfast-cancel-url' => array(
						                    'label' => esc_html__( 'Cancel Payment URL', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	"/booking-payment-canceled/",								
											'desc'  => esc_html__( 'Full link on this site to the page to which customer will be redirected after cancel or error of the payment.', 'lt-booking' ),
						                ),			

						                								
/*
						                'stripe-currency' => array(
						                    'label' => esc_html__( 'Stripe Currency', 'lt-booking' ),
											'desc'  => esc_html__( 'Check the https://stripe.com/docs/currencies', 'lt-booking'),
											'type' => 'text',
										    'value'	=>	"USD",
						                ),		                		                

						                'stripe-success-url' => array(
						                    'label' => esc_html__( 'Success Payment URL', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	"/booking-payment-succeed/",
											'desc'  => esc_html__( 'Full link on this site to the page to which customer will be redirected after successful payment.', 'lt-booking' ),
						                ),			                
						                'stripe-cancel-url' => array(
						                    'label' => esc_html__( 'Cancel Payment URL', 'lt-booking' ),
											'type' => 'text',
											'value'	=>	"/booking-payment-canceled/",								
											'desc'  => esc_html__( 'Full link on this site to the page to which customer will be redirected after cancel or error of the payment.', 'lt-booking' ),
						                ),										
*/						                
									),

								),
								'show_borders' => false,
							),	                               		                
						),
					
					),
				),
			),
		);
	},
	100
);

if ( !function_exists('lt_booking_point_add_meta') ) {

	function lt_booking_point_add_meta() {
	    add_meta_box(
	        'lt-booking-shortcode',
	        esc_html__( 'LT Booking Shortcode', 'lt-booking' ),
	        'lt_booking_point_shortcode',
	        'lt-booking-point',
	        'normal',
	        'default'
	    );
	}
}
add_action('add_meta_boxes', 'lt_booking_point_add_meta');

if ( !function_exists('lt_booking_point_shortcode') ) {

	function lt_booking_point_shortcode( $post ) {

		echo esc_html__( 'Use this shortcode in order to add form on your page', 'lt-booking' ).' <code>[lt-booking id="'.$post->ID.'"]</code>';
	}
}

