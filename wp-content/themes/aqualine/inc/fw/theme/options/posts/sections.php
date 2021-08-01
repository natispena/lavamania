<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'theme_block' => array(
		'title'   => esc_html__( 'Theme Block', 'aqualine' ),
		'label'   => esc_html__( 'Theme Block', 'aqualine' ),
		'type'    => 'select',
		'choices' => array(
			'none'  => esc_html__( 'Not Assigned', 'aqualine' ),
			'before_footer'  => esc_html__( 'Before Footer', 'aqualine' ),
			'subscribe'  => esc_html__( 'Subscribe', 'aqualine' ),
			'top_bar'  => esc_html__( 'Top Bar', 'aqualine' ),
		),
		'value' => 'none',
	)
);


