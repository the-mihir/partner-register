<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add menu items
function partner_admin_menu() {
    add_menu_page(
        'Partner Management', // Page title
        'Partners',          // Menu title
        'manage_options',    // Capability
        'partners',          // Menu slug
        'display_partner_list', // Callback function
        'dashicons-groups', // Icon
        30                  // Position
    );

    add_submenu_page(
        'partners',           // Parent slug
        'Add New Partner',    // Page title
        'Add New Partner',    // Menu title
        'manage_options',     // Capability
        'add-new-partner',    // Menu slug
        'display_partner_form' // Callback function
    );
}
add_action('admin_menu', 'partner_admin_menu');

// Display partner list page
function display_partner_list() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    
    // Handle delete action
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $partner_id = intval($_GET['id']);
        if (wp_verify_nonce($_GET['_wpnonce'], 'delete_partner_' . $partner_id)) {
            $wpdb->delete($table_name, array('id' => $partner_id), array('%d'));
            wp_redirect(admin_url('admin.php?page=partners&message=deleted'));
            exit;
        }
    }

    // Get all partners
    $partners = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_date DESC");
    
    require_once PARTNER_PLUGIN_PATH . 'templates/admin/partner-list.php';
}

// Display partner form page
function display_partner_form() {
    require_once PARTNER_PLUGIN_PATH . 'templates/admin/partner-form.php';
}