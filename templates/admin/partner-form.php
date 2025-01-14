<?php
$partner_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$partner = array();

if ($partner_id > 0) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'partners';
    $partner = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $partner_id), ARRAY_A);
}
?>

<div class="wrap">
    <h1><?php echo $partner_id ? 'Edit Partner' : 'Add New Partner'; ?></h1>

    <form method="post" action="" enctype="multipart/form-data" class="partner-form">
        <?php wp_nonce_field('save_partner', 'partner_nonce'); ?>
        <input type="hidden" name="action" value="save_partner">
        <input type="hidden" name="partner_id" value="<?php echo $partner_id; ?>">

        <table class="form-table">
            <tr>
                <th scope="row"><label for="company_name">Company Name *</label></th>
                <td>
                    <input type="text" 
                           name="company_name" 
                           id="company_name" 
                           class="regular-text" 
                           value="<?php echo isset($partner['company_name']) ? esc_attr($partner['company_name']) : ''; ?>" 
                           required>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="company_subheading">Company Subheading</label></th>
                <td>
                    <input type="text" 
                           name="company_subheading" 
                           id="company_subheading" 
                           class="regular-text" 
                           value="<?php echo isset($partner['company_subheading']) ? esc_attr($partner['company_subheading']) : ''; ?>">
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="tags">Tags</label></th>
                <td>
                    <input type="text" 
                           name="tags" 
                           id="tags" 
                           class="regular-text" 
                           value="<?php echo isset($partner['tags']) ? esc_attr($partner['tags']) : ''; ?>"
                           placeholder="Enter tags separated by commas">
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="about_partner">About Partner</label></th>
                <td>
                    <textarea name="about_partner" 
                              id="about_partner" 
                              rows="5" 
                              class="large-text"><?php echo isset($partner['about_partner']) ? esc_textarea($partner['about_partner']) : ''; ?></textarea>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="partner_logo">Company Logo/Banner</label></th>
                <td>
                    <?php if (isset($partner['logo_url']) && !empty($partner['logo_url'])) : ?>
                        <div class="current-logo">
                            <img src="<?php echo esc_url($partner['logo_url']); ?>" style="max-width: 200px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="partner_logo" id="partner_logo" accept="image/*">
                </td>
            </tr>
        </table>

        <?php submit_button($partner_id ? 'Update Partner' : 'Add Partner'); ?>
    </form>
</div>