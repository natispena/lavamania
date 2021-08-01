<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(
			"subheader" => array(
				"label" => esc_html__("Subheader", 'aqualine'),
				"type" => "text"
			),							
			"cut" => array(
				"label" => esc_html__("Excerpt", 'aqualine'),
				"type" => "textarea"
			),							
			"price" => array(
				"label" => esc_html__("Price", 'aqualine'),
				'desc' => esc_html__( 'Use {{ brackets }} to add postfix', 'aqualine' ),
				"type" => "text"
			),		
			'link'    => array(
				'label' => esc_html__( 'External Link', 'aqualine' ),
				'desc' => esc_html__( 'Replaces default service link (get more)', 'aqualine' ),				
				'type'  => 'text',
			),							
		),
	),		
);

