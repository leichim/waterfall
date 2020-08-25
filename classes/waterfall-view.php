<?php
/**
 * Contains all functionalities which determine the general display of this theme
 */
defined( 'ABSPATH' ) or die( 'Go eat veggies!' );

class Waterfall_View extends Waterfall_Base  {

    /**
     * Contains the components object
     *
     * @access public
     */
    public $components;      
    
    /**
     * Contains the templates that are routed to the /templates/ folder
     *
     * @access private
     */
    private $files; 

    /**
     * Initialize our view functions
     */
    protected function initialize() {
        
        // Template files used by Waterfall
        $this->files = apply_filters(
            'waterfall_templates', 
            ['index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home', 'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment']
        );

        $this->actions = [
            ['wp_head', 'headerHeight', 10, 0],
            ['wp_head', 'containerWidth', 10, 0],
            ['wp_head', 'analytics', 20, 0],
        ];        

        $this->filters = [
            ['body_class', 'bodyClasses'],
            ['excerpt_length', 'excerptLength', 999],
        ];
                
        // Execute our hooks
        $this->modifyTemplateFolder();
        
        // Extend theme support
        $this->themeSupport();

        // Loads our custom components from Make it WorkPress
        $this->components = new MakeitWorkPress\WP_Components\Boot();       
        
    }
    
    /**
     * Modifies the template folder for each template file
     */
    private function modifyTemplateFolder() {

        /**
         * Redefine where to look for our templates
         */        
        foreach( $this->files as $type ) {
            add_action("{$type}_template_hierarchy", function($templates) {
                
                $return = [];
                
                foreach($templates as $template) {
                    $return[] = 'templates/' . $template;    
                }
                
                return $return;
                
            });
        } 
        
    }

    /**
     * Adjusts specific styling for the header
     * Adds optional styling which can not yet be covered by wp-custom-fields
     */
    public function headerHeight() {

        $height = wf_get_data('layout', 'header_height');

        if( isset($height['amount']) && $height['amount'] && $height['unit'] ) {

            echo '<style type="text/css" id="waterfall-header-height"> 
                .molecule-header-atoms .atom-logo img { 
                    height: calc(' . $height['amount'] . $height['unit'] . ' - 16px); width: auto;
                } 
                .molecule-header-atoms .atom-menu-hamburger { 
                    margin: calc( (' . $height['amount'] . $height['unit'] . ' - 30px)/2 ) 4px; 
                }
                .molecule-header-transparent ~ .main .main-header, .molecule-header-transparent ~ .main .main-header.components-image-background { 
                    padding-top: calc(' . $height['amount'] . $height['unit'] . ' + 32px);
                }
            </style>';

        } 

    }

    /**
     * Adds additional styling for page builders if the container width is set
     */
    public function containerWidth() {
        
        $media      = '';
        $reset      = '';
        $styles     = '';
        $width      = wf_get_data('customizer', 'layout_width');

        if( isset($width['amount']) && $width['amount'] && $width['unit'] ) {

            /** For Element */
            if( did_action('elementor/loaded') ) {      
                foreach( ['narrow' => 10, 'default' => 20, 'extended' => 30, 'wide' => 40, 'wider' => 60] as $gap => $value ) {
                    
                    // Default container styles
                    $styles .= '.elementor-section-wrap > .elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-' . $gap . ' {
                        max-width: calc(' . $width['amount'] . $width['unit'] . ' + ' . $value . 'px)
                    }';

                    // Adapted media queries for our grid
                    $media .= '.elementor-section-wrap > .elementor-section.elementor-section-boxed > .elementor-column-gap-' . $gap . ' {
                        margin: 0 -' . $value/2 . 'px;
                    }';

                    // Resets our 1280px styling
                    if( $width['unit'] == 'px' && ($width['amount'] < 1280) ) {
                        $reset .= '.elementor-section-wrap > .elementor-section.elementor-section-boxed > .elementor-column-gap-' . $gap . ' {
                            margin: 0 auto;
                        }';   
                    }
                }

                /**
                 * If we have a larger grid in our settings, we have to adapt responsive containers more early.
                 * Secondly, we need to redeclare mobile padding as the inline styling overwrites the whole range.
                 */
                if( $width['unit'] == 'px' && ($width['amount'] > 1280) ) {
                    $styles .= '@media screen and (max-width: ' . $width['amount'] . $width['unit'] . ') {
                        .waterfall-fullwidth-content .elementor-section-wrap > .elementor-section > .elementor-container, 
                        [class*="elementor-location-"] .elementor-section-wrap > .elementor-section > .elementor-container {
                            padding: 0 32px;
                        }
                    }
                    @media screen and (max-width: 767px) {
                        .waterfall-fullwidth-content .elementor-section-wrap > .elementor-section > .elementor-container, 
                        [class*="elementor-location-"] .elementor-section-wrap > .elementor-section > .elementor-container {
                            padding: 0 16px;
                        }
                    }';                    
                }

                // Reset media queries for 1280px if our containers are smaller than 1280px
                if( $reset ) {
                    $styles .= '@media screen and (max-width: 1280px) {' . $reset . '}';
                }                

                // Adaptive queries depending on container width
                $styles .= '@media screen and (max-width: ' . $width['amount'] . $width['unit'] . ') {' . $media . '}';

            }
        
        }

        // Output our styles
        if( ! $styles ) {
            return;
        }

        echo '<style type="text/css" id="waterfall-container-width">' . $styles . '</style>'; 

    }

    /**
     * Adds the analytics script to the header
     */
    public function analytics() {

        $analytics = wf_get_data('options', 'analytics');
        
        if( $analytics ) {
            echo '<!-- Global site tag (gtag.js) - Google Analytics -->
            <script async="async" src="https://www.googletagmanager.com/gtag/js?id=' . $analytics . '"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag("js", new Date());
                gtag("config", "' . $analytics . '", {"anonymize_ip": true });
            </script>';
        }

    }

    /**
     * Alters our body classes
     * 
     * @param Array $classes The passed body classes
     */    
    public function bodyClasses($classes) {

        global $wp_query;

        // Retrieve default customizer and metadata
        $data       = [];
        $types      = [
            'customizer'    => ['layout', 'lightbox'],
            'colors'        => ['content_sidebar_background'],
            'layout'        => ['search_sidebar_position'],
            'meta'          => ['content_width', 'page_header_overlay']
        ];

        foreach( $types as $type => $keys ) {
            $data[$type] = wf_get_data($type, $keys);
        }
        
        // Default layout class for boxed and non-boxed
        if( $data['customizer']['layout'] ) {
            $classes[]  = 'waterfall-' . $data['customizer']['layout'] . '-layout';
        }

        if( $data['colors']['content_sidebar_background'] ) {
            $classes[]  = 'waterfall-colored-sidebar';    
        }
        
        // Initialize lightbox
        if( $data['customizer']['lightbox'] ) {
            $classes[]  = 'waterfall-lightbox';
        }

        // Set-up the sidebars for default archives and pages set-up as posts page under Settings, Reading
        $page = isset( get_queried_object()->ID ) ? get_queried_object()->ID : 0;
        
        if( is_archive() || (is_front_page() && get_option('show_on_front') == 'posts') || ( is_home() && $page = get_option('page_for_posts') ) ) {
            
            $type               = wf_get_archive_post_type();
            
            // Woocommerce archives
            if( function_exists('is_woocommerce') && is_woocommerce() ) {

                $sidebar_position   = wf_get_data('woocommerce', $type . '_archive_sidebar_position');
                $sidebar            = $sidebar_position  ? $sidebar_position : 'left';

            // Default archives
            } else {
                $sidebar_position   = wf_get_data('layout', $type . '_archive_sidebar_position');
                $sidebar            = $sidebar_position ? $sidebar_position : 'default';
            }

        }
        
        // Search Archives
        if( is_search() ) {
            $sidebar = $data['layout']['search_sidebar_position'] ? $layout['search_sidebar_position'] : 'default';  
        }

        // Single Posts and pages
        if( is_singular() ) {

            $type               = isset($wp_query->queried_object->post_type) ? $wp_query->queried_object->post_type : 'post';
            $sidebar            = function_exists('is_product') && is_product() ? wf_get_data('woocommerce', $type . '_sidebar_position') : wf_get_data('layout', $type . '_sidebar_position');
            $content_width      = wf_get_data('layout', $type . '_content_width');

            // Posts or pages with an overlay and adjustable width
            if( $data['meta']['page_header_overlay'] ) {
                $classes[] = 'waterfall-content-header-overlay';
            }
            
            if( $data['meta']['content_width']['full'] || $content_width == 'full' ) {
                $sidebar    = 'default';
                $classes[]  = 'waterfall-fullwidth-content';
            }

        }
                    
        $classes[] = apply_filters('waterfall_sidebar_class', 'waterfall-' . $sidebar . '-sidebar');
        
        return $classes;
        
    }

    /**
     * Alters the excerpt length based on our settings
     * 
     * @param Int $length The excerpt length
     */    
    public function excerptLength($length) {

        $excerpt_length = wf_get_data('customizer', 'excerpt_length');

        if( is_numeric($excerpt_length) ) {
            return absint($excerpt_length);
        }

        return $length;

    }
 
    /**
     * Enables different theme support modules
     */
    private function themeSupport() {
        
        add_theme_support( 'custom-background' ); 
        add_theme_support( 'custom-logo' ); 
		add_theme_support( 'post-thumbnails' ); 
        add_theme_support( 'title-tag' );
		add_theme_support( 'html5', ['comment-list', 'comment-form', 'search-form', 'caption'] );
       
    }    
    
}