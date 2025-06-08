<?php
// Register Amenity Taxonomy
add_action('init', 'gy_register_amenity_taxonomy');
function gy_register_amenity_taxonomy() {
    $labels = array(
        'name'                       => _x('Amenities', 'Taxonomy General Name', GY_TEXT_DOMAIN),
        'singular_name'              => _x('Amenity', 'Taxonomy Singular Name', GY_TEXT_DOMAIN),
        'menu_name'                  => __('Amenities', GY_TEXT_DOMAIN),
        'all_items'                  => __('All Amenities', GY_TEXT_DOMAIN),
        'parent_item'                => __('Parent Amenity', GY_TEXT_DOMAIN),
        'parent_item_colon'          => __('Parent Amenity:', GY_TEXT_DOMAIN),
        'new_item_name'             => __('New Amenity Name', GY_TEXT_DOMAIN),
        'add_new_item'               => __('Add New Amenity', GY_TEXT_DOMAIN),
        'edit_item'                 => __('Edit Amenity', GY_TEXT_DOMAIN),
        'update_item'               => __('Update Amenity', GY_TEXT_DOMAIN),
        'view_item'                 => __('View Amenity', GY_TEXT_DOMAIN),
        'separate_items_with_commas' => __('Separate amenities with commas', GY_TEXT_DOMAIN),
        'add_or_remove_items'        => __('Add or remove amenities', GY_TEXT_DOMAIN),
        'choose_from_most_used'      => __('Choose from the most used', GY_TEXT_DOMAIN),
        'popular_items'              => __('Popular Amenities', GY_TEXT_DOMAIN),
        'search_items'               => __('Search Amenities', GY_TEXT_DOMAIN),
        'not_found'                 => __('Not Found', GY_TEXT_DOMAIN),
        'no_terms'                   => __('No amenities', GY_TEXT_DOMAIN),
        'items_list'                 => __('Amenities list', GY_TEXT_DOMAIN),
        'items_list_navigation'      => __('Amenities list navigation', GY_TEXT_DOMAIN),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );

    register_taxonomy('amenity', array('yate'), $args);
}