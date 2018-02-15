<?php
/**
 * Represents a modal pop-up
 */

// Atom values
$atom = MakeitWorkPress\WP_Components\Build::multiParseArgs( $atom, [
    'content'   => '',
    'data'      => [
        'id' => uniqid()
    ]
] ); 

$attributes = MakeitWorkPress\WP_Components\Build::attributes($atom['attributes']); ?>

<div <?php echo $attributes; ?>>
    <div class="atom-modal-container">
        <?php if( atom['content'] ) { ?>
            <div class="atom-modal-content">
                <?php echo $atom['content']; ?>
            </div>
        <?php } ?>
    </div>
    <a href="#" class="atom-modal-close"><i class="fa fa-times fa-2x"></i></a>        	
</div>