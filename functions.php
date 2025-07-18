<?php

// Defines
define('FL_CHILD_THEME_DIR', get_stylesheet_directory());
define('FL_CHILD_THEME_URL', get_stylesheet_directory_uri());

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action('wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000);

// Includes
require_once get_stylesheet_directory() . '/includes/inc-custom-functions.php';
require_once get_stylesheet_directory() . '/includes/inc-wordpress-mods.php';
require_once get_stylesheet_directory() . '/includes/inc-beaver-builder-mods.php';
require_once get_stylesheet_directory() . '/includes/inc-acf.php';
require_once get_stylesheet_directory() . '/includes/inc-gravity-forms-mods.php';
require_once get_stylesheet_directory() . '/includes/inc-shortcodes.php';
