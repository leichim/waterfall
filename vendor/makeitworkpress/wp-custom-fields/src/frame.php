<?php
/**
 * Creates the variable values for a new options frame
 * This acts as the main controller for passing data to a template.
 */
namespace MakeitWorkPress\WP_Custom_Fields;
use stdClass as stdClass;

// Bail if accessed directly
if ( ! defined('ABSPATH') ) {
    die;
}

class Frame {
    
    // Contains our frame
    private $frame;
    
    /**
     * Set our values
     *
     * @param array $frames The array with option frames, such as option pages or metaboxes
     * @param array $values The array with values for the option fields
     */
    public function __construct( Array $frame, $values = '' ) {
        
        // Our frame and values
        $this->frame    = $frame;  
        $this->values   = $values;
        
        // Default public variables
        $this->class            = isset($frame['class']) ? esc_attr($frame['class']) : '';
        $this->errors           = ''; // Used within option pages
        $this->id               = esc_attr($frame['id']);
        $this->resetButton      = ''; // Used within option pages
        $this->restoreButton    = ''; // Used within option pages
        $this->saveButton       = ''; // Used within option pages
        $this->sections         = [];
        $this->settingFields    = ''; // Used within option pages
        $this->title            = esc_html($frame['title']);
        $this->type             = '';

        // Include our scripts and media
        wp_enqueue_media();  

        if( ! wp_script_is('alpha-color-picker') ) {
            wp_enqueue_script('alpha-color-picker');
        }
        
        if( ! wp_script_is('wp-custom-fields-js') ) {
            wp_enqueue_script('wp-custom-fields-js');  
        }       
        
        // Populate Variables
        $this->populateSections();
        
    }
    
    /**
     * Populates the sections and their fields
     */
    private function populateSections() {
    
        if( ! isset($this->frame['sections']) || ! is_array($this->frame['sections']) )
            return;
        
        // Current section
        $transient              = get_transient( 'wp_custom_fields_current_section_' . $this->frame['id'] );
        $this->currentSection   = ! empty( $transient ) ? $transient : array_values($this->frame['sections'])[0]['id'];   
        
        // Loop through our sections
        foreach( $this->frame['sections'] as $key => $section ) {
            
            if( ! isset($section['id']) )
                continue;
            
            $this->sections[$key]                  = $section;
            $this->sections[$key]['active']        = $this->currentSection == $section['id'] ? 'active'          : '';
            $this->sections[$key]['description']   = isset( $section['description'] ) ? esc_textarea($section['description']) : '';
            $this->sections[$key]['fields']        = [];
            $this->sections[$key]['icon']          = ! empty( $section['icon'] ) ? esc_html($section['icon'])  : false;
            $this->sections[$key]['id']            = esc_attr($section['id']);
            $this->sections[$key]['tabs']          = isset( $section['tabs'] ) && $section['tabs'] == false ? false : true;
            $this->sections[$key]['title']         = isset( $section['title'] ) ? esc_html($section['title'])  : __( 'Titleless Section', 'wp-custom-fields' );

            if( ! isset($section['fields']) || ! is_array($section['fields']) ) {
                continue;
            }
            
            foreach( $section['fields'] as $field ) {

                // Fields without an id are not added
                if( ! isset($field['id']) )
                    continue;

                $this->sections[$key]['fields'][]  = $this->populateField( $field );

            }
                
        }
        
    }
    
    /**
     * Populates the fields. Is executed by $this->populateSections
     *
     * @param array $fields The array from a single field
     */
    private function populateField( Array $field = [] ) {
        
        
        // Populate our variables
        $field                  = $field;
        $field['column']        = isset( $field['columns'] )            ?  'wcf-' . esc_attr($field['columns']) : 'wcf-full';
        $field['description']   = isset( $field['description'] )        ?  esc_textarea($field['description'])      : '';
        $field['form']          = '<div class="error notice"><p>' . sprintf( __('The given field class does not exist for the field with id: %s', 'wp-custom-fields'), $field['id']) . '</p></div>';
        
        // Make sure our IDs do not contain brackets
        $field['id']            = str_replace( '[', '_', esc_attr($field['id']) ); 
        $field['id']            = str_replace( ']', '', esc_attr($field['id']) ); 
        $field['name']          = isset( $field['name'] )               ? esc_attr($field['name'])          : $field['id'];
        
        $field['placeholder']   = isset( $field['placeholder'] )        ? esc_attr($field['placeholder'])   : '';
        $field['title']         = isset( $field['title'] )              ? esc_html($field['title'])         : '';
        $field['titleTag']      = isset( $field['type'] ) && $field['type'] == 'heading'           ? 'h3'                              : 'h4';

        // We should have a field type
        if( ! isset($field['type']) ) {
            $field['form']      = '<div class="error notice"><p>' . sprintf( __('The type is not defined for the field with id: %s', 'wp-custom-fields'), $field['id']) . '</p></div>';
            $field['type']      = 'unknown';
            return $field;
        }

        $field['type']          = esc_attr($field['type']);
        
        // The class
        $class                  = apply_filters( 'wp_custom_fields_field_class', 'MakeitWorkPress\WP_Custom_Fields\Fields\\' . ucfirst( $field['type'] ), $field );
        
        // Render our field form, allow custom fields to be filtered.   
        if( class_exists($class) ) {

            $configurations     = $class::configurations();
        
            // Check if there is a default value set up, and whether there is a value already stored for the specific field
            $default            = isset( $field['default'] )            ? $field['default'] : $configurations['defaults'];
            $field['values']    = isset( $this->values[$field['id']] )  ? maybe_unserialize( $this->values[$field['id']] ) : $default; 

            // Get the buffered string output from our rendered templates
            ob_start();
                $class::render($field);
            $form = ob_get_clean();

            $field['form']      = apply_filters( 'wp_custom_fields_field_form', $form, $field );

        }
        
        return $field;
        
    }
    
    /**
     * Displays the frame
     */
    public function render() {

        // If we have nothing, return the nothing 
        if( empty($this->sections) ) {
            require( WP_CUSTOM_FIELDS_PATH . '/templates/nothing.php' );
            return;
        } 
        
        // Cast the object to the frame variable.
        $frame = $this;
        
        // Render the frame
        require( WP_CUSTOM_FIELDS_PATH . '/templates/frame.php' );
        
    }
    
}