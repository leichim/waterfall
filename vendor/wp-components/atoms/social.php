<?php
/**
 * Displays a social links component
 */

// Atom values
$atom = wp_parse_args( $atom, array(
    'colorBackground'   => true,
    'icons'  => array(
        'email'         => 'envelope', 
        'facebook'      => 'facebook', 
        'instagram'     => 'instagram', 
        'twitter'       => 'twitter', 
        'linkedin'      => 'linkedin', 
        'google-plus'   => 'google-plus', 
        'pinterest'     => 'pinterest', 
        'reddit'        => 'reddit-alien', 
        'stumbleupon'   => 'stumbleupon',
        'whatsapp'      => 'whatsapp'
    ),
    'urls'      => array(),
    'titles'    => array()
) ); 

if( $atom['colorBackground'] ) 
    $atom['style'] .= ' components-background'; ?>

<div class="atom-social <?php echo $atom['style']; ?>" <?php echo $atom['inlineStyle']; ?>>
    
    <?php foreach( $atom['urls'] as $network => $url ) { ?>
    
        <a class="atom-network components-<?php echo esc_attr( $network ); ?>" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="author external">
            
            <?php if( isset($atom['icons'][$network]) ) { ?>
                <i class="fa fa-<?php echo $atom['icons'][$network]; ?>"></i>
            <?php } ?>
            
            <?php if( isset($atom['titles'][$network]) ) { ?>
                <span><?php echo $atom['titles'][$network]; ?></span>
            <?php } ?>
        </a>
    
    <?php } ?>
    
</div>