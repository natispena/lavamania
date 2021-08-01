<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$aqualine_choices =  array();
$aqualine_choices['default'] = esc_html__( 'Default', 'aqualine' );

$aqualine_color_schemes = fw_get_db_settings_option( 'items' );
if ( !empty($aqualine_color_schemes) ) {

	foreach ($aqualine_color_schemes as $v) {

		$aqualine_choices[$v['slug']] = esc_html( $v['name'] );
	}
}

$aqualine_theme_config = aqualine_theme_config();
$aqualine_sections_list = aqualine_get_sections();


$options = array(
	'general' => array(
		'title'   => esc_html__( 'Page settings', 'aqualine' ),
		'type'    => 'box',
		'options' => array(		
			'general-box' => array(
				'title'   => __( 'General Settings', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(

					'margin-layout'    => array(
						'label' => esc_html__( 'Content Margin', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Margins control for content', 'aqualine' ),
						'choices' => array(
							'default'  => esc_html__( 'Top And Bottom', 'aqualine' ),
							'top'  => esc_html__( 'Top Only', 'aqualine' ),
							'bottom'  => esc_html__( 'Bottom Only', 'aqualine' ),
							'disabled' => esc_html__( 'Margin Removed', 'aqualine' ),
						),
						'value' => 'default',
					),			
					'topbar-layout'    => array(
						'label' => esc_html__( 'Topbar section', 'aqualine' ),
						'desc' => esc_html__( 'You can edit it in Sections menu of dashboard.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array('default' => 'Default') + array('hidden' => 'Hidden') + $aqualine_sections_list['top_bar'],						
						'value'	=> 'default',
					),						
					'navbar-layout'    => array(
						'label' => esc_html__( 'Navbar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array( 'default'  	=> esc_html__( 'Default', 'aqualine' ) ) + $aqualine_theme_config['navbar'] + array( 'disabled'  	=> esc_html__( 'Hidden', 'aqualine' ) ),
						'value' => $aqualine_theme_config['navbar-default'],
					),								
					'header-layout'    => array(
						'label' => esc_html__( 'Page Header', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'default'  => esc_html__( 'Default', 'aqualine' ),
							'disabled' => esc_html__( 'Hidden', 'aqualine' ),
						),
						'value' => 'default',
					),						
					'subscribe-layout'    => array(
						'label' => esc_html__( 'Subscribe Block', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Subscribe block before footer. Can be edited from Sections Menu.', 'aqualine' ),
						'choices' => array(
							'default'  => esc_html__( 'Default', 'aqualine' ),
							'disabled' => esc_html__( 'Hidden', 'aqualine' ),
						),
						'value' => 'default',
					),		
					'before-footer-layout'    => array(
						'label' => esc_html__( 'Before Footer', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Before footer sections. Edited in Sections menu.', 'aqualine' ),
						'choices' => array(
							'default'  => esc_html__( 'Default', 'aqualine' ),
							'disabled' => esc_html__( 'Hidden', 'aqualine' ),
						),
						'value' => 'default',
					),	
					'footer-layout'    => array(
						'label' => esc_html__( 'Footer', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Footer block before footer. Edited in Widgets menu.', 'aqualine' ),
						'choices' => $aqualine_theme_config['footer'] + array( 'disabled'  	=> esc_html__( 'Hidden', 'aqualine' ) ),
						'value' => $aqualine_theme_config['footer-default'],
					),	
					'footer-parallax'    => array(
						'label' => esc_html__( 'Footer Parallax', 'aqualine' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Footer block parallax effect.', 'aqualine' ),
						'choices' => array(
							'default'  => esc_html__( 'Default', 'aqualine' ),
							'disabled' => esc_html__( 'Disabled', 'aqualine' ),
						),
						'value' => 'default',
					),																			
					'color-scheme'    => array(
						'label' => esc_html__( 'Color Scheme', 'aqualine' ),
						'type'    => 'select',
						'choices' => $aqualine_choices,
						'value' => 'default',
					),		
					'body-bg'    => array(
						'label' => esc_html__( 'Background Scheme', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'default'  => esc_html__( 'White', 'aqualine' ),
							'black'  => esc_html__( 'Black', 'aqualine' ),
						),
						'value' => 'default',
					),						
					'background-image'    => array(
						'label' => esc_html__( 'Background Image', 'aqualine' ),
						'type'  => 'upload',
						'desc'   => esc_html__( 'Will be used to fill whole page', 'aqualine' ),
					),												
				),											
			),	
			'cpt' => array(
				'title'   => esc_html__( 'Blog / Gallery', 'aqualine' ),
				'type'    => 'tab',
				'options' => array(				
					'sidebar-layout'    => array(
						'label' => esc_html__( 'Blog Sidebar', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'hidden' => esc_html__( 'Hidden', 'aqualine' ),
							'left'  => esc_html__( 'Sidebar Left', 'aqualine' ),
							'right'  => esc_html__( 'Sidebar Right', 'aqualine' ),
						),
						'value' => 'hidden',
					),						
					'blog-layout'    => array(
						'label' => esc_html__( 'Blog Layout', 'aqualine' ),
						'description'   => esc_html__( 'Used only for blog pages.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'default'  => esc_html__( 'Default', 'aqualine' ),
							'classic'  => esc_html__( 'One Column', 'aqualine' ),
							'two-cols' => esc_html__( 'Two Columns', 'aqualine' ),
							'three-cols' => esc_html__( 'Three Columns', 'aqualine' ),
						),
						'value' => 'default',
					),
					'gallery-layout'    => array(
						'label' => esc_html__( 'Gallery Layout', 'aqualine' ),
						'description'   => esc_html__( 'Used only for gallery pages.', 'aqualine' ),
						'type'    => 'select',
						'choices' => array(
							'default' => esc_html__( 'Default', 'aqualine' ),
							'col-2' => esc_html__( 'Two Columns', 'aqualine' ),
							'col-3' => esc_html__( 'Three Columns', 'aqualine' ),
							'col-4' => esc_html__( 'Four Columns', 'aqualine' ),
						),
						'value' => 'default',
					),					
				)
			)	
		)
	),
);

unset($options['general']['options']['general-box']['options']['footer-parallax']);
unset($options['general']['options']['general-box']['options']['before-footer-layout']);

