<?php
function gy_shortcode_listado_yates() {
    $query = new WP_Query([
        'post_type' => 'yate',
        'posts_per_page' => -1,
    ]);

    $html = '<div class="listado-yates">';
    while ($query->have_posts()) {
        $query->the_post();
        $precio = get_post_meta(get_the_ID(), '_gy_precio', true);
        $capacidad = get_post_meta(get_the_ID(), '_gy_capacidad', true);
        $html .= '<div class="yate">';
        $html .= '<h3>' . get_the_title() . '</h3>';
        $html .= '<p>' . get_the_excerpt() . '</p>';
        $html .= '<p>Precio: $' . esc_html($precio) . '</p>';
        $html .= '<p>Capacidad: ' . esc_html($capacidad) . ' personas</p>';
        $html .= '<a href="' . get_permalink() . '">Ver más</a>';
        $html .= '</div>';
    }
    $html .= '</div>';
    wp_reset_postdata();

    return $html;
}
add_shortcode('listar_yates', 'gy_shortcode_listado_yates');
