<?php

/**
 * Helper class for child theme functions.
 *
 * @class FLChildTheme
 */
final class FLChildTheme {
    
    /**
	 * Enqueues scripts and styles.
	 *
     * @return void
     */
    static public function enqueue_scripts()
    {
	    wp_enqueue_style( 'ccpsa', FL_CHILD_THEME_URL . '/style.css' );
        wp_enqueue_style( 'ultimate-icons-css', site_url(). '/wp-content/uploads/bb-plugin/icons/ultimate-icons/style.css' );
        wp_enqueue_script( 'ccpsa', FL_CHILD_THEME_URL . '/dist/js/ccpsa-scripts-min.js' );
    }
}