<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'main' => array(
		'title'   => 'Additonal',
		'type'    => 'box',
		'options' => array(
			'image'    => array(
				'label' => esc_html__( 'Pagination Image', 'aqualine' ),
				'type'  => 'upload',
			),				
			'header'    => array(
				'label' => esc_html__( 'Pagination Header', 'aqualine' ),
				'type'  => 'text',
			),				
		),
	),
);

