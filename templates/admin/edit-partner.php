<?php
if (!defined('ABSPATH')) {
    exit;
}

// Get partner ID from URL
$partner_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get partner data
global $wpdb;
$table_name = $wpdb->prefix . 'partners';
$partner = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $partner_id));

// If partner not found, redirect back to list
if (!$partner) {
    wp_redirect(admin_url('admin.php?page=partner-content-management'));
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_partner'])) {
    $data = array(
        'partner_name' => sanitize_text_field($_POST['partner_name']),
        'offering_area_name' => sanitize_text_field($_POST['offering_area_name']),
        'subheading' => sanitize_textarea_field($_POST['subheading']),
        'tags' => sanitize_textarea_field($_POST['tags']),
        'about_partner' => sanitize_textarea_field($_POST['about_partner']),
        'box_heading_one' => sanitize_text_field($_POST['box_heading_one']),
        'box_heading_two' => sanitize_text_field($_POST['box_heading_two']),
        'box_text_one' => sanitize_textarea_field($_POST['box_text_one']),
        'box_text_two' => sanitize_textarea_field($_POST['box_text_two']),
        'offering_text' => sanitize_textarea_field($_POST['offering_text']),
        'offer_box_heading_one' => sanitize_text_field($_POST['offer_box_heading_one']),
        'offer_box_heading_two' => sanitize_text_field($_POST['offer_box_heading_two']),
        'offer_box_text_one' => sanitize_textarea_field($_POST['offer_box_text_one']),
        'offer_box_text_two' => sanitize_textarea_field($_POST['offer_box_text_two'])
    );

    // Handle file uploads
    $upload_fields = ['hero_image_one', 'hero_image_two', 'offer_image_one', 'offer_image_two'];
    foreach ($upload_fields as $field) {
        if (!empty($_FILES[$field]['name'])) {
            $uploaded_file = wp_handle_upload($_FILES[$field], array('test_form' => false));
            if (!isset($uploaded_file['error'])) {
                $data[$field] = $uploaded_file['url'];
            }
        }
    }

    // Handle arrays (facilities, benefits, services)
    if (isset($_POST['facilities'])) {
        $data['facilities'] = json_encode(array_map('sanitize_text_field', $_POST['facilities']));
    }
    if (isset($_POST['benefits'])) {
        $data['benefits'] = json_encode(array_map('sanitize_text_field', $_POST['benefits']));
    }
    if (isset($_POST['services'])) {
        $data['services'] = json_encode(array_map(function($service) {
            return array_map('sanitize_text_field', $service);
        }, $_POST['services']));
    }

    // Update partner
    $wpdb->update(
        $table_name,
        $data,
        ['id' => $partner_id],
        array_fill(0, count($data), '%s'),
        ['%d']
    );

    // Redirect back to list with success message
    wp_redirect(add_query_arg('message', 'updated', admin_url('admin.php?page=partner-content-management')));
    exit;
}

// Decode JSON data for arrays
$facilities = json_decode($partner->facilities ?? '[]', true) ?: [];
$benefits = json_decode($partner->benefits ?? '[]', true) ?: [];
$services = json_decode($partner->services ?? '[]', true) ?: [];
?>

<div class="wrap">
    <h1>Edit Partner</h1>
    
    <form method="post" action="" enctype="multipart/form-data">
        <div class="container-fluid border rounded-3 p-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <label for="partner_name" class="form-label fw-bold fs-5 mb-2">Partner Name</label>
                            <input type="text" class="form-control" id="partner_name" name="partner_name" 
                                   value="<?php echo esc_attr($partner->partner_name); ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                        <label for="offering_area_name" class="form-label fw-bold fs-5 mb-2">Offering Area Name *</label>   
                            <input type="text" class="form-control" id="offering_area_name" name="offering_area_name" 
                                   value="<?php echo esc_attr($partner->offering_area_name); ?>" required>
                        </div>

                        <div class="col-md-12 mb-3">
                        <label for="subheading" class="form-label fw-bold fs-5 mb-2">Subheading *</label>
                            <textarea class="form-control" id="subheading" name="subheading" rows="2" required><?php echo esc_textarea($partner->subheading); ?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                        <label for="tags" class="form-label fw-bold fs-5 mb-2">Tags</label>
                            <textarea class="form-control" id="tags" name="tags" rows="2" 
                                placeholder="Enter tags separated by commas (e.g., luxury, spa, beach)"><?php echo esc_textarea($partner->tags); ?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                        <label for="about_partner" class="form-label fw-bold fs-5 mb-2">About Partner</label>
                            <textarea class="form-control" id="about_partner" name="about_partner" rows="4"><?php echo esc_textarea($partner->about_partner); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="box_heading_one" class="form-label fw-bold fs-5 mb-2">Box Heading One</label>
                            <input type="text" class="form-control" id="box_heading_one" name="box_heading_one" 
                                   value="<?php echo esc_attr($partner->box_heading_one); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="box_heading_two" class="form-label fw-bold fs-5 mb-2">Box Heading Two</label>
                            <input type="text" class="form-control" id="box_heading_two" name="box_heading_two" 
                                   value="<?php echo esc_attr($partner->box_heading_two); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="box_text_one" class="form-label fw-bold fs-5 mb-2">Box Text One</label>
                            <textarea class="form-control" id="box_text_one" name="box_text_one" rows="3"><?php echo esc_textarea($partner->box_text_one); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="box_text_two" class="form-label fw-bold fs-5 mb-2">Box Text Two</label>
                            <textarea class="form-control" id="box_text_two" name="box_text_two" rows="3"><?php echo esc_textarea($partner->box_text_two); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="hero_image_one" class="form-label fw-bold fs-5 mb-2">Hero Image One</label>
                            <?php if (!empty($partner->hero_image_one)): ?>
                                <img src="<?php echo esc_url($partner->hero_image_one); ?>" style="max-width: 200px; display: block; margin-bottom: 10px;">
                            <?php endif; ?>
                            <input type="file" class="form-control" id="hero_image_one" name="hero_image_one" accept="image/*">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="hero_image_two" class="form-label fw-bold fs-5 mb-2">Hero Image Two</label>
                            <?php if (!empty($partner->hero_image_two)): ?>
                                <img src="<?php echo esc_url($partner->hero_image_two); ?>" style="max-width: 200px; display: block; margin-bottom: 10px;">
                            <?php endif; ?>
                            <input type="file" class="form-control" id="hero_image_two" name="hero_image_two" accept="image/*">
                        </div>

                        <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2">Facilities *</label>
                            <div id="facilities-container">
                                <?php foreach ($facilities as $facility): ?>
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="facilities[]" value="<?php echo esc_attr($facility); ?>" required>
                                            <button type="button" class="btn btn-danger remove-field">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-primary add-facility mt-2">
                                <i class="fas fa-plus"></i> Add Facility
                            </button>
                        </div>

                        <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2">Offering Text</label>
                            <textarea class="form-control" id="offering_text" name="offering_text" rows="3"><?php echo esc_textarea($partner->offering_text); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="offer_box_heading_one" class="form-label fw-bold fs-5 mb-2">Offer Box Heading One</label>
                            <input type="text" class="form-control" id="offer_box_heading_one" name="offer_box_heading_one" 
                                   value="<?php echo esc_attr($partner->offer_box_heading_one); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="offer_box_heading_two" class="form-label fw-bold fs-5 mb-2">Offer Box Heading Two</label>
                            <input type="text" class="form-control" id="offer_box_heading_two" name="offer_box_heading_two" 
                                   value="<?php echo esc_attr($partner->offer_box_heading_two); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="offer_box_text_one" class="form-label fw-bold fs-5 mb-2">Offer Box Text One</label>
                            <textarea class="form-control" id="offer_box_text_one" name="offer_box_text_one" rows="3"><?php echo esc_textarea($partner->offer_box_text_one); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="offer_box_text_two" class="form-label fw-bold fs-5 mb-2">Offer Box Text Two</label>
                            <textarea class="form-control" id="offer_box_text_two" name="offer_box_text_two" rows="3"><?php echo esc_textarea($partner->offer_box_text_two); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="offer_image_one" class="form-label fw-bold fs-5 mb-2">Offer Image One</label>
                            <?php if (!empty($partner->offer_image_one)): ?>
                                <img src="<?php echo esc_url($partner->offer_image_one); ?>" style="max-width: 200px; display: block; margin-bottom: 10px;">
                            <?php endif; ?>
                            <input type="file" class="form-control" id="offer_image_one" name="offer_image_one" accept="image/*">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="offer_image_two" class="form-label fw-bold fs-5 mb-2">Offer Image Two</label>
                            <?php if (!empty($partner->offer_image_two)): ?>
                                <img src="<?php echo esc_url($partner->offer_image_two); ?>" style="max-width: 200px; display: block; margin-bottom: 10px;">
                            <?php endif; ?>
                            <input type="file" class="form-control" id="offer_image_two" name="offer_image_two" accept="image/*">
                        </div>

                        <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2">Benefits</label>
                            <div id="benefits-container">
                                <?php foreach ($benefits as $benefit): ?>
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="benefits[]" value="<?php echo esc_attr($benefit); ?>">
                                            <button type="button" class="btn btn-danger remove-field">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-primary add-benefit mt-2">
                                <i class="fas fa-plus"></i> Add Benefit
                            </button>
                        </div>

                        <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2">Services</label>
                            <div id="services-container">
                                <?php foreach ($services as $index => $service): ?>
                                    <div class="service-group border p-3 mb-3">
                                        <div class="row">
                                            <div class="col-12 text-end mb-2">
                                                <button type="button" class="btn btn-danger remove-service">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold fs-5 mb-2">Service Name *</label>
                                                <input type="text" class="form-control" name="services[<?php echo $index; ?>][name]" 
                                                       value="<?php echo esc_attr($service['name'] ?? ''); ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold fs-5 mb-2">Service Heading *</label>
                                                <input type="text" class="form-control" name="services[<?php echo $index; ?>][heading]" 
                                                       value="<?php echo esc_attr($service['heading'] ?? ''); ?>" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold fs-5 mb-2">Address</label>
                                                <textarea class="form-control" name="services[<?php echo $index; ?>][address]" rows="2"><?php echo esc_textarea($service['address'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold fs-5 mb-2">Facilities</label>
                                                <textarea class="form-control" name="services[<?php echo $index; ?>][facilities]" rows="2"><?php echo esc_textarea($service['facilities'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="number" step="0.01" class="form-control" name="services[<?php echo $index; ?>][price]" 
                                                       value="<?php echo esc_attr($service['price'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Service Brief</label>
                                                <textarea class="form-control" name="services[<?php echo $index; ?>][brief]" rows="3"><?php echo esc_textarea($service['brief'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-primary add-service mt-2">
                                <i class="fas fa-plus"></i> Add Service
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="<?php echo admin_url('admin.php?page=partner-content-management'); ?>" class="button button-secondary">Cancel</a>
                        <button type="submit" name="update_partner" class="button button-primary">Update Partner</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modified Facilities Dynamic Fields
    document.querySelector('.add-facility').addEventListener('click', function() {
        const container = document.getElementById('facilities-container');
        const newField = `
            <div class="mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="facilities[]" required>
                    <button type="button" class="btn btn-danger remove-field">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newField);
    });

    // Benefits Dynamic Fields
    document.querySelector('.add-benefit').addEventListener('click', function() {
        const container = document.getElementById('benefits-container');
        const newField = `
            <div class="mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="benefits[]">
                    <button type="button" class="btn btn-danger remove-field">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newField);
    });

    // Services Dynamic Fields
    let serviceCount = <?php echo count($services); ?>;
    document.querySelector('.add-service').addEventListener('click', function() {
        const container = document.getElementById('services-container');
        const newField = `
            <div class="service-group border p-3 mb-3">
                <div class="row">
                    <div class="col-12 text-end mb-2">
                        <button type="button" class="btn btn-danger remove-service">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2 ">Service Name</label>
                        <input type="text" class="form-control" name="services[${serviceCount}][name]">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2 ">Service Heading</label>
                        <input type="text" class="form-control" name="services[${serviceCount}][heading]">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2 ">Address</label>
                        <textarea class="form-control" name="services[${serviceCount}][address]" rows="2"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2 ">Facilities</label>
                        <textarea class="form-control" name="services[${serviceCount}][facilities]" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2 ">Price</label>
                        <input type="number" step="0.01" class="form-control" name="services[${serviceCount}][price]">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold fs-5 mb-2 ">Service Brief</label>
                        <textarea class="form-control" name="services[${serviceCount}][brief]" rows="3"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newField);
        serviceCount++;
    });

    // Remove buttons functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-field') || e.target.parentElement.classList.contains('remove-field')) {
            const fieldGroup = e.target.closest('.input-group').parentElement;
            fieldGroup.remove();
        }
        if (e.target.classList.contains('remove-service') || e.target.parentElement.classList.contains('remove-service')) {
            const serviceGroup = e.target.closest('.service-group');
            serviceGroup.remove();
        }
    });
});
</script>

<style>
.button.button-primary, 
.button.button-secondary {
    padding: 10px 20px;
    font-size: 16px;
    height: auto;
    line-height: 1.4;
    min-width: 150px;
    text-align: center;
}
</style>