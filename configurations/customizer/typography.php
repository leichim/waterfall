<?php
/**
 * Adds typography customizer panel
 */
defined( 'ABSPATH' ) or die( 'Go eat veggies!' );

$typography = array(
    'description'   => __('Adjust the typography at various locations here.', 'waterfall'),
    'id'            => 'waterfall_typography',
    'title'         => __('Typography', 'waterfall'),
    'panel'         => true,
    'priority'      => 20,
    'sections'      => array(
        array(
            'id'            => 'general_typography',
            'title'         => __('General', 'waterfall'),
            'fields'    => array(                   
                array(
                    'default'       => '',
                    'css'           => 'body',
                    'id'            => 'body_typography',
                    'title'         => __('General Font', 'waterfall'),
                    'type'          => 'typography'
                ),               
                array(
                    'default'       => '',
                    'css'           => '.header',
                    'id'            => 'header_menu_typography',
                    'title'         => __('Header Navigation Menu', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => '.atom-breadcrumbs',
                    'id'            => 'breadcrumbs_typography',
                    'title'         => __('Breadcrumbs', 'waterfall'),
                    'type'          => 'typography'
                ),               
                array(
                    'default'       => '',
                    'css'           => '.main-content',
                    'id'            => 'content_typography',
                    'title'         => __('Main Content', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => '.entry-meta',
                    'id'            => 'meta_typography',
                    'title'         => __('Meta', 'waterfall'),
                    'description'   => __('Meta are secondary text blocks such as the date and category of a post.', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => 'blockquote',
                    'id'            => 'blockquote_typography',
                    'title'         => __('Blockquotes', 'waterfall'),
                    'type'          => 'typography'
                )                
            )              
        ),         
        array(
            'id'            => 'headings_typography',
            'title'         => __('Headings', 'waterfall'),
            'fields'    => array(  
                array(
                    'default'       => '',
                    'css'           => 'h1, h2, h3, h4, h5, h6',
                    'columns'       => 'third',
                    'id'            => 'heading16_typography',
                    'title'         => __('All Headings', 'waterfall'),
                    'type'          => 'typography'
                ),                                 
                array(
                    'default'       => '',
                    'css'           => 'h1.page-title, .page h1.entry-title',
                    'id'            => 'page_heading_typography',
                    'title'         => __('Page Title Headings', 'waterfall'),
                    'description'   => __('Determines the typography for headings in pages, 404 pages and archives.', 'waterfall'),
                    'type'          => 'typography'
                ),               
                array(
                    'default'       => '',
                    'css'           => '.single h1.entry-title',
                    'id'            => 'post_heading_typography',
                    'title'         => __('Post Title Headings', 'waterfall'),
                    'description'   => __('Determines the typography for headings in post articles.', 'waterfall'),
                    'type'          => 'typography'
                ),
                array(
                    'default'       => '',
                    'css'           => '.single-product h1.product_title',
                    'id'            => 'product_heading_typography',
                    'title'         => __('Product Title Headings', 'waterfall'),
                    'description'   => __('Determines the typography for headings in products.', 'waterfall'),
                    'type'          => 'typography'
                ),
                array(
                    'default'       => '',
                    'css'           => '.widget-title',
                    'id'            => 'widget_title_typography',
                    'title'         => __('Widget Titles', 'waterfall'),
                    'description'   => __('Determines the typography for widget headings.', 'waterfall'),
                    'type'          => 'typography'
                ), 
                array(
                    'default'       => '',
                    'css'           => '.main-related h3',
                    'id'            => 'related_title_typography',
                    'title'         => __('Related Post Title', 'waterfall'),
                    'description'   => __('Determines the typography for the title above related posts.', 'waterfall'),
                    'type'          => 'typography'
                ),                                                               
                array(
                    'default'       => '',
                    'css'           => 'h1',
                    'columns'       => 'third',
                    'id'            => 'heading1_typography',
                    'title'         => __('Heading 1', 'waterfall'),
                    'type'          => 'typography'
                ),               
                array(
                    'default'       => '',
                    'css'           => 'h2',
                    'columns'        => 'third',
                    'id'            => 'heading2_typography',
                    'title'         => __('Heading 2', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => 'h3',
                    'columns'        => 'third',
                    'id'            => 'heading3_typography',
                    'title'         => __('Heading 3', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => 'h4',
                    'columns'        => 'third',
                    'id'            => 'heading4_typography',
                    'title'         => __('Heading 4', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => 'h5',
                    'columns'        => 'third',
                    'id'            => 'heading5_typography',
                    'title'         => __('Heading 5', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => 'h6',
                    'columns'       => 'third',
                    'id'            => 'heading6_typography',
                    'title'         => __('Heading 6', 'waterfall'),
                    'type'          => 'typography'
                )               
            )              
        ),        
        array(
            'id'            => 'footer_typography',
            'title'         => __('Footer', 'waterfall'),
            'fields'    => array(                   
                array(
                    'default'       => '',
                    'css'           => '.footer',
                    'id'            => 'footer_typography',
                    'title'         => __('Footer Content', 'waterfall'),
                    'type'          => 'typography'
                ),                
                array(
                    'default'       => '',
                    'css'           => '.footer h1, .footer h2, .footer h3, .footer h4, .footer h5, .footer h6',
                    'id'            => 'footer_titles',
                    'title'         => __('Footer Titles', 'waterfall'),
                    'type'          => 'typography'
                ),              
                array(
                    'default'       => '',
                    'css'           => '.molecule-footer-socket',
                    'id'            => 'socket_typography',
                    'title'         => __('Socket Content', 'waterfall'),
                    'type'          => 'typography'
                ),              
                array(
                    'default'       => '',
                    'css'           => '.molecule-footer-socket .atom-menu',
                    'id'            => 'socket_menu_typography',
                    'title'         => __('Socket Navigation Menu', 'waterfall'),
                    'type'          => 'typography'
                )               
            )              
        )
    )
);