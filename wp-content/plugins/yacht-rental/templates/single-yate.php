<?php get_header(); ?>

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