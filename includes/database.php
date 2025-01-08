<?php
function partner_manager_install() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'partners';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        heading TEXT NOT NULL,
        facilities TEXT NOT NULL,
        image1 VARCHAR(255),
        image2 VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
