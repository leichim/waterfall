<?php
/**
 * Loads our option configurations
 */  
defined( 'ABSPATH' ) or die( 'Go eat veggies!' );

// Default posts types supported in customzer
$defaultPosts = ['post', 'page'];
if( class_exists('Waterfall_Reviews\Plugin') ) {
    $defaultPosts[] = 'reviews';
}
if( class_exists('Waterfall_Events\Plugin') ) {
    $defaultPosts[] = 'events';   
}

// The options
$options = [
    'capability'    => 'manage_options',
    'class'         => 'tabs-left',
    'id'            => 'waterfall_options',
    'location'      => 'menu', 
    'menu_icon'     => 'dashicons-admin-generic',
    'menu_title'    => __('Waterfall', 'waterfall'),
    'menu_position' => 60,
    'title'         => __('Waterfall Theme Settings', 'waterfall'),
    'sections'      => [
        'general'   => [
            'icon'          => 'settings',
            'id'            => 'general',
            'title'         => __('General', 'waterfall'),
            'description'   => __('The general settings for the theme. Are you looking for lay-out options? Those can be found in the Customizer.', 'waterfall'),
            'fields'        => [ 
                [
                    'columns'       => 'half',
                    'default'       => $defaultPosts,
                    'description'   => __('For these post types, lay-out settings will be available in the customizer, and a sidebar under widgets.', 'waterfall'),
                    'id'            => 'customizer_post_types',
                    'options'       => wf_get_post_types(true),
                    'title'         => __('Customizer Post Types', 'waterfall'),
                    'multiple'      => true,
                    'type'          => 'select'
                ],
                [
                    'columns'       => 'half',
                    'description'   => __('Enable this to Enable ElasticPress for Related Posts. ElasticSearch and the ElasticPress plugin are required.', 'waterfall'),
                    'id'            => 'enable_elastic_related',
                    'title'         => __('Enable ElasticPress for Related Posts', 'waterfall'),
                    'single'        => true,
                    'type'          => 'checkbox',
                    'style'         => 'switcher switcher-enable',
                    'options'       => [
                        'enable' => ['label' => __('Enable ElasticPress')],
                    ]
                ],   
                [
                    'default'       => '',
                    'id'            => 'integrations_heading',
                    'title'         => __('Integrations', 'waterfall'),
                    'type'          => 'heading'
                ],                                                
                [
                    'columns'       => 'half',
                    'default'       => '',
                    'description'   => __('This set-ups the correct script for loading Google Analytics. The Tracking ID should have a format of UA-000000-01.', 'waterfall'),
                    'id'            => 'analytics',
                    'title'         => __('Google Analytics Tracking ID', 'waterfall'),
                    'type'          => 'input'
                ], 
                [
                    'columns'       => 'half',
                    'default'       => '',
                    'description'   => __('This allows extensions of Waterfall to properly display Google Maps.', 'waterfall'),
                    'id'            => 'maps_api_key',
                    'title'         => __('Google Maps API Key', 'waterfall'),
                    'type'          => 'input'
                ],
                [
                    'default'       => '',
                    'id'            => 'structured_data_heading',
                    'title'         => __('Structured Data', 'waterfall'),
                    'type'          => 'heading'
                ],                                                                                   
                [
                    'columns'       => 'half',
                    'default'       => '',
                    'description'   => __('This determines what structured data is used for the website logo, usually representing the organization. Select none to discard.', 'waterfall'),
                    'id'            => 'represent_scheme',
                    'options'       => [
                        ''             => __('None', 'waterfall'),
                        'organization' => __('Organization', 'waterfall'),
                        'person'       => __('Person', 'waterfall')
                    ],
                    'title'         => __('Structured data for Website Representation', 'waterfall'),
                    'type'          => 'select'
                ],              
                [
                    'columns'       => 'half',
                    'default'       => [],
                    'description'   => __('This removes the Structured data for the selected post types.', 'waterfall'),
                    'id'            => 'scheme_post_types_disable',
                    'options'       => wf_get_post_types(true),
                    'title'         => __('Disable Microdata', 'waterfall'),
                    'multiple'      => true,
                    'type'          => 'select'
                ]
            ]
        ],
        'optimize'   => [
            'icon'          => 'access_time',
            'id'            => 'optimize',
            'title'         => __('Optimize', 'waterfall'),
            'description'   => __('Custom optimizations for the theme, slightly improving performance.', 'waterfall'),
            'fields'        => [                  
                [
                    'default'       => '',
                    'description'   => __('Improve the loading performance by enabling optimizations. Be aware that some optimizations such as Disabling XMLRPC can break plugins.', 'waterfall'),
                    'id'            => 'optimize',
                    'options'       => [
                        'deferCSS'                  => ['label' => __('Defer CSS', 'waterfall')],
                        'deferJS'                   => ['label' => __('Defer Javascript Loading', 'waterfall')],
                        'disableComments'           => ['label' => __('Disable Comments', 'waterfall')],
                        'disableEmbed'              => ['label' => __('Disable Embed Scripts. Breaks video embedding.', 'waterfall')],
                        'disableEmoji'              => ['label' => __('Disable Emoji', 'waterfall')],
                        'disableFeeds'              => ['label' => __('Disable Feeds', 'waterfall')],
                        'disableHeartbeat'          => ['label' => __('Disable Heartbeat', 'waterfall')],
                        'slowHeartbeat'             => ['label' => __('Slow Down Heartbeat Script', 'waterfall')],
                        'jqueryToFooter'            => ['label' => __('Move the jQuery Script to Footer', 'waterfall')],
                        'disablejQuery'             => ['label' => __('Disable jQuery', 'waterfall')],
                        'disablejQueryMigrate'      => ['label' => __('Disable jQuery Migrate', 'waterfall')],
                        'disableRSD'                => ['label' => __('Disable RSD', 'waterfall')],
                        'disableShortlinks'         => ['label' => __('Disable WordPress Shortlinks', 'waterfall')],                      
                        'disableVersionNumbers'     => ['label' => __('Remove WordPress Version Numbers from Scripts', 'waterfall')],            
                        'disableWLWManifest'        => ['label' => __('Disable the WLW Manifest', 'waterfall')],
                        'disableWPVersion'          => ['label' => __('Remove the WordPress Version from front-end', 'waterfall')],           
                        'disableXMLRPC'             => ['label' => __('Disable XMLRPC', 'waterfall')],
                        'limitRevisions'            => ['label' => __('Limit Post Revisions to 5', 'waterfall')],
                        'blockExternalHTTP'         => ['label' => __('Block external HTTP Requests. Breaks external embeds.', 'waterfall')],
                        'limitCommentsJS'           => ['label' => __('Enqueue Comment JavaScript only on Comments', 'waterfall')],
                        'removeCommentsStyle'       => ['label' => __('Remove Additional Styling for Comments', 'waterfall')]
                    ],
                    'title'         => __('Theme Optimizations', 'waterfall'),
                    'type'          => 'checkbox'
                ]
            ]      
        ],
        'advanced'   => [
            'icon'          => 'autorenew',
            'id'            => 'advanced',
            'title'         => __('Advanced', 'waterfall'),
            'description'   => __('Advanced theme settings', 'waterfall'),
            'fields'        => [                  
                [
                    'action'        => 'syncMultiSiteOptions',
                    'description'   => __('This function synchronizes Waterfall Customizer and Option settings for all the sites registered in a multisite network. It will use the options of the current site.', 'waterfall'),
                    'id'            => 'sync_settings',
                    'label'         => __('Synchronize', 'waterfall'),
                    'message'       => true,
                    'title'         => __('Synchronize Settings', 'waterfall'),
                    'type'          => 'button'
                ]
            ]
        ]        
    ] 
];