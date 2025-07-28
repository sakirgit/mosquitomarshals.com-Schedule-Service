<?php


/**
 * by none Logged in user
 *
 * @param [type] $email
 * @return void
 */

function reclaim_your_house_mail($name, $email, $phone, $zip, $reciever)
{
	
	$to = $reciever;
	//$to = 'carlosandig87@gmail.com';
	$subject = '[Mosquito Marshals] Customer Information Request';
	
	$body ='<table  style="width: 73%;border: 1px solid #756767;border-collapse: collapse;">';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$name.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Email:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$email.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Phone:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$phone.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Zip:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$zip.'</td></tr>';
	$body .= '</table>';
	
 

  $headers = array(
    'Content-Type: text/html; charset=UTF-8'
  );
  $return = wp_mail($to, $subject, $body, $headers);

}


function default_pestjs_mail($defualt, $fname, $lastname, $email, $phone, $zip, $reciever)
{

	$to = $reciever;
	//$to = 'carlosandig87@gmail.com';
	$subject = '[Mosquito Marshals] Customer Information Request';
	
	$body ='<table  style="width: 73%;border: 1px solid #756767;border-collapse: collapse;">';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">First Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$fname.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Last Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$lastname.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Email:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$email.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Phone:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$phone.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Zip:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$zip.'</td></tr>';
	$body .= '</table>';
	
 

  $headers = array(
    'Content-Type: text/html; charset=UTF-8'
  );
  $return = wp_mail($to, $subject, $body, $headers);
}


function reclaim_your_house_mail2($fname, $lastname, $email, $phone, $zip, $reciever)
{

	$to = $reciever;
	//$to = 'carlosandig87@gmail.com';
	$subject = '[Mosquito Marshals] Customer Information Request';
	
	$body ='<table  style="width: 73%;border: 1px solid #756767;border-collapse: collapse;">';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">First Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$fname.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Last Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$lastname.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Email:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$email.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Phone:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$phone.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Zip:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$zip.'</td></tr>';
	$body .= '</table>';
	
 

  $headers = array(
    'Content-Type: text/html; charset=UTF-8'
  );
  $return = wp_mail($to, $subject, $body, $headers);
}

function wpno_ct_updated() {
	
	
	if(isset($_POST['email'])) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			
			if(!empty($_POST['zipcode'])) {
				global $wpdb, $table_prefix;
				$cproduct = $wpdb->get_results("
					SELECT DISTINCT A.*
						FROM ".$table_prefix."posts AS A
						INNER JOIN ".$table_prefix."postmeta AS E
							ON E.post_id = A.ID	
						WHERE   A.post_status = 'publish' AND 
								A.post_type = 'service_location' AND
								E.meta_key = 'zip_code_service' AND E.meta_value LIKE '%".$_POST['zipcode']."%' ORDER BY E.meta_value ASC LIMIT 1
				");
				if( $cproduct ){
					
					foreach($cproduct as $pinoy) {
						reclaim_your_house_mail($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['zipcode'], get_post_meta($pinoy->ID, 'email_address_services', true));
					}
					
					$response['status'] = 1;
					$response['error_zip'] = 1;
					$response['errored_zip'] = 1;
					$response['message'] = '“Thank you for contacting us, a Marshal will be in touch as soon as possible.” ';
					$response['zipmessage'] = '';
					
				} else {
					reclaim_your_house_mail($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['zipcode'],  get_option( 'admin_email' ));
					
					$response['status'] = 1;
					$response['error_zip'] = 1;
					$response['message'] = 'Successfully Sent';
					$response['errored_zip'] = 2;
					$response['zipmessage'] = '“Unfortunately the Marshals are not serving this location at this time. Interested in becoming a Marshal? Check out our Franchise Opportunities <a href="'.get_bloginfo('url').'/franchise-opportunities/">link.</a> page for more information”';
				}
				
			} else {
				$response['status'] = 0;
				$response['message'] = 'Zip Code required';
			}
			
		} else {
			$response['message'] = 'Failed to send';
			$response['status'] = 0;
		}
		
	} else {
		$response['message'] = 'Failed to send';
		$response['status'] = 0;
	}
	
	
	
	echo json_encode($response);
}	


add_action( 'rest_api_init', function () {
  register_rest_route( 'xinfox/v1', '/send', array(
    'methods' => 'POST',
    'callback' => 'wpno_ct_updated',
	 'show_in_index' => false,
  ) );
} );



add_shortcode( 'wp_ct_form', 'wp_ct_form_func' );
function wp_ct_form_func( $atts ) {
    $atts = shortcode_atts( array(
        'type' => 'infographics'
    ), $atts, 'wp_ct_form' );
	
	$html = '';
	
	if(!is_admin()){
			
		$html .= '<div class="register-form">';
		$html .= '<div id="message"></div>';
		$html .= '<div id="form-container-custome" >';
		$html .= '<div class="form-group" >';
		$html .= '<input type="text" id="ct_none_fname" placeholder="Full Name">';
		$html .= '</div>';
		$html .= '<div class="form-group">';
		$html .= '<input type="email"  id="ct_none_email" placeholder="Email Address">';
		$html .= '</div>';
		$html .= '<div class="form-group">';
		$html .= '<input type="text"  id="ct_none_phone" placeholder="Phone Number">';
		$html .= '</div>';
		$html .= '<div class="form-group">';
		$html .= '<input type="text"  id="ct_none_zip" placeholder="Zip Code">';
		$html .= '</div>';
		$html .= '<div class="row-form" >';
		$html .= '<div class="form-group form-state" style="width: 100%;">';
		$html .= '<p id="text-warning"></p>	';		
		$html .= '<button type="submit" class="btn btn-default non-loggeds" id="noneUserButton" onclick="customSent()">Submit</button>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		
	}

	return 	$html;
	
 }
 
 function wpno_ct_updated2() {
	
	
	if(isset($_POST['email'])) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			
			if(!empty($_POST['zipcode'])) {
				global $wpdb, $table_prefix;
				$cproduct = $wpdb->get_results("
					SELECT DISTINCT A.*
						FROM ".$table_prefix."posts AS A
						INNER JOIN ".$table_prefix."postmeta AS E
							ON E.post_id = A.ID	
						WHERE   A.post_status = 'publish' AND 
								A.post_type = 'service_location' AND
								E.meta_key = 'zip_code_service' AND E.meta_value LIKE '%".$_POST['zipcode']."%' ORDER BY E.meta_value ASC LIMIT 1
				");
				if( $cproduct ){
					
					foreach($cproduct as $pinoy) {
						reclaim_your_house_mail2($_POST['fname'], $_POST['lname'],  $_POST['email'], $_POST['phone'], $_POST['zipcode'], get_post_meta($pinoy->ID, 'email_address_services', true));
					}
					
					$response['status'] = 1;
					$response['error_zip'] = 1;
					$response['message'] = '“Thank you for contacting us, a Marshal will be in touch as soon as possible.” ';
					$response['errored_zip'] = 1;
					
				} else {
					reclaim_your_house_mail2($_POST['fname'], $_POST['lname'],  $_POST['email'], $_POST['phone'], $_POST['zipcode'], get_option( 'admin_email' ));
					
					$response['status'] = 1;
					$response['error_zip'] = 1;
					$response['message'] = 'Your form has been successfully submitted';
					$response['errored_zip'] = 2;
					$response['zipmessage'] = '“Unfortunately the Marshals are not serving this location at this time. Interested in becoming a Marshal? Check out our Franchise Opportunities <a href="'.get_bloginfo('url').'/franchise-opportunities/">link.</a> page for more information”';
				}
				
			} else {
				$response['status'] = 0;
				$response['message'] = 'Zip Code required';
			}
			
		} else {
			$response['message'] = 'Failed to send';
			$response['status'] = 0;
		}
		
	} else {
		$response['message'] = 'Failed to send';
		$response['status'] = 0;
	}
	
	
	
	echo json_encode($response);
}	


add_action( 'rest_api_init', function () {
  register_rest_route( 'xinfox/v1', '/sendx', array(
    'methods' => 'POST',
    'callback' => 'wpno_ct_updated2',
	 'show_in_index' => false,
  ) );
} );