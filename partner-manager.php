<?php
/*
Plugin Name: Partner Manager
Description: A plugin to manage and display partners.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue CSS and JS
function partner_manager_enqueue_assets() {
    wp_enqueue_style('partner-manager-admin', plugin_dir_url(__FILE__) . 'assets/css/admin-styles.css');
    wp_enqueue_style('partner-manager-bootstrap', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');

    wp_enqueue_script('partner-manager-admin', plugin_dir_url(__FILE__) . 'assets/js/admin-scripts.js', ['jquery'], null, true);
    wp_enqueue_script('partner-manager-bootstrap', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.bundle.min.js'); // Correct Bootstrap JS
}

add_action('admin_enqueue_scripts', 'partner_manager_enqueue_assets');

// Include necessary files
include_once plugin_dir_path(__FILE__) . 'includes/database.php';
include_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Activate plugin
register_activation_hook(__FILE__, 'partner_manager_install');

// Admin menu
add_action('admin_menu', 'partner_manager_admin_menu');

function partner_manager_admin_menu() {
    add_menu_page(
        'Manage Partners',
        'Partners',
        'manage_options',
        'manage-partners',
        'partner_manager_manage_page',
        'dashicons-groups',
        20
    );

    add_submenu_page(
        'manage-partners',
        'Add Partner',
        'Add New Partner',
        'manage_options',
        'add-partner',
        'partner_manager_add_page'
    );

    add_submenu_page(
        null, // Hidden from menu
        'Edit Partner',
        'Edit Partner',
        'manage_options',
        'edit-partner',
        'partner_manager_edit_page'
    );
}

// Callback functions for admin pages
function partner_manager_manage_page() {
    include plugin_dir_path(__FILE__) . 'admin/manage-partners.php';
}

function partner_manager_add_page() {
    include plugin_dir_path(__FILE__) . 'admin/add-partner.php';
}

function partner_manager_edit_page() {
    include plugin_dir_path(__FILE__) . 'admin/edit-partner.php';
}
