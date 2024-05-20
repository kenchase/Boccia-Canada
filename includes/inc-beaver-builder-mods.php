<?php 

/** 
 * Filter posts on the Hall of Page to show HOF members by Category
 */

// Athletes
function fl_builder_loop_query_hof_athletes( $query_args ) {
  if ( !is_array($query_args) ) {
    return $query_args;
  }
  if ( !array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ( 'ccpsa-mod-posts-hof-athletes' == $query_args['settings']->id ) {
    $query_args = array(
        'posts_per_page' => -1,
        'tax_query' => array(
            array (
                'taxonomy' => 'hall_of_fame_category',
                'field'    => 'slug',
                'terms' => array('athlete'), // This operator ensures all relevant terms are output
            )
        ),
        'meta_query' => array(
          'relation' => 'AND',
          'query_one' => array(
              'key' => 'acf_hof_year_inducted',
          ),
          'query_two' => array(
              'key' => 'acf_hof_display_name',
        
          ), 
        ),
        'orderby' => array( 
          'query_one' => 'ASC',
          'query_two' => 'ASC',
        ),
    );
  }
  return $query_args;
}
add_filter( 'fl_builder_loop_query_args', 'fl_builder_loop_query_hof_athletes' );

// Builders
function fl_builder_loop_query_hof_builders( $query_args ) {
  if ( !is_array($query_args) ) {
    return $query_args;
  }
  if ( !array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ( 'ccpsa-mod-posts-builders' == $query_args['settings']->id ) {
    $query_args = array(
        'posts_per_page' => -1,
        'tax_query' => array(
            array (
                'taxonomy' => 'hall_of_fame_category',
                'field'    => 'slug',
                'terms' => array('builder'), // This operator ensures all relevant terms are output 
            )
        ),
        'meta_query' => array(
          'relation' => 'AND',
          'query_one' => array(
              'key' => 'acf_hof_year_inducted',
          ),
          'query_two' => array(
              'key' => 'acf_hof_display_name',
        
          ), 
        ),
        'orderby' => array( 
          'query_one' => 'ASC',
          'query_two' => 'ASC',
        ),
    );
  }
  return $query_args;
}
add_filter( 'fl_builder_loop_query_args', 'fl_builder_loop_query_hof_builders' );

// Offical and Coaches
function fl_builder_loop_query_hof_off_coach( $query_args ) {
  if ( !is_array($query_args) ) {
    return $query_args;
  }
  if ( !array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ( 'ccpsa-mod-posts-off-coach' == $query_args['settings']->id ) {
    $query_args = array(
        'posts_per_page' => -1,
        'tax_query' => array(
            array (
                'taxonomy' => 'hall_of_fame_category', // Add in Taxonomy
                'field'    => 'slug',
                'terms' => array('official-coach'), // This operator ensures all relevant terms are output 
            )
        ),
        'meta_query' => array(
          'relation' => 'AND',
          'query_one' => array(
              'key' => 'acf_hof_year_inducted',
          ),
          'query_two' => array(
              'key' => 'acf_hof_display_name',
        
          ), 
        ),
        'orderby' => array( 
          'query_one' => 'ASC',
          'query_two' => 'ASC',
      ),
    );
  }
  return $query_args;
}
add_filter( 'fl_builder_loop_query_args', 'fl_builder_loop_query_hof_off_coach' );


// Events
function fl_builder_loop_query_events( $query_args ) {
  if ( !is_array($query_args) ) {
    return $query_args;
  }
  if ( !array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ( 'ccpsa-mod-posts-events' == $query_args['settings']->id ) {
    
    $query_args = array(
        'posts_per_page' => -1,
        'post_type'			=> 'event',
        'meta_query' => array(
          'relation' => 'AND',
          'query_one' => array(
              'key' => 'acf_event_start_date',
              'type' => 'DATE',
          ), 
        ),
        'orderby' => array( 
          'query_one' => 'ASC',
          'date' =>'ASC',
      ),
    );
  }
  return $query_args;
}
add_filter( 'fl_builder_loop_query_args', 'fl_builder_loop_query_events' );

// Enqueue Ultimate Icons
function ccpsa_theme_name_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}