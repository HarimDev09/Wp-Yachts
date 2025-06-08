<?php
/**
 * Plugin Name: Gestor de Yates
 * Description: Plugin para gestionar y mostrar yates con sus características y precios.
 * Version: 1.0.0
 * Author: Tu Nombre
 * Text Domain: gestor-yates
 * Domain Path: /languages
 */

defined('ABSPATH') or die('No direct access allowed!');

// Define plugin constants
define('GY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('GY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GY_TEXT_DOMAIN', 'gestor-yates');

// Load plugin files
require_once GY_PLUGIN_PATH . 'includes/post-type.php';
require_once GY_PLUGIN_PATH . 'includes/taxonomies.php';
require_once GY_PLUGIN_PATH . 'includes/metaboxes.php';
require_once GY_PLUGIN_PATH . 'includes/admin-scripts.php';
require_once GY_PLUGIN_PATH . 'includes/public-display.php';
require_once GY_PLUGIN_PATH . 'includes/functions.php';

// Load translations
add_action('plugins_loaded', 'gy_load_textdomain');
function gy_load_textdomain() {
    load_plugin_textdomain(GY_TEXT_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// Activation/Deactivation hooks
register_activation_hook(__FILE__, 'gy_activate_plugin');
register_deactivation_hook(__FILE__, 'gy_deactivate_plugin');

function gy_activate_plugin() {
    // Flush rewrite rules on activation
    flush_rewrite_rules();
}

function gy_deactivate_plugin() {
    // Flush rewrite rules on deactivation
    flush_rewrite_rules();
}