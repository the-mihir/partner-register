<div class="wrap">
    <h1 class="wp-heading-inline">Partners</h1>
    <a href="<?php echo admin_url('admin.php?page=add-new-partner'); ?>" class="page-title-action">Add New</a>
    
    <?php if (isset($_GET['message'])): ?>
        <div class="updated notice is-dismissible">
            <p>
                <?php 
                $message = $_GET['message'] === 'deleted' ? 'Partner deleted successfully.' : 'Changes saved.';
                echo esc_html($message);
                ?>
            </p>
        </div>
    <?php endif; ?>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th width="50">SL</th>
                <th>Company Name</th>
                <th width="200">Created Date</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($partners):
                $sl = 1;
                foreach ($partners as $partner): 
                    $delete_nonce = wp_create_nonce('delete_partner_' . $partner->id);
            ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo esc_html($partner->company_name); ?></td>
                    <td><?php echo date('F j, Y', strtotime($partner->created_date)); ?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=add-new-partner&id=' . $partner->id); ?>" 
                           class="button button-small">Update</a>
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=partners&action=delete&id=' . $partner->id), 'delete_partner_' . $partner->id); ?>" 
                           class="button button-small button-link-delete"
                           onclick="return confirm('Are you sure you want to delete this partner?')">Delete</a>
                    </td>
                </tr>
            <?php 
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="4">No partners found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>