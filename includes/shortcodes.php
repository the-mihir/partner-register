<?php
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode for Partner Cards Grid
function partner_cards_shortcode() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    $partners = $wpdb->get_results("SELECT * FROM $table_name");

    $output = '<div class="partner-cards">';
    foreach ($partners as $partner) {
        $output .= '<div class="partner-card">';
        // Use company name in URL instead of ID
        $partner_url = add_query_arg('partner', urlencode($partner->company_name), site_url('/partner-details'));
        $output .= '<a href="' . esc_url($partner_url) . '">';
        $output .= '<div class="partner-card-image">';
        if (!empty($partner->logo_url)) {
            $output .= '<img src="' . esc_url($partner->logo_url) . '" alt="' . esc_attr($partner->company_name) . '">';
        }
        $output .= '</div>';
        $output .= '<h3 class="partner-card-title">' . esc_html($partner->company_name) . '</h3>';
        $output .= '</a>';
        $output .= '</div>';
    }
    $output .= '</div>';
    return $output;
}
add_shortcode('partner_cards', 'partner_cards_shortcode');



// Shortcode for Single Partner Details
function partner_details_shortcode() {
    // Get company name from URL
    $company_name = isset($_GET['partner']) ? urldecode($_GET['partner']) : '';
    
    if (empty($company_name)) {
        return '<p>No partner selected.</p>';
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    
    // Query by company name instead of ID
    $partner = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE company_name = %s",
        $company_name
    ));

    if (!$partner) {
        return '<p>Partner not found.</p>';
    }

    ob_start();
    ?>
    <div class="partner-details-page">
        <div class="partner-header">
            <?php if (!empty($partner->logo_url)): ?>
                <div class="partner-logo">
                    <img src="<?php echo esc_url($partner->logo_url); ?>" 
                         alt="<?php echo esc_attr($partner->company_name); ?>">
                </div>
            <?php endif; ?>
            <h1 class="partner-title"><?php echo esc_html($partner->company_name); ?></h1>
            <?php if (!empty($partner->company_subheading)): ?>
                <p class="partner-subtitle"><?php echo esc_html($partner->company_subheading); ?></p>
            <?php endif; ?>
        </div>

        <div class="partner-content">
            <?php if (!empty($partner->tags)): ?>
                <div class="partner-tags">
                    <?php 
                    $tags = array_map('trim', explode(',', $partner->tags));
                    foreach ($tags as $tag): ?>
                        <span class="partner-tag"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($partner->about_partner)): ?>
                <div class="partner-about">
                    <?php echo wpautop(esc_html($partner->about_partner)); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('partner_details', 'partner_details_shortcode');

// Add necessary scripts and styles for frontend
function partner_frontend_assets() {
    wp_enqueue_style('partner-frontend-style', PARTNER_PLUGIN_URL . 'assets/css/public-style.css');
    wp_enqueue_script('partner-frontend-script', PARTNER_PLUGIN_URL . 'assets/js/public-script.js', array('jquery'), '1.0.0', true);
    wp_localize_script('partner-frontend-script', 'partnerAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'partner_frontend_assets');

// AJAX handler for loading partner details
add_action('wp_ajax_get_partner_details', 'get_partner_details_ajax');
add_action('wp_ajax_nopriv_get_partner_details', 'get_partner_details_ajax');

function get_partner_details_ajax() {
    $partner_id = isset($_POST['partner_id']) ? intval($_POST['partner_id']) : 0;
    echo do_shortcode("[partner_details id='$partner_id']");
    wp_die();
}