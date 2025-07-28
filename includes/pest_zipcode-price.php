<?php

function cron_pest_customer_delete_6ecf7d69() {
    // do stuff
	 global $wpdb, $table_prefix;
	 
	$ky = $wpdb->get_results("SELECT * FROM ".$table_prefix."pestmarshals_person ORDER BY id ASC"); 
	
	 foreach($ky as $vt) {
		$table_name = $wpdb->prefix . 'pestmarshals_person';
			$delete = $wpdb->delete( 
					$table_name, 
					array( 
						'id' =>$vt->id
					),
					array('%s') 
				);
	 }		
}

add_action( 'pest_customer_delete', 'cron_pest_customer_delete_6ecf7d69', 10, 0 );



add_action( 'admin_menu', 'price_zipcode_funct' );

function price_zipcode_funct() {
	add_meta_box( 'price_zipcode_meta', 'Add Service Type', 'price_zip_pest', 'service_location', 'side', 'high' );
}

function price_zip_pest( $post ){
	
	require_once JOHNNIE_TEMPLATES . 'form_zip.php';
}

add_action( 'admin_menu', 'update_zipcode_funct' );

function update_zipcode_funct() {
	add_meta_box( 'update_zipcode_meta', 'Service Type', 'update_zip_pest', 'service_location', 'normal', 'high' );
}

function update_zip_pest( $post ){
	
	require_once JOHNNIE_TEMPLATES . 'form_update.php';
}

add_action( 'admin_menu', function(){
	add_menu_page( 'Schedule Service', 'Person', 'manage_options', 'schedule_servicejs', 'my_service_content_page', 'dashicons-welcome-widgets-menus', 90 );
	add_submenu_page( 'schedule_servicejs', 'Settings', 'Settings', 'manage_options', 'location-settins-001', 'location_settings_001');
});


function my_service_content_page() {
   	require_once JOHNNIE_TEMPLATES . 'list-person-pest.php';
}

function location_settings_001(){
	 	require_once JOHNNIE_TEMPLATES . 'settings-form.php';
}
