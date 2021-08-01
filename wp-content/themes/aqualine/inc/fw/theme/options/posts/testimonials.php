<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(
			'subheader'    => array(
				'label' => esc_html__( 'Subheader', 'aqualine' ),
				'type'  => 'text',
			),
			'rate'    => array(
				'type'    => 'select',
				'label' => esc_html__( 'Rate', 'aqualine' ),				
				'description'   => esc_html__( 'Null for hidden', 'aqualine' ),
				'choices' => array(
					0,1,2,3,4,5
				),
			),						
			'short'    => array(
				'type'    => 'checkbox',
				'label' => esc_html__( 'Short Testimonial', 'aqualine' ),				
				'description'   => esc_html__( 'Image will be hiddem and layout inverted', 'aqualine' ),
			),				
		),
	),		
);

