<?php 
   function ccpsa_format_file_size_units($bytes)
   {
       if ($bytes >= 1073741824)
       {
           $bytes = number_format($bytes / 1073741824, 2) . __(' GB', 'ccpsa');
       }
       elseif ($bytes >= 1048576)
       {
           $bytes = number_format($bytes / 1048576, 2) . __(' MB', 'ccpsa');
       }
       elseif ($bytes >= 1024)
       {
           $bytes = number_format($bytes / 1024, 2) . __('KB', 'ccpsa');
       }
       elseif ($bytes > 1)
       {
           $bytes = $bytes . __(' bytes', 'ccpsa');
       }
       elseif ($bytes == 1)
       {
           $bytes = $bytes . __(' byte', 'ccpsa');
       }
       else
       {
           $bytes =  __('0 bytes', 'ccpsa');
       }
       return $bytes;
}
// Set the staus of an event post type to "draft" if the events end date is in the past
function ccpsa_update_event_status()
{
    // Query for events that are published and have an end date before the current day.
    $today = date('Ymd');
    $args = array (
        'post_type' => 'event',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key'		=> 'acf_event_end_date',
                'compare'	=> '<',
                'value'		=> $today,
            )
        ),
    );
    $past_events = get_posts($args);
    // Loop through past events and set their status to draft
    foreach ( $past_events as $post ) {
        wp_update_post(array(
            'ID'            =>  $post->ID,
            'post_status'   =>  'draft'
        ));
    }
}
add_action( 'ccpsa_update_event_status_init', 'ccpsa_update_event_status' );