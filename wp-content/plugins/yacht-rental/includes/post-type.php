<?php
// Register Yacht Custom Post Type
add_action('init', 'gy_register_yacht_post_type');
function gy_register_yacht_post_type() {
    $labels = array(
        'name'                  => _x('Yachts', 'Post Type General Name', GY_TEXT_DOMAIN),
        'singular_name'         => _x('Yacht', 'Post Type Singular Name', GY_TEXT_DOMAIN),
        'menu_name'             => __('Yachts', GY_TEXT_DOMAIN),
        'name_admin_bar'        => __('Yacht', GY_TEXT_DOMAIN),
        'archives'              => __('Yacht Archives', GY_TEXT_DOMAIN),
        'attributes'            => __('Yacht Attributes', GY_TEXT_DOMAIN),
        'parent_item_colon'     => __('Parent Yacht:', GY_TEXT_DOMAIN),
        'all_items'             => __('All Yachts', GY_TEXT_DOMAIN),
        'add_new_item'          => __('Add New Yacht', GY_TEXT_DOMAIN),
        'add_new'               => __('Add New', GY_TEXT_DOMAIN),
        'new_item'              => __('New Yacht', GY_TEXT_DOMAIN),
        'edit_item'             => __('Edit Yacht', GY_TEXT_DOMAIN),
        'update_item'           => __('Update Yacht', GY_TEXT_DOMAIN),
        'view_item'             => __('View Yacht', GY_TEXT_DOMAIN),
        'view_items'            => __('View Yachts', GY_TEXT_DOMAIN),
        'search_items'          => __('Search Yacht', GY_TEXT_DOMAIN),
        'not_found'             => __('Not found', GY_TEXT_DOMAIN),
        'not_found_in_trash'    => __('Not found in Trash', GY_TEXT_DOMAIN),
        'featured_image'        => __('Yacht Image', GY_TEXT_DOMAIN),
        'set_featured_image'    => __('Set yacht image', GY_TEXT_DOMAIN),
        'remove_featured_image' => __('Remove yacht image', GY_TEXT_DOMAIN),
        'use_featured_image'    => __('Use as yacht image', GY_TEXT_DOMAIN),
        'insert_into_item'      => __('Insert into yacht', GY_TEXT_DOMAIN),
        'uploaded_to_this_item' => __('Uploaded to this yacht', GY_TEXT_DOMAIN),
        'items_list'            => __('Yachts list', GY_TEXT_DOMAIN),
        'items_list_navigation' => __('Yachts list navigation', GY_TEXT_DOMAIN),
        'filter_items_list'     => __('Filter yachts list', GY_TEXT_DOMAIN),
    );

    $args = array(
        'label'                 => __('Yacht', GY_TEXT_DOMAIN),
        'description'           => __('Yacht management system', GY_TEXT_DOMAIN),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies'            => array('amenity'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-sos',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('yate', $args);
}