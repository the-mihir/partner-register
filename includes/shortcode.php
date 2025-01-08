<?php
function partner_manager_shortcode($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';

    $partners = $wpdb->get_results("SELECT * FROM $table_name");
    $output = '<div class="partners-list">';

    foreach ($partners as $partner) {
        $output .= '<div class="partner-item">';
        $output .= '<h2>' . esc_html($partner->name) . '</h2>';
        $output .= '<p>' . esc_html($partner->heading) . '</p>';
        $output .= '<img src="' . esc_url($partner->image1) . '" alt="' . esc_attr($partner->name) . '">';
        $output .= '</div>';
    }

    $output .= '</div>';
    return $output;
}
add_shortcode('partner_manager', 'partner_manager_shortcode');
