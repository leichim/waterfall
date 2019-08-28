<?php
/**
 * Displays the default featured image
 */

// Atom values
$atom = wp_parse_args( $atom, [
    'enlarge'   => false,
    'image'     => '',      // Expects a custom image tag for the image, including the html or an id to an image. Also accepts custom string to look for the image id in a meta field
    'lazyload'  => false,   // Lazyload an image
    'link'      => '',      // A custom link from the image. Also accepts post to load the permalink for the post
    'post'      => null,
    'schema'    => true,                    // If microdata is rendered or not    
    'size'      => 'large'
 ] );

// Custom link to a post
if( $atom['link'] == 'post' ) {
    $atom['link'] = is_numeric( $atom['post'] ) || is_object( $atom['post'] ) ? esc_url( get_permalink( $atom['post'] ) ) : esc_url( get_permalink() );
}

if( $atom['enlarge'] ) {
    $atom['attributes']['class'] .= ' atom-image-enlarge';
}

// If we have a lazyload, we add something to the class
$class              = $atom['lazyload'] ? ' lazy' : '';
$args               = ['itemprop' => 'image', 'class' => $class];

if( ! $atom['schema'] ) {
    unset($args['itemprop']);
}

// Now, load our image based upon what we have in the image parameter
if( is_numeric($atom['image']) ) {
    $atom['image']  = wp_get_attachment_image( $atom['image'], $atom['size'], false, $args );
} elseif( is_string($atom['image']) && strlen($atom['image']) > 3 && strpos( $atom['image'], '<img') !== false ) {
    $atom['image']  = $atom['image'];
} elseif( is_string($atom['image']) && strlen($atom['image']) > 2 ) {
    $id             = get_post_meta( get_the_ID(), $atom['image'], true);
    $atom['image']  = wp_get_attachment_image( $id , $atom['size'], false, $args );
} elseif( empty($atom['image']) && isset($atom['post']) ) {
    $atom['image']  = get_the_post_thumbnail( $atom['post'], $atom['size'], $args );
} else {
    global $post;
    $atom['image']  = get_the_post_thumbnail( $post, $atom['size'], $args );
}

// We have a lazyloading image, so we need to replace our attributes. We also check if lazyloading already has been applied
if( $atom['lazyload'] && strpos( $atom['image'], 'data-src') === false ) {
    $atom['image']  = str_replace( 'src=', 'src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src=', $atom['image'] );   
    $atom['image']  = str_replace( 'srcset', 'data-srcset', $atom['image'] );

    // Lazyloading sizes
    if( strpos($atom['image'], 'sizes') ) {
        $atom['image']  = str_replace( 'sizes', 'data-sizes', $atom['image'] );
    }
}

// We should have an image
if( ! $atom['image'] ) {
    return '';
} 

$attributes = MakeitWorkPress\WP_Components\Build::attributes($atom['attributes']); ?>

<figure <?php echo $attributes; ?>>
    
    <?php if( $atom['link'] ) { ?>
        <a href="<?php echo $atom['link']; ?>" rel="bookmark">
    <?php } ?>
    
        <?php echo $atom['image']; ?>
    
    <?php if( $atom['link'] ) { ?>
        </a>
    <?php } ?>
    
</figure>