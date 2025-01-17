<?php
/**
* Plugin Name: Partner Content Management
* Plugin URI: https://github.com/
* Description: A plugin for managing partner Content.
* Version: 1.0
* Author: Mihir Das
* Author URI: https://github.com/the-mihir
* License: GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* text-domain: partner-content-management
**/


if(!defined('ABSPATH')){
    exit;
}

// Define Plugin Constants
define('PARTNER_CONTENT_MANAGEMENT_DIR', plugin_dir_path(__FILE__));
define('PARTNER_CONTENT_MANAGEMENT_URL', plugin_dir_url(__FILE__));


// Include necessary files
require_once PARTNER_CONTENT_MANAGEMENT_DIR . 'includes/database.php';
require_once PARTNER_CONTENT_MANAGEMENT_DIR . 'includes/admin-menu.php';


// Register activation hook
register_activation_hook(__FILE__, 'partner_content_management_activate');

function partner_content_management_activate() {
    // Create database tables
    partner_content_management_create_tables();
}



// Handle partner deletion
function handle_partner_deletion() {
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $partner_id = intval($_GET['id']);
        
        // Verify nonce
        if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'delete_partner_' . $partner_id)) {
            wp_die('Security check failed');
        }

        // Delete the partner
        global $wpdb;
        $table_name = $wpdb->prefix . 'partners';
        $wpdb->delete(
            $table_name,
            ['id' => $partner_id],
            ['%d']
        );

        // Redirect back to the partner list with a message
        wp_redirect(add_query_arg('message', 'deleted', admin_url('admin.php?page=partner-content-management')));
        exit;
    }
}
add_action('admin_init', 'handle_partner_deletion');



// Adding Style and Script
function partner_content_management_enqueue_styles_scripts(){
    wp_enqueue_style('partner-content-management-style', PARTNER_CONTENT_MANAGEMENT_URL . 'assets/css/bootstrap.min.css');
    wp_enqueue_style('partner-content-management-style', PARTNER_CONTENT_MANAGEMENT_URL . 'assets/css/style.css');
    wp_enqueue_script('partner-content-management-script', PARTNER_CONTENT_MANAGEMENT_URL . 'assets/js/script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'partner_content_management_enqueue_styles_scripts');

