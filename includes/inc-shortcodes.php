<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// Display reports on the Policies and Reporting page

function ccpsa_reports_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'type' => '',
        ), $atts, 'ccpsa-reports' 
    );

    $type = esc_html( $atts['type'] );
    $acf_row_name = 'acf_' . $type;
    $acf_repeater_field_name = rtrim($acf_row_name, "s"); // ACF repeater field is always the singular version of the row name
    if( $acf_row_name === 'acf_policies' ) {
        $acf_repeater_field_name = 'acf_policy';
    }
 
    ob_start();
    require get_stylesheet_directory() . '/includes/tpl-ccpsa-list-docs.php';
    return ob_get_clean();
}
add_shortcode('ccpsa-reports', 'ccpsa_reports_shortcode');

// Display pdf documents on serach results page

function ccpsa_show_docs_in_search_res( $atts ) {
    $search_query = get_search_query();
    $query_args = array(
        's'                 => $search_query, // <-- Your search term
        'post_type'         => 'attachment',
        'post_mime_type'    => 'application/pdf',
        'post_status'       => 'inherit',
        'posts_per_page'    => -1,
    );
    $query = new WP_Query( $query_args );
    ob_start();
    require get_stylesheet_directory() . '/includes/tpl-ccpsa-search-results-docs.php';
    return ob_get_clean();
}
add_shortcode('ccpsa-docs-in-search-res', 'ccpsa_show_docs_in_search_res');