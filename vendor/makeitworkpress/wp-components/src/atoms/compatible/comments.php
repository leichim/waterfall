<?php
/**
 * This is the actual output for the comments atom, as loaded through comments_template in atoms/comments.php.
 */
global $atom;
global $build;

if( ! wp_script_is('comment-reply') && apply_filters('components_comment_script', true) ) {
    wp_enqueue_script('comment-reply'); 
} 

$attributes = MakeitWorkPress\WP_Components\Build::attributes($atom['attributes']); ?>
<div <?php echo $attributes; ?>>
    
    <?php if( $atom['closed'] ) { ?> 
        <p class="atom-comments-closed"><?php echo $atom['closedText']; ?></p>
    <?php } elseif( $atom['haveComments'] ) { ?> 
    
        <?php if( $atom['title'] ) { ?> 

            <h3 class="atom-comments-title"><?php echo $atom['title']; ?></h3>

        <?php } ?>

        <ol>
            <?php wp_list_comments(); ?>
        </ol>

        <?php if( $atom['paged'] ) { ?> 
            <nav class="atom-comments-navigation">
                <?php echo $atom['pagination']; ?>    
            </nav>
        <?php } ?>
    
    <?php } ?>
    
    <?php echo $atom['form']; ?>

</div>

<?php
/**
 * Unset our global comments atom
 */
unset($GLOBALS['atom']);
?>