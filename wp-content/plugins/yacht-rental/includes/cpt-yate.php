<?php
function gy_registrar_post_type_yate() {
    $labels = [
        'name' => 'Yates',
        'singular_name' => 'Yate',
        'add_new' => 'Agregar Yate',
        'add_new_item' => 'Nuevo Yate',
        'edit_item' => 'Editar Yate',
        'new_item' => 'Nuevo Yate',
        'view_item' => 'Ver Yate',
        'search_items' => 'Buscar Yates',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-admin-site',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'yates'],
    ];

    register_post_type('yate', $args);
}
add_action('init', 'gy_registrar_post_type_yate');
