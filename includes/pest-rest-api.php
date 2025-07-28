<?php


function getperson() {
	
	if(isset($_POST['zipcode'])) {
			$var1 = $_POST['fname'];
			$var2 = $_POST['lname'];
			$var3 = $_POST['email'];
			$var4 = $_POST['phone'];
			$var5 = $_POST['zipcode'];
			$var6 = $_POST['street'];
			$var7 = $_POST['city'];
			$var8 = $_POST['state'];
			$var8 = $_POST['state'];
			
			/*
			global $wpdb, $table_prefix;
			$cproduct = $wpdb->get_row("
				SELECT A.*
					FROM ".$table_prefix."pestmarshals_person 
					WHERE   id = 'publish' 
			");
			*/
			
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				
				
				
				global $wpdb, $table_prefix;
				$table_name = $wpdb->prefix . 'pestmarshals_person';
				$add_info = $wpdb->insert( 
						$table_name, 
						array( 
							'ip' => $_SERVER['REMOTE_ADDR'],
							'email_address' => $_POST['email'],
							'first_name' => $_POST['fname'],
							'last_name' => $_POST['lname'],
							'zipcode' => $_POST['zipcode'],
							'phone' => $_POST['phone'],
							'CustomerID' => 'mosquitomarshals-',
							'time' => current_time( 'mysql' )
						),
						array('%s','%s','%s','%s','%s','%s','%s') 
					);
					
					if( $add_info ){
						$response['test'] = 1;
						$response['customer'] = 'mosquitomarshals-'.$wpdb->insert_id;
						$response['pestid'] = $wpdb->insert_id;
						echo json_encode($response);
						
					}
			}
			
	}	
	
}

	

add_action( 'rest_api_init', function () {
  register_rest_route( 'pestmarhsal/v1', '/person', array(
    'methods' => 'POST',
    'callback' => 'getperson',
	 'show_in_index' => false,
  ) );
} );	

function servicepest() {
	
	if(isset($_POST['zipcode'])) {
		$var1 = $_POST['fname'];
		$var2 = $_POST['lname'];
		$var3 = $_POST['email'];
		$var4 = $_POST['phone'];
		$var5 = $_POST['zipcode'];
		$var6 = $_POST['street'];
		$var7 = $_POST['city'];
		$var8 = $_POST['state'];
		
		
		
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			
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
					
					
						/* ========= For service type data ========= */
						/* ========= For service type data ========= */
						$authenticationkey = get_post_meta($cproduct[0]->ID, 'authenticationkey', true);
						$authenticationtoken = get_post_meta($cproduct[0]->ID, 'authenticationtoken', true);
						$office_id = get_post_meta($cproduct[0]->ID, 'office_id', true);
						
						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://mosquitomarshals.pestroutes.com/api/serviceType/search',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS =>'{
							 "includeData":1
						}',
						  CURLOPT_HTTPHEADER => array(
							 'Content-Type: application/json',
							 'authenticationKey: ' . $authenticationkey,
							 'authenticationToken: ' . $authenticationtoken,
						  ),
						));

						$service_types_data = curl_exec($curl);

						curl_close($curl);
						/* ========= For service type data ========= */
						/* ========= For service type data ========= */
						
						 $service_types_data = json_decode( $service_types_data);
						 $service_types = $service_types_data->serviceTypes;
					
					
						foreach($cproduct as $pinoy) {
							
							
							
							/* ============ Service types HTML inputs ============ */
							/* ============ Service types HTML inputs ============ */

								if( $service_types ) {
									foreach($service_types as $serviced){
										if( $serviced->officeID  == $office_id && $serviced->visible  == 1 ){
												
											$serid = $serviced->typeID;
											
											$custom_price = $serviced->defaultInitialCharge;
											
											if( $custom_price != null || $custom_price != "" ){
													
												$service_types_inputs[] = array(
													'product' => '<div class="item-type"><div class="row-items-1"><div id="service-select"><input name="package" type="radio" value="'.$serid.'"></div></div>',
													'description' => '<div class="row-items-2"><div id="service-description"><b>'
													.$custom_price 
													. '</b> ' . $serviced->description 
											//		. ', Cat:' . $serviced->category 
													. '</div></div></div> ',
												);		
											}	
										}
									}
									
								} else {
									$service_types_inputs['status'] = 'error';
								}
								
							/* ============ Service types HTML inputs ============ */
							/* ============ Service types HTML inputs ============ */
							
							
							
							$owner_email = get_field('email_address', get_post_meta($pinoy->ID, 'owner_id', true));
							
							
							$response[] = array(
								'slid' => $pinoy->ID,
								'title' => $pinoy->post_title,
								'address' => get_post_meta($pinoy->ID, 'address_service', true),
								'zip' => get_post_meta($pinoy->ID, 'zip_code_service', true),
							//	'email' => get_post_meta($pinoy->ID, 'email_address_services', true),
								'email' => $owner_email,
								'phone' => get_post_meta($pinoy->ID, 'phone_number_service', true),
								'officeid' => get_post_meta($pinoy->ID, 'office_id', true),
								'customer_zip' => $_POST['zipcode'],
								'service_types_data' => $service_types_inputs
							//	'authenticationkey' => get_post_meta($pinoy->ID, 'authenticationkey', true),
							//	'authenticationtoken' => get_post_meta($pinoy->ID, 'authenticationtoken', true)
							);
						}
					
				} else {
					$response['verify'] = '0';
					$response['message'] = 'Can find Zip Code';
				}
				
				
		} else {
			$response['verify'] = '0';
			$response['message'] = 'Email Address is not valid';
		}
	//	$response['customer_zip'] = $_POST['zipcode'];
		echo json_encode($response);
		
	}
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'pestmarhsal/v1', '/create', array(
    'methods' => 'POST',
    'callback' => 'servicepest',
	 'show_in_index' => false,
  ) );
} );


function get_service_location_by_office_id($office_id) {
    // Set up WP_Query arguments
    $args = array(
        'post_type'  => 'service_location', // Replace with your actual post type
        'meta_query' => array(
            array(
                'key'     => 'office_id',
                'value'   => $office_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1 // Limit to one post
    );

    // Run the query
    $query = new WP_Query($args);

    // Check if we have results
    if ($query->have_posts()) {
        $query->the_post(); // Set up the post data

        // Get the values of the custom fields
        $authenticationkey = get_field('authenticationkey');
        $authenticationtoken = get_field('authenticationtoken');

        // Reset post data
        wp_reset_postdata();

        // Return the data
        return array(
            'post_id' => get_the_ID(),
            'authenticationkey' => $authenticationkey,
            'authenticationtoken' => $authenticationtoken
        );
    } else {
        // Return null if no post found
        return null;
    }
}


function serviceproduct() {
	global $wpdb, $table_prefix;
		
		$service = $wpdb->get_results("
			SELECT A.*
				FROM ".$table_prefix."posts AS A
				WHERE   A.post_status = 'publish' AND 
						A.post_type = 'cp_zipcode' AND A.post_parent = '".$_POST['locationid']."' ORDER BY A.ID DESC
		");
		
		if( $service ) {
			foreach($service as $serviced){
				$serid = get_post_meta($serviced->ID, 'service_id', true);
				
				$custom_price = get_post_meta($serviced->ID, 'price_pestzipcode', true);
				$gh = str_replace("%price%", $custom_price, get_post_meta($serid, 'description_service', true)); 
				$service_title = get_the_title($serid); 
				$service_price = get_post_meta($serid, 'price_service', true);
				
				$response[] = array(
					'product' => '<label class="item-type"><div class="row-items-1"><div id="service-select" style="float: left;margin-right: 19px;"><input name="package" type="radio" value="$'.$service_price.' | ' . $service_title . '"></div></label>',
					'description' => '<div class="row-items-2"><div id="service-description">'.$gh.'</div></div></div>',
				);			
				
			}
			
		} else {
			$response['status'] = 'error';
		}
		echo json_encode($response);
		/*
		$cproduct = $wpdb->get_results("
			SELECT A.*
				FROM ".$table_prefix."posts AS A
				WHERE   A.post_status = 'publish' AND 
						A.post_type = 'service_type'  ORDER BY A.post_title ASC
		");
		
		foreach($cproduct as $pinoy) {
			$response[] = array(
				'product' => '<div class="item-type"><div class="row-items-1"><div id="service-select"><input name="package" type="radio" value="'.$pinoy->ID.'"></div></div>',
				'description' => '<div class="row-items-2"><div id="service-description">'.get_post_meta($pinoy->ID, 'description_service', true).'</div></div></div>',
			);
		}
		*/
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'pestmarhsal/v1', '/get', array(
    'methods' => 'POST',
    'callback' => 'serviceproduct',
	 'show_in_index' => false,
  ) );
} );

function serviceid() {
	
	if(isset($_POST['serviceid'])) {
		global $wpdb, $table_prefix;
		$cproduct = $wpdb->get_row("
			SELECT A.*
				FROM ".$table_prefix."posts AS A
				WHERE   A.post_status = 'publish' AND 
						A.post_type = 'cp_zipcode' AND A.ID = '".$_POST['serviceid']."' ORDER BY A.ID 
		");
		$serid = $_POST['serviceid'];
		
		$response['title'] = get_the_title($serid);
		$response['price'] = get_post_meta($_POST['serviceid'], 'price_pestzipcode', true);
		//$response['type'] = get_post_meta($cproduct->ID, 'servicetype', true);
		//$response['frequency'] = get_post_meta($cproduct->ID, 'frequency', true);
		/*
		$response['title'] = $cproduct->post_title;
		$response['price'] = get_post_meta($cproduct->ID, 'price_service', true);
		$response['type'] = get_post_meta($cproduct->ID, 'servicetype', true);
		$response['frequency'] = get_post_meta($cproduct->ID, 'frequency', true);
		*/
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipcode = $_POST['zipcode'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$sarea = $_POST['sarea'];
		$spemail = $_POST['spemail'];
		
		$pay_cardnumber = $_POST['pay_cardnumber'];
		$pay_expirationdate = $_POST['pay_expirationdate'];
		$pay_securitycode = $_POST['pay_securitycode'];
		$pay_promoCode = $_POST['pay_promoCode'];
		$pay_request_information = $_POST['pay_request_information'];
		
		if($_POST['email']) {
		$response['fname'] = $fname;
		$response['lname'] = $lname;
		$response['address'] = $address;
		$response['email'] = $email;
		$response['phone'] = $phone;
		$response['sarea'] = $sarea;
		$response['spemail'] = $spemail;
		
			service_email_notification($_POST['fname'],$_POST['lname'],$_POST['address'], $_POST['email'],$_POST['phone'], get_the_title($serid),$_POST['sprovider'],$_POST['sarea'],$_POST['spemail'],$_POST['spemail']);
			
			$service_location_data = get_service_location_by_office_id($_POST['officeID']);
			$authenticationkey = $service_location_data['authenticationkey'];
			$authenticationtoken = $service_location_data['authenticationtoken'];
			
		//	/*
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://mosquitomarshals.fieldroutes.com/api/customer/create',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "fname":"'. $fname . '",
				 "lname":"'. $lname . '",
				 "email":"'. $email . '",
				 "address":"'. $address . '",
				 "city":"'. $city . '",
				 "state":"'. $state . '",
				 "zip":"'. $zipcode . '",
				 "phone1":"'. $phone . '"
			}',
			  CURLOPT_HTTPHEADER => array(
				 'Content-Type: application/json',
				 'sec-fetch-mode: cors',
				 'sec-fetch-site: cross-site',
				 'sec-fetch-dest: empty',
				 'authenticationKey: ' . $authenticationkey,
				 'authenticationToken: ' . $authenticationtoken,
			  ),
			));

			$response['customer_fr_data'] =  curl_exec($curl);
				
			curl_close($curl);
				
				
				
				
								
				
				
			$customer_entry_data = json_decode($response['customer_fr_data']);
				
				
				
				
				
			/* ================ ============ ================ */
			/* ================ Subscription ================ */
			/* ================ ============ ================ */
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://mosquitomarshals.pestroutes.com/api/subscription/create',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "customerID":'. $customer_entry_data->result . ',
				 "serviceID":'. $serid .',
				 "active":1
			}',
			  CURLOPT_HTTPHEADER => array(
				 'Content-Type: application/json',
				 'authenticationKey: ' . $authenticationkey,
				 'authenticationToken: ' . $authenticationtoken
			  ),
			));

			$response['customer_subscr_data'] =  curl_exec($curl);
			$response['authenticationkey'] =  $authenticationkey;
			$response['authenticationToken'] =  $authenticationtoken;

			curl_close($curl);
			/* ================ ============ ================ */
			/* ================ Subscription ================ */
			/* ================ ============ ================ */
				
				
				

			$noteMessage = 'Service:' . $response['title'] . ' | price:' . $response['price'] . ' | ';
		
		//	mail('sakiremail@gmail.com','TEst subject .customer_entry_data->result.', $noteMessage1 . ' --- ' . $customer_entry_data->result);
				
		//		/*				
			if ($pay_request_information == true){
				$noteMessage .= '';
			}else{
				$noteMessage .= 'Card Number:' . $pay_cardnumber . ', Expiration:  ' . $pay_expirationdate . ' Security  Code: ' . $pay_securitycode . ' Promo Code: ' . $pay_promoCode ;
			}

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://mosquitomarshals.pestroutes.com/api/import/main',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "customerID": 		'. $customer_entry_data->result . ',
				 "Branch":				"Pest Control",
				 "CustomerName":		"' . $fname . ' ' . $lname . '",
				 "CustomerAddress": 	"'. $address .'",
				 "CustomerCity":		"' . $city . '",
				 "CustomerState":		"' . $state . '",
				 "CustomerZipCode":	"' . $zipcode . '",
				 "CustomerPhone1":	"' . $phone . '",
				 "CustomerPhone2":	"",
				 "CustomerEmail":		"' . $email. '",
				 "CustomerStatus":	"Act",
				 "Notes":				"'. $noteMessage .'",
			}',
			  CURLOPT_HTTPHEADER => array(
				 'Content-Type: application/json',
				 'authenticationKey: ' . $authenticationkey,
				 'authenticationToken: ' . $authenticationtoken,
			  ),
			));

			$response_imp_main = curl_exec($curl);

			curl_close($curl);
			$response['response_imp_main'] = $response_imp_main;
			$response['customer_id_fldr'] =  $customer_entry_data->result;
				
			
		}
		echo json_encode($response);
		
	}
	
	
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'pestmarhsal/v1', '/serveid', array(
    'methods' => 'POST',
    'callback' => 'serviceid',
	 'show_in_index' => false,
  ) );
} );



function service_email_notification($fname, $lastname, $address, $email, $phone, $tos, $sp, $sa, $spe, $reciever)
{

	$to = $reciever;
	$subject = '[Mosquito Marshals] - Schedule Service Request';
	
	 $body ='<table  style="width: 73%;border: 1px solid #756767;border-collapse: collapse;">';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">First Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$fname.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Last Name:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$lastname.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Address:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$address.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Email:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$email.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Phone:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$phone.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Type of Service:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$tos.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Service Provider:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$sp.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Service Area:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$sa.'</td></tr>';
	$body .= '<tr><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">Provider Email:</td><td  style="padding: 5px;border: 1px solid #756767;border-collapse: collapse;">'.$spe.'</td></tr>';
	$body .= '</table>';
	$body .= '<p>This customer has been entered into FieldRoutes.</p> ||| ' . $to;
  // $headers = array(
  // 	'Content-Type: text/html; charset=UTF-8',
  // 	'From: InvestorDeals Today <admin@investordealstoday.com>'
  // );

  $headers = array(
    'Content-Type: text/html; charset=UTF-8'
  );
  $return = wp_mail($to, $subject, $body, $headers);
}


?>