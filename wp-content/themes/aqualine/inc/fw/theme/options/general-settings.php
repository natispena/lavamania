<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$aqualine_theme_config = aqualine_theme_config();
$aqualine_sections_list = aqualine_get_sections();

$navbar_custom_assign = array();

if ( !empty( $aqualine_theme_config['navbar'] ) AND is_array($aqualine_theme_config['navbar']) AND sizeof( $aqualine_theme_config['navbar']) > 1 ) {

	$menus = get_terms('nav_menu');
	if ( !empty($menus) ) {

		$list = array();
		foreach ( $menus as $item ) {

			$list[$item->term_id] = $item->name;
		}

		foreach ( $aqualine_theme_config['navbar'] as $key => $val) {

			$navbar_custom_assign['navbar-'.$key.'-assign'] = array(
				'label' => sprintf( esc_html__( 'Navbar %s Assign', 'aqualine' ), ucwords($key) ),
				'type'    => 'select',
				'desc' => esc_html__( 'You can assign additional menus for inner navbar.', 'aqualine' ),
				'value' => 'default',
				'choices' => array('default' => esc_html__( 'Default', 'aqualine' )) + $list,
			);
		}

		$navbar_custom_assign = array();
	}
}

$options = array(
	'general' => array(
		'title'   => esc_html__( 'General', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => esc_html__( 'General Settings', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(						
					'page-loader'    => array(
						'type'    => 'multi-picker',
						'picker'       => array(
							'loader' => array(
								'label'   => esc_html__( 'Page Loader', 'aqualine' ),
								'type'    => 'select',
								'choices' => array(
									'disabled' => esc_html__( 'Disabled', 'aqualine' ),
									'image' => esc_html__( 'Image', 'aqualine' ),
									'enabled' => esc_html__( 'Theme Loader', 'aqualine' ),
								),
								'value' => 'enabled'
							)
						),						
						'choices' => array(
							'image' => array(
								'loader_img'    => array(
									'label' => esc_html__( 'Page Loader Image', 'aqualine' ),
									'type'  => 'upload',
								),
							),
						),
						'value' => 'enabled',
					),	
					'google_api'    => array(
						'label' => esc_html__( 'Google Maps API Key', 'aqualine' ),
						'desc'  => esc_html__( 'Required for contacts page, also used in widget. In order to use you must generate your own API on Google Maps Platform', 'aqualine' ),
						'type'  => 'text',
					),								
				),
			),
			'logo' => array(
				'title'   => esc_html__( 'Logo and Media', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(	
					'logo-box' => array(
						'title'   => esc_html__( 'Logo', 'aqualine' ),
						'type'    => 'box',
						'options' => array(			
							'favicon'    => array(
								'html' => esc_html__( 'To change Favicon go to Appearance -> Customize -> Site Identity', 'aqualine' ),
								'type'  => 'html',
							),		
				            'logo_height' => array(
				                'type'  => 'slider',
				                'value' => $aqualine_theme_config['logo_height'],
				                'properties' => array(

				                    'min' => 0,
				                    'max' => 200,
				                    'step' => 1,

				                ),
				                'label' => esc_html__('Logo Max Height, px', 'aqualine'),
				            ),  												
							'logo'    => array(
								'label' => esc_html__( 'Logo Black', 'aqualine' ),
								'type'  => 'upload',
							),
							'logo_2x'    => array(
								'label' => esc_html__( 'Logo Black 2x', 'aqualine' ),
								'type'  => 'upload',
							),	
							'logo_white'    => array(
								'label' => esc_html__( 'Logo White', 'aqualine' ),
								'type'  => 'upload',
							),
							'logo_white_2x'    => array(
								'label' => esc_html__( 'Logo White 2x', 'aqualine' ),
								'type'  => 'upload',
							),		
							'theme-icon-main'    => array(
								'label' => esc_html__( 'Headers icon', 'aqualine' ),
								'type'  => 'icon-v2',
							),								
							'widgets_bg'    => array(
								'label' => esc_html__( 'Sidebar Widgets Background', 'aqualine' ),
								'type'  => 'upload',
							),									
							'404_bg'    => array(
								'label' => esc_html__( '404 Background', 'aqualine' ),
								'type'  => 'upload',
							),	  										
						),
					),
				),
			),				
		),
	),
	'header' => array(
		'title'   => esc_html__( 'Header', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(
			'header-box-2' => array(
				'title'   => esc_html__( 'Navbar', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'navbar-default'    => array(
						'label' => esc_html__( 'Navbar Default', 'aqualine' ),
						'type'    => 'select',
						'value' => $aqualine_theme_config['navbar-default'],
						'choices' => $aqualine_theme_config['navbar'],
					),	
					'navbar-default-force'    => array(
						'label' => esc_html__( 'Navbar Default Override', 'aqualine' ),
						'desc'   => esc_html__( 'By default every page can have unqiue navbar setting. You can override them here.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Disabled. Every page uses its own settings', 'aqualine' ),
							'force'  => esc_html__( 'Enabled. Override all site pages and use Navbar Default', 'aqualine' ),
						),
						'value' => 'disabled',
					),						
					'navbar-affix'    => array(
						'label' => esc_html__( 'Navbar Sticked', 'aqualine' ),
						'desc'   => esc_html__( 'May not work with all navbar types', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'' => esc_html__( 'Allways Static', 'aqualine' ),
							'affix'  => esc_html__( 'Sticked', 'aqualine' ),
						),
						'value' => '',
					),
					'navbar-breakpoint'    => array(
						'label' => esc_html__( 'Navbar Mobile Breakpoint, px', 'aqualine' ),
						'desc'   => esc_html__( 'Mobile menu will be displayed in viewports below this value', 'aqualine' ),
						'type'    => 'text',
						'value' => '1198',
					),												
					$navbar_custom_assign,
				)
			),
			'header-box-topbar' => array(
				'title'   => esc_html__( 'Topbar', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'topbar-info'    => array(
						'label' => ' ',
						'type'    => 'html',
						'html' => esc_html__( 'You can edit topbar in sections menu of dashboard', 'aqualine' ),
					),					
					'topbar'    => array(
						'label' => esc_html__( 'Topbar visibility', 'aqualine' ),
						'desc'   => esc_html__( 'You can edit topbar layout in Sections menu', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'visible'  => esc_html__( 'Always Visible', 'aqualine' ),
							'desktop'  => esc_html__( 'Desktop Visible', 'aqualine' ),
							'desktop-tablet'  => esc_html__( 'Desktop and Tablet Visible', 'aqualine' ),
							'mobile'  => esc_html__( 'Mobile only Visible', 'aqualine' ),
							'hidden' => esc_html__( 'Hidden', 'aqualine' ),
						),
						'value' => 'hidden',
					),					
					'topbar-section'    => array(
						'label' => esc_html__( 'Topbar section', 'aqualine' ),
						'desc' => esc_html__( 'You can edit it in Sections menu of dashboard.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array('' => 'None / Hidden') + $aqualine_sections_list['top_bar'],						
						'value'	=> '',
					),						
				)
			),			
			'header-box-icons' => array(
				'title'   => esc_html__( 'Icons and Elements', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(		
					'icons-info'    => array(
						'label' => ' ',
						'type'    => 'html',
						'html' => esc_html__( 'Icons can be displayed in topbar using shortcode: [ltx-navbar-icons]', 'aqualine' ),
					),																
					'navbar-icons' => array(
		                'label' => esc_html__( 'Navbar / Topbar Icons', 'aqualine' ),
		                'desc' => esc_html__( 'Depends on theme style', 'aqualine' ),
		                'type' => 'addable-box',
		                'value' => array(),
		                'box-options' => array(
							'type'        => array(
								'type'         => 'multi-picker',
								'label'        => false,
								'desc'         => false,
								'picker'       => array(
									'type_radio' => array(
										'label'   => esc_html__( 'Type', 'aqualine' ),
										'type'    => 'radio',
										'choices' => array(
											'search' => esc_html__( 'Search', 'aqualine' ),
											'basket'  => esc_html__( 'WooCommerce Cart', 'aqualine' ),
											'profile'  => esc_html__( 'User Profile', 'aqualine' ),
											'social'  => esc_html__( 'Social Icon', 'aqualine' ),
										),
									)
								),
								'choices'      => array(
									'basket'  => array(
										'count'    => array(
											'label' => esc_html__( 'Count', 'aqualine' ),
											'type'    => 'select',
											'choices' => array(
												'show' => esc_html__( 'Show count label', 'aqualine' ),
												'hide'  => esc_html__( 'Hide count label', 'aqualine' ),
											),
											'value' => 'show',
										),											
									),
									'profile'  => array(									
									),
									'social'  => array(
					                    'text' => array(
					                        'label' => esc_html__( 'Header', 'aqualine' ),
					                        'type' => 'text',
					                    ),				                    
					                    'href' => array(
					                        'label' => esc_html__( 'External Link', 'aqualine' ),
					                        'type' => 'text',
					                        'value' => '#',
					                    ),											
									),		
								),
								'show_borders' => false,
							),	  														                	
							'icon-type'        => array(
								'type'         => 'multi-picker',
								'label'        => false,
								'desc'         => false,
								'value'        => array(
									'icon_radio' => 'default',
								),
								'picker'       => array(
									'icon_radio' => array(
										'label'   => esc_html__( 'Icon', 'aqualine' ),
										'type'    => 'radio',
										'choices' => array(
											'default'  => esc_html__( 'Default', 'aqualine' ),
											'fa' => esc_html__( 'Custom', 'aqualine' )
										),
										'desc'    => esc_html__( 'For social icons you need to use FontAwesome in any case.',
											'aqualine' ),
									)
								),
								'choices'      => array(
									'default'  => array(
									),
									'fa' => array(
										'icon_v2'  => array(
											'type'  => 'icon-v2',
											'label' => esc_html__( 'Select Icon', 'aqualine' ),
										),										
									),
								),
								'show_borders' => false,
							),
							'icon-visible'        => array(
								'label'   => esc_html__( 'Visibility', 'aqualine' ),
								'type'    => 'radio',
								'value'    => 'hidden-mob',								
								'choices' => array(
									'hidden-mob'  => esc_html__( 'Hidden on mobile', 'aqualine' ),
									'visible-mob' => esc_html__( 'Visible on mobile', 'aqualine' )
								),
							),													
		                ),
                		'template' => '{{- type.type_radio }}',		                
                    ),
					'basket-icon'    => array(
						'label' => esc_html__( 'Basket icon in navbar', 'aqualine' ),
						'desc'   => esc_html__( 'As replacement for basket in topbar in mobile view', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Hidden', 'aqualine' ),
							'mobile'  => esc_html__( 'Visible on Mobile', 'aqualine' ),
						),
						'value' => 'disabled',
					),					
				),
			),
			'header-box-1' => array(
				'title'   => esc_html__( 'Page Header H1', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'pageheader-display'    => array(
						'label' => esc_html__( 'Page Header Visibility', 'aqualine' ),
						'desc'   => esc_html__( 'Status of Page Header with H1 and Breadcrumbs', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'default' => esc_html__( 'Default', 'aqualine' ),
							'disabled'  => esc_html__( 'Force Hidden on all Pages', 'aqualine' ),
						),
						'value' => 'fixed',
					),		
					'pageheader-overlay'    => array(
						'label' => esc_html__( 'Page Header Overlay', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
						),
						'value' => 'enabled',
					),	
					'header_fixed'    => array(
						'label' => esc_html__( 'Background parallax', 'aqualine' ),
						'desc'   => esc_html__( 'Parallax effect requires large images', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Disabled', 'aqualine' ),
							'fixed'  => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'fixed',
					),														
					'header_bg'    => array(
						'label' => esc_html__( 'Inner Pages Header Background', 'aqualine' ),
						'desc'  => esc_html__( 'By default header is gray, you can replace it with background image', 'aqualine' ),
						'type'  => 'upload',
					),  			
					'wc_bg'    => array(
						'label' => esc_html__( 'WooCommerce Header Background', 'aqualine' ),
						'desc'  => esc_html__( 'Used only for WooCommerce pages', 'aqualine' ),
						'type'  => 'upload',
					),  					
					'featured_bg'    => array(
						'label' => esc_html__( 'Featured Images as Background', 'aqualine' ),
						'desc'  => esc_html__( 'Use Featured Image for Page as Header Background for all the pages', 'aqualine' ),
						'type'    => 'select',						
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),	
					'header-social'    => array(
						'label' => esc_html__( 'Social icons in page header', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'enabled',
					),	

				),
			),
		),
	),	
	'footer' => array(
		'title'   => esc_html__( 'Footer', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(

			'footer-box-1' => array(
				'title'   => esc_html__( 'Widgets', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'footer-layout-default'    => array(
						'label' => esc_html__( 'Footer Default Style', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Footer block before copyright. Edited in Widgets menu.', 'aqualine' ),
						'choices' => $aqualine_theme_config['footer'],
						'value' => $aqualine_theme_config['footer-default'],
					),						
					'footer_widgets'    => array(
						'label' => esc_html__( 'Enable Footer Widgets', 'aqualine' ),
						'desc'   => esc_html__( 'Widgets controled in Appearance -> Widgets. Column will be hidden, then no active widgets exists', 'aqualine' ),	
						'type'  => 'checkbox',
						'value'	=> 'true',
					),					
					'footer-parallax'    => array(
						'label' => esc_html__( 'Footer Parallax', 'aqualine' ),
						'type'    => 'select',							
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),						
					'footer_bg'    => array(
						'label' => esc_html__( 'Footer Background', 'aqualine' ),
						'type'  => 'upload',
					),		
					'footer-box-1-1' => array(
						'title'   => esc_html__( 'Desktop widgets visibility', 'aqualine' ),
						'type'    => 'box',
						'options' => array(

							'footer_1_hide'    => array(
								'label' => esc_html__( 'Footer 1', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),						
							),
							'footer_2_hide'    => array(
								'label' => esc_html__( 'Footer 2', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),	
							),
							'footer_3_hide'    => array(
								'label' => esc_html__( 'Footer 3', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),	
							),
							'footer_4_hide'    => array(
								'label' => esc_html__( 'Footer 4', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),	
							),
						)
					),
					'footer-box-1-2' => array(
						'title'   => esc_html__( 'Notebook widgets visibility', 'aqualine' ),
						'type'    => 'box',
						'options' => array(

							'footer_1__hide_md'    => array(
								'label' => esc_html__( 'Footer 1', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),						
							),
							'footer_2_hide_md'    => array(
								'label' => esc_html__( 'Footer 2', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),	
							),
							'footer_3_hide_md'    => array(
								'label' => esc_html__( 'Footer 3', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),	
							),
							'footer_4_hide_md'    => array(
								'label' => esc_html__( 'Footer 4', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),	
							),
						)
					),					
					'footer-box-1-3' => array(
						'title'   => esc_html__( 'Mobile widgets visibility', 'aqualine' ),
						'type'    => 'box',
						'options' => array(
							'footer_1_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 1', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),
							),
							'footer_2_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 2', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),
							),
							'footer_3_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 3', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),
							),
							'footer_4_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 4', 'aqualine' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'aqualine'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'aqualine'),
								),
							),														
						)
					)
				),
			),
			'footer-box-subscribe' => array(
				'title'   => esc_html__( 'Subscribe and Other', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'footer-sections'    => array(
						'html' => esc_html__( 'You can edit all items in Sections menu of dashboard.', 'aqualine' ),
						'type'  => 'html',
					),							
					'subscribe-section'    => array(
						'label' => esc_html__( 'Subscribe block', 'aqualine' ),
						'desc' => esc_html__( 'Section displayed before widgets on every page. You can hide in on certain page in page settings.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array('' => 'None / Hidden') + $aqualine_sections_list['subscribe'],						
						'value'	=> '',
					),
					'before-footer-section'    => array(
						'label' => esc_html__( 'Before Footer section', 'aqualine' ),
						'desc' => esc_html__( 'Section displayed under all content before subscribe/widgets.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array('' => 'None / Hidden') + $aqualine_sections_list['before_footer'],
						'value'	=> '',
					),					
				),
			),	
			'footer-box-2' => array(
				'title'   => esc_html__( 'Go Top', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(															
					'go_top_visibility'    => array(
						'label' => esc_html__( 'Go Top Visibility', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'visible'  => esc_html__( 'Always visible', 'aqualine' ),
							'desktop' => esc_html__( 'Desktop Only', 'aqualine' ),
							'mobile' => esc_html__( 'Mobile Only', 'aqualine' ),
							'hidden' => esc_html__( 'Hidden', 'aqualine' ),
						),						
						'value'	=> 'visible',
					),		
					'go_top_pos'    => array(
						'label' => esc_html__( 'Go Top Position', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'floating'  => esc_html__( 'Floating', 'aqualine' ),
							'static' => esc_html__( 'Static at the footer', 'aqualine' ),
						),						
						'value'	=> 'floating',
					),		
					'go_top_img'    => array(
						'label' => esc_html__( 'Go Top Image', 'aqualine' ),
						'type'  => 'upload',
					),		
					'go_top_icon'    => array(
						'label' => esc_html__( 'Go Top Icon', 'aqualine' ),
						'type'  => 'icon-v2',
					),					
					'go_top_text'    => array(
						'label' => esc_html__( 'Go Top Text', 'aqualine' ),
						'type'  => 'text',
					),														
				),
			),
			'footer-box-3' => array(
				'title'   => esc_html__( 'Copyrights', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(																							
					'copyrights'    => array(
						'label' => esc_html__( 'Copyrights', 'aqualine' ),
						'type'  => 'wp-editor',
					),									
				),
			),					
		),
	),	
	'layout' => array(
		'title'   => esc_html__( 'Posts Layout', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(

			'layout-box-1' => array(
				'title'   => esc_html__( 'Blog Posts', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(

					'blog_layout'    => array(
						'label' => esc_html__( 'Blog Layout', 'aqualine' ),
						'desc'   => esc_html__( 'Default blog page layout.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'classic'  => esc_html__( 'One Column', 'aqualine' ),
							'two-cols' => esc_html__( 'Two Columns', 'aqualine' ),
							'three-cols' => esc_html__( 'Three Columns', 'aqualine' ),
						),
						'value' => 'classic',
					),				
					'blog_list_sidebar'    => array(
						'label' => esc_html__( 'Blog List Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'aqualine' ),
							'left' => esc_html__( 'Left', 'aqualine' ),
							'right' => esc_html__( 'Right', 'aqualine' ),
						),
						'value' => 'right',
					),				
					'blog_post_sidebar'    => array(
						'label' => esc_html__( 'Blog Post Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'aqualine' ),
							'left' => esc_html__( 'Left', 'aqualine' ),
							'right' => esc_html__( 'Right', 'aqualine' ),
						),
						'value' => 'right',
					),																				
					'excerpt_auto'    => array(
						'label' => esc_html__( 'Excerpt Classic Blog Size', 'aqualine' ),
						'desc'  => esc_html__( 'Automaticly cuts content for blogs', 'aqualine' ),
						'value'	=> 350,
						'type'  => 'short-text',
					),
					'excerpt_masonry_auto'    => array(
						'label' => esc_html__( 'Excerpt Masonry Blog Size', 'aqualine' ),
						'desc'  => esc_html__( 'Automaticly cuts content for blogs', 'aqualine' ),
						'value'	=> 150,
						'type'  => 'short-text',
					),
					'blog_gallery_autoplay'    => array(
						'label' => esc_html__( 'Gallery post type autoplay, ms', 'aqualine' ),
						'desc'  => esc_html__( 'Set 0 to disable autoplay', 'aqualine' ),
						'type'  => 'text',
						'value' => '4000',
					),						
				)
			),
			'layout-box-2' => array(
				'title'   => esc_html__( 'Services', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(	
					'services_list_layout'    => array(
						'label' => esc_html__( 'Services List Layout', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'classic'  => esc_html__( 'One Column', 'aqualine' ),
							'two-cols' => esc_html__( 'Two Columns', 'aqualine' ),
							'three-cols' => esc_html__( 'Three Columns', 'aqualine' ),
						),
						'value' => 'two-cols',
					),						
					'services_list_sidebar'    => array(
						'label' => esc_html__( 'Services List Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'aqualine' ),
							'left' => esc_html__( 'Left', 'aqualine' ),
							'right' => esc_html__( 'Right', 'aqualine' ),
						),
						'value' => 'hidden',
					),				
					'services_post_sidebar'    => array(
						'label' => esc_html__( 'Services Post Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'aqualine' ),
							'left' => esc_html__( 'Left', 'aqualine' ),
							'right' => esc_html__( 'Right', 'aqualine' ),
						),
						'value' => 'hidden',
					),					
				)
			),
			'layout-box-3' => array(
				'title'   => esc_html__( 'WooCommerce', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'shop_list_sidebar'    => array(
						'label' => esc_html__( 'WooCommerce List Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'aqualine' ),
							'left' => esc_html__( 'Left', 'aqualine' ),
							'right' => esc_html__( 'Right', 'aqualine' ),
						),
						'value' => 'left',
					),				
					'shop_post_sidebar'    => array(
						'label' => esc_html__( 'WooCommerce Product Sidebar', 'aqualine' ),
						'desc'   => esc_html__( 'Blog Post Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'aqualine' ),
							'left' => esc_html__( 'Left', 'aqualine' ),
							'right' => esc_html__( 'Right', 'aqualine' ),
						),
						'value' => 'hidden',
					),											
					'excerpt_wc_auto'    => array(
						'label' => esc_html__( 'Excerpt WooCommerce Size', 'aqualine' ),
						'desc'  => esc_html__( 'Automaticly cuts description for products', 'aqualine' ),
						'value'	=> 50,
						'type'  => 'short-text',
					),		
					'wc_zoom'    => array(
						'label' => esc_html__( 'WooCommerce Product Hover Zoom', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Enables mouse hover zoom in single product page', 'aqualine' ),
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),
					'wc_hover_gallery'    => array(
						'label' => esc_html__( 'Hover Gallery Photo ', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Display first gallery image on product list hover', 'aqualine' ),
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),					
					'wc_columns'    => array(
						'label' => esc_html__( 'Columns number', 'aqualine' ),
						'desc'  => esc_html__( 'Overrides default WooCommerce settings', 'aqualine' ),
						'type'  => 'text',
						'value' => '3',
					),
					'wc_per_page'    => array(
						'label' => esc_html__( 'Products per Page', 'aqualine' ),
						'type'  => 'text',
						'value' => '6',
					),
					'wc_show_list_excerpt'    => array(
						'label' => esc_html__( 'Display Excerpt in Shop List', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'enabled',
					),					
					'wc_show_list_rate'    => array(
						'label' => esc_html__( 'Display Rate in Shop List', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),
					'wc_show_list_attr'    => array(
						'label' => esc_html__( 'Display Attributes in Shop List', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),
					'wc_show_more'    => array(
						'label' => esc_html__( 'Display Read More', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'aqualine' ),
							'enabled' => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled',
					),					
					'wc_new_days'    => array(
						'label' => esc_html__( 'Number of days to display New label. Set 0 to hide.', 'aqualine' ),
						'type'  => 'text',
						'value' => '30',
					),						
				)
			),
			'layout-box-4' => array(
				'title'   => esc_html__( 'Gallery', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(													
					'gallery_layout'    => array(
						'label' => esc_html__( 'Default Gallery Layout', 'aqualine' ),
						'desc'   => esc_html__( 'Default galley page layout.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'col-2' => esc_html__( 'Two Columns', 'aqualine' ),
							'col-3' => esc_html__( 'Three Columns', 'aqualine' ),
							'col-4' => esc_html__( 'Four Columns', 'aqualine' ),
						),
						'value' => 'col-2',
					),						
				)
			)
		)
	),
	'fonts' => array(
		'title'   => esc_html__( 'Fonts', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(

			'fonts-box' => array(
				'title'   => esc_html__( 'Fonts Settings', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'font-main'                => array(
						'label' => __( 'Main Font', 'aqualine' ),
						'type'  => 'typography-v2',
						'desc'	=>	esc_html__( 'Use https://fonts.google.com/ to find font you need', 'aqualine' ),
						'value'      => array(
							'family'    => $aqualine_theme_config['font_main'],
							'subset'    => 'latin-ext',
							'variation' => $aqualine_theme_config['font_main_var'],
							'size'      => 0,
							'line-height' => 0,
							'letter-spacing' => 0,
							'color'     => '#000'
						),
						'components' => array(
							'family'         => true,
							'size'           => false,
							'line-height'    => false,
							'letter-spacing' => false,
							'color'          => false
						),
					),
					'font-main-weights'    => array(
						'label' => esc_html__( 'Additonal weights', 'aqualine' ),
						'desc'  => esc_html__( 'Coma separates weights, for example: "800,900"', 'aqualine' ),
						'type'  => 'text',
						'value'  => $aqualine_theme_config['font_main_weights'],							
					),											
					'font-headers'                => array(
						'label' => __( 'Headers Font', 'aqualine' ),
						'type'  => 'typography-v2',
						'value'      => array(
							'family'    => $aqualine_theme_config['font_headers'],
							'subset'    => 'latin-ext',
							'variation' => $aqualine_theme_config['font_headers_var'],
							'size'      => 0,
							'line-height' => 0,
							'letter-spacing' => 0,
							'color'     => '#000'
						),
						'components' => array(
							'family'         => true,
							'size'           => false,
							'line-height'    => false,
							'letter-spacing' => false,
							'color'          => false
						),
					),
					'font-headers-weights'    => array(
						'label' => esc_html__( 'Additonal weights', 'aqualine' ),
						'desc'  => esc_html__( 'Coma separates weights, for example: "600,800"', 'aqualine' ),
						'type'  => 'text',
						'value'  => $aqualine_theme_config['font_headers_weights'],						
					),
					'font-subheaders'                => array(
						'label' => __( 'SubHeaders Font', 'aqualine' ),
						'type'  => 'typography-v2',
						'value'      => array(
							'family'    => $aqualine_theme_config['font_subheaders'],
							'subset'    => 'latin-ext',
							'variation' => $aqualine_theme_config['font_subheaders_var'],
							'size'      => 0,
							'line-height' => 0,
							'letter-spacing' => 0,
							'color'     => '#000'
						),
						'components' => array(
							'family'         => true,
							'size'           => false,
							'line-height'    => false,
							'letter-spacing' => false,
							'color'          => false
						),
					),
					'font-subheaders-weights'    => array(
						'label' => esc_html__( 'Additonal weights', 'aqualine' ),
						'desc'  => esc_html__( 'Coma separates weights, for example: "600,800"', 'aqualine' ),
						'type'  => 'text',
						'value'  => $aqualine_theme_config['font_subheaders_weights'],						
					),							
				),
			),
			'fontello-box' => array(
				'title'   => esc_html__( 'Fontello', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'fontello-local'    => array(
						'label' => esc_html__( 'Local Fontello Packs', 'aqualine' ),
						'desc'   => esc_html__( 'Import the same files from /assets/fontello/ directory of theme.', 'aqualine' ),	
						'type'  => 'checkbox',
						'value'	=> false,
					),							
					'fontello-css'    => array(
						'label' => esc_html__( 'Fontello Codes CSS', 'aqualine' ),
						'desc'  => esc_html__( 'Upload *-codes.css postfix file here', 'aqualine' ),
						'type'  => 'upload',
						'images_only' => false,
					),		
					'fontello-ttf'    => array(
						'label' => esc_html__( 'Fontello TTF', 'aqualine' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-eot'    => array(
						'label' => esc_html__( 'Fontello EOT', 'aqualine' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-woff'    => array(
						'label' => esc_html__( 'Fontello WOFF', 'aqualine' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-woff2'    => array(
						'label' => esc_html__( 'Fontello WOFF2', 'aqualine' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-svg'    => array(
						'label' => esc_html__( 'Fontello SVG', 'aqualine' ),
						'type'  => 'upload',
						'images_only' => false,
					),												
				),
			),

		),
	),	
	'social' => array(
		'title'   => esc_html__( 'Social', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(
			'social-box' => array(
				'title'   => esc_html__( 'Social', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(
					'target-social'    => array(
						'label' => esc_html__( 'Open social links in', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'self'  => esc_html__( 'Same window', 'aqualine' ),
							'blank' => esc_html__( 'New window', 'aqualine' ),
						),
						'value' => 'self',
					),		
					'social-header' => array(
                        'label' => esc_html__( 'Social Header', 'aqualine' ),
                        'type' => 'text',
                        'value' => 'Follow us',
                    ),		  
		            'social-icons' => array(
		                'label' => esc_html__( 'Social Icons', 'aqualine' ),
		                'type' => 'addable-box',
		                'value' => array(),
		                'desc' => esc_html__( 'Visible in inner page header', 'aqualine' ),
		                'box-options' => array(
		                    'icon_v2' => array(
		                        'label' => esc_html__( 'Icon', 'aqualine' ),
		                        'type'  => 'icon-v2',
		                    ),
		                    'text' => array(
		                        'label' => esc_html__( 'Text', 'aqualine' ),
		                        'desc' => esc_html__( 'If needed', 'aqualine' ),
		                        'type' => 'text',
		                    ),
		                    'href' => array(
		                        'label' => esc_html__( 'Link', 'aqualine' ),
		                        'type' => 'text',
		                        'value' => '#',
		                    ),		                    
		                ),
                		'template' => '{{- text }}',		                
                    ),								
				),
			),
		),
	),	
	'colors' => array(
		'title'   => esc_html__( 'Colors Schemes', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(			
			'schemes-box' => array(
				'title'   => esc_html__( 'Additional Color Schemes Settings', 'aqualine' ),
				'type'    => 'box',
				'options' => array(
					'advice'    => array(
						'html' => esc_html__( 'You also need to change the global settings in Appearance -> Customize -> Aqualine settings', 'aqualine' ),
						'type'  => 'html',
					),	
					'items' => array(
						'label' => esc_html__( 'Theme Color Schemes', 'aqualine' ),
						'type' => 'addable-box',
						'value' => array(),
						'desc' => esc_html__( 'Can be selected in page settings', 'aqualine' ),
						'box-options' => array(
							'slug' => array(
								'label' => esc_html__( 'Scheme ID', 'aqualine' ),
								'type' => 'text',
								'desc' => esc_html__( 'Required Field', 'aqualine' ),
								'value' => '',
							),							
							'name' => array(
								'label' => esc_html__( 'Scheme Name', 'aqualine' ),
								'desc' => esc_html__( 'Required Field', 'aqualine' ),
								'type' => 'text',
								'value' => '',
							),
							'logo'    => array(
								'label' => esc_html__( 'Logo Black', 'aqualine' ),
								'type'  => 'upload',
							),
							'logo_2x'    => array(
								'label' => esc_html__( 'Logo Black 2x', 'aqualine' ),
								'type'  => 'upload',
							),
							'logo_white'    => array(
								'label' => esc_html__( 'Logo White', 'aqualine' ),
								'type'  => 'upload',
							),		
							'logo_white_2x'    => array(
								'label' => esc_html__( 'Logo White 2x', 'aqualine' ),
								'type'  => 'upload',
							),		
							'main-color'  => array(
								'label' => esc_html__( 'Main Color', 'aqualine' ),
								'type'  => 'color-picker',
							),
							'second-color' => array(
								'label' => esc_html__( 'Second Color', 'aqualine' ),
								'type'  => 'color-picker',
							),
							'gray-color' => array(
								'label' => esc_html__( 'Gray Color', 'aqualine' ),
								'type'  => 'color-picker',
							),								
							'black-color' => array(
								'label' => esc_html__( 'Black Color', 'aqualine' ),
								'type'  => 'color-picker',
							),	
							'white-color' => array(
								'label' => esc_html__( 'White Color', 'aqualine' ),
								'type'  => 'color-picker',
							),								
						),
						'template' => '{{- name }}',
					),
				),
			),
		),
	),	
	'popup' => array(
		'title'   => esc_html__( 'Popup', 'aqualine' ),
		'type'    => 'tab',
		'options' => array(
			'popup-box' => array(
				'title'   => esc_html__( 'Popup settings', 'aqualine' ),
				'type'    => 'box',
				'options' => array(						
					'popup-status'    => array(
						'label'   => esc_html__( 'Status', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Disabled', 'aqualine' ),
							'enabled'  => esc_html__( 'Enabled', 'aqualine' ),
						),
						'value' => 'disabled'
					),						
					'popup-hours'    => array(
						'label' => esc_html__( 'Period hidden, days', 'aqualine' ),
						'type'  => 'text',
						'value'	=>	'24',
					),						
					'popup-text'    => array(
						'label' => esc_html__( 'Popup text', 'aqualine' ),
						'type'  => 'wp-editor',
					),
					'popup-bg'    => array(
						'label' => esc_html__( 'Popup Background', 'aqualine' ),
						'type'  => 'upload',
					),					
					'popup-yes'    => array(
						'label' => esc_html__( 'Yes button', 'aqualine' ),
						'type'  => 'text',
						'value'	=>	'Yes',
					),	
					'popup-no'    => array(
						'label' => esc_html__( 'No button', 'aqualine' ),
						'type'  => 'text',
						'value'	=>	'No',
					),																
					'popup-no-link'    => array(
						'label' => esc_html__( 'No link', 'aqualine' ),
						'type'  => 'text',
						'value'	=>	'https://google.com',
					),																
				),	
			),
		),
	),
);

unset($options['popup']);
unset($options['header']['header-box-topbar']);
unset($options['general']['options']['logo']['options']['logo-box']['options']['theme-icon-main']);
unset($options['general']['options']['logo']['options']['logo-box']['options']['widgets_bg']);
unset($options['general']['options']['logo']['options']['logo-box']['options']['404_bg']);

if ( function_exists('ltx_share_buttons_conf') ) {

	$share_links = ltx_share_buttons_conf();

	$share_links_options = array();
	if ( !empty($share_links) ) {

		$share_links_options = array(

			'share_icons_hide' => array(
                'label' => esc_html__( 'Hide all share icons block', 'aqualine' ),
                'type'  => 'checkbox',
                'value'	=>	false,
            ),
		);
		foreach ( $share_links as $key => $item ) {

			$state = fw_get_db_settings_option( 'share_icon_' . $key );

			$value = false;
			if ( is_null($state) AND $item['active'] == 1 ) {

				$value = true;
			}

			$share_links_options[] =
			array(
				'share_icon_'.$key => array(
	                'label' => $item['header'],
	                'type'  => 'checkbox',
	                'value'	=>	$value,
	            ),
			);
		}
	}

	$share_links_options['share-add'] = array(

        'label' => esc_html__( 'Custom Share Buttons', 'aqualine' ),
        'type' => 'addable-box',
        'value' => array(),
        'desc' => esc_html__( 'You can use {link} and {title} variables to set url. E.g. "http://www.facebook.com/sharer.php?u={link}"', 'aqualine' ),
        'box-options' => array(
            'icon' => array(
                'label' => esc_html__( 'Icon', 'aqualine' ),
                'type'  => 'icon-v2',
            ),
            'header' => array(
                'label' => esc_html__( 'Header', 'aqualine' ),
                'type' => 'text',
            ),
            'link' => array(
                'label' => esc_html__( 'Link', 'aqualine' ),
                'type' => 'text',
                'value' => '',
            ),		  
            'color' => array(
                'label' => esc_html__( 'Color', 'aqualine' ),
                'type' => 'color-picker',
                'value' => '',
            ),		              
        ),
		'template' => '{{- header }}',		                
    );

	$options['social']['options']['share-box'] = array(
		'title'   => esc_html__( 'Share Buttons', 'aqualine' ),
		'type'    => 'tab',
		'options' => $share_links_options,
	);
}

