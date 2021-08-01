<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => '',
		'type'    => 'box',
		'options' => array(
			'role'    => array(
				'label' => esc_html__( 'Role', 'aqualine' ),
				'type'  => 'text',
			),					
			'image' => array(
				'label' => esc_html__( 'Image', 'aqualine' ),
				'type'  => 'upload',
			),
		),
	),
);

