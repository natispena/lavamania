<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'main' => array(
		'title'   => 'LTX Post Format',
		'type'    => 'box',
		'options' => array(
			'gallery'    => array(
				'label' => esc_html__( 'Gallery', 'aqualine' ),
				'desc' => esc_html__( 'Upload featured images for slider gallery post type', 'aqualine' ),
				'type'  => 'multi-upload',
			),				
		),
	),
);

