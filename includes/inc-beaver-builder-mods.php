<?php

/** 
 * Filter posts on the Hall of Page to show HOF members by Category
 */

// Athletes
function fl_builder_loop_query_hof_athletes($query_args)
{
  if (!is_array($query_args)) {
    return $query_args;
  }
  if (!array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ('ccpsa-mod-posts-hof-athletes' == $query_args['settings']->id) {
    $query_args = array(
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
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
add_filter('fl_builder_loop_query_args', 'fl_builder_loop_query_hof_athletes');

// Builders
function fl_builder_loop_query_hof_builders($query_args)
{
  if (!is_array($query_args)) {
    return $query_args;
  }
  if (!array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ('ccpsa-mod-posts-builders' == $query_args['settings']->id) {
    $query_args = array(
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
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
add_filter('fl_builder_loop_query_args', 'fl_builder_loop_query_hof_builders');

// Offical and Coaches
function fl_builder_loop_query_hof_off_coach($query_args)
{
  if (!is_array($query_args)) {
    return $query_args;
  }
  if (!array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ('ccpsa-mod-posts-off-coach' == $query_args['settings']->id) {
    $query_args = array(
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
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
add_filter('fl_builder_loop_query_args', 'fl_builder_loop_query_hof_off_coach');

// Teams
function fl_team_loop_query_hof_teams($query_args)
{
  if (!is_array($query_args)) {
    return $query_args;
  }
  if (!array_key_exists('settings', $query_args)) {
    return $query_args;
  }
  if ('ccpsa-mod-posts-hof-teams' == $query_args['settings']->id) {
    $query_args = array(
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
          'taxonomy' => 'hall_of_fame_category',
          'field'    => 'slug',
          'terms' => array('team'), // This operator ensures all relevant terms are output 
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
add_filter('fl_team_loop_query_args', 'fl_team_loop_query_hof_teams');
