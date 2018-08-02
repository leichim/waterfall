<?php
 /** 
  * Displays a text input field
  */
namespace MakeitWorkPress\WP_Custom_Fields\Fields;
use MakeitWorkPress\WP_Custom_Fields\Field as Field;

// Bail if accessed directly
if ( ! defined( 'ABSPATH' ) )
    die;

class Input implements Field {
    
    public static function render($field = array()) {
        
        $attributes  = '';
        $placeholder = isset($field['placeholder']) && $field['placeholder'] ? ' placeholder="' . $field['placeholder'] . '"' : '';
        $type        = isset($field['subtype']) && $field['subtype'] ? $field['subtype'] : 'text';

        foreach( array('min', 'max', 'step') as $attribute ) {
            if( isset($field[$attribute]) && $field[$attribute] !== '' ) {
                $attributes .= ' ' . $attribute . '="' . $field[$attribute] . '"';  
            }
        }

        // Our field class
        $class = $type == 'number' ? 'small-text' : 'regular-text';
        
        return '<input class="' . $class . '" id="' . $field['id'] . '" name="' . $field['name']  . '" type="' . $type . '" value="' . $field['values'] . '"' . $placeholder . $attributes . ' />';    
    }
    
    public static function configurations() {
        $configurations = array(
            'type'      => 'input',
            'defaults'  => ''
        );
            
        return $configurations;
    }
    
}