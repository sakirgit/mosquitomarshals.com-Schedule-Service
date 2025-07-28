<?php
/**
 * Plugin Name:       Contact Form Johnnie
 * Plugin URI:        https://pestmarshals.com
 * Description:       Pestmarshals site customization |||
 * Version:           0.1.0
 * Requires at least: 4.9
 * Requires PHP:      7.3
 * Author:            Johnnie O'Dell
 * Author URI:        https://pestmarshals.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pestmarshals
 * Domain Path:       /languages
 *
 * @package           Pestmarshals_custom
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Useful global constants.
define( 'JOHNNIE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'JOHNNIE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'JOHNNIE_PLUGIN_INC', JOHNNIE_PLUGIN_PATH . 'includes/' );
define( 'JOHNNIE_TEMPLATES', JOHNNIE_PLUGIN_PATH . 'template/' );

// Include files.
require_once JOHNNIE_PLUGIN_INC . 'pest_contactform.php';
require_once JOHNNIE_PLUGIN_INC . 'pest_zipcode-price.php';
require_once JOHNNIE_PLUGIN_INC . 'pest-location-service.php';
require_once JOHNNIE_PLUGIN_INC . 'pest-rest-api.php';
require_once JOHNNIE_PLUGIN_INC . 'class-marshall-controller.php';
require_once JOHNNIE_PLUGIN_INC . 'shortcode-funct.php';

require_once JOHNNIE_PLUGIN_PATH . 'map-location/map-location.php';

/* 
 * ==== ACTION: ENQUEUE STYLES AND SCRIPTS FRONTEND ====
*/


add_action('wp_enqueue_scripts', function(){
	$url = JOHNNIE_PLUGIN_URL;
    $dir = JOHNNIE_PLUGIN_PATH;
	
	 if(is_page('schedule-services')) {
		
		wp_enqueue_style('service-peststyle', $url.'css/service.css');
		wp_register_script('kzipscripts', $url.'js/pestjh.js', ['jquery'],  true );
		wp_enqueue_script('kzipscripts' );
		
	 }
	 
	 wp_register_script('location_js', $url.'js/location.js', ['jquery'],  true );
	 wp_enqueue_script('location_js' );
	 wp_localize_script('location_js', 'lz', [ 
        'ajax'=>admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'locationzip-yankee-nonce' ),
        'lc' => 'locationzip_posting',
    ]);
	
	wp_localize_script('location_js', 'dz', [ 
        'ajax'=>admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'reclaim-yankee-nonce' ),
        'dc' => 'reclaimyard_posting',
    ]);
	 

//	wp_mail( $to, $subject, $body, $headers );
	
	
});

$to = 'james@mosquitomarshals.com';
$subject = 'Email subject Test Subject 454244332';
$body = 'Email body content Test Message 44444';
$headers = array('Content-Type: text/html; charset=UTF-8');

//mail($to, $subject, $body);

/* 
 * ==== ACTION: ENQUEUE STYLES AND SCRIPTS  ====
*/
add_action( 'admin_enqueue_scripts', function() {
    $url = JOHNNIE_PLUGIN_URL;
    $dir = JOHNNIE_PLUGIN_PATH;
	
	if(isset($_GET['page'])) {
	if($_GET['page'] == 'location-settins-001') {
	wp_enqueue_style('settings-carlo-ariel', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
	}
	}
    wp_enqueue_style('admin-peststyle', $url.'css/style.css');
	
  
	
    wp_register_script('zipscripts', $url.'js/pest.js', ['jquery'],  true );
    wp_enqueue_script('zipscripts' );
	
	wp_localize_script('zipscripts', 'ps', [ 
        'ajax'=>admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'zipcode-pest-posting-nonce' ),
        'pe' => 'zipcode_update_posting',
    ]);
	
	wp_localize_script('zipscripts', 'dp', [ 
        'ajax'=>admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'zipcode-pest-del-nonce' ),
        'de' => 'zipcode_delete_posting',
    ]);
	wp_localize_script('zipscripts', 'du', [ 
        'ajax'=>admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'zipcode-pest-upadd-nonce' ),
        'dl' => 'zipcode_upadd_posting',
    ]);
	
	
	wp_localize_script('zipscripts', 'sp', [ 
        'ajax'=>admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'settings-locationjs-nonce' ),
        'sv' => 'settings_locationjs_posting',
    ]);
	
    
});

/*
* 
 * ==== ACTION: SETTINGS AJAX SUBMISSION    ====
*/
add_action('wp_ajax_settings_locationjs_posting', 'settings_locationjs_posting' );
add_action('wp_ajax_nopriv_settings_locationjs_posting', 'settings_locationjs_posting' );

function settings_locationjs_posting(){
	$r = $_REQUEST;
	if ( ! wp_verify_nonce( $r['nonce'], 'settings-locationjs-nonce') ) {
        echo json_encode(['status'=>'error', 'message'=>'something wrong', 'n'=>'invalid']); 
        wp_die();
    }
	
	 if (!get_option("subject_custom_js")) {
		 add_option( 'subject_custom_js', $r['subject'], '', 'yes' );
	 }
	
	 if (!get_option("email_custom_js")) {
		 add_option( 'email_custom_js', $r['emailaddreee'], '', 'yes' );
	 }
	 
	 if (!get_option("message_error_js")) {
		 add_option( 'message_error_js', $r['message_error'], '', 'yes' );
	 }
	 
	 if (!get_option("message_success_js")) {
		 add_option( 'message_success_js', $r['message_success'], '', 'yes' );
	 }
	 
	update_option("subject_custom_js", $r['subject']);
	update_option("email_custom_js", $r['emailaddreee']);
	update_option("message_error_js", $r['message_error']);
	update_option("message_success_js", $r['message_success']);
	
	 echo json_encode(['status'=>'success', 'message'=> 'Successfully Save settings', 'n'=>'valid']);
	  wp_die();
	
}



/* 
 * ==== ACTION: DEFAULT LOCATION FORM AJAX SUBMISSION    ====
*/
add_action('wp_ajax_reclaimyard_posting', 'reclaimyard_posting' );
add_action('wp_ajax_nopriv_reclaimyard_posting', 'reclaimyard_posting' );

function reclaimyard_posting(){
	global $wpdb, $table_prefix;
	$r = $_REQUEST;
	$error_custom = ( get_option("message_error_js") ) ? get_option("message_error_js"):'something wrong';
    if ( ! wp_verify_nonce( $r['nonce'], 'reclaim-yankee-nonce') ) {
        echo json_encode(['status'=>'error', 'message'=> $error_custom, 'n'=>'invalid']); 
        wp_die();
    }
	
	$subject = (get_option("subject_custom_js")) ? get_option("subject_custom_js"): 'From '.get_option("blogname");
	$email = ( get_option("email_custom_js") ) ? get_option("email_custom_js"):get_option( 'admin_email' );
	
	$message =  (get_option("message_success_js")) ? get_option("message_success_js"):'Thank you for contacting us, a Marshal will be in touch as soon as possible.';
	default_pestjs_mail($subject, $r['ct3_none_fname'], $r['ct3_none_lname'],  $r['ct3_none_email'], $r['ct3_none_phone'], $r['ct3_none_zip'], $email);
	
	echo json_encode(['status'=>'success', 'message'=> $message, 'n'=>'valid']); 
	wp_die();
	
	
}

/* 
 * ==== ACTION: LOCATION FORM AJAX SUBMISSION    ====
*/
add_action('wp_ajax_locationzip_posting', 'locationzip_posting' );
add_action('wp_ajax_nopriv_locationzip_posting', 'locationzip_posting' );

function locationzip_posting(){
	global $wpdb, $table_prefix;
	$r = $_REQUEST;
    if ( ! wp_verify_nonce( $r['nonce'], 'locationzip-yankee-nonce') ) {
        echo json_encode(['status'=>'error', 'message'=>'something wrong', 'n'=>'invalid']); 
        wp_die();
    }
	
	if(isset($r['ct3_none_email'])) {
		if (filter_var($r['ct3_none_email'], FILTER_VALIDATE_EMAIL)) {
			if(!empty($r['ct3_none_zip'])) {
				global $wpdb, $table_prefix;
				$cproduct = $wpdb->get_results("
					SELECT DISTINCT A.*
						FROM ".$table_prefix."posts AS A
						INNER JOIN ".$table_prefix."postmeta AS E
							ON E.post_id = A.ID	
						WHERE   A.post_status = 'publish' AND 
								A.post_type = 'service_location' AND
								E.meta_key = 'zip_code_service' AND E.meta_value LIKE '%".$r['ct3_none_zip']."%' ORDER BY E.meta_value ASC LIMIT 1
				");
				if( $cproduct ){
					
					foreach($cproduct as $pinoy) {
						reclaim_your_house_mail2($r['ct3_none_fname'], $r['ct3_none_lname'],  $r['ct3_none_email'], $r['ct3_none_phone'], $r['ct3_none_zip'], get_post_meta($pinoy->ID, 'email_address_services', true));
					}
					$message = 'Thank you for contacting us, a Marshal will be in touch as soon as possible.';
					 echo json_encode(['status'=>'success', 'message'=> $message, 'n'=>'valid']); 
					 wp_die();
					
				} else {
					reclaim_your_house_mail2($r['ct3_none_fname'], $r['ct3_none_lname'],  $r['ct3_none_email'], $r['ct3_none_phone'], $r['ct3_none_zip'], get_option( 'admin_email' ));
					$message = 'Unfortunately the Marshals are not serving this location at this time. Interested in becoming a Marshal? Check out our Franchise Opportunities <a href="'.get_bloginfo('url').'/franchise-opportunities/">link.</a> page for more information';
					 echo json_encode(['status'=>'success', 'message'=> $message, 'n'=>'valid']); 
					 wp_die();
					
				}
				
			} 
			
		}
	}
	 echo json_encode(['status'=>'error', 'message'=>'something wrong', 'n'=>'invalid']); 
     wp_die();
		
	
	
}

/* 
 * ==== ACTION: GENERATE CUSTOM TITLE    ====
*/

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//usage 


/* 
 * ==== ACTION: UPDATE AJAX SUBMISSION    ====
*/
add_action('wp_ajax_zipcode_upadd_posting', 'zipcode_upadd_posting' );
add_action('wp_ajax_nopriv_zipcode_upadd_posting', 'zipcode_upadd_posting' );
function zipcode_upadd_posting() {
	global $wpdb, $table_prefix;
	$r = $_REQUEST;
    if ( ! wp_verify_nonce( $r['nonce'], 'zipcode-pest-upadd-nonce') ) {
        echo json_encode(['status'=>'error', 'message'=>'something wrong', 'n'=>'invalid']); 
        wp_die();
    }
	
	/*
	$jf = wp_update_post(array(
	'ID'        =>  $r['idpriceZip'],
	'post_title'  => wp_strip_all_tags($r['zipcodepest'])
	));
	
	*/	
	update_post_meta( $r['idpriceZip'], 'price_pestzipcode', $r['pricepest']);	
	update_post_meta( $r['idpriceZip'], 'service_id', $r['serviceUpdate']);	
	
	if($jf){
		$message = 'Updated';
		 echo json_encode(['status'=>'success', 'message'=> $message,  'n'=>'valid']); 
		 wp_die();	
	}
	
	$message = 'failed';
	 echo json_encode(['status'=>'success', 'message'=> $message, 'n'=>'valid']); 
	 wp_die();	
	
}

/* 
 * ==== ACTION: DELETE AJAX SUBMISSION    ====
*/
add_action('wp_ajax_zipcode_delete_posting', 'zipcode_delete_posting' );
add_action('wp_ajax_nopriv_zipcode_delete_posting', 'zipcode_delete_posting' );
function zipcode_delete_posting() {
	global $wpdb, $table_prefix;
	$r = $_REQUEST;
    if ( ! wp_verify_nonce( $r['nonce'], 'zipcode-pest-del-nonce') ) {
        echo json_encode(['status'=>'error', 'message'=>'something wrong', 'n'=>'invalid']); 
        wp_die();
    }
	
	$gh = wp_delete_post($r['idpriceZip']);
	
	if($gh){
		$message = $r['zipcodepest']. ' has been deleted';
		 echo json_encode(['status'=>'success', 'message'=> $message, 'z'=>$n, 'n'=>'valid']); 
		 wp_die();	
	}
	$message = $r['zipcodepest']. ' has not been deleted';
	 echo json_encode(['status'=>'success', 'message'=> $message, 'z'=>$n, 'n'=>'valid']); 
	 wp_die();	
	
	
}	

/* 
 * ==== ACTION: ADD AJAX SUBMISSION    ====
*/
add_action('wp_ajax_zipcode_update_posting', 'zipcode_update_posting' );
add_action('wp_ajax_nopriv_zipcode_update_posting', 'zipcode_update_posting' );
function zipcode_update_posting() {
	global $wpdb, $table_prefix;
	$r = $_REQUEST;
    if ( ! wp_verify_nonce( $r['nonce'], 'zipcode-pest-posting-nonce') ) {
        echo json_encode(['status'=>'error', 'message'=>'something wrong', 'n'=>'invalid']); 
        wp_die();
    }
	

	//$found_post = $wpdb->get_row("SELECT * FROM ".$table_prefix."posts WHERE post_title = '".wp_strip_all_tags($r['zipcode'])."' AND `post_type` = 'cp_zipcode'"); 
	$myRandomString = generateRandomString(5);
	//if($found_post == false) {}
	$zip_id =  wp_insert_post( array(
	'post_title'        => wp_strip_all_tags($myRandomString),
	'post_type'         => 'cp_zipcode',
	 'post_status'       => 'publish',
	 'post_parent'       => $r['idpriceZip'],
	 'comment_status'    => 'closed',
	 'ping_status'       => 'closed',
	));
	$n = $zip_id;
	
	$gh1 = $zip_id;
	if($r['price']  != false) {
		 add_post_meta( $gh1, 'price_pestzipcode', $r['price'], true);
	}
	
	if($r['serviceType']  != false) {
		 add_post_meta( $gh1, 'service_id', $r['serviceType'], true);
	}
		
		
	$message = 'Successfully Added';
	 echo json_encode(['status'=>'success', 'message'=> $message, 'z'=>$r['serviceType'], 'n'=>'valid']); 
     wp_die();
		
	
	/*
	$message = 'Zipcode already exist '.$r['zipcode'];
	 echo json_encode(['status'=>'success', 'message'=> $message, 'z'=>$r['serviceType'], 'n'=>'valid']); 
     wp_die();	
	*/
	
}








 
/*
function custom_owners_rewrite_rules() {
    add_rewrite_rule(
        '^([^/]+)/?$',
        'index.php?owners=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_owners_rewrite_rules');

function custom_owners_post_link($post_link, $post) {
    if ('owners' === $post->post_type) {
        $post_link = home_url('/' . $post->post_name . '/');
    }
    return $post_link;
}
add_filter('post_type_link', 'custom_owners_post_link', 10, 2);

function flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules_on_activation');
*/


