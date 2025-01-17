<?php

if(!defined('ABSPATH')){
    exit;
}

// Create database tables on plugin activation
function partner_content_management_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    
    // Partners table
    $table_name = $wpdb->prefix . 'partners';
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        partner_name varchar(255) NOT NULL,
        offering_area_name varchar(255) NOT NULL,
        subheading text NOT NULL,
        tags text,
        about_partner text,
        box_heading_one varchar(255),
        box_text_one text,
        box_heading_two varchar(255),
        box_text_two text,
        hero_image_one varchar(255) NOT NULL,
        hero_image_two varchar(255),
        facilities text NOT NULL,
        offering_text text,
        offer_box_heading_one varchar(255),
        offer_box_text_one text,
        offer_box_heading_two varchar(255),
        offer_box_text_two text,
        offer_image_one varchar(255),
        offer_image_two varchar(255),
        benefits text,
        services longtext,
        hotel_name varchar(255),
        address text,
        offer_stay_total_night int(11),
        price decimal(10,2),
        hotel_info_text text,
        created_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(PARTNER_CONTENT_MANAGEMENT_DIR . 'partner-management.php', 'partner_content_management_create_tables');