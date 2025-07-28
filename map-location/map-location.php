<?php 

function skr_enqueue_admin_scripts($hook) {
    global $post;

    // Ensure script is only added to the edit screen of 'service_location' post type
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ('service_location' === $post->post_type) {
            // Enqueue the JavaScript file
            wp_enqueue_script('skr-ajax-script', JOHNNIE_PLUGIN_URL . 'map-location/js/skr-ajax.js', array('jquery'), null, true);

            // Localize the script with new data
            wp_localize_script('skr-ajax-script', 'skrAjax', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('location_metabox_nonce')  // Create nonce which will be passed to AJAX
            ));
        }
    }
}
add_action('admin_enqueue_scripts', 'skr_enqueue_admin_scripts');


// Register the metabox
function skr_add_location_metabox() {
    add_meta_box(
        'location_meta_box',
        'For Location page Google map',
        'skr_render_location_metabox',
        'service_location',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'skr_add_location_metabox');

// Render the metabox content
function skr_render_location_metabox($post) {
    // Add nonce for security
    wp_nonce_field('location_metabox', 'location_metabox_nonce');

    // Retrieve existing values from the database
    $google_map_button_value = get_post_meta($post->ID, '_google_map_button_value', true);

    // Display the form
    ?>
    <label for="google_map_button">Add or Update the ZIP codes location to the Location page in Google map:</label>
    <p><button type="button" id="google_map_button" class="button button-primary"> &nbsp; Add / Update &nbsp; </button></p>
    <input type="hidden" id="google_map_button_value" name="google_map_button_value" value="<?php echo esc_attr($google_map_button_value); ?>">

    <div class="" id="map_btn_ajax_sts" >
        <div class="skr_spinner" id="map_btn_ajax_loading" style="display: none;"></div>
        <div class="" id="map_btn_ajax_msg"></div>
    </div>
    

    <style>
    .skr_spinner {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 9px solid;
        border-color: #dbdcef;
        border-right-color: #ff4747;
        animation: spinner-d3wgkg 1s infinite linear;
        margin: 0px auto;
    }

    @keyframes spinner-d3wgkg {
        to {
            transform: rotate(1turn);
        }
    }
    </style>


    <script>
        jQuery(document).ready(function($) {
			  console.log(0);
        });
    </script>
    <?php
}

// Save the metabox data
function skr_save_location_metabox($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['location_metabox_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['location_metabox_nonce'], 'location_metabox')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Update the meta field in the database.
    if (isset($_POST['google_map_button_value'])) {
        update_post_meta($post_id, '_google_map_button_value', sanitize_text_field($_POST['google_map_button_value']));
    }
}
add_action('save_post', 'skr_save_location_metabox');

function skr_loc_conditions($data,$table_name,$table_name_asl_category,$table_name_stores_categories,$post_id,$zip_code,$email,$phone) {
    
    global $wpdb;
            
    $city = '';
    $state = '';

    // Extract city and state from the JSON
    foreach ($data['results'][0]['address_components'] as $component) {
        if (in_array('locality', $component['types'])) {
            $city = $component['long_name'];
        } elseif (in_array('administrative_area_level_1', $component['types'])) {
            $state = $component['long_name'];
        }
    }

    $lat = $data['results'][0]['geometry']['location']['lat'];
    $lng = $data['results'][0]['geometry']['location']['lng'];

    // Check if the ZIP code exists in the table
    $existing_row = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE postal_code = %s",
            $zip_code
        )
    );

    if ($existing_row) {
        // Update the row
        $wpdb->update(
            $table_name,
            array(
                'title' => get_the_title($post_id) . ' (ZIP:'. $zip_code .')',
                'city' => $city,
                'state' => $state,
                'lat' => $lat,
                'lng' => $lng,
                'street' => $address,
                'email' => $email,
                'phone' => $phone,
                'country' => 223,
            ),
            array('postal_code' => $zip_code),
            array('%s', '%s', '%s', '%s', '%s', '%s'),
            array('%s')
        );
        $store_id = $existing_row->id;
    } else {
        // Insert a new row
        $wpdb->replace(
            $table_name,
            array(
                'title' => get_the_title($post_id) . ' (ZIP:'. $zip_code .')',
                'city' => $city,
                'state' => $state,
                'lat' => $lat,
                'lng' => $lng,
                'street' => $address,
                'postal_code' => $zip_code,
                'email' => $email,
                'phone' => $phone,
                'country' => 223
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        $store_id = $wpdb->insert_id;
    }





    // Get category ID based on category name
    $category_name = get_the_title($post_id); // Assuming post title is the category name
    
    $category_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id FROM $table_name_asl_category WHERE category_name = %s",
            $category_name
        )
    );
    
    if ($category_id != null) {
        // Check if the category ID exists for the store ID
        $existing_category = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table_name_stores_categories WHERE category_id = %d AND store_id = %d",
                $category_id,
                $store_id
            )
        );

        if (!$existing_category || is_null($existing_category)) {
            // Insert a new row in stores_categories table
            $wpdb->insert(
                $table_name_stores_categories,
                array(
                    'category_id' => $category_id,
                    'store_id' => $store_id,
                ),
                array('%d', '%d')
            );
        }
    }

}


function skr_ajax_handler() {
    // Check for nonce security
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'location_metabox_nonce')) {
        wp_die('Nonce value cannot be verified.');
    }

    // Get post and address details
    $post_id = intval($_POST['post_id']);
    $zip_codes = explode(',', get_post_meta($post_id, 'zip_code_service', true));
    $address = get_post_meta($post_id, 'address_service', true);
//    $email = get_post_meta($post_id, 'email_address_services', true);
//    $phone = get_post_meta($post_id, 'phone_number_service', true);

    $owner_id = get_post_meta($post_id, 'owner_id', true);

    // Get owner email and phone
    $email = get_field('email_address', $owner_id);
    $phone = get_field('phone_number', $owner_id);

    global $wpdb;
    $table_name = $wpdb->prefix . 'asl_stores'; // Use dynamic table prefix
    $table_name_asl_category = $wpdb->prefix . 'asl_categories';
    $table_name_stores_categories = $wpdb->prefix . 'asl_stores_categories';

//    $wpdb->get_results("DELETE FROM $table_name_stores_categories WHERE 0=0");
    
    // Process each ZIP code
    foreach ($zip_codes as $zip_code) {
        $zip_code = trim($zip_code);
        $api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&components=postal_code:$zip_code|country:USA&key=AIzaSyAs19mkHmdw-WamEd0fPcEUR5uCdTZWPnU";

        $response = wp_remote_get($api_url);
        if (is_wp_error($response)) {
            continue;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($data['status'] == 'OK') {

            skr_loc_conditions($data,$table_name,$table_name_asl_category,$table_name_stores_categories,$post_id,$zip_code,$email,$phone);

        }else if($data['status'] == 'ZERO_RESULTS'){
            
            $api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=&components=postal_code:$zip_code|country:USA&key=AIzaSyAs19mkHmdw-WamEd0fPcEUR5uCdTZWPnU";

            $response = wp_remote_get($api_url);
            if (is_wp_error($response)) {
                continue;
            }
    
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            
            skr_loc_conditions($data,$table_name,$table_name_asl_category,$table_name_stores_categories,$post_id,$zip_code,$email,$phone);
        }
    }

    echo json_encode(array('success' => true, 'message' => 'Locations saved to google map successfully.'));
    wp_die();
}
add_action('wp_ajax_skr_save_location', 'skr_ajax_handler');

/* ================================================================== */

// Add the metabox
function skr_add_owner_metabox() {
    add_meta_box(
        'owner_metabox',
        'Select the Owner',
        'skr_render_owner_metabox',
        'service_location',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'skr_add_owner_metabox');

// Render the metabox content
function skr_render_owner_metabox($post) {
    // Get the list of "Owners"
    $owners = get_posts(array(
        'post_type' => 'owners',
        'posts_per_page' => -1,
    ));

    // Get the selected owner ID
    $selected_owner_id = get_post_meta($post->ID, 'owner_id', true);
    // Display the dropdown select field
    ?>
    <label for="owner_id">Select Owner for this location:</label>
    <select name="owner_id" id="owner_id">
        <option value="">- Select Owner -</option>
        <?php foreach ($owners as $owner) : ?>
            <option value="<?php echo esc_attr($owner->ID); ?>" <?php selected($owner->ID, $selected_owner_id); ?>>
                <?php echo esc_html($owner->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <style>
        #owner-image img{
            max-width: 100%;
            margin-top: 5px;
        }
    </style>
    <!-- Placeholder for owner's image -->
    <div id="owner-image"></div>
    <!-- Placeholder for owner's phone number -->
    <div id="owner-phone"></div>
    <!-- Placeholder for owner's email address -->
    <div id="owner-email"></div>

    <script>
        jQuery(document).ready(function($) {
            $('#owner_id').change(function() {
                var ownerID = $(this).val();
                $.ajax({
                    url: ajaxurl, // WordPress AJAX URL
                    type: 'POST',
                    data: {
                        action: 'get_owner_data',
                        owner_id: ownerID
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#owner-image').html('<img src="' + data.image_url + '">');
                        $('#owner-phone').text('Phone: ' + data.phone);
                        $('#owner-email').text('Email: ' + data.email);
                    }
                });
            });

            // Trigger change event on page load
            $('#owner_id').trigger('change');
        });
    </script>
    <?php
}
// Ajax handler for fetching owner data
function skr_get_owner_data() {
    $owner_id = $_POST['owner_id'];

    $owner_image = get_field('upload_owner_image', $owner_id);
    $owner_phone = get_field('phone_number', $owner_id);
    $owner_email = get_field('email_address', $owner_id);

    $response = array(
        'image_url' => $owner_image['url'],
        'phone' => $owner_phone,
        'email' => $owner_email
    );

    echo json_encode($response);
    wp_die();
}
add_action('wp_ajax_get_owner_data', 'skr_get_owner_data');
// Save the metabox data// Save the metabox data
function skr_save_owner_metabox($post_id) {
   
    // Save owner ID
    if (isset($_POST['owner_id'])) {
        update_post_meta($post_id, 'owner_id', sanitize_text_field($_POST['owner_id']));
    }else{
        update_post_meta($post_id, 'owner_id', 33);
    }
}
add_action('save_post', 'skr_save_owner_metabox');


/* =====================================================================
Remove 'owners' from Owners URL 
 */
/*
// Add custom rewrite rules
function custom_rewrite_rules_for_owners() {
    add_rewrite_rule(
        '^([^/]+)/?$',
        'index.php?owners=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules_for_owners', 10, 0);

// Modify the permalink structure for owners post type
function custom_post_type_permalink($permalink, $post) {
    // Skip other post types
    if ($post->post_type !== 'owners' || $post->post_type !== 'pages') {
        return $permalink;
    }

    // Generate custom permalink
    return home_url('/' . $post->post_name . '/');
}
add_filter('post_type_link', 'custom_post_type_permalink', 10, 2);

// Flush rewrite rules on activation
function flush_rewrite_rules_on_activation() {
    custom_rewrite_rules_for_owners();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');

// Flush rewrite rules on deactivation
function flush_rewrite_rules_on_deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'flush_rewrite_rules_on_deactivation');
*/

