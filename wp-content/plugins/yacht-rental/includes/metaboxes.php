<?php
// Register all metaboxes
add_action('add_meta_boxes', 'gy_add_metaboxes');
function gy_add_metaboxes() {
    add_meta_box(
        'gy_general_features',
        __('General Features', GY_TEXT_DOMAIN),
        'gy_general_features_callback',
        'yate',
        'normal',
        'high'
    );

    add_meta_box(
        'gy_hourly_pricing',
        __('Hourly Pricing', GY_TEXT_DOMAIN),
        'gy_hourly_pricing_callback',
        'yate',
        'normal',
        'high'
    );

    add_meta_box(
        'gy_key_features',
        __('Key Features', GY_TEXT_DOMAIN),
        'gy_key_features_callback',
        'yate',
        'normal',
        'high'
    );

    add_meta_box(
        'gy_additional_settings',
        __('Additional Settings', GY_TEXT_DOMAIN),
        'gy_additional_settings_callback',
        'yate',
        'side'
    );

    add_meta_box(
        'gy_gallery',
        __('Yacht Gallery', GY_TEXT_DOMAIN),
        'gy_gallery_callback',
        'yate',
        'normal',
        'high'
    );
}

// General Features Callback
function gy_general_features_callback($post) {
    wp_nonce_field('gy_save_general_features', 'gy_general_features_nonce');

    $model = get_post_meta($post->ID, '_gy_model', true);
    $year = get_post_meta($post->ID, '_gy_year', true);
    $cabins = get_post_meta($post->ID, '_gy_cabins', true);
    $staterooms = get_post_meta($post->ID, '_gy_staterooms', true);
    $bathrooms = get_post_meta($post->ID, '_gy_bathrooms', true);
    $max_speed = get_post_meta($post->ID, '_gy_max_speed', true);
    $crew = get_post_meta($post->ID, '_gy_crew', true);
    $guest = get_post_meta($post->ID, '_gy_guest', true);
    $max_people = get_post_meta($post->ID, '_gy_max_people', true);
    $departure_location = get_post_meta($post->ID, '_gy_departure_location', true);

    ?>
    <div class="gy-metabox-container">
        <div class="gy-field">
            <label for="gy_model"><?php _e('Model', GY_TEXT_DOMAIN); ?></label>
            <input type="text" id="gy_model" name="gy_model" value="<?php echo esc_attr($model); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_year"><?php _e('Year', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_year" name="gy_year" value="<?php echo esc_attr($year); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_cabins"><?php _e('Cabins', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_cabins" name="gy_cabins" value="<?php echo esc_attr($cabins); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_staterooms"><?php _e('Staterooms', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_staterooms" name="gy_staterooms" value="<?php echo esc_attr($staterooms); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_bathrooms"><?php _e('Bathrooms', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_bathrooms" name="gy_bathrooms" value="<?php echo esc_attr($bathrooms); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_max_speed"><?php _e('Max Speed (knots)', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_max_speed" name="gy_max_speed" value="<?php echo esc_attr($max_speed); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_crew"><?php _e('Crew', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_crew" name="gy_crew" value="<?php echo esc_attr($crew); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_guest"><?php _e('Guest Capacity', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_guest" name="gy_guest" value="<?php echo esc_attr($guest); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_max_people"><?php _e('Max People', GY_TEXT_DOMAIN); ?></label>
            <input type="number" id="gy_max_people" name="gy_max_people" value="<?php echo esc_attr($max_people); ?>">
        </div>

        <div class="gy-field">
            <label for="gy_departure_location"><?php _e('Departure Location', GY_TEXT_DOMAIN); ?></label>
            <input type="text" id="gy_departure_location" name="gy_departure_location" value="<?php echo esc_attr($departure_location); ?>">
        </div>
    </div>
    <?php
}

// Hourly Pricing Callback
function gy_hourly_pricing_callback($post) {
    wp_nonce_field('gy_save_hourly_pricing', 'gy_hourly_pricing_nonce');
    
    $hourly_pricing = get_post_meta($post->ID, '_gy_hourly_pricing', true);
    $hourly_pricing = is_array($hourly_pricing) ? $hourly_pricing : array();
    
    ?>
    <div class="gy-metabox-container">
        <div id="gy-hourly-pricing-container">
            <?php if (!empty($hourly_pricing)) : ?>
                <?php foreach ($hourly_pricing as $index => $price) : ?>
                    <div class="gy-hourly-pricing-row">
                        <select name="gy_hourly_pricing[<?php echo $index; ?>][hour]" class="gy-hour-select">
                            <?php for ($i = 0; $i < 24; $i++) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($price['hour'], $i); ?>>
                                    <?php printf('%02d:00 - %02d:00', $i, ($i + 1) % 24); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <input type="number" name="gy_hourly_pricing[<?php echo $index; ?>][cost]" value="<?php echo esc_attr($price['cost']); ?>" placeholder="<?php _e('Price', GY_TEXT_DOMAIN); ?>">
                        <button type="button" class="button gy-remove-hour"><?php _e('Remove', GY_TEXT_DOMAIN); ?></button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <button type="button" id="gy-add-hour" class="button"><?php _e('Add Hour Slot', GY_TEXT_DOMAIN); ?></button>
    </div>
    
    <script type="text/html" id="tmpl-gy-hourly-pricing-row">
        <div class="gy-hourly-pricing-row">
            <select name="gy_hourly_pricing[{{data.index}}][hour]" class="gy-hour-select">
                <?php for ($i = 0; $i < 24; $i++) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php printf('%02d:00 - %02d:00', $i, ($i + 1) % 24); ?>
                    </option>
                <?php endfor; ?>
            </select>
            <input type="number" name="gy_hourly_pricing[{{data.index}}][cost]" value="" placeholder="<?php _e('Price', GY_TEXT_DOMAIN); ?>">
            <button type="button" class="button gy-remove-hour"><?php _e('Remove', GY_TEXT_DOMAIN); ?></button>
        </div>
    </script>
    <?php
}

// Key Features Callback
function gy_key_features_callback($post) {
    wp_nonce_field('gy_save_key_features', 'gy_key_features_nonce');
    
    $key_features = get_post_meta($post->ID, '_gy_key_features', true);
    $key_features = is_array($key_features) ? $key_features : array();
    
    ?>
    <div class="gy-metabox-container">
        <div id="gy-key-features-container">
            <?php if (!empty($key_features)) : ?>
                <?php foreach ($key_features as $index => $feature) : ?>
                    <div class="gy-key-feature-row">
                        <input type="text" name="gy_key_features[<?php echo $index; ?>][title]" value="<?php echo esc_attr($feature['title']); ?>" placeholder="<?php _e('Feature Title', GY_TEXT_DOMAIN); ?>">
                        <textarea name="gy_key_features[<?php echo $index; ?>][desc]" placeholder="<?php _e('Feature Description', GY_TEXT_DOMAIN); ?>"><?php echo esc_textarea($feature['desc']); ?></textarea>
                        <button type="button" class="button gy-remove-feature"><?php _e('Remove', GY_TEXT_DOMAIN); ?></button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="gy-add-feature-container">
            <input type="text" id="gy-new-feature-title" placeholder="<?php _e('New Feature Title', GY_TEXT_DOMAIN); ?>">
            <textarea id="gy-new-feature-desc" placeholder="<?php _e('New Feature Description', GY_TEXT_DOMAIN); ?>"></textarea>
            <button type="button" id="gy-add-feature" class="button"><?php _e('Add Feature', GY_TEXT_DOMAIN); ?></button>
        </div>
    </div>
    
    <script type="text/html" id="tmpl-gy-key-feature-row">
        <div class="gy-key-feature-row">
            <input type="text" name="gy_key_features[{{data.index}}][title]" value="{{data.title}}" placeholder="<?php _e('Feature Title', GY_TEXT_DOMAIN); ?>">
            <textarea name="gy_key_features[{{data.index}}][desc]" placeholder="<?php _e('Feature Description', GY_TEXT_DOMAIN); ?>">{{data.desc}}</textarea>
            <button type="button" class="button gy-remove-feature"><?php _e('Remove', GY_TEXT_DOMAIN); ?></button>
        </div>
    </script>
    <?php
}

// Additional Settings Callback
function gy_additional_settings_callback($post) {
    wp_nonce_field('gy_save_additional_settings', 'gy_additional_settings_nonce');
    
    $apply_tax = get_post_meta($post->ID, '_gy_apply_tax', true);
    $pickup_other_point = get_post_meta($post->ID, '_gy_pickup_other_point', true);
    
    ?>
    <div class="gy-metabox-container">
        <div class="gy-field">
            <label>
                <input type="checkbox" name="gy_apply_tax" value="1" <?php checked($apply_tax, '1'); ?>>
                <?php _e('Apply Tax', GY_TEXT_DOMAIN); ?>
            </label>
        </div>
        
        <div class="gy-field">
            <label>
                <input type="checkbox" name="gy_pickup_other_point" value="1" <?php checked($pickup_other_point, '1'); ?>>
                <?php _e('Allow Pickup at Another Point', GY_TEXT_DOMAIN); ?>
            </label>
        </div>
    </div>
    <?php
}

// Gallery Callback
function gy_gallery_callback($post) {
    wp_nonce_field('gy_save_gallery', 'gy_gallery_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_gy_galeria', true);
    $gallery_ids = $gallery_ids ? explode(',', $gallery_ids) : array();
    
    ?>
    <div class="gy-metabox-container">
        <div id="gy-gallery-container">
            <ul class="gy-gallery-images">
                <?php foreach ($gallery_ids as $image_id) : ?>
                    <?php if ($image = wp_get_attachment_image_src($image_id)) : ?>
                        <li class="gy-gallery-image" data-attachment-id="<?php echo esc_attr($image_id); ?>">
                            <img src="<?php echo esc_url($image[0]); ?>" alt="">
                            <a href="#" class="gy-remove-image">×</a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            
            <input type="hidden" id="gy_galeria" name="gy_galeria" value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
            
            <button type="button" id="gy-upload-gallery" class="button"><?php _e('Add Images', GY_TEXT_DOMAIN); ?></button>
        </div>
    </div>
    <?php
}

// Save all metabox data
add_action('save_post', 'gy_save_metaboxes');
function gy_save_metaboxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (get_post_type($post_id) !== 'yate') return;
    
    // Save General Features
    if (isset($_POST['gy_general_features_nonce']) && wp_verify_nonce($_POST['gy_general_features_nonce'], 'gy_save_general_features')) {
        $fields = array(
            'gy_model' => '_gy_model',
            'gy_year' => '_gy_year',
            'gy_cabins' => '_gy_cabins',
            'gy_staterooms' => '_gy_staterooms',
            'gy_bathrooms' => '_gy_bathrooms',
            'gy_max_speed' => '_gy_max_speed',
            'gy_crew' => '_gy_crew',
            'gy_guest' => '_gy_guest',
            'gy_max_people' => '_gy_max_people',
            'gy_departure_location' => '_gy_departure_location',
        );
        
        foreach ($fields as $field => $meta_key) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Save Hourly Pricing
    if (isset($_POST['gy_hourly_pricing_nonce']) && wp_verify_nonce($_POST['gy_hourly_pricing_nonce'], 'gy_save_hourly_pricing')) {
        if (!empty($_POST['gy_hourly_pricing'])) {
            $hourly_pricing = array();
            
            foreach ($_POST['gy_hourly_pricing'] as $price) {
                if (!empty($price['hour']) && isset($price['cost'])) {
                    $hourly_pricing[] = array(
                        'hour' => absint($price['hour']),
                        'cost' => floatval($price['cost']),
                    );
                }
            }
            
            update_post_meta($post_id, '_gy_hourly_pricing', $hourly_pricing);
        } else {
            delete_post_meta($post_id, '_gy_hourly_pricing');
        }
    }
    
    // Save Key Features
    if (isset($_POST['gy_key_features_nonce']) && wp_verify_nonce($_POST['gy_key_features_nonce'], 'gy_save_key_features')) {
        if (!empty($_POST['gy_key_features'])) {
            $key_features = array();
            
            foreach ($_POST['gy_key_features'] as $feature) {
                if (!empty($feature['title'])) {
                    $key_features[] = array(
                        'title' => sanitize_text_field($feature['title']),
                        'desc' => sanitize_textarea_field($feature['desc']),
                    );
                }
            }
            
            update_post_meta($post_id, '_gy_key_features', $key_features);
        } else {
            delete_post_meta($post_id, '_gy_key_features');
        }
    }
    
    // Save Additional Settings
    if (isset($_POST['gy_additional_settings_nonce']) && wp_verify_nonce($_POST['gy_additional_settings_nonce'], 'gy_save_additional_settings')) {
        $apply_tax = isset($_POST['gy_apply_tax']) ? '1' : '0';
        $pickup_other_point = isset($_POST['gy_pickup_other_point']) ? '1' : '0';
        
        update_post_meta($post_id, '_gy_apply_tax', $apply_tax);
        update_post_meta($post_id, '_gy_pickup_other_point', $pickup_other_point);
    }
    
    // Save Gallery
    if (isset($_POST['gy_gallery_nonce']) && wp_verify_nonce($_POST['gy_gallery_nonce'], 'gy_save_gallery')) {
        if (!empty($_POST['gy_galeria'])) {
            $gallery_ids = explode(',', sanitize_text_field($_POST['gy_galeria']));
            $gallery_ids = array_map('absint', $gallery_ids);
            $gallery_ids = array_filter($gallery_ids);
            
            update_post_meta($post_id, '_gy_galeria', implode(',', $gallery_ids));
        } else {
            delete_post_meta($post_id, '_gy_galeria');
        }
    }
}