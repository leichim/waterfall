<?php
/**
 * Contains all Event Calendar related options
 */
defined( 'ABSPATH' ) or die( 'Go eat veggies!' );

class Waterfall_Events extends Waterfall_Base {

    /**
     * Initialize our WooCommerce functions
     */
    public function initialize() { 
        
        $this->filters = [
            ['template_include', 'locateTemplate', 50]
        ];

    } 

    /**
     * Setup a custom template for the Events Calendar
     * 
     * @param String $template The template that is included
     */
    public function locateTemplate($template) {

        if( strpos($template, 'the-events-calendar/src/views/v2/default-template.php') ) {

            // Use the custom theme template
            $template = '/templates/events-calendar/default-template.php';
            
            // Check if our file exists
            if ( file_exists( STYLESHEETPATH . $template ) ) {
                $template = STYLESHEETPATH . $template;
            } elseif ( file_exists( TEMPLATEPATH . $template ) ) {
                $template = TEMPLATEPATH . $template;
            }

        }

        return $template;

    }

}