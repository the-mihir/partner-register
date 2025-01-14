<?php
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
add_action('admin_init', 'handle_partner_form_submission');

function handle_partner_form_submission() {
    if (!isset($_POST['action']) || $_POST['action'] !== 'save_partner') {
        return;
    }

    if (!isset($_POST['partner_nonce']) || !wp_verify_nonce($_POST['partner_nonce'], 'save_partner')) {
        wp_die('Invalid nonce');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    $partner_id = isset($_POST['partner_id']) ? intval($_POST['partner_id']) : 0;

    // Prepare partner data
    $partner_data = array(
        'company_name' => sanitize_text_field($_POST['company_name']),
        'company_subheading' => sanitize_text_field($_POST['company_subheading']),
        'tags' => sanitize_text_field($_POST['tags']),
        'about_partner' => wp_kses_post($_POST['about_partner'])
    );

    // Handle image upload
    if (!empty($_FILES['partner_logo']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_upload('partner_logo', 0);
        if (!is_wp_error($attachment_id)) {
            $partner_data['logo_url'] = wp_get_attachment_url($attachment_id);
        }
    }

    if ($partner_id > 0) {
        // Update existing partner
        $wpdb->update(
            $table_name,
            $partner_data,
            array('id' => $partner_id)
        );
        $message = 'updated';
    } else {
        // Insert new partner
        $wpdb->insert($table_name, $partner_data);
        $partner_id = $wpdb->insert_id;
        $message = 'added';
    }

    // Redirect after successful submission
    wp_redirect(admin_url("admin.php?page=partners&message={$message}"));
    exit;
}