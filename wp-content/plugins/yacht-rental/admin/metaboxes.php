<?php

function gy_agregar_metaboxes() {
    add_meta_box('gy_datos_yate', 'Datos del Yate', 'gy_render_campos_yate', 'yate', 'normal', 'default');
}
add_action('add_meta_boxes', 'gy_agregar_metaboxes');

function gy_render_campos_yate($post) {
    // Características simples
    $campos = [
        'model' => 'Modelo',
        'year' => 'Año',
        'cabins' => 'Cabinas',
        'staterooms' => 'Staterooms',
        'bathrooms' => 'Baños',
        'max_speed' => 'Velocidad Máxima',
        'crew' => 'Tripulación',
        'guest' => 'Pasajeros',
        'max_personas' => 'Máximo de Personas',
        'departure_location' => 'Lugar de Salida',
    ];

    echo "<h4>Características</h4>";
    foreach ($campos as $key => $label) {
        $valor = get_post_meta($post->ID, "_gy_$key", true);
        echo "<label>$label:</label><br>";
        echo "<input type='text' name='gy_$key' value='" . esc_attr($valor) . "' style='width:100%;'><br><br>";
    }

    // Puede recoger en otro punto
    $pickup_otro_punto = get_post_meta($post->ID, '_gy_pickup_otro_punto', true);
    echo "<label><input type='checkbox' name='gy_pickup_otro_punto' value='1'" . checked($pickup_otro_punto, '1', false) . "> ¿Puede recoger en otro punto?</label><br><br>";

    // Galería de imágenes (URLs por ahora)
    $galeria = get_post_meta($post->ID, '_gy_galeria', true);
    echo "<h4>Galería de imágenes</h4>";
    echo "<textarea name='gy_galeria' style='width:100%; height:60px;' placeholder='URLs separadas por comas'>" . esc_textarea($galeria) . "</textarea><br><br>";

    // Key Features (JSON en textarea)
    $key_features = get_post_meta($post->ID, '_gy_key_features', true);
    echo "<h4>Key Features</h4>";
    echo "<textarea name='gy_key_features' style='width:100%; height:80px;' placeholder='Una por línea: Título | Descripción'>" . esc_textarea($key_features) . "</textarea><br><br>";

    // Precios por hora (JSON en textarea)
    $precios_por_hora = get_post_meta($post->ID, '_gy_precios_por_hora', true);
    echo "<h4>Precios por hora</h4>";
    echo "<textarea name='gy_precios_por_hora' style='width:100%; height:80px;' placeholder='Una por línea: Horas | Precio'>" . esc_textarea($precios_por_hora) . "</textarea><br><br>";

    // Checkbox para aplicar tax
    $aplicar_tax = get_post_meta($post->ID, '_gy_aplicar_tax', true);
    echo "<label><input type='checkbox' name='gy_aplicar_tax' value='1'" . checked($aplicar_tax, '1', false) . "> ¿Aplicar tax a los precios?</label><br><br>";

    // Amenities (múltiple)
    $todas_amenidades = ['WiFi', 'Bebidas', 'Música', 'Capitán', 'Aire acondicionado', 'Toallas', 'Equipo de snorkel'];
    $seleccionadas = get_post_meta($post->ID, '_gy_amenidades', true);
    if (!is_array($seleccionadas)) $seleccionadas = [];

    echo "<h4>Amenities</h4>";
    echo "<select name='gy_amenidades[]' multiple style='width:100%; height:100px;'>";
    foreach ($todas_amenidades as $amenidad) {
        echo "<option value='" . esc_attr($amenidad) . "'" . selected(in_array($amenidad, $seleccionadas), true, false) . ">$amenidad</option>";
    }
    echo "</select><br><br>";
}

function gy_guardar_campos_yate($post_id) {
    $campos = ['model', 'year', 'cabins', 'staterooms', 'bathrooms', 'max_speed', 'crew', 'guest', 'max_personas', 'departure_location'];

    foreach ($campos as $campo) {
        if (isset($_POST["gy_$campo"])) {
            update_post_meta($post_id, "_gy_$campo", sanitize_text_field($_POST["gy_$campo"]));
        }
    }

    // Checkbox recoger otro punto
    update_post_meta($post_id, '_gy_pickup_otro_punto', isset($_POST['gy_pickup_otro_punto']) ? '1' : '0');

    // Galería
    if (isset($_POST['gy_galeria'])) {
        update_post_meta($post_id, '_gy_galeria', sanitize_text_field($_POST['gy_galeria']));
    }

    // Key Features (guardamos como string)
    if (isset($_POST['gy_key_features'])) {
        update_post_meta($post_id, '_gy_key_features', sanitize_textarea_field($_POST['gy_key_features']));
    }

    // Precios por hora
    if (isset($_POST['gy_precios_por_hora'])) {
        update_post_meta($post_id, '_gy_precios_por_hora', sanitize_textarea_field($_POST['gy_precios_por_hora']));
    }

    // Checkbox aplicar tax
    update_post_meta($post_id, '_gy_aplicar_tax', isset($_POST['gy_aplicar_tax']) ? '1' : '0');

    // Amenities múltiples
    $amenidades = isset($_POST['gy_amenidades']) ? array_map('sanitize_text_field', $_POST['gy_amenidades']) : [];
    update_post_meta($post_id, '_gy_amenidades', $amenidades);
}
add_action('save_post', 'gy_guardar_campos_yate');
