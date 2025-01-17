<div class="wrap">
    <h1>Partners</h1>
    <a href="<?php echo admin_url('admin.php?page=partner-content-management-add-new'); ?>" class="button button-primary">Add New Partner</a>

   <div>
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
   </div>

<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">Partner Name</th>
                <th scope="col">Offer Heading</th>
                <th scope="col">Created Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'partners';
            $partners = $wpdb->get_results("SELECT id, partner_name,offer_heading, created_date FROM $table_name ORDER BY id DESC");
            
            if($partners): 
                foreach($partners as $index => $partner):
            ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo esc_html($partner->partner_name); ?></td>
                    <td><?php echo esc_html($partner->offer_heading);?></td>
                    <td><?php echo date('F j, Y', strtotime($partner->created_date)); ?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=partner-content-management-edit&id=' . $partner->id); ?>" 
                           class="button button-small">Edit</a>
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=partner-content-management&action=delete&id=' . $partner->id), 'delete_partner_' . $partner->id); ?>" 
                           class="button button-small button-delete" 
                           onclick="return confirm('Are you sure you want to delete this partner?');">Delete</a>
                    </td>
                </tr>
            <?php 
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="5" class="text-center">No partners found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>