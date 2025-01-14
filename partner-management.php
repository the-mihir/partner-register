<?php
/**
 * Plugin Name: Partner Management
 * Description: Manage partners with custom post types and shortcodes
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}




// Define plugin constants
define('PARTNER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PARTNER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Activation Hook
register_activation_hook(__FILE__, 'partner_plugin_activate');

function partner_plugin_activate() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    
    $table_name = $wpdb->prefix . 'partners';
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        company_name varchar(255) NOT NULL,
        company_subheading text,
        tags text,
        about_partner text,
        logo_url varchar(255),
        created_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation Hook
register_deactivation_hook(__FILE__, 'partner_plugin_deactivate');

function partner_plugin_deactivate() {
    // Cleanup code if needed
}

// Include required files after plugin is loaded
function partner_plugin_init() {
    require_once PARTNER_PLUGIN_PATH . 'includes/database.php';
    require_once PARTNER_PLUGIN_PATH . 'includes/admin-menu.php';
    require_once PARTNER_PLUGIN_PATH . 'includes/partner-form.php';
    require_once PARTNER_PLUGIN_PATH . 'includes/shortcodes.php';
}
add_action('plugins_loaded', 'partner_plugin_init');

// Enqueue admin scripts and styles
function partner_admin_enqueue_scripts($hook) {
    // Only load on our plugin pages
    if (strpos($hook, 'partner') !== false) {
        wp_enqueue_style('partner-admin-style', PARTNER_PLUGIN_URL . 'assets/css/admin-style.css');
        wp_enqueue_script('partner-admin-script', PARTNER_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), '1.0.0', true);
    }
}
add_action('admin_enqueue_scripts', 'partner_admin_enqueue_scripts');