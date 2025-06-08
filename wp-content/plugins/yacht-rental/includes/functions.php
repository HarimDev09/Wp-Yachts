<?php
// Helper function to get all yachts
function gy_get_all_yachts($args = array()) {
    $default_args = array(
        'post_type' => 'yate',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    
    $args = wp_parse_args($args, $default_args);
    
    $query = new WP_Query($args);
    
    return $query;
}

// Helper function to get yacht features
function gy_get_yacht_features($yacht_id) {
    $features = array();
    
    $meta_fields = array(
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
    
    foreach ($meta_fields as $meta_key => $label) {
        $value = get_post_meta($yacht_id, $meta_key, true);
        if ($value) {
            $features[$label] = $value;
        }
    }
    
    return $features;
}

// Helper function to get yacht gallery
function gy_get_yacht_gallery($yacht_id) {
    $gallery_ids = get_post_meta($yacht_id, '_gy_galeria', true);
    $gallery = array();
    
    if ($gallery_ids) {
        $gallery_ids = explode(',', $gallery_ids);
        
        foreach ($gallery_ids as $image_id) {
            $image = wp_get_attachment_image_src($image_id, 'full');
            if ($image) {
                $gallery[] = array(
                    'id' => $image_id,
                    'url' => $image[0],
                    'width' => $image[1],
                    'height' => $image[2],
                );
            }
        }
    }
    
    return $gallery;
}

// Helper function to get yacht hourly pricing
function gy_get_yacht_pricing($yacht_id) {
    $pricing = get_post_meta($yacht_id, '_gy_hourly_pricing', true);
    $formatted_pricing = array();
    
    if (is_array($pricing)) {
        foreach ($pricing as $slot) {
            $start_hour = str_pad($slot['hour'], 2, '0', STR_PAD_LEFT);
            $end_hour = str_pad(($slot['hour'] + 1) % 24, 2, '0', STR_PAD_LEFT);
            
            $formatted_pricing[] = array(
                'hour' => $slot['hour'],
                'start' => $start_hour . ':00',
                'end' => $end_hour . ':00',
                'cost' => $slot['cost'],
                'formatted_cost' => number_format($slot['cost'], 2),
                'time_range' => $start_hour . ':00 - ' . $end_hour . ':00',
                'display' => $start_hour . ':00 - ' . $end_hour . ':00 (' . number_format($slot['cost'], 2) . ')',
            );
        }
    }
    
    return $formatted_pricing;
}

// Helper function to get yacht key features
function gy_get_yacht_key_features($yacht_id) {
    return get_post_meta($yacht_id, '_gy_key_features', true);
}

// Helper function to get yacht amenities
function gy_get_yacht_amenities($yacht_id) {
    return get_the_terms($yacht_id, 'amenity');
}

// Shortcode to display yachts
add_shortcode('yachts', 'gy_yachts_shortcode');
function gy_yachts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    ), $atts);
    
    ob_start();
    
    $args = array(
        'post_type' => 'yate',
        'posts_per_page' => $atts['limit'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
    );
    
    $yachts = gy_get_all_yachts($args);
    
    if ($yachts->have_posts()) :
        echo '<div class="gy-yachts-shortcode">';
        while ($yachts->have_posts()) : $yachts->the_post();
            ?>
            <div class="gy-yacht-item">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>
                <div class="gy-yacht-excerpt"><?php the_excerpt(); ?></div>
                <a href="<?php the_permalink(); ?>" class="gy-yacht-link">
                    <?php _e('View Details', GY_TEXT_DOMAIN); ?>
                </a>
            </div>
            <?php
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    else :
        echo '<p>' . __('No yachts found.', GY_TEXT_DOMAIN) . '</p>';
    endif;
    
    return ob_get_clean();
}