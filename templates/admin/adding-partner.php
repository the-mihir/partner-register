<div class="wrap">
    <h1>Add New Partner</h1>

    <?php if (isset($_POST['submit'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'partners';

        $data = array(
            'partner_name' => sanitize_text_field($_POST['partner_name']),
            'offering_area_name' => sanitize_text_field($_POST['offering_area_name']),
            'subheading' => sanitize_textarea_field($_POST['subheading']),
            'tags' => sanitize_textarea_field($_POST['tags']),
            'about_partner' => sanitize_textarea_field($_POST['about_partner']),
            'box_heading_one' => sanitize_text_field($_POST['box_heading_one']),
            'box_text_one' => sanitize_textarea_field($_POST['box_text_one']),
            'box_heading_two' => sanitize_text_field($_POST['box_heading_two']), 
            'box_text_two' => sanitize_textarea_field($_POST['box_text_two']),
            'hero_image_one' => sanitize_text_field($_POST['hero_image_one']),
            'hero_image_two' => sanitize_text_field($_POST['hero_image_two']),
            'facilities' => sanitize_textarea_field($_POST['facilities']),
            'offering_text' => sanitize_textarea_field($_POST['offering_text']),
            'offer_box_heading_one' => sanitize_text_field($_POST['offer_box_heading_one']),
            'offer_box_text_one' => sanitize_textarea_field($_POST['offer_box_text_one']),
            'offer_box_heading_two' => sanitize_text_field($_POST['offer_box_heading_two']),
            'offer_box_text_two' => sanitize_textarea_field($_POST['offer_box_text_two']),
            'offer_image_one' => sanitize_text_field($_POST['offer_image_one']),
            'offer_image_two' => sanitize_text_field($_POST['offer_image_two']),
            'benefits' => sanitize_textarea_field($_POST['benefits']),
            'services' => sanitize_textarea_field($_POST['services']),
            'hotel_name' => sanitize_text_field($_POST['hotel_name']),
            'address' => sanitize_textarea_field($_POST['address']),
            'offer_stay_total_night' => intval($_POST['offer_stay_total_night']),
            'price' => floatval($_POST['price']),
            'hotel_info_text' => sanitize_textarea_field($_POST['hotel_info_text'])
        );

        $wpdb->insert($table_name, $data);

        if ($wpdb->insert_id) {
            wp_redirect(admin_url('admin.php?page=partner-content-management&message=added'));
            exit;
        }
    } ?>

    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="container-fluid border rounded-3 p-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="partner_name" class="form-label">Partner Name *</label>
                            <input type="text" class="form-control" id="partner_name" name="partner_name" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="offering_area_name" class="form-label">Offering Area Name *</label>
                            <input type="text" class="form-control" id="offering_area_name" name="offering_area_name" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="subheading" class="form-label">Subheading *</label>
                            <textarea class="form-control" id="subheading" name="subheading" rows="2" required></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <textarea class="form-control" id="tags" name="tags" rows="2" 
                                placeholder="Enter tags separated by commas (e.g., luxury, spa, beach)"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="about_partner" class="form-label">About Partner</label>
                            <textarea class="form-control" id="about_partner" name="about_partner" rows="4"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="box_heading_one" class="form-label">Box Heading One</label>
                            <input type="text" class="form-control" id="box_heading_one" name="box_heading_one">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="box_heading_two" class="form-label">Box Heading Two</label>
                            <input type="text" class="form-control" id="box_heading_two" name="box_heading_two">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="box_text_one" class="form-label">Box Text One</label>
                            <textarea class="form-control" id="box_text_one" name="box_text_one" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="box_text_two" class="form-label">Box Text Two</label>
                            <textarea class="form-control" id="box_text_two" name="box_text_two" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hero_image_one" class="form-label">Hero Image One *</label>
                            <input type="file" class="form-control" id="hero_image_one" name="hero_image_one" accept="image/*" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hero_image_two" class="form-label">Hero Image Two</label>
                            <input type="file" class="form-control" id="hero_image_two" name="hero_image_two" accept="image/*">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Facilities *</label>
                            <div id="facilities-container">
                                <div class="mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="facilities[]" required>
                                        <button type="button" class="btn btn-danger remove-field">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary add-facility mt-2">
                                <i class="fas fa-plus"></i> Add Facility
                            </button>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="offering_text" class="form-label">Offering Text</label>
                            <textarea class="form-control" id="offering_text" name="offering_text" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="offer_box_heading_one" class="form-label">Offer Box Heading One</label>
                            <input type="text" class="form-control" id="offer_box_heading_one" name="offer_box_heading_one">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="offer_box_heading_two" class="form-label">Offer Box Heading Two</label>
                            <input type="text" class="form-control" id="offer_box_heading_two" name="offer_box_heading_two">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="offer_box_text_one" class="form-label">Offer Box Text One</label>
                            <textarea class="form-control" id="offer_box_text_one" name="offer_box_text_one" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="offer_box_text_two" class="form-label">Offer Box Text Two</label>
                            <textarea class="form-control" id="offer_box_text_two" name="offer_box_text_two" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="offer_image_one" class="form-label">Offer Image One</label>
                            <input type="file" class="form-control" id="offer_image_one" name="offer_image_one" accept="image/*">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="offer_image_two" class="form-label">Offer Image Two</label>
                            <input type="file" class="form-control" id="offer_image_two" name="offer_image_two" accept="image/*">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Benefits</label>
                            <div id="benefits-container">
                                <div class="mb-2">
                                    <input type="text" class="form-control" name="benefits[]">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary add-benefit mt-2">
                                <i class="fas fa-plus"></i> Add Benefit
                            </button>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Services</label>
                            <div id="services-container">
                                <div class="service-group border p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Service Name *</label>
                                            <input type="text" class="form-control" name="services[0][name]" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Service Heading *</label>
                                            <input type="text" class="form-control" name="services[0][heading]" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="services[0][address]" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Facilities</label>
                                            <textarea class="form-control" name="services[0][facilities]" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="number" step="0.01" class="form-control" name="services[0][price]">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Service Brief</label>
                                            <textarea class="form-control" name="services[0][brief]" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary add-service mt-2">
                                <i class="fas fa-plus"></i> Add Service
                            </button>
                        </div>

                        
                    </div>

                    <div class="mt-4 text-end">
                    <a href="<?php echo admin_url('admin.php?page=partner-content-management'); ?>" class="button button-secondary">Cancel</a>
                        <button type="submit" name="submit" class="button button-primary">Add New Partner</button>
                        
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
    let serviceCount = 1;
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
                        <label class="form-label">Service Name</label>
                        <input type="text" class="form-control" name="services[${serviceCount}][name]">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Service Heading</label>
                        <input type="text" class="form-control" name="services[${serviceCount}][heading]">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="services[${serviceCount}][address]" rows="2"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Facilities</label>
                        <textarea class="form-control" name="services[${serviceCount}][facilities]" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" name="services[${serviceCount}][price]">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Service Brief</label>
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
