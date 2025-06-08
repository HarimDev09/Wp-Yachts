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

// Create templates/single-yate.php
/*
<?php
/**
 * Template for displaying a single yacht
 */

get_header(); ?>

<div class="gy-single-yacht">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header>
        
        <div class="entry-content">
            <?php
            // Display featured image
            if (has_post_thumbnail()) {
                echo '<div class="gy-featured-image">';
                the_post_thumbnail('large');
                echo '</div>';
            }
            
            // Display gallery
            $gallery_ids = get_post_meta(get_the_ID(), '_gy_galeria', true);
            if ($gallery_ids) {
                $gallery_ids = explode(',', $gallery_ids);
                echo '<div class="gy-gallery">';
                foreach ($gallery_ids as $image_id) {
                    echo wp_get_attachment_image($image_id, 'medium');
                }
                echo '</div>';
            }
            
            // Display content
            the_content();
            
            // Display general features
            echo '<div class="gy-general-features">';
            echo '<h2>' . __('General Features', GY_TEXT_DOMAIN) . '</h2>';
            echo '<ul>';
            
            $features = array(
                '_gy_model' => __('Model', GY_TEXT_DOMAIN),
                '_gy_year' => __('Year', GY_TEXT_DOMAIN),
                '_gy_cabins' => __('Cabins', GY_TEXT_DOMAIN),
                '_gy_staterooms' => __('Staterooms', GY_TEXT_DOMAIN),
                '_gy_bathrooms' => __('Bathrooms', GY_TEXT_DOMAIN),
                '_gy_max_speed' => __('Max Speed', GY_TEXT_DOMAIN),
                '_gy_crew' => __('Crew', GY_TEXT_DOMAIN),
                '_gy_guest' => __('Guest Capacity', GY_TEXT_DOMAIN),
                '_gy_max_people' => __('Max People', GY_TEXT_DOMAIN),
                '_gy_departure_location' => __('Departure Location', GY_TEXT_DOMAIN),
            );
            
            foreach ($features as $meta_key => $label) {
                $value = get_post_meta(get_the_ID(), $meta_key, true);
                if ($value) {
                    echo '<li><strong>' . esc_html($label) . ':</strong> ' . esc_html($value) . '</li>';
                }
            }
            
            echo '</ul>';
            echo '</div>';
            
            // Display hourly pricing
            $hourly_pricing = get_post_meta(get_the_ID(), '_gy_hourly_pricing', true);
            if ($hourly_pricing && is_array($hourly_pricing)) {
                echo '<div class="gy-hourly-pricing">';
                echo '<h2>' . __('Hourly Pricing', GY_TEXT_DOMAIN) . '</h2>';
                echo '<table>';
                echo '<thead><tr><th>' . __('Hour', GY_TEXT_DOMAIN) . '</th><th>' . __('Price', GY_TEXT_DOMAIN) . '</th></tr></thead>';
                echo '<tbody>';
                
                foreach ($hourly_pricing as $price) {
                    $start_hour = str_pad($price['hour'], 2, '0', STR_PAD_LEFT);
                    $end_hour = str_pad(($price['hour'] + 1) % 24, 2, '0', STR_PAD_LEFT);
                    
                    echo '<tr>';
                    echo '<td>' . $start_hour . ':00 - ' . $end_hour . ':00</td>';
                    echo '<td>' . number_format($price['cost'], 2) . '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }
            
            // Display key features
            $key_features = get_post_meta(get_the_ID(), '_gy_key_features', true);
            if ($key_features && is_array($key_features)) {
                echo '<div class="gy-key-features">';
                echo '<h2>' . __('Key Features', GY_TEXT_DOMAIN) . '</h2>';
                echo '<ul>';
                
                foreach ($key_features as $feature) {
                    echo '<li>';
                    echo '<h3>' . esc_html($feature['title']) . '</h3>';
                    echo '<p>' . esc_html($feature['desc']) . '</p>';
                    echo '</li>';
                }
                
                echo '</ul>';
                echo '</div>';
            }
            
            // Display amenities
            $amenities = get_the_terms(get_the_ID(), 'amenity');
            if ($amenities && !is_wp_error($amenities)) {
                echo '<div class="gy-amenities">';
                echo '<h2>' . __('Amenities', GY_TEXT_DOMAIN) . '</h2>';
                echo '<ul class="gy-amenities-list">';
                
                foreach ($amenities as $amenity) {
                    echo '<li>' . esc_html($amenity->name) . '</li>';
                }
                
                echo '</ul>';
                echo '</div>';
            }
            
            // Display booking form
            echo '<div class="gy-booking-form">';
            echo '<h2>' . __('Book This Yacht', GY_TEXT_DOMAIN) . '</h2>';
            echo '<form id="gy-booking-form">';
            echo '<input type="hidden" name="yacht_id" value="' . get_the_ID() . '">';
            echo '<input type="hidden" name="action" value="gy_process_booking">';
            wp_nonce_field('gy-booking-nonce', 'gy_booking_nonce');
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-name">' . __('Name', GY_TEXT_DOMAIN) . '</label>';
            echo '<input type="text" id="gy-booking-name" name="name" required>';
            echo '</div>';
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-email">' . __('Email', GY_TEXT_DOMAIN) . '</label>';
            echo '<input type="email" id="gy-booking-email" name="email" required>';
            echo '</div>';
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-phone">' . __('Phone', GY_TEXT_DOMAIN) . '</label>';
            echo '<input type="tel" id="gy-booking-phone" name="phone" required>';
            echo '</div>';
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-date">' . __('Date', GY_TEXT_DOMAIN) . '</label>';
            echo '<input type="date" id="gy-booking-date" name="date" required>';
            echo '</div>';
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-hour">' . __('Hour', GY_TEXT_DOMAIN) . '</label>';
            echo '<select id="gy-booking-hour" name="hour" required>';
            echo '<option value="">' . __('Select an hour', GY_TEXT_DOMAIN) . '</option>';
            
            if ($hourly_pricing && is_array($hourly_pricing)) {
                foreach ($hourly_pricing as $price) {
                    $start_hour = str_pad($price['hour'], 2, '0', STR_PAD_LEFT);
                    $end_hour = str_pad(($price['hour'] + 1) % 24, 2, '0', STR_PAD_LEFT);
                    echo '<option value="' . $price['hour'] . '">' . $start_hour . ':00 - ' . $end_hour . ':00 (' . number_format($price['cost'], 2) . ')</option>';
                }
            }
            
            echo '</select>';
            echo '</div>';
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-people">' . __('Number of People', GY_TEXT_DOMAIN) . '</label>';
            echo '<input type="number" id="gy-booking-people" name="people" min="1" required>';
            echo '</div>';
            
            $pickup_other_point = get_post_meta(get_the_ID(), '_gy_pickup_other_point', true);
            if ($pickup_other_point) {
                echo '<div class="gy-form-field">';
                echo '<label for="gy-booking-pickup">' . __('Pickup Location', GY_TEXT_DOMAIN) . '</label>';
                echo '<input type="text" id="gy-booking-pickup" name="pickup">';
                echo '</div>';
            }
            
            echo '<div class="gy-form-field">';
            echo '<label for="gy-booking-notes">' . __('Additional Notes', GY_TEXT_DOMAIN) . '</label>';
            echo '<textarea id="gy-booking-notes" name="notes"></textarea>';
            echo '</div>';
            
            echo '<button type="submit">' . __('Book Now', GY_TEXT_DOMAIN) . '</button>';
            echo '</form>';
            echo '<div id="gy-booking-response"></div>';
            echo '</div>';
            ?>
        </div>
    </article>
</div>

<?php get_footer(); ?>
*/

// Create templates/archive-yate.php
/*
<?php
/**
 * Template for displaying yacht archive
 */

get_header(); ?>

<div class="gy-yacht-archive">
    <header class="page-header">
        <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
    </header>
    
    <div class="gy-yacht-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('gy-yacht-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="gy-yacht-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="gy-yacht-content">
                        <h2 class="gy-yacht-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="gy-yacht-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <div class="gy-yacht-meta">
                            <?php
                            $model = get_post_meta(get_the_ID(), '_gy_model', true);
                            $year = get_post_meta(get_the_ID(), '_gy_year', true);
                            $max_people = get_post_meta(get_the_ID(), '_gy_max_people', true);
                            
                            if ($model) {
                                echo '<div class="gy-meta-item"><strong>' . __('Model', GY_TEXT_DOMAIN) . ':</strong> ' . esc_html($model) . '</div>';
                            }
                            
                            if ($year) {
                                echo '<div class="gy-meta-item"><strong>' . __('Year', GY_TEXT_DOMAIN) . ':</strong> ' . esc_html($year) . '</div>';
                            }
                            
                            if ($max_people) {
                                echo '<div class="gy-meta-item"><strong>' . __('Max People', GY_TEXT_DOMAIN) . ':</strong> ' . esc_html($max_people) . '</div>';
                            }
                            ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="gy-yacht-link">
                            <?php _e('View Details', GY_TEXT_DOMAIN); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No yachts found.', GY_TEXT_DOMAIN); ?></p>
        <?php endif; ?>
    </div>
    
    <?php the_posts_pagination(); ?>
</div>

<?php get_footer(); ?>
*/

// Process booking form
add_action('wp_ajax_gy_process_booking', 'gy_process_booking');
add_action('wp_ajax_nopriv_gy_process_booking', 'gy_process_booking');
function gy_process_booking() {
    check_ajax_referer('gy-booking-nonce', 'nonce');
    
    $response = array('success' => false, 'message' => '');
    
    // Validate data
    $required_fields = array(
        'name' => __('Name', GY_TEXT_DOMAIN),
        'email' => __('Email', GY_TEXT_DOMAIN),
        'phone' => __('Phone', GY_TEXT_DOMAIN),
        'date' => __('Date', GY_TEXT_DOMAIN),
        'hour' => __('Hour', GY_TEXT_DOMAIN),
        'people' => __('Number of People', GY_TEXT_DOMAIN),
    );
    
    $errors = array();
    $data = array();
    
    foreach ($required_fields as $field => $label) {
        if (empty($_POST[$field])) {
            $errors[] = sprintf(__('%s is required', GY_TEXT_DOMAIN), $label);
        } else {
            $data[$field] = sanitize_text_field($_POST[$field]);
        }
    }
    
    // Validate email
    if (!empty($data['email']) && !is_email($data['email'])) {
        $errors[] = __('Please enter a valid email address', GY_TEXT_DOMAIN);
    }
    
    // Validate yacht ID
    $yacht_id = isset($_POST['yacht_id']) ? absint($_POST['yacht_id']) : 0;
    if (!$yacht_id || get_post_type($yacht_id) !== 'yate') {
        $errors[] = __('Invalid yacht selection', GY_TEXT_DOMAIN);
    }
    
    // Check if there are errors
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        wp_send_json($response);
    }
    
    // Get yacht details
    $yacht_title = get_the_title($yacht_id);
    $hourly_pricing = get_post_meta($yacht_id, '_gy_hourly_pricing', true);
    $price = 0;
    
    // Find the selected hour price
    if (is_array($hourly_pricing)) {
        foreach ($hourly_pricing as $slot) {
            if ($slot['hour'] == $data['hour']) {
                $price = $slot['cost'];
                break;
            }
        }
    }
    
    // Additional data
    $data['pickup'] = isset($_POST['pickup']) ? sanitize_text_field($_POST['pickup']) : '';
    $data['notes'] = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    
    // Create booking post
    $booking_data = array(
        'post_title' => sprintf(__('Booking for %s on %s', GY_TEXT_DOMAIN), $yacht_title, $data['date']),
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'gy_booking',
    );
    
    $booking_id = wp_insert_post($booking_data);
    
    if ($booking_id) {
        // Save booking meta
        update_post_meta($booking_id, '_gy_booking_yacht_id', $yacht_id);
        update_post_meta($booking_id, '_gy_booking_name', $data['name']);
        update_post_meta($booking_id, '_gy_booking_email', $data['email']);
        update_post_meta($booking_id, '_gy_booking_phone', $data['phone']);
        update_post_meta($booking_id, '_gy_booking_date', $data['date']);
        update_post_meta($booking_id, '_gy_booking_hour', $data['hour']);
        update_post_meta($booking_id, '_gy_booking_people', $data['people']);
        update_post_meta($booking_id, '_gy_booking_price', $price);
        update_post_meta($booking_id, '_gy_booking_pickup', $data['pickup']);
        update_post_meta($booking_id, '_gy_booking_notes', $data['notes']);
        update_post_meta($booking_id, '_gy_booking_status', 'pending');
        
        // Send email notification
        $to = get_option('admin_email');
        $subject = sprintf(__('New Yacht Booking: %s', GY_TEXT_DOMAIN), $yacht_title);
        
        $message = sprintf(__('You have a new booking for %s', GY_TEXT_DOMAIN), $yacht_title) . "\n\n";
        $message .= __('Booking Details:', GY_TEXT_DOMAIN) . "\n";
        $message .= __('Name:', GY_TEXT_DOMAIN) . ' ' . $data['name'] . "\n";
        $message .= __('Email:', GY_TEXT_DOMAIN) . ' ' . $data['email'] . "\n";
        $message .= __('Phone:', GY_TEXT_DOMAIN) . ' ' . $data['phone'] . "\n";
        $message .= __('Date:', GY_TEXT_DOMAIN) . ' ' . $data['date'] . "\n";
        $message .= __('Hour:', GY_TEXT_DOMAIN) . ' ' . $data['hour'] . ':00 - ' . (($data['hour'] + 1) % 24) . ':00' . "\n";
        $message .= __('Number of People:', GY_TEXT_DOMAIN) . ' ' . $data['people'] . "\n";
        $message .= __('Price:', GY_TEXT_DOMAIN) . ' ' . number_format($price, 2) . "\n";
        
        if ($data['pickup']) {
            $message .= __('Pickup Location:', GY_TEXT_DOMAIN) . ' ' . $data['pickup'] . "\n";
        }
        
        if ($data['notes']) {
            $message .= __('Additional Notes:', GY_TEXT_DOMAIN) . ' ' . $data['notes'] . "\n";
        }
        
        wp_mail($to, $subject, $message);
        
        $response['success'] = true;
        $response['message'] = __('Thank you for your booking! We will contact you soon to confirm your reservation.', GY_TEXT_DOMAIN);
    } else {
        $response['message'] = __('There was an error processing your booking. Please try again.', GY_TEXT_DOMAIN);
    }
    
    wp_send_json($response);
}