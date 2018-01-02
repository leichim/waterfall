<?php
/**
 * Contains the basic class for new view controllers
 */
namespace Views;

defined( 'ABSPATH' ) or die( 'Go eat veggies!' );

abstract class Base {
    
    /**
     * The current type we are looking at
     * This is used to make a distinction between archives and search or pages and posts, as they share similar settings.
     *
     * @access public
     */
    public $type;    

    /**
     * Contains the list of our custom properties for each view controller
     *
     * @access protected
     */
    protected $properties; 
    
    /**
     * Contains our customizer properties
     *
     * @access protected
     */
    protected $customizer;
    
    /**
     * Contains our layout properties
     *
     * @access protected
     */
    protected $layout;  
     
    /**
     * Contains our meta properties
     *
     * @access protected
     */
    protected $meta;   
  
    /**
     * The initial state of our class
     *
     * @param string $type The type of content we are looking at. This determines a context based prefix for retrieving settings from the customizer
     */
    public function __construct( $type = '' ) {

        global $wp_query;

        // Determine our type
        $this->type = $type;

        // Determine our type on rendering 
        if( $this->type == 'archive' ) {
            $this->type = get_archive_post_type() . '_archive';
        } elseif( is_singular() && $type == 'singular' ) { 
            global $post;
            $this->type = $post->post_type;
        }         

        // Set our properties
        $this->setProperties();

        // Determine odd layout properties that can occur for archives and singulars
        $this->contentContainer = true;
        $this->mainContainer    = false; // In the future, this allows us to have a more flexible placement of the sidebar        
        $this->relatedContainer = true;      
        $this->relatedSection   = true;      
        $this->mainLayout();
    }

    /**
     * Sets all basic properties that are retrieved from our customizer or meta settings. Can only be defined in child class
     * This function should define $this->properties
     */
    abstract protected function setProperties();

    /**
     * This function automatically sets all properties based upon the array mentioned above.
     * It should be called during rendering.
     */
    protected final function getProperties() {

      

        // Loads meta data from the postmeta
        if( is_singular() && isset($this->properties['meta']) ) {
            $this->meta         = apply_filters( 'waterfall_meta_properties', get_theme_option('meta', $this->properties['meta']), get_called_class() );
        }

        // Sets general customizer properties
        if( isset($this->properties['customizer']) ) {
            $this->customizer   = apply_filters( 'waterfall_customizer_properties', get_theme_option('customizer', $this->properties['customizer']), get_called_class() );
        }

        // Sets layout customizer properties
        if( isset($this->properties['layout']) ) {
            $prefix             = $this->type ? $this->type . '_' : '';
            $this->layout       = apply_filters( 'waterfall_layout_properties', get_theme_option('layout', $this->properties['layout'], $prefix), get_called_class() );    
        }        

    }

    /**
     * Examines whether an module is disabled.
     * The parameters can be used to do a manual check
     *
     * @param string $prefix    The current prefix, such as post_related or header_
     * @param string $context   An optional context which is used for singular items to load meta data
     */
    protected function disabled( $prefix = '', $context = 'content_') {
        
        $customizer     = false;
        $disabled       = false;
        $meta           = array( 'disable' => false );
        
        // For singular items
        if( is_singular() ) {
            $disable    = get_theme_option( 'meta', $context . $prefix . '_disable' );
            $meta       = $disable ? $disable : $meta;
        }

        // General (most likely used for the general header and footer)
        $prefix     = $this->type ? $this->type . '_' . $prefix : $prefix; // If a type is defined, this will have a different prefix
        $customizer = get_theme_option( 'layout', $prefix . '_disable' );    

        if( $meta['disable'] == true || $customizer === true ) {
            $disabled   = true;
        }

        return apply_filters( 'waterfall_disabled_section', $disabled, $prefix, $context );

    }

    /**
     * Determines if we need to do some odd lay-out conditions for the main layout
     */
     private function mainLayout() {

        /**
         * Determines the settings for the content section
         */
        
        // Look if our display of content inside .main-content should be fullwidth or not
        $contentWidth               = get_theme_option( 'layout', $this->type . '_content_width' );
        $metaContentWidth           = get_theme_option( 'meta', 'content_width' );

        if( $contentWidth == 'full' || ( is_singular() && (isset($metaContentWidth['full']) && $metaContentWidth['full']) ) ) {
            $this->contentContainer = false;
        }

        /**
         * Determines the appearance and width for the related section
         */
        $relatedWidth               = get_theme_option( 'layout', $this->type . '_related_width' );

        if( $relatedWidth == 'full' ) {
            $this->relatedContainer = false;
        }

        // And obviously, we also bail out if disabled
        if( $this->disabled('related') ) {
            $this->relatedSection   = false;
        }

     }

}