<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


 
 // GENERATE WIRECARD USERNAME AND PASSWORD FIELD FROM DATABASE.
 
 define('WIRECARD_CARD_USER' , MODULE_PAYMENT_WIRECC_USER_ID . ':' . MODULE_PAYMENT_WIRECC_PASSWORD);
 define('WIRECARD_DEBIT_USER' , MODULE_PAYMENT_WIREDD_USER_ID . ':' . MODULE_PAYMENT_WIREDD_PASSWORD);
  define('WIRECARD_PAYPAL_USER' , MODULE_PAYMENT_WIREPP_USER_ID . ':' . MODULE_PAYMENT_WIREPP_PASSWORD);

  
 // additionally,  there are modules  MODULE_PAYMENT_WIRECC_MERCHANT and MODULE_PAYMENT_WIRECC_MERCHANT which store the merchant keys.
 
 
 // CARD URLS
 
 	if (MODULE_PAYMENT_WIRECC_MODE == 'Test'){
	  define('WIRECC_PURCHASE_URL' , "https://api-test.wirecard.com/engine/rest/payments/");
	  define('WIRECC_REFUND_URL' , "https://api-test.wirecard.com/engine/rest/payments/");
	  define('WIRECC_RELEASE_URL' , "https://api-test.wirecard.com/engine/rest/payments/");
	
	}elseif (MODULE_PAYMENT_WIRECC_MODE == 'Live'){
	  define('WIRECC_PURCHASE_URL' , "https://api.wirecard.com/engine/rest/payments/");
	  define('WIRECC_REFUND_URL' , "https://api.wirecard.com/engine/rest/payments/");
	  define('WIRECC_RELEASE_URL' , "https://api.wirecard.com/engine/rest/payments/");
	}
	

// DIRECT DEBIT URLS	
	
  	if (MODULE_PAYMENT_WIREDD_MODE == 'Test'){
	  define('WIREDD_PURCHASE_URL' , "https://api-test.wirecard.com/engine/rest/paymentmethods/");
	  define('WIREDD_REFUND_URL' , "https://api-test.wirecard.com/engine/rest/paymentmethods/");
	  define('WIREDD_RELEASE_URL' , "https://api-test.wirecard.com/engine/rest/paymentmethods/");
	
	}elseif (MODULE_PAYMENT_WIREDD_MODE == 'Live'){
	  define('WIREDD_PURCHASE_URL' , "https://api.wirecard.com/engine/rest/paymentmethods/");
	  define('WIREDD_REFUND_URL' , "https://api.wirecard.com/engine/rest/paymentmethods/");
	  define('WIREDD_RELEASE_URL' , "https://api.wirecard.com/engine/rest/paymentmethods/");
	}



 // PAYPAL URLS	
	
  	if (MODULE_PAYMENT_WIREPP_MODE == 'Test'){
	  define('WIREPP_PURCHASE_URL' , "https://api-test.wirecard.com/engine/rest/paymentmethods/");
	  define('WIREPP_REFUND_URL' , "https://api-test.wirecard.com/engine/rest/payments/");
	  define('WIREPP_RELEASE_URL' , "https://api-test.wirecard.com/engine/rest/payments/");
	
	}elseif (MODULE_PAYMENT_WIREPP_MODE == 'Live'){
	  define('WIREPP_PURCHASE_URL' , "https://api.wirecard.com/engine/rest/paymentmethods/");
	  define('WIREPP_REFUND_URL' , "https://api.wirecard.com/engine/rest/payments/");
	  define('WIREPP_RELEASE_URL' , "https://api.wirecard.com/engine/rest/payments/");
	}




// #################################### GENERAL SECTION #################################################



// #######################################################################
// standard wirecard post function

function dsf_wirecard_post($dsv_url, $dsv_file, $posttype='card') {
	
	
	//set up the curl
	
	// attempting to send basic authorisation via header
	
		$headers = array();
		  $headers[] = "Content-Type: text/xml";
		  
		  if ($posttype == 'sepa'){
			  $headers[] = "Authorization: Basic " . base64_encode (WIRECARD_DEBIT_USER);		  
		  }elseif ($posttype == 'paypal'){
			  $headers[] = "Authorization: Basic " . base64_encode (WIRECARD_PAYPAL_USER);		  
		  }else{
			  $headers[] = "Authorization: Basic " . base64_encode (WIRECARD_CARD_USER);		  
		  }
		  $headers[] = "Accept: application/xml";
		  $headers[] = 'Expect:';
	
	if (substr($dsv_url,0,5) == 'https'){
		$port = 443;
	}else{
		$port = 80;
	}
	
	
	$ch = curl_init(); // initialize curl handle
	
	curl_setopt($ch, CURLOPT_URL, $dsv_url); // set url to post to
    curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_HEADER, 1);	// keep it true for UTF8 translastions to work correctly.
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); // Fail on errors
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
	curl_setopt($ch, CURLOPT_PORT, $port); //Set the port number
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // times out after 15s
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dsv_file); // add POST fields
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


			$xml = curl_exec($ch);   
			
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			
			if (isset($curl_errno) && (int)$curl_errno > 0){
				$debug = curl_getinfo($ch);
			}else{
				$debug = '';
			}

			

			// close the connection
			curl_close($ch);	
			
			
			list($header, $body) = explode("\r\n\r\n", $xml, 2);

			
	// save a copy of the XML we are receiving back -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS AND PAREQ VALUES.  THIS IS FINE WHEN WE ARE
	//													USING THE FALSE TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE RECEIVING BACK WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	


			// save a copy of this file before processing it.
	//	$id = 'WC-RESPONSE-' . time();
	//	$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
	//	fputs($fp, $body);
	//	fclose($fp);
			
			
			
			// return the data and the error number (if it exists)
			return array('curlerrno' => $curl_errno, 
						 'curlerror' => $curl_error, 
						 'headers' => $header,
						 'data' =>$body,
						 'debug' => $debug); 
		
}


// ####################



// #######################################################################
// write shop notes to order
  function dsf_wirecard_shop_notes($order_number, $details ='') {
   
   $new_order_query = dsf_db_query("select orders_id, transaction_details from " . DS_DB_SHOP . ".orders where orders_id='" . (int)$order_number . "'");
	
   $new_order_info = dsf_db_fetch_array($new_order_query);

  // get order number first.
  $our_order_id = $new_order_info['orders_id'];
  
  if ((int)$our_order_id > 0){
					  
			$new_comments = date('Y-m-d H:i:s') . ' :- ' . utf8_encode($details) . "\n\n" . $new_order_info['transaction_details'];
 
  		  $sql_data_array = array('transaction_details' => dsf_db_prepare_input($new_comments));
		  dsf_db_perform(DS_DB_SHOP . '.orders', $sql_data_array, 'update', "orders_id = '" . (int)$our_order_id . "'");
  }
  
  return 'updated_record';
}


// ####################



// ###############################################################################
// get an orders payment card type

  function dsf_wirecard_card_type($order_number){
	  
	  $query = dsf_db_query("select card_type from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $order_number . "'");
	  $results = dsf_db_fetch_array($query);
	  
	  if (isset($results['card_type'])){
		  
		  return $results['card_type'];
	  }else{
		  return '';
	  }
  }
  
// #############################




// #######################################################################
function dsf_send_wirecard_card_mail($savedorder, $address_confirmations=''){
global $basket, $customer_id, $payment, $currencies;

				// Send an email notification to the customer.

						
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='3'");
	
// lets start with the email confirmation

						  
						 
										$email_details = dsf_db_fetch_array($email_query);
										$signature_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='1'");
									   $signature_details = dsf_db_fetch_array($signature_query);
									
									  $email_subject = $email_details['subject'];
									  $email_footer = $signature_details['details'];
									
									
									// overwrite subject as per Christian emails 2011-09-28
									  $email_subject = TRANSLATION_EMAIL_YOUR_ORDER . ' ' . SAP_ORDER_PREFIX  . $savedorder->info['id'];
									
									
								// plain text;
									
									
									  $email_order = TRANSLATION_WORD_DEAR . ' ' . $savedorder->customer['name'] . "\n\n" . $email_details['details'] . "\n";
									  
										// get products ordered by doing email function.
									  $products_ordered = dsf_order_email_items($savedorder, 'true');
										
													 
									
									  $email_order .= $products_ordered['plain'];
													
									  $email_order .= "\n" .EMAIL_SEPARATOR ."\n" . $email_footer;
						 
						 
						 		// html
									  
									  $html_order = TRANSLATION_WORD_DEAR . ' ' . $savedorder->customer['name'] . "<br /><br />";
									  $html_order .= $email_details['details'] . "<br /><br />";
									  
									  $html_order .= $products_ordered['html'] . '<br /><br />';
									  $html_order .= $email_footer;
									  
								
									 $email_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX  . $savedorder->info['id'], $email_order);
									 $html_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX  . $savedorder->info['id'], $html_order);
						 
						 
						  // end of email.
						 
						 
 
  
					  dsf_send_email($savedorder->customer['name'], $savedorder->customer['email_address'], $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					
					// send emails to other people
					  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_TO, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }


					// send emails to other people
					  if (SEND_EXTRA_ORDER_EMAILS_DUPLICATE != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_DUPLICATE, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }



// just for consistancy.

return true;




} // end email wirecard card order to customer.





// #######################################################################
function dsf_send_wirecard_paypal_mail($savedorder, $address_confirmations=''){
global $basket, $customer_id, $payment, $currencies;

				// Send an email notification to the customer.

						
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='7'");
	
// lets start with the email confirmation

						  
						 
										$email_details = dsf_db_fetch_array($email_query);
										$signature_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='1'");
									   $signature_details = dsf_db_fetch_array($signature_query);
									
									  $email_subject = $email_details['subject'];
									  $email_footer = $signature_details['details'];
									
									
									// overwrite subject as per Christian emails 2011-09-28
									  $email_subject = TRANSLATION_EMAIL_YOUR_ORDER . ' ' . SAP_ORDER_PREFIX  . $savedorder->info['id'];
									
									
								// plain text;
									
									
									  $email_order = TRANSLATION_WORD_DEAR . ' ' . $savedorder->customer['name'] . "\n\n" . $email_details['details'] . "\n";
									  
										// get products ordered by doing email function.
									  $products_ordered = dsf_order_email_items($savedorder, 'true');
										
													 
									
									  $email_order .= $products_ordered['plain'];
													
									  $email_order .= "\n" .EMAIL_SEPARATOR ."\n" . $email_footer;
						 
						 
						 		// html
									  
									  $html_order = TRANSLATION_WORD_DEAR . ' ' . $savedorder->customer['name'] . "<br /><br />";
									  $html_order .= $email_details['details'] . "<br /><br />";
									  
									  $html_order .= $products_ordered['html'] . '<br /><br />';
									  $html_order .= $email_footer;
									  
								
									 $email_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX  . $savedorder->info['id'], $email_order);
									 $html_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX  . $savedorder->info['id'], $html_order);
						 
						 
						  // end of email.
						 
						 
 
  
					  dsf_send_email($savedorder->customer['name'], $savedorder->customer['email_address'], $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					
					// send emails to other people
					  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_TO, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }


					// send emails to other people
					  if (SEND_EXTRA_ORDER_EMAILS_DUPLICATE != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_DUPLICATE, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }



// just for consistancy.

return true;




} // end email wirecard paypal order to customer.





// #################################### GENERAL SECTION COMPLETE #################################################













// #################################### ENROLLMENT SECTION #################################################


// #######################################################################
// ##### CHECK FOR 3D Enrollment
  
  function dsf_wirecard_card_enrollment($dsv_orderid, $dsv_creditc_number, $dsv_creditc_type, $dsv_expmonth, $dsv_expyear, $dsv_cv_code, $dsv_amount, $savedorder){

   global $wirecard_attempts;



	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type','check-enrollment');

	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => DEFAULT_CURRENCY) );

	$dsv_wire_xml->dsXmlElement('usage',SAP_ORDER_PREFIX . $dsv_orderid);


	$dsv_wire_xml->dsXmlPush('account-holder');

		$dsv_wire_xml->dsXmlElement('first-name',$savedorder->customer['firstname']);
		$dsv_wire_xml->dsXmlElement('last-name',$savedorder->customer['lastname']);
		$dsv_wire_xml->dsXmlElement('email',$savedorder->customer['email_address']);
		$dsv_wire_xml->dsXmlElement('phone',$savedorder->customer['telephone']);


		$dsv_wire_xml->dsXmlPush('address');

			$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->customer['house'] . ' ' . $savedorder->customer['street']));

			if (strlen($savedorder->customer['district']) > 1){
				$dsv_wire_xml->dsXmlElement('street2', $savedorder->customer['district']);
			}
			
			if (strlen($savedorder->customer['town']) > 1){
				$dsv_wire_xml->dsXmlElement('city', $savedorder->customer['town']);
			}
			
			if (strlen($savedorder->customer['county']) > 1){
				$dsv_wire_xml->dsXmlElement('state', $savedorder->customer['county']);
			}

				$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);

			if (strlen($savedorder->customer['postcode']) > 1){
				$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->customer['postcode']);
			}




		$dsv_wire_xml->dsXmlPop('address');

	$dsv_wire_xml->dsXmlPop('account-holder');
	


	// delivery address if exists.
		if (isset($savedorder->delivery['postcode']) && strlen($savedorder->delivery['postcode'])>4){ // delivery address exists
	
	$dsv_wire_xml->dsXmlPush('shipping');
	
	
										if (strpos($savedorder->delivery['name'],' ') > 0){
												$splits = explode(' ', trim($savedorder->delivery['name']));
												// take into account that the customer could have put mr, mrs etc..  therefore use only the last two splits
												$total_splits = sizeof($splits);
												
												if ($total_splits > 1){
														$first_split = $total_splits - 2;
														$second_split = $total_splits -1;
												}else{
														$first_split = 0;
														$second_split = 1;
												}
												
												
												$Delivery_Firstnames = $splits[$first_split];
												$Delivery_Surname = $splits[$second_split];
												
										}else{
											// no breaks,  ensure something is there
											
												$Delivery_Surname = $savedorder->customer['name'];
												$Delivery_Firstnames = $savedorder->customer['name'];
										}
	
	
	
		$dsv_wire_xml->dsXmlElement('first-name',$Delivery_Firstnames);
		$dsv_wire_xml->dsXmlElement('last-name',$Delivery_Surname);
	
	
	
	
		$dsv_wire_xml->dsXmlPush('address');

			$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->delivery['house'] . ' ' . $savedorder->delivery['street']));

			if (strlen($savedorder->delivery['district']) > 1){
				$dsv_wire_xml->dsXmlElement('street2', $savedorder->delivery['district']);
			}
			
			if (strlen($savedorder->delivery['town']) > 1){
				$dsv_wire_xml->dsXmlElement('city', $savedorder->delivery['town']);
			}
			
			if (strlen($savedorder->delivery['county']) > 1){
				$dsv_wire_xml->dsXmlElement('state', $savedorder->delivery['county']);
			}

				$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);

			if (strlen($savedorder->delivery['postcode']) > 1){
				$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->delivery['postcode']);
			}

		$dsv_wire_xml->dsXmlPop('address');
	
	$dsv_wire_xml->dsXmlPop('shipping');
	
		}
		

		$dsv_wire_xml->dsXmlPush('card');
				$dsv_wire_xml->dsXmlElement('account-number', $dsv_creditc_number);
	
				$dsv_expdat = dsf_format_fixed_length($dsv_expmonth, 2, 'right' ,'0');
				
				$dsv_wire_xml->dsXmlElement('expiration-month', $dsv_expdat);
				$dsv_wire_xml->dsXmlElement('expiration-year', $dsv_expyear);
				$dsv_wire_xml->dsXmlElement('card-type', $dsv_creditc_type);
				$dsv_wire_xml->dsXmlElement('card-security-code', $dsv_cv_code);


	$dsv_wire_xml->dsXmlPop('card');
	
	$dsv_wire_xml->dsXmlElement('ip-address', substr(dsf_get_ip_address_nonproxy(),0,15));


	$dsv_wire_xml->dsXmlElement('order-number',SAP_ORDER_PREFIX . $dsv_orderid);
	$dsv_wire_xml->dsXmlElement('descriptor',SAP_ORDER_PREFIX . $dsv_orderid);
	
	$dsv_wire_xml->dsXmlPop('payment');
	
	
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();



// make a record in the wirecard_responses table.

		$sql_data_array = array('orders_id' => $dsv_orderid,
								'orderid' => $dsv_orderid,
								'amount' => $dsv_amount,
								'trans_type' => 1,
								'card_type' => $dsv_creditc_type,
								'request_id' => $dsv_wirecard_request_id);
								
		// save it
		
			$prev_item = dsf_db_query("select token_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "'");
			
			if (dsf_db_num_rows($prev_item) == 0){
				// this is a new attempt therefore we a new record
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array);
			}else{
				// we have already attempted this order before and it must have failed - update with new details.
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $dsv_orderid . "'");
				
			}
			

	// $response = $dsv_xml_to_post;

	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE FALSE TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
			// save a copy of this file before sending it.
//		$id = 'WC-CE-' . time();
//		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
//		fputs($fp, $dsv_xml_to_post);
//		fclose($fp);

	
// post the xml created and return back to the requesting script.

	 $response = dsf_wirecard_post(WIRECC_PURCHASE_URL , $dsv_xml_to_post);
	
return $response;

}




// ###############



// #####
// check an enrollment response

function dsf_wirecard_check_enrollment_response($orderid, $xml_returned) {
	
	// the first job is to split the xml_returned into a simplexml object that we can work on.
	$transaction_state = '';
	$return_text = '';
	$debug_text = '';
	$return_error = 'false';
	$card_enrolled = 'false';
	$pareq = '';
	$acs_url = '';
	$token_id = '';
	$status_numbers = array();
	
	
	
	
	$results = simplexml_load_string($xml_returned);
	
	
	
	if (isset($results->{'merchant-account-id'}) && strlen($results->{'merchant-account-id'}) > 1){
		
		// we have a merchant ID.  this should be avaialble in every response file otherwise we have an xml problem.
		
		$transaction_id = trim($results->{'transaction-id'});
		$transaction_state = trim($results->{'transaction-state'});
		
		if (strtolower($transaction_state) == 'success'	){
			
		
			// check to see what the actual status is.
			if (count($results->statuses->status) > 1 ){
				
				// we have more than one status result, not on the documentation for a success state but we need make a note of them so we can investigate.
				
								
								
								// 2014-09-24 we started to received two status values
								
								//	[201.0000] => 3d-acquirer:The resource was successfully created.
								//	[200.1077] => 3d-acquirer:Card is eligible for the ACS authentication process. If the customer has not yet activated his card for 3-D Secure processing his issuer may offer activation during shopping.
								
								// this makes the success values fall over preventing orders from completing,   this is a quick fix to correct the problem for these two status values only.
								
								
									$multiple_status_error = 'false';
									
										$pareq = trim($results->{'three-d'}->pareq);
										$acs_url = trim($results->{'three-d'}->{'acs-url'});
										$token_id = trim($results->{'card-token'}->{'token-id'});
								
								
									foreach($results->statuses->status as $status){
								
											if (strlen($status->attributes()->code) > 0){
												$status_code_value = trim($status->attributes()->code);
												$status_code_text = trim($status->attributes()->description);
												$status_code_severity = trim($status->attributes()->severity);
												
												$status_numbers[$status_code_value] = $status_code_text . '(' . $status_code_severity . ')';
												
												
													if ($status_code_value == "201.0000" || $status_code_value == "200.1077"){
														// we are still ok to proceed if we have a pareq, token and url
															if (strlen($pareq) > 4 && strlen($acs_url) > 4 && strlen($token_id) > 2){
																// we have values with which we should be able to proceed.
																
															}else{
																
																// fail it
																$multiple_status_error = 'true';
																
																
																$return_text .= 'pareq, acs_url or token_id not present.' . "\n";
																
															}
														
														
													}else{
														
														// unknown value therefore mark as error.
															$multiple_status_error = 'true';
													}
											}
									}





									if ($multiple_status_error == 'false'){
										// we have not found an error therefore proceed.
										$card_enrolled = 'true';
										
										
										
									}else{
										$return_text .= 'unexpected multiple responses' . "\n";
										$debug_text .=  dsf_print_array($results->statuses);
										
										
										$card_enrolled = 'false';
										$return_error = 'true';
									}
								
								// END OF AMENDENT 2014-09-24
								
								
								
								// previously
								
								/*
								
									$return_text .= 'unexpected multiple responses' . "\n";
									$debug_text .=  dsf_print_array($results->statuses);
									
									foreach($results->statuses->status as $status){
								
											if (strlen($status->attributes()->code) > 0){
												$status_code_value = trim($status->attributes()->code);
												$status_code_text = trim($status->attributes()->description);
												
													$status_numbers[$status_code_value] = $status_code_text;
											}
									}

									
									
				
									$card_enrolled = 'false';
									$return_error = 'true';
									*/
											
		
			}else{
				
				
										if (trim($results->statuses->status->attributes()->code) == "201.0000"){
											// completely successful.
												$card_enrolled = 'true';
											
											// get pareq value and url to jump to.
												$pareq = trim($results->{'three-d'}->pareq);
												$acs_url = trim($results->{'three-d'}->{'acs-url'});
												$token_id = trim($results->{'card-token'}->{'token-id'});
											
										}elseif (trim($results->statuses->status->attributes()->code) == "500.1072"){
												// card is not enrolled.
													$card_enrolled = 'false';
													$token_id = trim($results->{'card-token'}->{'token-id'});
													
										}else{
											
											// an error has generated.
											
													$return_text .= 'a failed status code has been generated value ' . trim($results->statuses->status->attributes()->code) . "\n";
													$card_enrolled = 'false';
													$return_error = 'true';
											
											
										}
			
				
				
			}
			
			
		
		}else{
			
			// transaction state not success therefore we could have multiple errors - these will most likely be issues with the data the customer input (card numbers, cv2 etc....)
			
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										$status_code_severity = trim($status->attributes()->severity);
										
										$status_numbers[$status_code_value] = $status_code_text . '(' . $status_code_severity . ')';

										
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										$status_code_severity = trim($results->statuses->status->attributes()->severity);
										
										$status_numbers[$status_code_value] = $status_code_text . '(' . $status_code_severity . ')';
						}
						
						
						
						
						
				 // at this stage - we may not have an error but simply the card is not enrolled.  we need to account for that seperately.
				 
				 		if (sizeof($status_numbers) == 1){
							// we only have one item in the array.
							
							if (isset($status_numbers['500.1072'])){
								// card not enrolled
						
								$return_text .= 'Cardholder not participating'. "\n";
								$card_enrolled = 'false';
								$token_id = trim($results->{'card-token'}->{'token-id'});	
													
							}else{
								
								$return_text .= 'transaction state not success'. "\n";
								$return_error = 'true';
							}
						}else{
						
						
							$return_text .= 'transaction state not success'. "\n";
							$return_error = 'true';
						}
						
		}
	
	
	
	}else{
		$return_text .= 'No merchant account ID found'. "\n";
		$return_error = 'true';
		
		
	} // end merchant accout check.
		
	
	
	
	// start building the save sql (but we only save when we have a transaction id returned.
	
	
	
// update the transaction database
	if (strlen($transaction_id) > 0){
		$sql_data_array = array('enrollment_trans_id' => $transaction_id,
								'token_id' => $token_id);
		
		$upd = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $orderid . "'");
	
	
	}
	
	
	
	
	
return array('error_generated' => $return_error,
			'status_numbers' => $status_numbers,
			'transaction_id' => $transaction_id,
			'transaction_state' => $transaction_state,
			'text' => $return_text,
			'debug_text' => $debug_text,
			'card_enrolled' => $card_enrolled,
			'pareq' => $pareq,
			'acs_url' => $acs_url,
			'token_id' => $token_id);
			
}




// #################################### ENROLLMENT SECTION COMPLETE #################################################





// #################################### PARES SECTION #################################################


// #######################################################################
// ##### Make a purchase request (can be either an authorisation or payment request) with a 3D response back.

  
  function dsf_wirecard_card_purchase_pares($dsv_orderid, $pares){

   global $wirecard_attempts;

	// get the parent transaction id from the database for this request.
	
	$parent_query = dsf_db_query("select enrollment_trans_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "'");
	$parent_results = dsf_db_fetch_array($parent_query);
	
	$parent_transaction_id = $parent_results['enrollment_trans_id'];
	
	
	

	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type',MODULE_PAYMENT_WIRECC_TXTYPE);


	$dsv_wire_xml->dsXmlElement('parent-transaction-id',$parent_transaction_id);


	$dsv_wire_xml->dsXmlPush('three-d');

		$dsv_wire_xml->dsXmlElement('pares',$pares);

	$dsv_wire_xml->dsXmlPop('three-d');
	
	$dsv_wire_xml->dsXmlPop('payment');
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();


	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE PRETEND TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
//		$id = 'WC-PARES-' . time();
//		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
//		fputs($fp, $dsv_xml_to_post);
//		fclose($fp);


	 $response = dsf_wirecard_post(WIRECC_PURCHASE_URL , $dsv_xml_to_post);
	
	

return $response;

	
	
	
}




// ###############








// #####
// check a pares payment response

function dsf_wirecard_card_purchase_pares_response($orderid, $xml_returned) {
	
	// the first job is to split the xml_returned into a simplexml object that we can work on.
	$transaction_state = '';
	$return_text = '';
	$debug_text = '';
	$return_error = 'false';
	$authentication_status = '';
	$authorisation_code = '';
	$status_numbers = array();
	
	$results = simplexml_load_string($xml_returned);
	
	
// $return_text .= dsf_print_array($results);
	
	
	if (isset($results->{'merchant-account-id'}) && strlen($results->{'merchant-account-id'}) > 1){
		
		// we have a merchant ID.  this should be avaialble in every response file otherwise we have an xml problem.
		
		$transaction_id = trim($results->{'transaction-id'});
		$transaction_state = trim($results->{'transaction-state'});
		
		if (isset($results->{'authorization-code'})){
			$authorisation_code = trim($results->{'authorization-code'});
		}else{
			$authorisation_code = '';
		}
		
		if (isset($results->{'three-d'}->{'cardholder-authentication-status'})){
			$authentication_status = trim($results->{'three-d'}->{'cardholder-authentication-status'});
		}else{
			$authentication_status = '';
		}
		


		// put all status codes into an array to work with.
		
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										
								 			$status_numbers[$status_code_value] = $status_code_text;
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										
								 		$status_numbers[$status_code_value] = $status_code_text;
						}

									
									

		if (strtolower($transaction_state) == 'success'	){
			
			// we have a succesful transaction therefore the status numbers we should expect
			// are:		200.0000  The request completed successfully
			//			200.1078 3D Full Authentication
			//			200.1079 3D Attempted Authentication
			//			200.1080 3D Failed Authentication
			//			200.1081 3D Authentication Errored
			
			// according to email 2013-12-03  the last two  200.1080 + 200.1081 will not produce the authorisation.  The test numbers supplied did not, real card testing will be required to confirm 100%.
			
											
		
		
		}else{
			
						
						
			$return_text .= 'transaction state not success'. "\n";
			$return_error = 'true';
			
		}
	
	
	
	}else{
		$return_text .= 'No merchant account ID found'. "\n";
		$return_error = 'true';
		
		
	} // end merchant accout check.
		
	
	
	
	// start building the save sql (but we only save when we have a transaction id returned.
	
	
	
// update the transaction database
	if (strlen($transaction_id) > 0 && strtolower($transaction_state) == 'success'	){
		$sql_data_array = array('payment_trans_id' => $transaction_id,
								'authorisation_code' => $authorisation_code,
								'txntype' => MODULE_PAYMENT_WIRECC_TXTYPE);
		
		$upd = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $orderid . "'");
	
	
	}
	
	
	
	
	
return array('error_generated' => $return_error,
			'status_numbers' => $status_numbers,
			'transaction_id' => $transaction_id,
			'transaction_state' => $transaction_state,
			'text' => $return_text,
			'debug_text' => $debug_text,
			'authorisation_code' => $authorisation_code,
			'authentication_status' => $authentication_status);
			
}






// #######################################################################
// ##### Check 3D response.  Email 2013-12-03 says this is not required and we should just do authorisation with pares value.

  
  function dsf_wirecard_card_check_pares($dsv_orderid, $pares){

   global $wirecard_attempts;

	// get the parent transaction id from the database for this request.
	
	$parent_query = dsf_db_query("select enrollment_trans_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "'");
	$parent_results = dsf_db_fetch_array($parent_query);
	
	$parent_transaction_id = $parent_results['enrollment_trans_id'];
	
	
	

	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type','check-payer-response');


	$dsv_wire_xml->dsXmlElement('parent-transaction-id',$parent_transaction_id);


	$dsv_wire_xml->dsXmlPush('three-d');

		$dsv_wire_xml->dsXmlElement('pares',$pares);

	$dsv_wire_xml->dsXmlPop('three-d');
	
	$dsv_wire_xml->dsXmlPop('payment');
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();


	
	 $response = dsf_wirecard_post(WIRECC_PURCHASE_URL , $dsv_xml_to_post);
	
	

return $response;

	
}




// ###############





// #################################### PARES SECTION COMPLETE #################################################







// #################################### NON PARES SECTION #################################################

// the non pares section is where we do payment requests when the enrollment check has resulted as false so we have no
// pares values to send with the authorisation.


// #######################################################################
// ##### Make a purchase request (can be either an authorisation or payment request) when we had a false enrollment check.

  
  function dsf_wirecard_card_purchase_non_pares($dsv_orderid){

   global $wirecard_attempts;

	// get the parent transaction id from the database for this request.
	
	$parent_query = dsf_db_query("select enrollment_trans_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "'");
	$parent_results = dsf_db_fetch_array($parent_query);
	
	$parent_transaction_id = $parent_results['enrollment_trans_id'];
	
	
	

	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type',MODULE_PAYMENT_WIRECC_TXTYPE);


	$dsv_wire_xml->dsXmlElement('parent-transaction-id',$parent_transaction_id);


	$dsv_wire_xml->dsXmlPop('payment');
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();


	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE PRETEND TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
//		$id = 'WC-NONPARES-' . time();
//		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
//		fputs($fp, $dsv_xml_to_post);
//		fclose($fp);


	 $response = dsf_wirecard_post(WIRECC_PURCHASE_URL , $dsv_xml_to_post);
	
	

return $response;

	
	
	
}




// ###############


// #####
// check a non pares payment response

function dsf_wirecard_card_purchase_non_pares_response($orderid, $xml_returned) {
	
	// the first job is to split the xml_returned into a simplexml object that we can work on.
	$transaction_state = '';
	$return_text = '';
	$debug_text = '';
	$return_error = 'false';
	$authentication_status = '';
	$authorisation_code = '';
	$status_numbers = array();
	
	$results = simplexml_load_string($xml_returned);
	
	
// $return_text .= dsf_print_array($results);
	
	
	if (isset($results->{'merchant-account-id'}) && strlen($results->{'merchant-account-id'}) > 1){
		
		// we have a merchant ID.  this should be avaialble in every response file otherwise we have an xml problem.
		
		$transaction_id = trim($results->{'transaction-id'});
		$transaction_state = trim($results->{'transaction-state'});
		
		if (isset($results->{'authorization-code'})){
			$authorisation_code = trim($results->{'authorization-code'});
		}else{
			$authorisation_code = '';
		}
		
		if (isset($results->{'three-d'}->{'cardholder-authentication-status'})){
			$authentication_status = trim($results->{'three-d'}->{'cardholder-authentication-status'});
		}else{
			$authentication_status = '';
		}
		


		// put all status codes into an array to work with.
		
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										
								 			$status_numbers[$status_code_value] = $status_code_text;
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										
								 		$status_numbers[$status_code_value] = $status_code_text;
						}

									
									

		if (strtolower($transaction_state) == 'success'	){
			
			// we have a succesful transaction therefore the status numbers we should expect
			// are:		200.0000  The request completed successfully
			//			200.1078 3D Full Authentication
			//			200.1079 3D Attempted Authentication
			//			200.1080 3D Failed Authentication
			//			200.1081 3D Authentication Errored
			
			// according to email 2013-12-03  the last two  200.1080 + 200.1081 will not produce the authorisation.  The test numbers supplied did not, real card testing will be required to confirm 100%.
			
											
		
		
		}else{
			
						
						
			$return_text .= 'transaction state not success'. "\n";
			$return_error = 'true';
			
		}
	
	
	
	}else{
		$return_text .= 'No merchant account ID found'. "\n";
		$return_error = 'true';
		
		
	} // end merchant accout check.
		
	
	
	
	// start building the save sql (but we only save when we have a transaction id returned.
	
	
	
// update the transaction database
	if (strlen($transaction_id) > 0 && strtolower($transaction_state) == 'success'	){
		$sql_data_array = array('payment_trans_id' => $transaction_id,
								'authorisation_code' => $authorisation_code,
								'txntype' => MODULE_PAYMENT_WIRECC_TXTYPE);
		
		$upd = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $orderid . "'");
	
	
	}
	
	
	
	
	
return array('error_generated' => $return_error,
			'status_numbers' => $status_numbers,
			'transaction_id' => $transaction_id,
			'transaction_state' => $transaction_state,
			'text' => $return_text,
			'debug_text' => $debug_text,
			'authorisation_code' => $authorisation_code,
			'authentication_status' => $authentication_status);
			
}




// ##############################




// #################################### NON PARES SECTION COMPLETE #################################################




// #################################### NON 3D SECTION (no enrollment check) #################################################


// #######################################################################
// ##### Make a purchase request (can be either an authorisation or payment request) used when no 3D is requested first.


  
  function dsf_wirecard_card_purchase_non_three_d($dsv_orderid, $dsv_creditc_number, $dsv_creditc_type, $dsv_expmonth, $dsv_expyear, $dsv_cv_code, $dsv_amount, $savedorder){

   global $wirecard_attempts;



	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type',MODULE_PAYMENT_WIRECC_TXTYPE);

	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => DEFAULT_CURRENCY) );

	$dsv_wire_xml->dsXmlPush('account-holder');

		$dsv_wire_xml->dsXmlElement('first-name',$savedorder->customer['firstname']);
		$dsv_wire_xml->dsXmlElement('last-name',$savedorder->customer['lastname']);
		$dsv_wire_xml->dsXmlElement('email',$savedorder->customer['email_address']);
		$dsv_wire_xml->dsXmlElement('phone',$savedorder->customer['telephone']);


		$dsv_wire_xml->dsXmlPush('address');

			$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->customer['house'] . ' ' . $savedorder->customer['street']));

			if (strlen($savedorder->customer['district']) > 1){
				$dsv_wire_xml->dsXmlElement('street2', $savedorder->customer['district']);
			}
			
			if (strlen($savedorder->customer['town']) > 1){
				$dsv_wire_xml->dsXmlElement('city', $savedorder->customer['town']);
			}
			
			if (strlen($savedorder->customer['county']) > 1){
				$dsv_wire_xml->dsXmlElement('state', $savedorder->customer['county']);
			}

				$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);

			if (strlen($savedorder->customer['postcode']) > 1){
				$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->customer['postcode']);
			}




		$dsv_wire_xml->dsXmlPop('address');

	$dsv_wire_xml->dsXmlPop('account-holder');
	


	// delivery address if exists.
		if (isset($savedorder->delivery['postcode']) && strlen($savedorder->delivery['postcode'])>4){ // delivery address exists
	
	$dsv_wire_xml->dsXmlPush('shipping');
	
	
										if (strpos($savedorder->delivery['name'],' ') > 0){
												$splits = explode(' ', trim($savedorder->delivery['name']));
												// take into account that the customer could have put mr, mrs etc..  therefore use only the last two splits
												$total_splits = sizeof($splits);
												
												if ($total_splits > 1){
														$first_split = $total_splits - 2;
														$second_split = $total_splits -1;
												}else{
														$first_split = 0;
														$second_split = 1;
												}
												
												
												$Delivery_Firstnames = $splits[$first_split];
												$Delivery_Surname = $splits[$second_split];
												
										}else{
											// no breaks,  ensure something is there
											
												$Delivery_Surname = $savedorder->customer['name'];
												$Delivery_Firstnames = $savedorder->customer['name'];
										}
	
	
	
		$dsv_wire_xml->dsXmlElement('first-name',$Delivery_Firstnames);
		$dsv_wire_xml->dsXmlElement('last-name',$Delivery_Surname);
	
	
	
	
		$dsv_wire_xml->dsXmlPush('address');

			$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->delivery['house'] . ' ' . $savedorder->delivery['street']));

			if (strlen($savedorder->delivery['district']) > 1){
				$dsv_wire_xml->dsXmlElement('street2', $savedorder->delivery['district']);
			}
			
			if (strlen($savedorder->delivery['town']) > 1){
				$dsv_wire_xml->dsXmlElement('city', $savedorder->delivery['town']);
			}
			
			if (strlen($savedorder->delivery['county']) > 1){
				$dsv_wire_xml->dsXmlElement('state', $savedorder->delivery['county']);
			}

				$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);

			if (strlen($savedorder->delivery['postcode']) > 1){
				$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->delivery['postcode']);
			}

		$dsv_wire_xml->dsXmlPop('address');
	
	$dsv_wire_xml->dsXmlPop('shipping');
	
		}
		

		$dsv_wire_xml->dsXmlPush('card');
				$dsv_wire_xml->dsXmlElement('account-number', $dsv_creditc_number);
	
				$dsv_expdat = dsf_format_fixed_length($dsv_expmonth, 2, 'right' ,'0');
				
				$dsv_wire_xml->dsXmlElement('expiration-month', $dsv_expdat);
				$dsv_wire_xml->dsXmlElement('expiration-year', $dsv_expyear);
				$dsv_wire_xml->dsXmlElement('card-type', $dsv_creditc_type);
				$dsv_wire_xml->dsXmlElement('card-security-code', $dsv_cv_code);


	$dsv_wire_xml->dsXmlPop('card');
	
	$dsv_wire_xml->dsXmlElement('ip-address', substr(dsf_get_ip_address_nonproxy(),0,15));
	
	$dsv_wire_xml->dsXmlPop('payment');
	
	
	












	
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();




// make a record in the wirecard_responses table.

		$sql_data_array = array('orders_id' => $dsv_orderid,
								'orderid' => $dsv_orderid,
								'amount' => $dsv_amount,
								'trans_type' => 1,
								'card_type' => $dsv_creditc_type,
								'request_id' => $dsv_wirecard_request_id,
								'txntype' => MODULE_PAYMENT_WIRECC_TXTYPE);
								
		// save it
		
			$prev_item = dsf_db_query("select token_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "'");
			
			if (dsf_db_num_rows($prev_item) == 0){
				// this is a new attempt therefore we a new record
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array);
			}else{
				// we have already attempted this order before and it must have failed - update with new details.
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $dsv_orderid . "'");
				
			}
			




	// $response = $dsv_xml_to_post;
	
	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE PRETEND TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
//		$id = 'WC-NON3D-' . time();
//		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
//		fputs($fp, $dsv_xml_to_post);
//		fclose($fp);

	

	 $response = dsf_wirecard_post(WIRECC_PURCHASE_URL , $dsv_xml_to_post);
	
	

return $response;

	
	
	
}




// ###############


// #####
// check an enrollment response

function dsf_wirecard_card_purchase_non_three_d_response($orderid, $xml_returned) {
	
	// the first job is to split the xml_returned into a simplexml object that we can work on.
	$transaction_state = '';
	$return_text = '';
	$debug_text = '';
	$return_error = 'false';
	$authentication_status = '';
	$authorisation_code = '';
	$token_id = '';
	
	$status_numbers = array();
	
	$results = simplexml_load_string($xml_returned);
	
	
// $return_text .= dsf_print_array($results);
	
	
	if (isset($results->{'merchant-account-id'}) && strlen($results->{'merchant-account-id'}) > 1){
		
		// we have a merchant ID.  this should be avaialble in every response file otherwise we have an xml problem.
		
		$transaction_id = trim($results->{'transaction-id'});
		$transaction_state = trim($results->{'transaction-state'});
		
		if (isset($results->{'authorization-code'})){
			$authorisation_code = trim($results->{'authorization-code'});
		}else{
			$authorisation_code = '';
		}
		
		if (isset($results->{'three-d'}->{'cardholder-authentication-status'})){
			$authentication_status = trim($results->{'three-d'}->{'cardholder-authentication-status'});
		}else{
			$authentication_status = '';
		}
		
		if (isset($results->{'card-token'}->{'token-id'})){
				$token_id = trim($results->{'card-token'}->{'token-id'});
		}
		

		// put all status codes into an array to work with.
		
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										
								 			$status_numbers[$status_code_value] = $status_code_text;
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										
								 		$status_numbers[$status_code_value] = $status_code_text;
						}

									
									

		if (strtolower($transaction_state) == 'success'	){
			
			// we have a succesful transaction therefore the status numbers we should expect
			// are:		200.0000  The request completed successfully
			//			200.1078 3D Full Authentication
			//			200.1079 3D Attempted Authentication
			//			200.1080 3D Failed Authentication
			//			200.1081 3D Authentication Errored
			
			// according to email 2013-12-03  the last two  200.1080 + 200.1081 will not produce the authorisation.  The test numbers supplied did not, real card testing will be required to confirm 100%.
			
											
		
		
		}else{
			
						
						
			$return_text .= 'transaction state not success'. "\n";
			$return_error = 'true';
			
		}
	
	
	
	}else{
		$return_text .= 'No merchant account ID found'. "\n";
		$return_error = 'true';
		
		
	} // end merchant accout check.
		
	
	
	
	// start building the save sql (but we only save when we have a transaction id returned.
	
	
	
// update the transaction database
	if (strlen($transaction_id) > 0 && strtolower($transaction_state) == 'success'	){
		$sql_data_array = array('payment_trans_id' => $transaction_id,
								'authorisation_code' => $authorisation_code,
								'token_id' => $token_id,
								'txntype' => MODULE_PAYMENT_WIRECC_TXTYPE);
		
		$upd = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $orderid . "'");
	
	
	}
	
	
	
	
	
return array('error_generated' => $return_error,
			'status_numbers' => $status_numbers,
			'transaction_id' => $transaction_id,
			'transaction_state' => $transaction_state,
			'text' => $return_text,
			'debug_text' => $debug_text,
			'authorisation_code' => $authorisation_code,
			'authentication_status' => $authentication_status);
			
			
}



// #################################### NON 3D SECTION (no enrollment check) COMPLETE #################################################












// #################################### CAPTURE SECTION #################################################




//  CAPTURE CARD / PAYPAL DETAILS  REQUESTER ####
// #######################################################################
// changed 25/10/2014 to encorporate capturing paypal items as well.

function dsf_wirecard_capture_request($orders_id){
	// trans type 1 = card
	// trans type 6 = paypal
	
	
	if ((int)$orders_id > 0){
			// we have an order number,  get the details to release.
			
			// get the info from the transaction database.
			$dsv_query = dsf_db_query("select payment_trans_id, amount, released, trans_type from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $orders_id . "' and (trans_type='1' || trans_type='6')");
			
			if (dsf_db_num_rows($dsv_query) == 1){
				// we only have one item therefore continue processing.
			
					$dsv_results = dsf_db_fetch_array($dsv_query);
							
			
					// two things to note here.
					
					// 1)   the catpute function we are about to use has lots of error reporting in it however, one thing
					//      it does not have is error checking that we are sending the correct information to it in the first
					//      place.  we therefore need to take that into account here.
					
					// 2)   we are doing a while to produce a loop.  we could do a for and break but since we are in
					//      a function break might cause unexpected function closure.
					
					$dsv_payment_trans_id = $dsv_results['payment_trans_id'];
					$dsv_amount = $dsv_results['amount'];
					
					if (strlen($dsv_payment_trans_id) < 1 || (float)$dsv_amount < 0.10){
						// we do not have sufficient information to proceed.
						$message = 'Order number ' . $orders_id . ' unable to run capture money function as values to send are: payment_trans_id = ' . $dsv_payment_trans_id . ' amount = ' . $dsv_amount;
						dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}elseif ((int)$dsv_results['released'] == 1){
						
						// already released or not a card transaction
						
						$message = 'Order number ' . $orders_id . ' unable to run capture money function as values to send are: released = ' .$dsv_results['realeased'];
						dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}else{
						
						// we are still here therefore we have everything to do the call.
						
						// start the while
								$dsv_max_attempts = 1; // the maximum amount of times we are going to try and release the money
								$dsv_current_attempt = 1;
								$return_value = 'false'; // automatically set the return value here to false because if we break
														 // out the loop we would not know and therefore could not set it again.
														 // we use reverse logic,  if we break the loop we set it to true.
			
			
								while ($dsv_current_attempt <= $dsv_max_attempts) {
									
								
									$capture_money = dsf_wirecard_capture($orders_id, $dsv_payment_trans_id, $dsv_amount, $dsv_results['trans_type']);
									
									if (isset($capture_money['status']) && $capture_money['status'] == 'success'){
										// we can break out the loop,  we have released the money  (capture)
										
										$return_value = 'true';
										$dsv_current_attempt = $dsv_max_attempts +1;  // create a break point by making current attempt larger than max
									
									} else{
									
										// add on to attempts.
										$dsv_current_attempt ++;
									}
									
								} // end while
						
						// at this point,  we have either managed to make a successfull capture or it hasn't work and we have tried
						// maximum times.  we already set the return value to false before the while so we don't need to do anymore error checking.
						
							if ($return_value == 'false'){
								// we have had 3 failure, we need to report it.
								
									$message = 'Order number ' . $orders_id . ' unable to capture money after ' . $dsv_max_attempts . ' attempts';
									dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);

							}
						
						
						
						
					}
			
			
			
			}else{
				// either more than one or no records found for transactions in the montrada transaction database.
				// we need to notify someone of this error.
				$message = 'Order number ' . $orders_id . ' unable to capture money as ' . dsf_db_num_rows($dsv_query) . ' items found in transaction database';
				dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
				$return_value = 'false';
			}
	
	


	}else{
		// no order number
		$return_value = 'false';
	}
	
	
	
	
	if ($return_value == 'true'){
		
				// update the orders status
						
		if ((int)$dsv_results['trans_type'] == 6){
			// paypal
			$new_orders_status = 68005;
			
			$sql_data_array = array('orders_status' => $new_orders_status);
		}else{
			// default card
			$new_orders_status = 66005;
			$sql_data_array = array('orders_status' => $new_orders_status);
		}
		
		$upd = dsf_db_perform(DS_DB_SHOP . ".orders",$sql_data_array,'update','orders_id=' . $orders_id);


	// update status history.
		  $sql_data_array = array('orders_id' => $orders_id, 
								  'orders_status_id' => $new_orders_status, 
								  'date_added' => 'now()');
		$upd = dsf_db_perform(DS_DB_SHOP . ".orders_status_history", $sql_data_array);

	// log the reply.
	}else{
	
		$message = 'Order number ' . $orders_id . ' return value is ' . $return_value;
		dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
	
	}
	
	
	
	
return $return_value;
}



//  CAPTURE CARD DETAILS  (release money from shadow / preauth) ####
// #######################################################################
// #######################################################################

function dsf_wirecard_capture($order_id, $dsv_payment_trans_id, $dsv_amount, $trans_type=1){
   
// IMPORTANT THIS FUNCTION IS NEVER TO BE RUN DIRECTLY.
// RUN IT FROM A SCRIPT OR OTHER FUNCTION WHICH CHECKS THE ANSWER AND DECIDES IF IT IS A COMMUNICATION
// OR TERMINAL PROBLEM SO IT CAN TRY AGAIN.

// THE CALLING SCRIPT MUST ENSURE WE HAVE THE CORRECT THREE PARAMETERS REQUIRED OTHERWISE
// IT SHOULD NOT ATTEMPT TO RUN THIS FUNCTION.

// amended on 25/10/2014 to encorporate paypal.
	// trans type 1 = card
	// trans type 6 = paypal


   
   $return_status = '';
   $return_text = '';
   $return_error ='';
	$status_numbers = array();
   
    
		$parent_transaction_id = $dsv_payment_trans_id;
	
	
	

	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $order_id . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
	if ((int)$trans_type == 6){
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="paypal"');
	}else{
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	}
	
	$dsv_wire_xml->dsXmlPop('payment-methods');

	if ((int)$trans_type == 6){
		$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIREPP_MERCHANT);
	}else{
		$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	}
	
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type','capture-authorization');

// added 2014-04-08 not within documentation however advised by Wirecard to add it so order numbers can be passed through for reporting.
	$dsv_wire_xml->dsXmlElement('order-detail',SAP_ORDER_PREFIX . $order_id);
// end addition.

	$dsv_wire_xml->dsXmlElement('parent-transaction-id',$parent_transaction_id);

	$dsv_wire_xml->dsXmlPop('payment');
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();


	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE PRETEND TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
	//	$id = 'WC-CAPTURE-' . time();
	//	$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
	//	fputs($fp, $dsv_xml_to_post);
	//	fclose($fp);

	if ((int)$trans_type == 6){
	 	$wire_request = dsf_wirecard_post(WIREPP_RELEASE_URL , $dsv_xml_to_post, 'paypal');
	}else{
	 	$wire_request = dsf_wirecard_post(WIRECC_RELEASE_URL , $dsv_xml_to_post, 'card');
	}
	

	// if we have a curl error at this stage,  we cannot let the customer re-try we therefore have no alternative but to decline the order.
	
			if (isset($wire_request['curlerrno']) && (int)$wire_request['curlerrno'] > 0){
				// we have a curl error,  we cannot continue with the process.
				
					$write_notes = dsf_wirecard_shop_notes($order_id, "Error communication issue" . $wire_request['curlerrno'] . $wire_request['curlerror'] . 'When doing capture');
					$return_status = 'failed';
					$return_text = 'Request ID ' . $dsv_wirecard_request_id . ' ERROR curl failed';
					$return_error = 'curl failed';
					
			}else{
				
				// start processing the data.
							
					$results = simplexml_load_string($wire_request['data']);
					
	
					$transaction_id = trim($results->{'transaction-id'});
					$transaction_state = trim($results->{'transaction-state'});
					
					if (isset($results->{'authorization-code'})){
						$authorisation_code = trim($results->{'authorization-code'});
					}else{
						$authorisation_code = '';
					}
		
		
					if (isset($results->{'requested-amount'})){
						$returned_amount = (float)trim($results->{'requested-amount'});
					}else{
						$returned_amount = 0;
					}


		// put all status codes into an array to work with.
		
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										
								 			$status_numbers[$status_code_value] = $status_code_text;
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										
								 		$status_numbers[$status_code_value] = $status_code_text;
						}

									
						$new_notes = '';
						reset($status_numbers);
						
						foreach($status_numbers as $id => $value){
							$new_notes .= $id . ' ' . $value . "\n";
						}
									

						if (strtolower($transaction_state) == 'success'	){


								// PRICE CHECK NEEDED HERE
								if ((float)$dsv_amount == (float)$returned_amount){
										// we are ok,  the amount requested is the amount captured.
										
								}else{
										// we have a problem as the amount captured does not match what we requested.
										
									$message = "Order number " . $order_id . " Authorise and capture values do not match\nREQUEST ID" . $dsv_wirecard_request_id;
									dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
										
								}
								
									

								// success
								
								// advise the order that the money has been taken.
										$write_notes = dsf_wirecard_shop_notes($order_id, "CAPURE MONEY REQUEST SUCCESSFULL\nMESSAGE = " . $transaction_state . " : " . $returned_amount . "\nauthcode = " . $authorisation_code . "\nstatus = " . $new_notes);
								
								// mark the transactions that the money has been taken
										$sql_data_array = array('capture_trans_id' => $transaction_id,
																'released' => 1);
										$upt = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array , "update" , "orders_id='" . $order_id . "' and payment_trans_id = '" . $dsv_payment_trans_id . "'");
								// advise calling function of success.
										$return_status = 'success';

								
							}else{
									
									$return_status = 'failed';
									$return_text = 'Request ID ' . $dsv_wirecard_request_id . ' ERROR ' . dsf_print_array($status_numbers);
									$return_error = 'capture failed';
									
									
									
								// put small error message into order regardless of which error status was above.
										$write_notes = dsf_wirecard_shop_notes($order_id, "CAPURE MONEY FAILED\nMESSAGE = " . $new_notes);
								
						}


	} // end curl error check
	
	
	
	$return_array = array('status' => $return_status,
						  'text' => $return_text,
						  'error' => $return_error);
	
	
	
	return $return_array;
}











// #################################### CARD REFUND SECTION #################################################





//  REFUND CARD REQUESTER ####
// #######################################################################
// #######################################################################
function dsf_wirecard_refund_request($orders_id=0, $refund_value=0){
	
	if ((int)$orders_id > 0){
			// we have an order number,  get the details to release.
			
			// get the info from the transaction database.
			$dsv_query = dsf_db_query("select payment_trans_id, capture_trans_id, released, txntype, trans_type from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $orders_id . "' and trans_type='1'");
			
			if (dsf_db_num_rows($dsv_query) == 1){
				// we only have one item therefore continue processing.
			
					$dsv_results = dsf_db_fetch_array($dsv_query);
							
			
					// two things to note here.
					
					// 1)   the refund function we are about to use has lots of error reporting in it however, one thing
					//      it does not have is error checking that we are sending the correct information to it in the first
					//      place.  we therefore need to take that into account here.
					
					// 2)   we are doing a while to produce a loop.  we could do a for and break but since we are in
					//      a function break might cause unexpected function closure.
					
					
					
					// the numbers we pass for a refund depend on whether or not the original transaction was a payment or capture type.
					
					$dsv_txntype = $dsv_results['txntype'];
					
					
					if (isset($dsv_results['capture_trans_id']) && strlen($dsv_results['capture_trans_id']) > 1){
						$dsv_transaction_type = 'capture';
						$dsv_parent_id = $dsv_results['capture_trans_id'];
						
					}else{
						// we don't have a capture value therefore this must be a purchase rather than authorise and capture.
						
						$dsv_transaction_type = 'purchase';
						$dsv_parent_id = $dsv_results['payment_trans_id'];
						
					}
					
					
					$dsv_amount = $refund_value;
					
					if (strlen($dsv_parent_id) < 1 || (float)$dsv_amount < 0.10){
						// we do not have sufficient information to proceed.
						$message = 'Order number ' . $orders_id . ' unable to run refund money function as values to send are: dsv_parent_id = ' . $dsv_parent_id . ' amount = ' . $dsv_amount;
						dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}elseif ((int)$dsv_results['released'] == 0 && $dsv_txntype == 'authorization'){
						
						// an authorisation / capture payment method where the capture has not been taken.
						
						$message = 'Order number ' . $orders_id . ' unable to run refund money as the money has not been taken values to send are: released = ' .$dsv_results['realeased'] . ' dsv_txntype = ' . $dsv_txntype . ' dsv_parent_id = ' . $dsv_results['dsv_parent_id'];
						dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}else{
						
						// we are still here therefore we have everything to do the call.
						
						// start the while
								$dsv_max_attempts = 3; // the maximum amount of times we are going to try and release the money
								$dsv_current_attempt = 1;
								$return_value = 'false'; // automatically set the return value here to false because if we break
														 // out the loop we would not know and therefore could not set it again.
														 // we use reverse logic,  if we break the loop we set it to true.
			
			
									
								
									$refund_money = dsf_wirecard_refund($orders_id, $dsv_transaction_type, $dsv_parent_id, $dsv_amount);
									
									if (isset($refund_money['status']) && $refund_money['status'] == 'success'){
										// we can break out the loop,  we have released the money  (capture)
										
										$return_value = 'true';
										$dsv_current_attempt = $dsv_max_attempts +1;  // create a break point by making current attempt larger than max
									
									} else{
									
										// add on to attempts.
										$dsv_current_attempt ++;
									}
									
						
						// at this point,  we have either managed to make a successfull refund or it hasn't work and we have tried
						// maximum times.  we already set the return value to false before the while so we don't need to do anymore error checking.
						
						
						
					}
			
			
			
			}else{
				// either more than one or no records found for transactions in the wirecard transaction database.
				// we need to notify someone of this error.
				$message = 'Order number ' . $orders_id . ' unable to refund money as ' . dsf_db_num_rows($dsv_query) . ' items found in transaction database';
				dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
				$return_value = 'false';
			}
	
	


	}else{
		// no order number
				$message = 'No order number passed to credit routine.';
				dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
		$return_value = 'false';
	}
	
return $return_value;
}












function dsf_wirecard_refund($orders_id, $dsv_transaction_type, $parent_transaction_id, $dsv_amount) {
	

// IMPORTANT THIS FUNCTION IS NEVER TO BE RUN DIRECTLY.
// RUN IT FROM A SCRIPT OR OTHER FUNCTION WHICH CHECKS THE ANSWER AND DECIDES IF IT IS A COMMUNICATION
// OR TERMINAL PROBLEM SO IT CAN TRY AGAIN.

// THE CALLING SCRIPT MUST ENSURE WE HAVE THE CORRECT THREE PARAMETERS REQUIRED OTHERWISE
// IT SHOULD NOT ATTEMPT TO RUN THIS FUNCTION.

   $return_status = '';
   $return_text = '';
   $return_error ='';


	$dsv_amount = number_format($dsv_amount,2,'.','');

	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $orders_id . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="creditcard"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	// $dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('parent-transaction-id',$parent_transaction_id);
	
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	if ($dsv_transaction_type == 'capture'){
		$dsv_wire_xml->dsXmlElement('transaction-type','refund-capture');
	}else{
		$dsv_wire_xml->dsXmlElement('transaction-type','refund-purchase');
	}

	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => DEFAULT_CURRENCY) );

	$dsv_wire_xml->dsXmlPop('payment');
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();


	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE PRETEND TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
//		$id = 'WC-REFUND-' . time();
//		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
//		fputs($fp, $dsv_xml_to_post);
//		fclose($fp);


	 $wire_request = dsf_wirecard_post(WIRECC_REFUND_URL , $dsv_xml_to_post);
	

	// if we have a curl error at this stage,  we cannot let the customer re-try we therefore have no alternative but to decline the order.
	
			if (isset($wire_request['curlerrno']) && (int)$wire_request['curlerrno'] > 0){
				// we have a curl error,  we cannot continue with the process.
				
					$write_notes = dsf_wirecard_shop_notes($orders_id, "Error communication issue" . $wire_request['curlerrno'] . $wire_request['curlerror'] . 'When doing refund');
					$return_status = 'failed';
					$return_text = 'Request ID ' . $dsv_wirecard_request_id . ' ERROR curl failed';
					$return_error = 'curl failed';
					
			}else{
				
				// start processing the data.
							
					$results = simplexml_load_string($wire_request['data']);
					
					
					
					
	
					$transaction_id = trim($results->{'transaction-id'});
					$transaction_state = trim($results->{'transaction-state'});
					$transaction_type = trim($results->{'transaction-type'});
					
					if (isset($results->{'authorization-code'})){
						$authorisation_code = trim($results->{'authorization-code'});
					}else{
						$authorisation_code = '';
					}
		
		
					if (isset($results->{'requested-amount'})){
						$returned_amount = (float)trim($results->{'requested-amount'});
					}else{
						$returned_amount = 0;
					}


					if (isset($results->{'card-token'}->{'token-id'})){
						$token_id = trim($results->{'card-token'}->{'token-id'});
					}else{
						$token_id ='';
					}
					


		// put all status codes into an array to work with.
		
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										
								 			$status_numbers[$status_code_value] = $status_code_text;
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										
								 		$status_numbers[$status_code_value] = $status_code_text;
						}

									
						$new_notes = '';
						reset($status_numbers);
						
						foreach($status_numbers as $id => $value){
							$new_notes .= $id . ' ' . $value . "\n";
						}
									

						if (strtolower($transaction_state) == 'success'	){


								// PRICE CHECK NEEDED HERE
								if ((float)$dsv_amount == (float)$returned_amount){
										// we are ok,  the amount requested is the amount refunded.
										
										
								}else{
										// we have a problem as the amount refunded does not match what we requested.
										
									$message = "Order number " . $orders_id . " Refund values do not match\nREQUEST ID" . $dsv_wirecard_request_id;
									dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
										
								}
								
									

								// success
								
								// advise the order that the money has been taken.
										$write_notes = dsf_wirecard_shop_notes($orders_id, "REFUND MONEY REQUEST SUCCESSFULL\nMESSAGE = " . $transaction_state . " : " . number_format($returned_amount, 2, '.', '') . "\nauthcode = " . $authorisation_code . "\nstatus = " . $new_notes);
										
								
								// mark the transactions that the money has been taken
																
										$sql_data_array = array('orders_id' => $orders_id,
																'orderid' => $orders_id,
																'amount' => $dsv_amount,
																'trans_type' => 3,
																'request_id' => $dsv_wirecard_request_id,
																'refund_trans_id' => $transaction_id,
																'token_id' => $token_id,
																'authorisation_code' => $authorisation_code,
																'txntype' => $transaction_type);
																
																
																
																
										$upt = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array);
								// advise calling function of success.
										$return_status = 'success';

								
							}else{
									
									$return_status = 'failed';
									$return_text = 'Request ID ' . $dsv_wirecard_request_id . ' ERROR ' . dsf_print_array($status_numbers);
									$return_error = 'capture failed';
									
									
									
								// put small error message into order regardless of which error status was above.
										$write_notes = dsf_wirecard_shop_notes($orders_id, "REFUND MONEY FAILED\nMESSAGE = " . $transaction_state . " : " . $dsv_amount . "\n" . $new_notes);
										
								
						}


	} // end curl error check
	
	
	
	$return_array = array('status' => $return_status,
						  'text' => $return_text,
						  'error' => $return_error);
	
	
	
	return $return_array;
}


// #################################### CARD REFUND SECTION COMPLETE #################################################





// #################################### SEPA DIRECT DEBIT SECTION #################################################


function dsf_wirecard_sepa_pending_debit($dsv_orderid, $dd_name, $dsv_iban, $dsv_bic, $dsv_amount, $savedorder){
	
   global $wirecard_attempts;



	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');
	$dsv_wirecard_mandate_id =  SAP_ORDER_PREFIX . $dsv_orderid;

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIREDD_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type','pending-debit');

	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => DEFAULT_CURRENCY) );

	$dsv_wire_xml->dsXmlPush('account-holder');

		$dsv_wire_xml->dsXmlElement('first-name',$savedorder->customer['firstname']);
		$dsv_wire_xml->dsXmlElement('last-name',$savedorder->customer['lastname']);
		$dsv_wire_xml->dsXmlElement('email',$savedorder->customer['email_address']);
		$dsv_wire_xml->dsXmlElement('phone',$savedorder->customer['telephone']);


		$dsv_wire_xml->dsXmlPush('address');

			$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->customer['house'] . ' ' . $savedorder->customer['street']));

			if (strlen($savedorder->customer['district']) > 1){
				$dsv_wire_xml->dsXmlElement('street2', $savedorder->customer['district']);
			}
			
			if (strlen($savedorder->customer['town']) > 1){
				$dsv_wire_xml->dsXmlElement('city', $savedorder->customer['town']);
			}
			
			if (strlen($savedorder->customer['county']) > 1){
				$dsv_wire_xml->dsXmlElement('state', $savedorder->customer['county']);
			}

				$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);

			if (strlen($savedorder->customer['postcode']) > 1){
				$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->customer['postcode']);
			}




		$dsv_wire_xml->dsXmlPop('address');

	$dsv_wire_xml->dsXmlPop('account-holder');
	
	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="sepadirectdebit"');
	$dsv_wire_xml->dsXmlPop('payment-methods');



	// delivery address is not part of sepa.
		

		$dsv_wire_xml->dsXmlPush('bank-account');
				$dsv_wire_xml->dsXmlElement('iban', $dsv_iban);
				$dsv_wire_xml->dsXmlElement('bic', $dsv_bic);
	$dsv_wire_xml->dsXmlPop('bank-account');
	
		$dsv_wire_xml->dsXmlPush('mandate');
				$dsv_wire_xml->dsXmlElement('mandate-id', $dsv_wirecard_mandate_id);
				$dsv_wire_xml->dsXmlElement('signed-date', date("Y-m-d" , time()));
	$dsv_wire_xml->dsXmlPop('mandate');
	
	
	
	$dsv_wire_xml->dsXmlElement('creditor-id', MODULE_PAYMENT_WIREDD_CREDITOR_ID);


	$dsv_wire_xml->dsXmlElement('ip-address', substr(dsf_get_ip_address_nonproxy(),0,15));
	$dsv_wire_xml->dsXmlElement('order-number',SAP_ORDER_PREFIX . $dsv_orderid);
	$dsv_wire_xml->dsXmlElement('descriptor',SAP_ORDER_PREFIX . $dsv_orderid);


	
	$dsv_wire_xml->dsXmlPop('payment');
	
	
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();



// make a record in the wirecard_responses table.

		$sql_data_array = array('orders_id' => $dsv_orderid,
								'orderid' => $dsv_wirecard_mandate_id,
								'amount' => $dsv_amount,
								'trans_type' => 2,
								'txntype' => 'pending-debit',
								'request_id' => $dsv_wirecard_request_id);
								
		// save it
		
			$prev_item = dsf_db_query("select token_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "' and trans_type='2'");
			
			if (dsf_db_num_rows($prev_item) == 0){
				// this is a new attempt therefore we a new record
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array);
			}else{
				// we have already attempted this order before and it must have failed - update with new details.
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $dsv_orderid . "' and trans_type='2'");
				
			}
			

	// $response = $dsv_xml_to_post;

	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE FALSE TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
			// save a copy of this file before sending it.
//		$id = 'WC-DD-' . time();
//		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
//		fputs($fp, $dsv_xml_to_post);
//		fclose($fp);

	
// post the xml created and return back to the requesting script.

	 $response = dsf_wirecard_post(WIREDD_PURCHASE_URL , $dsv_xml_to_post, 'sepa');
	
return $response;

}


	
	
	

// #################################### SEPA DIRECT DEBIT SECTION COMPLETE #################################################







// #################################### PAYPAL SECTION #################################################


function dsf_wirecard_paypal_request($dsv_orderid, $dsv_amount, $savedorder){
	
   global $wirecard_attempts;



	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $dsv_orderid . '--' . date('YmdHis');
	
	$dsv_enc_wirecard_request_id = dsf_md5_long_encrypt($dsv_wirecard_request_id);
	

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIREPP_MERCHANT);
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	$dsv_wire_xml->dsXmlElement('transaction-type',MODULE_PAYMENT_WIREPP_TXTYPE);

	
	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="paypal"');
	$dsv_wire_xml->dsXmlPop('payment-methods');


	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => DEFAULT_CURRENCY) );

// temp override because wirecard is not setup for GBP
//	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => str_replace("GBP" , "EUR" , DEFAULT_CURRENCY)) );

	$dsv_wire_xml->dsXmlPush('account-holder');

		$dsv_wire_xml->dsXmlElement('first-name',$savedorder->customer['firstname']);
		$dsv_wire_xml->dsXmlElement('last-name',$savedorder->customer['lastname']);
		$dsv_wire_xml->dsXmlElement('email',$savedorder->customer['email_address']);
		$dsv_wire_xml->dsXmlElement('phone',$savedorder->customer['telephone']);


		$dsv_wire_xml->dsXmlPush('address');

			$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->customer['house'] . ' ' . $savedorder->customer['street']));

			if (strlen($savedorder->customer['district']) > 1){
				$dsv_wire_xml->dsXmlElement('street2', $savedorder->customer['district']);
			}
			
			if (strlen($savedorder->customer['town']) > 1){
				$dsv_wire_xml->dsXmlElement('city', $savedorder->customer['town']);
			}
			
			if (strlen($savedorder->customer['county']) > 1){
				$dsv_wire_xml->dsXmlElement('state', $savedorder->customer['county']);
			}

				$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);

			if (strlen($savedorder->customer['postcode']) > 1){
				$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->customer['postcode']);
			}




		$dsv_wire_xml->dsXmlPop('address');

	$dsv_wire_xml->dsXmlPop('account-holder');


	// delivery address if exists.
		if (isset($savedorder->delivery['postcode']) && strlen($savedorder->delivery['postcode'])>4){ // delivery address exists
	
					$dsv_wire_xml->dsXmlPush('shipping');
					
					
														if (strpos($savedorder->delivery['name'],' ') > 0){
																$splits = explode(' ', trim($savedorder->delivery['name']));
																// take into account that the customer could have put mr, mrs etc..  therefore use only the last two splits
																$total_splits = sizeof($splits);
																
																if ($total_splits > 1){
																		$first_split = $total_splits - 2;
																		$second_split = $total_splits -1;
																}else{
																		$first_split = 0;
																		$second_split = 1;
																}
																
																
																$Delivery_Firstnames = $splits[$first_split];
																$Delivery_Surname = $splits[$second_split];
																
														}else{
															// no breaks,  ensure something is there
															
																$Delivery_Surname = $savedorder->customer['name'];
																$Delivery_Firstnames = $savedorder->customer['name'];
														}
					
					
					
						$dsv_wire_xml->dsXmlElement('first-name',$Delivery_Firstnames);
						$dsv_wire_xml->dsXmlElement('last-name',$Delivery_Surname);
					
						$dsv_wire_xml->dsXmlPush('address');
				
							$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->delivery['house'] . ' ' . $savedorder->delivery['street']));
				
							if (strlen($savedorder->delivery['district']) > 1){
								$dsv_wire_xml->dsXmlElement('street2', $savedorder->delivery['district']);
							}
							
							if (strlen($savedorder->delivery['town']) > 1){
								$dsv_wire_xml->dsXmlElement('city', $savedorder->delivery['town']);
							}
							
							if (strlen($savedorder->delivery['county']) > 1){
								$dsv_wire_xml->dsXmlElement('state', $savedorder->delivery['county']);
							}
				
								$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);
				
							if (strlen($savedorder->delivery['postcode']) > 1){
								$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->delivery['postcode']);
							}
				
						$dsv_wire_xml->dsXmlPop('address');
					
					$dsv_wire_xml->dsXmlPop('shipping');
	
		}else{
			
			// we need to send a delivery address regardless therefore we send the billing address again as the delivery address.
			

					$dsv_wire_xml->dsXmlPush('shipping');
				
						$dsv_wire_xml->dsXmlElement('first-name',$savedorder->customer['firstname']);
						$dsv_wire_xml->dsXmlElement('last-name',$savedorder->customer['lastname']);
				
				
						$dsv_wire_xml->dsXmlPush('address');
				
							$dsv_wire_xml->dsXmlElement('street1', trim($savedorder->customer['house'] . ' ' . $savedorder->customer['street']));
				
							if (strlen($savedorder->customer['district']) > 1){
								$dsv_wire_xml->dsXmlElement('street2', $savedorder->customer['district']);
							}
							
							if (strlen($savedorder->customer['town']) > 1){
								$dsv_wire_xml->dsXmlElement('city', $savedorder->customer['town']);
							}
							
							if (strlen($savedorder->customer['county']) > 1){
								$dsv_wire_xml->dsXmlElement('state', $savedorder->customer['county']);
							}
				
								$dsv_wire_xml->dsXmlElement('country', CONTENT_COUNTRY);
				
							if (strlen($savedorder->customer['postcode']) > 1){
								$dsv_wire_xml->dsXmlElement('postal-code', $savedorder->customer['postcode']);
							}
				
						$dsv_wire_xml->dsXmlPop('address');
				
					$dsv_wire_xml->dsXmlPop('shipping');
			
		}
		


	$dsv_wire_xml->dsXmlElement('ip-address', substr(dsf_get_ip_address_nonproxy(),0,15));
	$dsv_wire_xml->dsXmlElement('order-number',SAP_ORDER_PREFIX . $dsv_orderid);
	$dsv_wire_xml->dsXmlElement('descriptor',SAP_ORDER_PREFIX . $dsv_orderid);

	
	$dsv_wire_xml->dsXmlElement('success-redirect-url', dsf_href_link('checkout_success.html', 'payment=wirecard&order_id=' . $dsv_orderid, 'SSL'));
	$dsv_wire_xml->dsXmlElement('cancel-redirect-url',dsf_href_link('checkout_failed.html', 'payment=wirecard&order_id=' . $dsv_orderid, 'SSL'));
	$dsv_wire_xml->dsXmlElement('fail-redirect-url',dsf_href_link('checkout_failed.html', 'payment=wirecard&order_id=' . $dsv_orderid, 'SSL'));

	$dsv_wire_xml->dsXmlPush('notifications');
		$dsv_wire_xml->dsXmlHeaderPushSingle('notification','url="' . dsf_href_link('wc_notification_' . $dsv_enc_wirecard_request_id . '.html', '', 'SSL') . '"');
	$dsv_wire_xml->dsXmlPop('notifications');
	
	$dsv_wire_xml->dsXmlPop('payment');
	
	
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();



// make a record in the wirecard_responses table.

		$sql_data_array = array('orders_id' => $dsv_orderid,
								'orderid' => $dsv_wirecard_mandate_id,
								'amount' => $dsv_amount,
								'trans_type' => 6,
								'card_type' => 'paypal',
								'txntype' => MODULE_PAYMENT_WIREPP_TXTYPE,
								'request_id' => $dsv_wirecard_request_id);
								
		// save it
		
			$prev_item = dsf_db_query("select token_id from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $dsv_orderid . "' and trans_type='6'");
			
			if (dsf_db_num_rows($prev_item) == 0){
				// this is a new attempt therefore we a new record
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array);
			}else{
				// we have already attempted this order before and it must have failed - update with new details.
					$sve = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array, "update" , "orders_id='" . $dsv_orderid . "' and trans_type='6'");
				
			}
			

	// $response = $dsv_xml_to_post;

	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE FALSE TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
			// save a copy of this file before sending it.
		$id = 'WC-PP-' . time();
		$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
		fputs($fp, $dsv_xml_to_post);
		fclose($fp);

	
// post the xml created and return back to the requesting script.

	 $response = dsf_wirecard_post(WIREPP_PURCHASE_URL , $dsv_xml_to_post, 'paypal');
	
return $response;

}


	
	
	


// #################################### PAYPAL REFUND SECTION #################################################

// this could have been written into the card one to be dynamic to work with cards and paypal like the capture however due to major delays
// due to problems with the paypal capture routines, this project is well behind and impacting on other items.
// it has therefore been written as a separate item so it can be debugged quickly.




//  REFUND PAYPAL REQUESTER ####
// #######################################################################
// #######################################################################
function dsf_wirecard_paypal_refund_request($orders_id=0, $refund_value=0){
	
	if ((int)$orders_id > 0){
			// we have an order number,  get the details to release.
			
			// get the info from the transaction database.
			$dsv_query = dsf_db_query("select payment_trans_id, capture_trans_id, released, txntype, trans_type from " . DS_DB_SHOP . ".wirecard_responses where orders_id='" . $orders_id . "' and trans_type='6'");
			
			if (dsf_db_num_rows($dsv_query) == 1){
				// we only have one item therefore continue processing.
			
					$dsv_results = dsf_db_fetch_array($dsv_query);
							
			
					// two things to note here.
					
					// 1)   the refund function we are about to use has lots of error reporting in it however, one thing
					//      it does not have is error checking that we are sending the correct information to it in the first
					//      place.  we therefore need to take that into account here.
					
					// 2)   we are doing a while to produce a loop.  we could do a for and break but since we are in
					//      a function break might cause unexpected function closure.
					
					
					
					// the numbers we pass for a refund depend on whether or not the original transaction was a payment or capture type.
					
					$dsv_txntype = $dsv_results['txntype'];
					
					
					if (isset($dsv_results['capture_trans_id']) && strlen($dsv_results['capture_trans_id']) > 1){
						$dsv_transaction_type = 'capture';
						$dsv_parent_id = $dsv_results['capture_trans_id'];
						
					}else{
						// we don't have a capture value therefore this must be a purchase rather than authorise and capture.
						
						$dsv_transaction_type = 'debit';
						$dsv_parent_id = $dsv_results['payment_trans_id'];
						
					}
					
					
					$dsv_amount = $refund_value;
					
					if (strlen($dsv_parent_id) < 1 || (float)$dsv_amount < 0.10){
						// we do not have sufficient information to proceed.
						$message = 'Order number ' . $orders_id . ' unable to run refund money function as values to send are: dsv_parent_id = ' . $dsv_parent_id . ' amount = ' . $dsv_amount;
						dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}elseif ((int)$dsv_results['released'] == 0 && $dsv_txntype == 'authorization'){
						
						// an authorisation / capture payment method where the capture has not been taken.
						
						$message = 'Order number ' . $orders_id . ' unable to run refund money as the money has not been taken values to send are: released = ' .$dsv_results['realeased'] . ' dsv_txntype = ' . $dsv_txntype . ' dsv_parent_id = ' . $dsv_results['dsv_parent_id'];
						dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}else{
						
						// we are still here therefore we have everything to do the call.
						
						// start the while
								$dsv_max_attempts = 1; // the maximum amount of times we are going to try and release the money
								$dsv_current_attempt = 1;
								$return_value = 'false'; // automatically set the return value here to false because if we break
														 // out the loop we would not know and therefore could not set it again.
														 // we use reverse logic,  if we break the loop we set it to true.
			
			
								
									$refund_money = dsf_wirecard_paypal_refund($orders_id, $dsv_transaction_type, $dsv_parent_id, $dsv_amount);
									
									if (isset($refund_money['status']) && $refund_money['status'] == 'success'){
										// we can break out the loop,  we have released the money  (capture)
										
										$return_value = 'true';
										$dsv_current_attempt = $dsv_max_attempts +1;  // create a break point by making current attempt larger than max
									
									} else{
									
										// add on to attempts.
										$dsv_current_attempt ++;
									}
									
						
						// at this point,  we have either managed to make a successfull refund or it hasn't work and we have tried
						// maximum times.  we already set the return value to false before the while so we don't need to do anymore error checking.
						
						
						
					}
			
			
			
			}else{
				// either more than one or no records found for transactions in the wirecard transaction database.
				// we need to notify someone of this error.
				$message = 'Order number ' . $orders_id . ' unable to refund money as ' . dsf_db_num_rows($dsv_query) . ' items found in transaction database';
				dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
				$return_value = 'false';
			}
	
	


	}else{
		// no order number
				$message = 'No order number passed to credit routine.';
				dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
		$return_value = 'false';
	}
	
return $return_value;
}












function dsf_wirecard_paypal_refund($orders_id, $dsv_transaction_type, $parent_transaction_id, $dsv_amount) {
	

// IMPORTANT THIS FUNCTION IS NEVER TO BE RUN DIRECTLY.
// RUN IT FROM A SCRIPT OR OTHER FUNCTION WHICH CHECKS THE ANSWER AND DECIDES IF IT IS A COMMUNICATION
// OR TERMINAL PROBLEM SO IT CAN TRY AGAIN.

// THE CALLING SCRIPT MUST ENSURE WE HAVE THE CORRECT THREE PARAMETERS REQUIRED OTHERWISE
// IT SHOULD NOT ATTEMPT TO RUN THIS FUNCTION.

   $return_status = '';
   $return_text = '';
   $return_error ='';


	$dsv_amount = number_format($dsv_amount,2,'.','');

	$dsv_wirecard_request_id =  SAP_ORDER_PREFIX  . $orders_id . '--' . date('YmdHis');

	// build the request
	
	$dsv_wire_xml = new dsXmlBuilder;
	
	$dsv_wire_xml->dsXmlHeaderPush('payment','xmlns="http://www.elastic-payments.com/schema/payment"');

	$dsv_wire_xml->dsXmlPush('payment-methods');
		$dsv_wire_xml->dsXmlHeaderPushSingle('payment-method','name="paypal"');
	$dsv_wire_xml->dsXmlPop('payment-methods');

	// $dsv_wire_xml->dsXmlElement('merchant-account-id',MODULE_PAYMENT_WIRECC_MERCHANT);
	$dsv_wire_xml->dsXmlElement('parent-transaction-id',$parent_transaction_id);
	
	$dsv_wire_xml->dsXmlElement('request-id',$dsv_wirecard_request_id);

	if ($dsv_transaction_type == 'capture'){
		$dsv_wire_xml->dsXmlElement('transaction-type','refund-capture');
	}else{
		$dsv_wire_xml->dsXmlElement('transaction-type','refund-debit');
	}

	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => DEFAULT_CURRENCY) );
// temp override because wirecard is not setup for GBP
//	$dsv_wire_xml->dsXmlElement('requested-amount',$dsv_amount, array('currency' => str_replace("GBP" , "EUR" , DEFAULT_CURRENCY)) );

	$dsv_wire_xml->dsXmlPop('payment');
	
	
// generate the xml to send.
	$dsv_xml_to_post = $dsv_wire_xml->dsXmlGetXML();


	// save a copy of the XML we are about to post -  	THIS IS ONLY DURING INTEGRATION TESTING AND MUST BE REMOVED
	//													BECAUSE IT CONTAINS CARD DETAILS.  THIS IS FINE WHEN WE ARE
	//													USING THE PRETEND TEST CARD NUMBERS AND IS SOLELY SO WE CAN
	//													CHECK WHAT XML WE ARE CREATING AND PASSING TO WIRECARD WITHOUT
	//													ECHOING TO THE SCREEN BREAKING THE SMOOTH TRANSACTION FLOW.
	
	//	$id = 'WC-REFUND-' . time();
	//	$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
	//	fputs($fp, $dsv_xml_to_post);
	//	fclose($fp);


	 $wire_request = dsf_wirecard_post(WIREPP_REFUND_URL , $dsv_xml_to_post, 'paypal');
	

	// if we have a curl error at this stage,  we cannot let the customer re-try we therefore have no alternative but to decline the order.
	
			if (isset($wire_request['curlerrno']) && (int)$wire_request['curlerrno'] > 0){
				// we have a curl error,  we cannot continue with the process.
				
					$write_notes = dsf_wirecard_shop_notes($orders_id, "Error communication issue" . $wire_request['curlerrno'] . $wire_request['curlerror'] . 'When doing refund');
					$return_status = 'failed';
					$return_text = 'Request ID ' . $dsv_wirecard_request_id . ' ERROR curl failed';
					$return_error = 'curl failed';
					
			}else{
				
				// start processing the data.
							
					$results = simplexml_load_string($wire_request['data']);
					
	
					$transaction_id = trim($results->{'transaction-id'});
					$transaction_state = trim($results->{'transaction-state'});
					$transaction_type = trim($results->{'transaction-type'});
					
					if (isset($results->{'authorization-code'})){
						$authorisation_code = trim($results->{'authorization-code'});
					}else{
						$authorisation_code = '';
					}
		
		
					if (isset($results->{'requested-amount'})){
						$returned_amount = (float)trim($results->{'requested-amount'});
					}else{
						$returned_amount = 0;
					}


					if (isset($results->{'card-token'}->{'token-id'})){
						$token_id = trim($results->{'card-token'}->{'token-id'});
					}else{
						$token_id ='';
					}
					


		// put all status codes into an array to work with.
		
						if (count($results->statuses->status) > 1 ){
							foreach($results->statuses->status as $status){
								
									if (strlen($status->attributes()->code) > 0){
										$status_code_value = trim($status->attributes()->code);
										$status_code_text = trim($status->attributes()->description);
										
								 			$status_numbers[$status_code_value] = $status_code_text;
									}
							}
							
						}else{
							
										$status_code_value = trim($results->statuses->status->attributes()->code);
										$status_code_text = trim($results->statuses->status->attributes()->description);
										
								 		$status_numbers[$status_code_value] = $status_code_text;
						}

									
						$new_notes = '';
						reset($status_numbers);
						
						foreach($status_numbers as $id => $value){
							$new_notes .= $id . ' ' . $value . "\n";
						}
									

						if (strtolower($transaction_state) == 'success'	){


								// PRICE CHECK NEEDED HERE
								if ((float)$dsv_amount == (float)$returned_amount){
										// we are ok,  the amount requested is the amount refunded.
										
										
								}else{
										// we have a problem as the amount refunded does not match what we requested.
										
									$message = "Order number " . $orders_id . " Refund values do not match\nREQUEST ID" . $dsv_wirecard_request_id;
									dsf_send_email('Wirecard Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Wirecard Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
										
								}
								
									

								// success
								
								// advise the order that the money has been taken.
										$write_notes = dsf_wirecard_shop_notes($orders_id, "REFUND MONEY REQUEST SUCCESSFULL\nMESSAGE = " . $transaction_state . " : " . number_format($returned_amount, 2, '.', '') . "\nauthcode = " . $authorisation_code . "\nstatus = " . $new_notes);
										
								
								// mark the transactions that the money has been taken
																
										$sql_data_array = array('orders_id' => $orders_id,
																'orderid' => $orders_id,
																'amount' => $dsv_amount,
																'trans_type' => 7,
																'request_id' => $dsv_wirecard_request_id,
																'refund_trans_id' => $transaction_id,
																'token_id' => $token_id,
																'authorisation_code' => $authorisation_code,
																'txntype' => $transaction_type);
																
																
																
																
										$upt = dsf_db_perform(DS_DB_SHOP . '.wirecard_responses' , $sql_data_array);
								// advise calling function of success.
										$return_status = 'success';

								
							}else{
									
									$return_status = 'failed';
									$return_text = 'Request ID ' . $dsv_wirecard_request_id . ' ERROR ' . dsf_print_array($status_numbers);
									$return_error = 'capture failed';
									
									
									
								// put small error message into order regardless of which error status was above.
										$write_notes = dsf_wirecard_shop_notes($orders_id, "REFUND MONEY FAILED\nMESSAGE = " . $transaction_state . " : " . $dsv_amount . "\n" . $new_notes);
										
								
						}


	} // end curl error check
	
	
	
	$return_array = array('status' => $return_status,
						  'text' => $return_text,
						  'error' => $return_error);
	
	
	
	return $return_array;
}


// #################################### PAYPAL REFUND SECTION COMPLETE #################################################

















// #################################### PAYPAL SECTION COMPLETE #################################################


function dsf_md5_long_encrypt($text) {
	// standard encryption key being used just to make even the same values return a different encryption key
	$enc_value = 'Sta53One';
	
	// the idea is to return a 64 digit value which has the md5 value of the text embedded within it.
	// dsf_md5_long_decrypt will extract the single md5 value
	// there is no actual decryption it just returns its md5 for validation elsewhere. 
	
	$value_one = dsf_md5_encrypt($text, $enc_value);
	$value_two = md5($text);
	$value_three = md5($value_one);

	// mix text up
	
	$strip_a_one = substr($value_two , 0 , 7);
	$strip_a_two =	substr($value_two , 7 , 12);
	$strip_a_three = substr($value_two , 19);
	
	
	$strip_b_one = substr($value_three , 0 , 11);
	$strip_b_two =	substr($value_three , 11 , 10);
	$strip_b_three = substr($value_three , 21);


	// put it back together in 64 length text
	$new_string = $strip_b_one . $strip_a_three . $strip_a_one . $strip_b_two .  $strip_b_three . $strip_a_two;
	
	return ($new_string);
	
}


function dsf_md5_long_decrypt($text) {
	
	$strip_a_one = substr($text , 24 , 7);
	$strip_a_two =	substr($text , 52 , 12);
	$strip_a_three = substr($text , 11, 13);
	
	$new_string = $strip_a_one . $strip_a_two . $strip_a_three;
	
	return ($new_string);
	
}


	?>