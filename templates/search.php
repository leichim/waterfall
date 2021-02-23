<?php 
    /**
     * Displays the search page 
     *
     * Retrieves our header
     */
    wf_get_theme_header();

    // Outputs our elementor templates, unless we have the search archive running
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {    

        // Initializes our search
        $search = new Views\Index();
        
        // Build the header for our search page
        do_action('waterfall_before_search_header');

        $search->header();

        do_action('waterfall_after_search_header');

    ?>

    <div class="main-content">

        <?php do_action('waterfall_before_search_content_container'); ?>

        <?php if( $search->contentContainer ) { ?>
            <div class="components-container">    
        <?php } ?>

            <?php

                do_action('waterfall_before_search_posts');

                // Displays the grid with our posts
                $search->posts();

                do_action('waterfall_after_search_posts');

                // Displays our optional sidebar
                $search->sidebar();

                do_action('waterfall_after_search_sidebar');

            ?>

        <?php if( $search->contentContainer ) { ?>
            </div>    
        <?php } ?>

        <?php do_action('waterfall_after_search_content_container'); ?>    

    </div>

    <?php do_action('waterfall_after_search_main_content'); ?>

    <?php

    }

    /**
     * Retrieves our footer
     */
    wf_get_theme_footer(); 

?>