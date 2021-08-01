<?php

class FW_Option_Type_New extends FW_Option_Type
{
    public function get_type()
    {
        return 'bootstrap-date';
    }

    /**
     * @internal
     */
    protected function _enqueue_static($id, $option, $data)
    {
    	/*
        $uri = get_template_directory_uri() .'/inc/includes/option-types/'. $this->get_type() .'/static';
        wp_enqueue_style(
            'fw-option-'. $this->get_type(),
            $uri .'/css/styles.css'
        );

        wp_enqueue_script(
            'fw-option-'. $this->get_type(),
            $uri .'/js/scripts.js',
            array('fw-events', 'jquery')
        );
        */
        /*
        wp_enqueue_script(
            'fw-option-'. $this->get_type(),
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js',
            array('fw-events', 'jquery', 'moment')
        );       
*/
        ltb_wp_enqueue('script', 'ltb-bootstrap-datetime-picker', 'assets/js/bootstrap-datetimepicker.min.js', array('jquery', 'moment', 'fw-events'));

        ltb_wp_enqueue('style', 'ltb-bootstrap-datetime-picker', 'assets/css/bootstrap-datetimepicker.css');

        ltb_wp_enqueue('style', 'ltb-bootstrap-datetime-picker-glyph', 'assets/css/bootstrap-datetimepicker-standalone.min.css');

    }

    /**
     * @internal
     */
    protected function _render($id, $option, $data)
    {
        /**
         * $data['value'] contains correct value returned by the _get_value_from_input()
         * You decide how to use it in html
         */
        $option['attr']['value'] = (string)$data['value'];

        /**
         * $option['attr'] contains all attributes.
         *
         * Main (wrapper) option html element should have "id" and "class" attribute.
         *
         * All option types should have in main element the class "fw-option-type-{$type}".
         * Every javascript and css in that option should use that class.
         *
         * Remaining attributes you can:
         *  1. use them all in main element (if option itself has no input elements)
         *  2. use them in input element (if option has input element that contains option value)
         *
         * In this case you will use second option.
         */


        $wrapper_attr = array(
            'id'    => $option['attr']['id'],
            'class' => $option['attr']['class'],
        );
        $html = '';
        $html .=    "<div class='input-group date' id='".esc_attr($option['attr']['id'])."-wrap'>
               <input type='text' name='".esc_attr($option['attr']['name'])."' class='form-control ".esc_attr($option['attr']['class'])."'  id='".esc_attr($option['attr']['id'])."' value='".esc_attr($option['attr']['value'])."' />
               <span class='input-group-addon'>
               <span class='glyphicon glyphicon-calendar'></span>
               </span>
            </div>";

            if ( strpos (strtolower(get_option('time_format')), 'a' ) ) {

                $format = 'YYYY-MM-DD hh:mm A';
            }
                else {

                $format = 'YYYY-MM-DD HH:mm';
            }

        $html .= "<script>jQuery(function () {
             jQuery('#".$option['attr']['id']."-wrap').datetimepicker({
                format: '".$format."',
                sideBySide: true
             });
         });</script>";

        unset(
            $option['attr']['id'],
            $option['attr']['class']
        );

        return $html;
    }

    /**
     * @internal
     */
    protected function _get_value_from_input($option, $input_value)
    {
        /**
         * In this method you receive $input_value (from form submit or whatever)
         * and must return correct and safe value that will be stored in database.
         *
         * $input_value can be null.
         * In this case you should return default value from $option['value']
         */

        if (is_null($input_value)) {
            $input_value = $option['value'];
        }

        return (string)$input_value;
    }

    /**
     * @internal
     */
    protected function _get_defaults()
    {
        /**
         * These are default parameters that will be merged with option array.
         * They makes possible that any option has
         * only one required parameter array('type' => 'new').
         */

        return array(
            'value' => ''
        );
    }
}

FW_Option_Type::register('FW_Option_Type_New');

