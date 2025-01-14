<?php
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode for Partner Cards
function partner_cards_shortcode() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    $partners = $wpdb->get_results("SELECT * FROM $table_name ORDER BY company_name ASC");

    ob_start();
    ?>
    <div class="partner-cards-container">
        <?php foreach ($partners as $partner): ?>
            <div class="partner-card" data-partner-id="<?php echo $partner->id; ?>">
                <div class="partner-card-image">
                    <?php if (!empty($partner->logo_url)): ?>
                        <img src="<?php echo esc_url($partner->logo_url); ?>" alt="<?php echo esc_attr($partner->company_name); ?>">
                    <?php endif; ?>
                </div>
                <h3 class="partner-card-title"><?php echo esc_html($partner->company_name); ?></h3>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal for Partner Details -->
    <div id="partner-modal" class="partner-modal">
        <div class="partner-modal-content">
            <span class="partner-modal-close">&times;</span>
            <div id="partner-modal-body"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('partner_cards', 'partner_cards_shortcode');

// Shortcode for Partner Details
function partner_details_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => 0
    ), $atts);

    if (empty($atts['id'])) return '';

    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    $partner = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $atts['id']));

    if (!$partner) return '';

    ob_start();
    ?>
    <div class="partner-details">
        <div class="partner-header">
            <?php if (!empty($partner->logo_url)): ?>
                <div class="partner-logo">
                    <img src="<?php echo esc_url($partner->logo_url); ?>" alt="<?php echo esc_attr($partner->company_name); ?>">
                </div>
            <?php endif; ?>
            <h2><?php echo esc_html($partner->company_name); ?></h2>
            <?php if (!empty($partner->company_subheading)): ?>
                <h3><?php echo esc_html($partner->company_subheading); ?></h3>
            <?php endif; ?>
        </div>

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