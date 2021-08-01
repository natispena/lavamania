<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class ltx_Widget_Blogposts extends WP_Widget {
 
    /**
     * Widget constructor.
     */
    private $options;
    private $prefix;
    function __construct() {
 
        $this->prefix = "blogposts";
        $widget_ops = array( 'description' => esc_html__( 'Display posts with photo', 'lt-ext' ) );
        parent::__construct( false, esc_html__( 'LTX Posts', 'lt-ext' ), $widget_ops );
        
        // Create our options by using Unyson option types
        $this->options = array(
            'title' => array(
                'type' => 'text',
                'label' => esc_html__('Widget Title', 'lt-ext'),
            ),
/*            
            'style' => array(
                'type'    => 'select',
                'choices' => array(
                    'image-top' => esc_html__( 'Image at top', 'lt-ext' ),
//                    'image-left' => esc_html__( 'Image at left', 'lt-ext' ),
                ),
                'value' => 'image-top',
                'label' => esc_html__('Style', 'lt-ext'),
            ),            
*/            
            'num' => array(
                'type' => 'text',
                'label' => esc_html__('Number of posts to show', 'lt-ext'),
            ),
            'photo' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Show thumbnail', 'lt-ext'),
            ), 
            'readmore_text' => array(
                'type' => 'text',
                'label' => esc_html__('Readmore Header', 'lt-ext'),
            ),                                  
            'readmore_link' => array(
                'type' => 'text',
                'label' => esc_html__('Readmore Link', 'lt-ext'),
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

                function ltxBlogsWidgetsReinit(selector) {                  

                    var timeoutId;
                    $("#" + selector).on("remove", function(){ // ReInit options on html replace (on widget Save)

                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function(){ // wait a few milliseconds for html replace to finish
                            fwEvents.trigger("fw:options:init", { $elements: $("#" + selector) });
                            ltxBlogsWidgetsReinit(selector);
                        }, 100);
                    });           
                }

                $("#widgets-right .fw-theme-admin-widget-wrap").each(function(i, el) { 
                    ltxBlogsWidgetsReinit($(this).attr("id"));
                });
            });
        ' );
    }
}

