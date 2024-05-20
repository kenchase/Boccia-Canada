<?php
// Add font icon to gravity forms button
function ccpsa_make_gf_button( $button, $form ) {
    return "<button class='button gform_button' id='gform_submit_button_{$form['id']}'><span>{$form['button']['text']} <i class='fl-button-icon fl-button-icon-after ua-icon ua-icon-arrow-right2' aria-hidden='true'></i></span></button>";
}
add_filter( 'gform_submit_button', 'ccpsa_make_gf_button', 10, 2 );

// Hide validation below each filed
function ccpsa_empty_validation_message( $message, $form ) {
    return "";
}
// add_filter( 'gform_field_validation', 'ccpsa_empty_validation_message', 10, 4 );