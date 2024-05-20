<?php 
/** 
 * Prevent thumbnail generation for non-image mime types
*/
function cpca_disable_pdf_previews() {
    $fallbacksizes = array();
    return $fallbacksizes;
}
add_filter('fallback_intermediate_image_sizes', 'cpca_disable_pdf_previews');

function attachment_search( $query ) {
    if ( $query->is_search ) {
       $query->set( 'post_type', array( 'post', 'attachment' ) );
       $query->set( 'post_status', array( 'publish', 'inherit' ) );
    }
 
   return $query;
}

// add_filter( 'pre_get_posts', 'attachment_search' );