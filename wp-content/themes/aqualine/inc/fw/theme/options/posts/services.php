<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(			
			'header'    => array(
				'label' => esc_html__( 'Alternative Header', 'aqualine' ),
				'desc' => esc_html__( 'Use {{ brackets }} to headlight', 'aqualine' ),
				'type'  => 'text',
			),		
			'cut'    => array(
				'label' => esc_html__( 'Short Description', 'aqualine' ),
				'type'  => 'textarea',
			),								
			'link'    => array(
				'label' => esc_html__( 'External Link', 'aqualine' ),
				'desc' => esc_html__( 'Replaces default service link', 'aqualine' ),				
				'type'  => 'text',
			),		
		),
	),
);

