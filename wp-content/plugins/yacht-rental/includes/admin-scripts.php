<?php
// Enqueue admin scripts and styles
add_action('admin_enqueue_scripts', 'gy_admin_scripts');
function gy_admin_scripts($hook) {
    global $post_type;
    
    if (($hook == 'post-new.php' || $hook == 'post.php') && $post_type == 'yate') {
        // Styles
        wp_enqueue_style('gy-admin-styles', GY_PLUGIN_URL . 'assets/css/admin.css');
        
        // Scripts
        wp_enqueue_script('gy-admin-scripts', GY_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), '1.0.0', true);
        
        // Media uploader
        wp_enqueue_media();
        
        // Localize script
        wp_localize_script('gy-admin-scripts', 'gy_admin_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gy-admin-nonce'),
            'add_image' => __('Add Images', GY_TEXT_DOMAIN),
            'remove_image' => __('Remove Image', GY_TEXT_DOMAIN),
        ));
    }
}


