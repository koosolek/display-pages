<php

/*
Plugin Name: Edit Custom Fields
Plugin URI:
Description: A simple interface to edit or delete Custom Fields.
Version: 0.1.10
Author: Jay Sitter
Author URI: http://www.jaysitter.com/
Text Domain: edit-custom-fields
License: GPL2
*/

// Chat GPT code for displaying posts

function get_child_pages_by_meta($parent_id, $meta_key, $meta_value) {
    $args = array(
        'post_type'      => 'page',
        'post_parent'    => $parent_id,
        'meta_key'       => $meta_key,
        'meta_value'     => $meta_value,
        'posts_per_page' => -1, // Set the number of pages to display. -1 will display all.
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );

    $child_pages = get_posts($args);

    return $child_pages;
}

// Chat GPT code for shortcode

function child_pages_by_meta_shortcode($atts) {
    $atts = shortcode_atts(array(
        'parent'     => get_the_ID(), // By default, use the current page as the parent.
        'meta_key'   => '',
        'meta_value' => ''
    ), $atts);

    $child_pages = get_child_pages_by_meta($atts['parent'], $atts['meta_key'], $atts['meta_value']);

    if (empty($child_pages)) {
        return 'No child pages found.';
    }

    $output = '<ul class="child-pages-list">';

    foreach ($child_pages as $child) {
        $output .= '<li>';

        // Start the clickable div
        $output .= '<a href="' . get_permalink($child->ID) . '" class="child-page-link">';

        // Display the featured image
        if (has_post_thumbnail($child->ID)) {
            $output .= '<div class="child-page-thumbnail">' . get_the_post_thumbnail($child->ID, 'thumbnail') . '</div>';
        }

        // Display the page name
        $output .= '<div class="child-page-title">' . $child->post_title . '</div>';

        // End the clickable div
        $output .= '</a>';

        $output .= '</li>';
    }

    $output .= '</ul>';

    return $output;
}


add_shortcode('child_pages_by_meta', 'child_pages_by_meta_shortcode');

?>