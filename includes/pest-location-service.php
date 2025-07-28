<?php


function jals_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'pestmarshals_person';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		ip tinytext NOT NULL,
		email_address tinytext NOT NULL,
		first_name tinytext NOT NULL,
		last_name tinytext NOT NULL,
		phone tinytext NOT NULL,
		zipcode tinytext NOT NULL,
		CustomerID tinytext NOT NULL,
		PestRoutesCustomerID tinytext NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'jals_install' );


add_action( 'init', 'create_wp_location_service_type' );
function create_wp_location_service_type() {
  register_post_type( 'service_location',
    array(
      'labels' => array(
        'name' => __( 'Service Location' ),
        'singular_name' => __( 'Service Location' )
      ),
      'public' => false,
	  'show_ui' => true,
	  'show_in_nav_menus' => true,
	  'meta_box_cb' => null,
      'has_archive' => false,
      'rewrite' => array('slug' => 'service-location'),
	  'supports' => array( 'title', 'author')
    )
  );
}

function wpdocs_posts_thumb_columns( $columns ) {
	 $post_type = get_post_type();
		$post_new_columns = array(
			   'zipcode_info' => esc_html__( 'Zip Code', 'text_domain' ),			   
			);
			return array_merge( $columns, $post_new_columns );
	
}
add_filter( 'manage_service_location_posts_columns', 'wpdocs_posts_thumb_columns', 10 );
 
function wpdocs_posts_custom_columns( $column_name, $id ) {
	 if ( 'zipcode_info' === $column_name ) {
		$quiz_ans = get_post_meta(get_the_ID(), 'zip_code_service', true);
		
		if($quiz_ans){
			echo $quiz_ans;
		} else {
			echo '&#8212;';
		}
		
    }
	
}

add_action( 'manage_service_location_posts_custom_column', 'wpdocs_posts_custom_columns', 10, 2 );

add_action( 'init', 'create_wp_location_service_need' );
function create_wp_location_service_need() {
  register_post_type( 'service_type',
    array(
      'labels' => array(
        'name' => __( 'Service Type' ),
        'singular_name' => __( 'Service Type' )
      ),
      'public' => false,
	  'show_ui' => true,
	  'show_in_nav_menus' => true,
	  'meta_box_cb' => null,
      'has_archive' => false,
      'rewrite' => array('slug' => 'service-type'),
	  'supports' => array( 'title', 'author')
    )
  );
}
?>
