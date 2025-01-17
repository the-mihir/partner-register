<?php


if(!defined('ABSPATH')){
    exit;
}

// Add Admin Menu Item
function partner_content_management_admin_menu(){
    add_menu_page(
        'Partner Content Management',
        'Partners', 
        'manage_options', 
        'partner-content-management', 
        'partner_content_management_settings_page',
        'dashicons-groups',
        30
    );

    add_submenu_page(
        'partner-content-management',
        'Add New Partner',
        'Add New Partner',
        'manage_options',
        'partner-content-management-add-new',
        'partner_content_management_add_new_page'
    );  
    add_submenu_page(
        null,
        'Edit Partner',
        'Edit Partner',
        'manage_options',
        'partner-content-management-edit',
        'partner_content_management_edit_page'
    );
}
add_action('admin_menu', 'partner_content_management_admin_menu');

function partner_content_management_edit_page(){
    require_once PARTNER_CONTENT_MANAGEMENT_DIR . 'templates/admin/edit-partner.php';
}

function partner_content_management_settings_page(){
    require_once PARTNER_CONTENT_MANAGEMENT_DIR . 'templates/admin/partners-list.php';
}

function partner_content_management_add_new_page(){
    require_once PARTNER_CONTENT_MANAGEMENT_DIR . 'templates/admin/adding-partner.php';
}
