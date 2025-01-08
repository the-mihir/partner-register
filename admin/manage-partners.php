<?php
global $wpdb;
$table_name = $wpdb->prefix . 'partners';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $wpdb->delete($table_name, ['id' => $id]);
    echo '<div class="notice notice-success"><p>Partner deleted successfully.</p></div>';
}

// Fetch partners
$partners = $wpdb->get_results("SELECT * FROM $table_name");

?>

<div class="wrap">
    <h1>Manage Partners</h1>
    <a href="?page=add-partner" class="button button-primary">Add New Partner</a>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($partners as $partner) : ?>
                <tr>
                    <td><?php echo esc_html($partner->id); ?></td>
                    <td><?php echo esc_html($partner->name); ?></td>
                    <td><?php echo esc_html($partner->created_at); ?></td>
                    <td>
                        <a href="?page=edit-partner&id=<?php echo esc_attr($partner->id); ?>" class="button">Update</a>
                        <a href="?page=manage-partners&delete=<?php echo esc_attr($partner->id); ?>" class="button button-secondary" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
