<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(	
			'subheader'    => array(
				'label' => esc_html__( 'Sub Header', 'aqualine' ),
				'type'  => 'text',
			),					
		),
	),
);

