<?php
global $wpdb;
$table_name = $wpdb->prefix . 'partners';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $partner = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_text_field($_POST['partner_name']);
    $heading = sanitize_text_field($_POST['partner_heading']);
    $facilities = sanitize_textarea_field($_POST['partner_facilities']);
    $image1 = esc_url_raw($_POST['partner_image1']);
    $image2 = esc_url_raw($_POST['partner_image2']);

    $wpdb->update(
        $table_name,
        [
            'name' => $name,
            'heading' => $heading,
            'facilities' => $facilities,
            'image1' => $image1,
            'image2' => $image2,
        ],
        ['id' => $id]
    );

    echo '<div class="notice notice-success"><p>Partner updated successfully.</p></div>';
}
?>

<div class="wrap">
    <h1>Edit Partner</h1>
    <form method="POST">
        <table class="form-table">
            <tr>
                <th><label for="partner_name">Name</label></th>
                <td><input type="text" name="partner_name" id="partner_name" value="<?php echo esc_attr($partner->name); ?>" required></td>
            </tr>
            <tr>
                <th><label for="partner_heading">Heading</label></th>
                <td><input type="text" name="partner_heading" id="partner_heading" value="<?php echo esc_attr($partner->heading); ?>" required></td>
            </tr>
            <tr>
                <th><label for="partner_facilities">Facilities</label></th>
                <td><textarea name="partner_facilities" id="partner_facilities" rows="5"><?php echo esc_textarea($partner->facilities); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="partner_image1">Image 1</label></th>
                <td><input type="text" name="partner_image1" id="partner_image1" value="<?php echo esc_url($partner->image1); ?>"></td>
            </tr>
            <tr>
                <th><label for="partner_image2">Image 2</label></th>
                <td><input type="text" name="partner_image2" id="partner_image2" value="<?php echo esc_url($partner->image2); ?>"></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button button-primary" value="Update Partner">
        </p>
    </form>
</div>
