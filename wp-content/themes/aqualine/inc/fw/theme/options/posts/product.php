<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(			
			'featured'    => array(
				'type'    => 'checkbox',
				'label' => esc_html__( 'Featured Product', 'aqualine' ),				
				'desc'   => esc_html__( 'Image will be used as background', 'aqualine' ),
			),				
		),
	),
);

