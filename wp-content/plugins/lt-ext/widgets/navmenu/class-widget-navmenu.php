<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class ltx_Widget_Navmenu extends WP_Widget {
 
    /**
     * Widget constructor.
     */
    private $options;
    private $prefix;
    function __construct() {
 
        $this->prefix = "navmenu";
        $widget_ops = array( 'description' => esc_html__( 'Displays two-column navmenu', 'lt-ext' ) );
        parent::__construct( false, esc_html__( 'LTX Navmenu', 'lt-ext' ), $widget_ops );
        
        $menus_ = wp_get_nav_menus();
        $menus = array();
        if ( !empty($menus_) ) {

            foreach ($menus_ as $item) {

                $menus[$item->term_id] = $item->name;
            }
        }

        // Create our options by using Unyson option types
        $this->options = array(
            'title' => array(
                'type' => 'text',
                'label' => esc_html__('Widget Title', 'lt-ext'),
            ),
            'menu' => array(
                'type' => 'select',
                'label' => esc_html__('Menu', 'lt-ext'),
                'choices'   =>  $menus,
            ),                        
        );

        add_action("admin_enqueue_scripts", array($this, "print_widget_javascript"));
    }
 
    function widget( $args, $instance ) {

        if ( !function_exists( 'fw' ) ) return false;

        extract( $args );
        $params = array();
 
        foreach ( $instance as $key => $value ) {
            $params[ $key ] = $value;
        }

        $instance = $params;
        if ( file_exists( LTX_PLUGIN_DIR . 'widgets/' . $this->prefix . '/views/widget.php' ) ) {

            include LTX_PLUGIN_DIR . 'widgets/' . $this->prefix . '/views/widget.php';
        }
    }
 
    function update( $new_instance, $old_instance ) {

        if ( !function_exists( 'fw' ) ) return false;

        return fw_get_options_values_from_input(
            $this->options,
            FW_Request::POST(fw_html_attr_name_to_array_multi_key($this->get_field_name($this->prefix)), array())
        );
    }
 
    function form( $values ) {
 
        $prefix = $this->get_field_id($this->prefix); // Get unique prefix, preventing dupplicated key
        $id = 'fw-widget-options-'. $prefix;
 
        // Print our options
        echo '<div class="fw-force-xs fw-theme-admin-widget-wrap" id="'. esc_attr($id) .'">';
        
        if ( function_exists( 'fw' ) ) {

            echo fw()->backend->render_options($this->options, $values, array(
                'id_prefix' => $prefix .'-',
                'name_prefix' => $this->get_field_name($this->prefix),
            ));
        }
            else {

            echo "<p>" . esc_html__( 'Widget requires Unyson Framework installed', 'lt-ext' ) . "</p>";
        }

        echo '</div>';

        return $values;
    }
    
    /*
     * Initialize options after saving.
     */
    function print_widget_javascript() {

        wp_add_inline_script( 'jquery-core', '
            jQuery(function($) {

                function ltxNavmenuWidgetsReinit(selector) {                  

                    var timeoutId;
                    $("#" + selector).on("remove", function(){ // ReInit options on html replace (on widget Save)

                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function(){ // wait a few milliseconds for html replace to finish
                            fwEvents.trigger("fw:options:init", { $elements: $("#" + selector) });
                            ltxNavmenuWidgetsReinit(selector);
                        }, 100);
                    });           
                }

                $("#widgets-right .fw-theme-admin-widget-wrap").each(function(i, el) { 
                    ltxNavmenuWidgetsReinit($(this).attr("id"));
                });
            });
        ' );
    }
}

