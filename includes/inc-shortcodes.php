<?php
// exit if file is called directly
if (!defined('ABSPATH')) {

    exit;
}

add_shortcode('ccpsa-reports', 'ccpsa_reports_shortcode');
add_shortcode('ccpsa-docs-in-search-res', 'ccpsa_show_docs_in_search_res');
add_shortcode('ccpsa-main-nav', 'ccpsa_main_nav_shortcode');


// Display reports on the Policies and Reporting page
function ccpsa_reports_shortcode($atts)
{

    $atts = shortcode_atts(
        array(
            'type' => '',
        ),
        $atts,
        'ccpsa-reports'
    );

    $type = esc_html($atts['type']);
    $acf_row_name = 'acf_' . $type;
    $acf_repeater_field_name = rtrim($acf_row_name, "s"); // ACF repeater field is always the singular version of the row name
    if ($acf_row_name === 'acf_policies') {
        $acf_repeater_field_name = 'acf_policy';
    }

    ob_start();
    require get_stylesheet_directory() . '/includes/tpl-ccpsa-list-docs.php';
    return ob_get_clean();
}


// Display pdf documents on search results page
function ccpsa_show_docs_in_search_res($atts)
{
    $search_query = get_search_query();
    $query_args = array(
        's'                 => $search_query, // <-- Your search term
        'post_type'         => 'attachment',
        'post_mime_type'    => 'application/pdf',
        'post_status'       => 'inherit',
        'posts_per_page'    => -1,
    );
    $query = new WP_Query($query_args);
    ob_start();
    require get_stylesheet_directory() . '/includes/tpl-ccpsa-search-results-docs.php';
    return ob_get_clean();
}

// Create an accessible main nav
function ccpsa_main_nav_shortcode($atts)
{
    $args = array(
        'menu' => 'Main Nav',
        'container' => 'nav',
        'container_class' => 'ccpsa-main-nav',
        'container_id'    => 'site-navigation',
        'container_aria_label' => 'Main site navigation',
        'echo' => false,
        'walker'  => new CCPSA_Walker_Nav_Menu(),
    );
    $nav_menu_aria_label = __('Open menu', 'ccpsa');
    $html = '';
    $html .= '<div class="ccpsa-main-nav-wrap">';
    $html .= '<div id="site-header-menu" class="site-header-menu">';
    $html .= '<button class="ccpsa-main-nav-button" aria-expanded="false" aria-controls="site-header-menu" aria-label="' . $nav_menu_aria_label . '"><i class="fa-solid fa-bars"><span class="sr-only">Menu</span></i></button>';
    $html .= wp_nav_menu($args);
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

class CCPSA_Walker_Nav_Menu extends Walker_Nav_Menu
{
    /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
     * to match parent class for PHP 8 named parameter support.
     *
     * @see Walker::start_el()
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param WP_Post $data_object Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @param int $current_object_id Optional. ID of the current menu item. Default 0.
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        // Restores the more descriptive, specific name for use within this method.
        $menu_item = $data_object;

        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
        $classes[] = 'menu-item-' . $menu_item->ID;

        /**
         * Filters the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param WP_Post $menu_item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

        /**
         * Filters the CSS classes applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
         * @param WP_Post $menu_item The current menu item object.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));

        /**
         * Filters the ID attribute applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_item_id The ID attribute applied to the menu item's `<li>` element.
         * @param WP_Post $menu_item The current menu item.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);

        $li_atts = array();
        $li_atts['id'] = !empty($id) ? $id : '';
        $li_atts['class'] = !empty($class_names) ? $class_names : '';

        /**
         * Filters the HTML attributes applied to a menu's list item element.
         *
         * @since 6.3.0
         *
         * @param array $li_atts {
         * The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
         *
         * @type string $class HTML CSS class attribute.
         * @type string $id HTML id attribute.
         * }
         * @param WP_Post $menu_item The current menu item object.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $li_atts = apply_filters('nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth);
        $li_attributes = $this->build_atts($li_atts);

        $output .= $indent . '<li' . $li_attributes . '>';
        $atts = array();
        $atts['title'] = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
        $atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
        if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $menu_item->xfn;
        }

        if (!empty($menu_item->url)) {
            if (get_privacy_policy_url() === $menu_item->url) {
                $atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
            }

            $atts['href'] = $menu_item->url;
        } else {
            $atts['href'] = '';
        }

        $atts['aria-current'] = $menu_item->current ? 'page' : '';

        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         * The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         * @type string $title Title attribute.
         * @type string $target Target attribute.
         * @type string $rel The rel attribute.
         * @type string $href The href attribute.
         * @type string $aria-current The aria-current attribute.
         * }
         * @param WP_Post $menu_item The current menu item object.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);

        $attributes = $this->build_atts($atts);

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters('the_title', $menu_item->title, $menu_item->ID);

        /**
         * Filters a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string $title The menu item's title.
         * @param WP_Post $menu_item The current menu item object.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         * @param int $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);

        /** Custom CCPSA: Add custom attributes to menu links for accessibility  */
        $is_parent = in_array('menu-item-has-children', $menu_item->classes);
        $parent_output = "";
        if ($is_parent) {
            $parent_output = 'aria-expanded="false"';
        }
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . $parent_output . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        /** End Custom CCPSA */

        /**
         * Filters a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param WP_Post $menu_item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param stdClass $args An object of wp_nav_menu() arguments.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
    }
}