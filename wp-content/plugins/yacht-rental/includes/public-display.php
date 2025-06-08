<?php
// Enqueue frontend scripts and styles
add_action('wp_enqueue_scripts', 'gy_public_scripts');
function gy_public_scripts() {
    if (is_singular('yate') || is_post_type_archive('yate')) {
        wp_enqueue_style('gy-public-styles', GY_PLUGIN_URL . 'assets/css/public.css');
        
        wp_enqueue_script('gy-public-scripts', GY_PLUGIN_URL . 'assets/js/public.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script('gy-public-scripts', 'gy_public_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gy-public-nonce'),
            'select_hour' => __('Please select an hour', GY_TEXT_DOMAIN),
            'processing' => __('Processing...', GY_TEXT_DOMAIN),
        ));
    }
}

// Single Yacht Template
add_filter('single_template', 'gy_single_yacht_template');
function gy_single_yacht_template($template) {
    global $post;
    
    if ($post->post_type == 'yate') {
        $plugin_path = GY_PLUGIN_PATH . 'templates/single-yate.php';
        
        if (file_exists($plugin_path)) {
            return $plugin_path;
        }
    }
    
    return $template;
}

// Archive Yacht Template
add_filter('archive_template', 'gy_archive_yacht_template');
function gy_archive_yacht_template($template) {
    if (is_post_type_archive('yate')) {
        $plugin_path = GY_PLUGIN_PATH . 'templates/archive-yate.php';
        
        if (file_exists($plugin_path)) {
            return $plugin_path;
        }
    }
    
    return $template;
}





// add_action('wp_ajax_gy_process_booking', 'gy_process_booking');
// add_action('wp_ajax_nopriv_gy_process_booking', 'gy_process_booking');
// function gy_process_booking() {
//     check_ajax_referer('gy-booking-nonce', 'nonce');
    
//     $response = array('success' => false, 'message' => '');
    
//     // Validate data
//     $required_fields = array(
//         'name' => __('Name', GY_TEXT_DOMAIN),
//         'email' => __('Email', GY_TEXT_DOMAIN),
//         'phone' => __('Phone', GY_TEXT_DOMAIN),
//         'date' => __('Date', GY_TEXT_DOMAIN),
//         'hour' => __('Hour', GY_TEXT_DOMAIN),
//         'people' => __('Number of People', GY_TEXT_DOMAIN),
//     );
    
//     $errors = array();
//     $data = array();
    
//     foreach ($required_fields as $field => $label) {
//         if (empty($_POST[$field])) {
//             $errors[] = sprintf(__('%s is required', GY_TEXT_DOMAIN), $label);
//         } else {
//             $data[$field] = sanitize_text_field($_POST[$field]);
//         }
//     }
    
//     // Validate email
//     if (!empty($data['email']) && !is_email($data['email'])) {
//         $errors[] = __('Please enter a valid email address', GY_TEXT_DOMAIN);
//     }
    
//     // Validate yacht ID
//     $yacht_id = isset($_POST['yacht_id']) ? absint($_POST['yacht_id']) : 0;
//     if (!$yacht_id || get_post_type($yacht_id) !== 'yate') {
//         $errors[] = __('Invalid yacht selection', GY_TEXT_DOMAIN);
//     }
    
//     // Check if there are errors
//     if (!empty($errors)) {
//         $response['message'] = implode('<br>', $errors);
//         wp_send_json($response);
//     }
    
//     // Get yacht details
//     $yacht_title = get_the_title($yacht_id);
//     $hourly_pricing = get_post_meta($yacht_id, '_gy_hourly_pricing', true);
//     $price = 0;
    
//     // Find the selected hour price
//     if (is_array($hourly_pricing)) {
//         foreach ($hourly_pricing as $slot) {
//             if ($slot['hour'] == $data['hour']) {
//                 $price = $slot['cost'];
//                 break;
//             }
//         }
//     }
    
//     // Additional data
//     $data['pickup'] = isset($_POST['pickup']) ? sanitize_text_field($_POST['pickup']) : '';
//     $data['notes'] = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    
//     // Create booking post
//     $booking_data = array(
//         'post_title' => sprintf(__('Booking for %s on %s', GY_TEXT_DOMAIN), $yacht_title, $data['date']),
//         'post_content' => '',
//         'post_status' => 'publish',
//         'post_type' => 'gy_booking',
//     );
    
//     $booking_id = wp_insert_post($booking_data);
    
//     if ($booking_id) {
//         // Save booking meta
//         update_post_meta($booking_id, '_gy_booking_yacht_id', $yacht_id);
//         update_post_meta($booking_id, '_gy_booking_name', $data['name']);
//         update_post_meta($booking_id, '_gy_booking_email', $data['email']);
//         update_post_meta($booking_id, '_gy_booking_phone', $data['phone']);
//         update_post_meta($booking_id, '_gy_booking_date', $data['date']);
//         update_post_meta($booking_id, '_gy_booking_hour', $data['hour']);
//         update_post_meta($booking_id, '_gy_booking_people', $data['people']);
//         update_post_meta($booking_id, '_gy_booking_price', $price);
//         update_post_meta($booking_id, '_gy_booking_pickup', $data['pickup']);
//         update_post_meta($booking_id, '_gy_booking_notes', $data['notes']);
//         update_post_meta($booking_id, '_gy_booking_status', 'pending');
        
//         // Send email notification
//         $to = get_option('admin_email');
//         $subject = sprintf(__('New Yacht Booking: %s', GY_TEXT_DOMAIN), $yacht_title);
        
//         $message = sprintf(__('You have a new booking for %s', GY_TEXT_DOMAIN), $yacht_title) . "\n\n";
//         $message .= __('Booking Details:', GY_TEXT_DOMAIN) . "\n";
//         $message .= __('Name:', GY_TEXT_DOMAIN) . ' ' . $data['name'] . "\n";
//         $message .= __('Email:', GY_TEXT_DOMAIN) . ' ' . $data['email'] . "\n";
//         $message .= __('Phone:', GY_TEXT_DOMAIN) . ' ' . $data['phone'] . "\n";
//         $message .= __('Date:', GY_TEXT_DOMAIN) . ' ' . $data['date'] . "\n";
//         $message .= __('Hour:', GY_TEXT_DOMAIN) . ' ' . $data['hour'] . ':00 - ' . (($data['hour'] + 1) % 24) . ':00' . "\n";
//         $message .= __('Number of People:', GY_TEXT_DOMAIN) . ' ' . $data['people'] . "\n";
//         $message .= __('Price:', GY_TEXT_DOMAIN) . ' ' . number_format($price, 2) . "\n";
        
//         if ($data['pickup']) {
//             $message .= __('Pickup Location:', GY_TEXT_DOMAIN) . ' ' . $data['pickup'] . "\n";
//         }
        
//         if ($data['notes']) {
//             $message .= __('Additional Notes:', GY_TEXT_DOMAIN) . ' ' . $data['notes'] . "\n";
//         }
        
//         wp_mail($to, $subject, $message);
        
//         $response['success'] = true;
//         $response['message'] = __('Thank you for your booking! We will contact you soon to confirm your reservation.', GY_TEXT_DOMAIN);
//     } else {
//         $response['message'] = __('There was an error processing your booking. Please try again.', GY_TEXT_DOMAIN);
//     }
    
//     wp_send_json($response);
// }