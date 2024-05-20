<?php 
    $rows = get_field($acf_row_name);
    $html = "";
    $html_list_items = "";
    if( $rows ) {
        foreach( $rows as $row ) {
            if( is_array($row) && $row[$acf_repeater_field_name] === false) { // If the row is empty skip it
                continue;
            }
            $doc = $row[$acf_repeater_field_name];
            // print_r($doc);
            $url = $doc['url'];
            $filesize = $doc['filesize'];
            $filesize_formatted = ccpsa_format_file_size_units($filesize);
            $subtype = $doc['subtype'];
            $title = $doc['title'] . ' (' . $subtype . ', ' . $filesize_formatted . ')';
            $html_list_items .= '<li class="list-item"><i class="far fa-file-pdf" aria-hidden="true"></i> <span><a href="' . $url . '" target="_blank">' . $title . '</a></span></li>';
        } 
        if( $html_list_items === "" ) {
            $html = '<p>' . __('No documents found.', 'ccpsa') . '</p>';
        } else {
            $html .= '<ul class="list ccsa-reports-list">';
            $html .= $html_list_items;
            $html .= '</ul>';  
        }
    } else {
        $html = '<p>' . __('No documents found.', 'ccpsa') . '</p>';
    }
    echo $html;