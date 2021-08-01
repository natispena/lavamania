<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

$aqualine_cfg = aqualine_theme_config();

$options = array(
    
    'aqualine_customizer' => array(
        'title' => esc_html__('Aqualine Colors', 'aqualine'),
        'position' => 1,
        'options' => array(

            'main_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_main'],
                'label' => esc_html__('Main Color', 'aqualine'),
            ),            
            'second_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_second'],
                'label' => esc_html__('Second Color', 'aqualine'),
            ),                
            'gray_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_gray'],
                'label' => esc_html__('Gray Color', 'aqualine'),
            ),
            'black_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_black'],
                'label' => esc_html__('Black Color', 'aqualine'),
            ),      
            'red_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_red'],
                'label' => esc_html__('Red Color', 'aqualine'),
            ),
            'green_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_green'],
                'label' => esc_html__('Green Color', 'aqualine'),
            ),            
            'white_color' => array(
                'type' => 'color-picker',
                'value' => $aqualine_cfg['color_white'],
                'label' => esc_html__('White Color', 'aqualine'),
            ),                          
            'navbar_dark_color' => array(
                'type' => 'rgba-color-picker',
                'value' => $aqualine_cfg['navbar_dark'],
                'label' => esc_html__('Navbar Dark Color', 'aqualine'),
            ),      
        ),
    ),
);

