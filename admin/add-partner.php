<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_partner_nonce']) && wp_verify_nonce($_POST['add_partner_nonce'], 'add_partner')) {
    global $wpdb;

    $name = sanitize_text_field($_POST['partner_name']);
    $heading = sanitize_text_field($_POST['partner_heading']);
    $facilities = sanitize_textarea_field($_POST['partner_facilities']);
    $image1 = sanitize_text_field($_POST['partner_image1']);
    $image2 = sanitize_text_field($_POST['partner_image2']);

    $table_name = $wpdb->prefix . 'partners';

    // Insert into database
    $wpdb->insert($table_name, [
        'name' => $name,
        'heading' => $heading,
        'facilities' => $facilities,
        'image1' => $image1,
        'image2' => $image2,
        'created_at' => current_time('mysql')
    ]);

    echo '<div class="notice notice-success"><p>Partner added successfully!</p></div>';
}
?>


<!--  
<div class="wrap">
    <h1>Add New Partner</h1>
    <form method="POST" action="">
        <?php wp_nonce_field('add_partner', 'add_partner_nonce'); ?>

        <table class="form-table">
            <tr>
                <th scope="row"><label for="partner_name">Partner Name</label></th>
                <td><input type="text" id="partner_name" name="partner_name" required class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="partner_heading">Heading</label></th>
                <td><input type="text" id="partner_heading" name="partner_heading" required class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="partner_facilities">Facilities</label></th>
                <td><textarea id="partner_facilities" name="partner_facilities" rows="5" class="large-text"></textarea></td>
            </tr>
            <tr>
                <th scope="row"><label for="partner_image1">Image 1 URL</label></th>
                <td><input type="url" id="partner_image1" name="partner_image1" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="partner_image2">Image 2 URL</label></th>
                <td><input type="url" id="partner_image2" name="partner_image2" class="regular-text"></td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" class="button-primary" value="Add Partner">
        </p>
    </form>
</div>
-->

<!-- Custom partner fields -->
<div class="container-fluid mt-4">
    <div class="row border rounded-2 bg-light py-4">
        <!-- Left side: Tabs -->
        <div class="col-md-2">
            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active w-100 rounded-2 bg-secondary text-white" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Partner Basic</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="about-partner-tab" data-bs-toggle="tab" data-bs-target="#about-partner" type="button" role="tab" aria-controls="about-partner" aria-selected="false">About Partner</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="hero-photo-tab" data-bs-toggle="tab" data-bs-target="#hero-photo" type="button" role="tab" aria-controls="hero-photo" aria-selected="false">Partner Hero Photo</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="amenities-tab" data-bs-toggle="tab" data-bs-target="#amenities" type="button" role="tab" aria-controls="amenities" aria-selected="false">Partner Amenities</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="offers-tab" data-bs-toggle="tab" data-bs-target="#offers" type="button" role="tab" aria-controls="offers" aria-selected="false">Offers Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="about-partner-2-tab" data-bs-toggle="tab" data-bs-target="#about-partner-2" type="button" role="tab" aria-controls="about-partner-2" aria-selected="false">About Partner (Second)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="benefits-tab" data-bs-toggle="tab" data-bs-target="#benefits" type="button" role="tab" aria-controls="benefits" aria-selected="false">Benefits</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100 rounded-2 bg-secondary text-white" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="false">Services</button>
                </li>
            </ul>
        </div>

        <!-- Right side: Tab content -->
        <div class="col-md-10">
            <div class="tab-content" id="myTabContent">
                <!-- Partner Basic Tab -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <h4>Partner Basic</h4>
                    <form>
                        <div class="mb-3">
                            <label for="partnerName" class="form-label">Partner Name</label>
                            <input type="text" class="form-control" id="partnerName" placeholder="Enter partner name">
                        </div>
                        <div class="mb-3">
                            <label for="partnerSubHeading" class="form-label">Partner Sub Heading</label>
                            <input type="text" class="form-control" id="partnerSubHeading" placeholder="Enter partner sub heading">
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="tags" placeholder="Enter tags (comma separated)">
                        </div>
                    </form>
                </div>

                <!-- Other tabs content -->
                <div class="tab-pane fade" id="about-partner" role="tabpanel" aria-labelledby="about-partner-tab">
                    <h4>About Partner</h4>
                    <p>This is the content for About Partner.</p>
                </div>
                <div class="tab-pane fade" id="hero-photo" role="tabpanel" aria-labelledby="hero-photo-tab">
                    <h4>Partner Hero Photo</h4>
                    <p>This is the content for Partner Hero Photo.</p>
                </div>
                <div class="tab-pane fade" id="amenities" role="tabpanel" aria-labelledby="amenities-tab">
                    <h4>Partner Amenities</h4>
                    <p>This is the content for Partner Amenities.</p>
                </div>
                <div class="tab-pane fade" id="offers" role="tabpanel" aria-labelledby="offers-tab">
                    <h4>Offers Info</h4>
                    <p>This is the content for Offers Info.</p>
                </div>
                <div class="tab-pane fade" id="about-partner-2" role="tabpanel" aria-labelledby="about-partner-2-tab">
                    <h4>About Partner (Second)</h4>
                    <p>This is the content for About Partner (Second).</p>
                </div>
                <div class="tab-pane fade" id="benefits" role="tabpanel" aria-labelledby="benefits-tab">
                    <h4>Benefits</h4>
                    <p>This is the content for Benefits.</p>
                </div>
                <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                    <h4>Services</h4>
                    <p>This is the content for Services.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styling for the active tab */
.nav-pills .nav-link.active {
    background-color: #007bff; /* Active tab background color */
    color: white; /* Active tab text color */
}

.nav-pills .nav-link:hover {
    background-color: #0056b3; /* Hover effect for tabs */
}
</style>

