<?php
function gy_agregar_metaboxes() {
    add_meta_box('gy_datos_yate', 'Datos del Yate', 'gy_render_campos_yate', 'yate', 'normal', 'default');
}
add_action('add_meta_boxes', 'gy_agregar_metaboxes');

function gy_render_campos_yate($post) {
    $precio = get_post_meta($post->ID, '_gy_precio', true);
    $capacidad = get_post_meta($post->ID, '_gy_capacidad', true);
    ?>
    <label>Precio: </label>
    <input type="number" name="gy_precio" value="<?php echo esc_attr($precio); ?>"><br><br>
    
    <label>Capacidad: </label>
    <input type="number" name="gy_capacidad" value="<?php echo esc_attr($capacidad); ?>">
    <?php
}

function gy_guardar_campos_yate($post_id) {
    if (array_key_exists('gy_precio', $_POST)) {
        update_post_meta($post_id, '_gy_precio', sanitize_text_field($_POST['gy_precio']));
    }
    if (array_key_exists('gy_capacidad', $_POST)) {
        update_post_meta($post_id, '_gy_capacidad', sanitize_text_field($_POST['gy_capacidad']));
    }
}
add_action('save_post', 'gy_guardar_campos_yate');
