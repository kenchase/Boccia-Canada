<?php 
    $html = "";
    $html_list_items = "";
   
    if ( $query->have_posts() ) {
   
        while ( $query->have_posts() ) { 
            $query->the_post();
            $url = get_permalink();
            $title = get_the_title();
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