<?php
 // Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



 
 // GENERATE MONTRADA USERNAME AND PASSWORD FIELD FROM DATABASE.
 
 define('MONTRADA_CARD_USER' , MODULE_PAYMENT_MONTRADACC_USER_ID . ':' . MODULE_PAYMENT_MONTRADACC_PASSWORD);
 
 define('MONTRADA_DEBIT_USER' , MODULE_PAYMENT_MONTRADADD_USER_ID . ':' . MODULE_PAYMENT_MONTRADADD_PASSWORD);
 
  
  // URLS TO PASS DATA TO
  
  define('MODULE_PAYMENT_MONTRADACC_URL' , 'https://posh.montrada.de/posh/cmd/posh/tpl/txn_result.tpl');
  define('MODULE_PAYMENT_MONTRADADD_URL' , 'https://posh.montrada.de/posh/cmd/posh/tpl/txn_result.tpl');
  
  

// TEST CARD NUMBERS

//  4012001038443335  any cvcode, any future expiry date
//  5204740000001002  any cvcode, any future expiry date
//  5204740000001135  (always denied with rc=005)
//  4012001036983332  (last two digits from 'amount' control 'rc' in response)

// 3750 0000 0000 007 AMEX  expire upto 12/2011

  
// TEST BANK
// sortcode:  50080000
// account number:12345678



// #######################################################################
// #######################################################################
// ##### PROCESS A CARD TRANSACTION AND RETURN THE RESPONSE AS AN ARRAY ####
  
  function dsf_montradaCard($dsv_orderid, $dsv_creditc, $dsv_expmonth, $dsv_expyear, $dsv_cv_code, $dsv_amount){

   global $montrada_attempts;
	
	
	// we need unique numbers therefore we will add the attempts to the end of the order number
	
	// additionally, we need to prefix the order number with Country and Brand for the Accounts department in Germany
			
	$ext = dsf_format_fixed_length($montrada_attempts, 3, 'right' ,'0');
	$dsv_order_number =  SAP_ORDER_PREFIX . $dsv_orderid . '.' . $ext;
	
	
	// amount needs to be sent without decimals therefore we format accordingly.
	$dsv_amount = number_format(($dsv_amount * 100) , 0 ,'','');
	
	// endsure there are no spaces in the card number
	$dsv_creditc = str_replace(array(" ","-") , '' , $dsv_creditc);
	
	// format the expiry date accordingly
	
	$dsv_expdat = dsf_format_fixed_length($dsv_expyear, 2, 'right' ,'0') . dsf_format_fixed_length($dsv_expmonth, 2, 'right' ,'0');
	
	
	//set up the curl

    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, MODULE_PAYMENT_MONTRADACC_URL);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, MONTRADA_CARD_USER);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'orderid=' . $dsv_order_number . 
										 '&command=' . MODULE_PAYMENT_MONTRADACC_TXTYPE . 
										 '&creditc=' . $dsv_creditc .  
										 '&expdat=' . $dsv_expdat . 
										 '&cvcode=' . $dsv_cv_code . 
										 '&currency=' . DEFAULT_CURRENCY .
										 '&amount=' . $dsv_amount);
	$response = curl_exec($ch);
    $curlError = curl_error($ch);
    $curlErno = curl_errno($ch);
    curl_close($ch);
	
	// montrada attempts needs to add one for counter 
						$montrada_attempts ++;
	// re-save the session variable.
						dsf_session_unregister('montrada_attempts');
						dsf_session_register('montrada_attempts');
	
	
	// strip any details in the response and put it into an array
	$response_array = dsf_processMontradaReturn($response);
	
	// now make a new array with both this response and any curl errors
	// that way if we have nothing in response_array we can see why.
	
	$return_array = array('error_number' => $curlErno,
						  'error_text' => $curlError,
						  'response' => $response_array);
						  
	
	return $return_array;
	
}


// #######################################################################
// #######################################################################
// PROCESS A DIRECT DEBIT TRANSACTION AND REURN THE RSPONSE AS AN ARRAY
  
  function dsf_montradaBank($dsv_orderid, $dsv_cname, $dsv_bankcode, $dsv_account, $dsv_amount){
    global $montrada_attempts;
    
	// we need unique numbers therefore we will add the attempts to the end of the order number
	
	// additionally, we need to prefix the order number with Country and Brand for the Accounts department in Germany
			
	$ext = dsf_format_fixed_length($montrada_attempts, 3, 'right' ,'0');
	$dsv_order_number =  SAP_ORDER_PREFIX . $dsv_orderid . '.' . $ext;
	
	
	// amount needs to be sent without decimals therefore we format accordingly.
	$dsv_amount = number_format(($dsv_amount * 100) , 0 ,'','');
	
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, MODULE_PAYMENT_MONTRADADD_URL);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, MONTRADA_DEBIT_USER);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'orderid=' . $dsv_order_number . 
										 '&command=' . MODULE_PAYMENT_MONTRADADD_TXTYPE . 
										 '&cname=' . $dsv_cname .  
										 '&bankcode=' . $dsv_bankcode . 
										 '&account=' . $dsv_account . 
										 '&currency=' . DEFAULT_CURRENCY .
										 '&amount=' . $dsv_amount);
	$response = curl_exec($ch);
    $curlError = curl_error($ch);
    $curlErno = curl_errno($ch);
    curl_close($ch);
	
	// montrada attempts needs to add one for counter 
						$montrada_attempts ++;
	// re-save the session variable.
						dsf_session_unregister('montrada_attempts');
						dsf_session_register('montrada_attempts');
	
	// strip any details in the response and put it into an array
	$response_array = dsf_processMontradaReturn($response);
	
	// now make a new array with both this response and any curl errors
	// that way if we have nothing in response_array we can see why.
	
	$return_array = array('error_number' => $curlErno,
						  'error_text' => $curlError,
						  'response' => $response_array);
						  
	
	return $return_array;
	
}



//  CAPTURE CARD DETAILS  REQUESTER ####
// #######################################################################
// #######################################################################
function dsf_montrada_capture_request($orders_id){
	
	if ((int)$orders_id > 0){
			// we have an order number,  get the details to release.
			
			// get the info from the transaction database.
			$dsv_query = dsf_db_query("select trefnum, amount, released, trans_type from " . DS_DB_SHOP . ".montrada_responses where orders_id='" . $orders_id . "' and trans_type='1'");
			
			if (dsf_db_num_rows($dsv_query) == 1){
				// we only have one item therefore continue processing.
			
					$dsv_results = dsf_db_fetch_array($dsv_query);
							
			
					// two things to note here.
					
					// 1)   the catpute function we are about to use has lots of error reporting in it however, one thing
					//      it does not have is error checking that we are sending the correct information to it in the first
					//      place.  we therefore need to take that into account here.
					
					// 2)   we are doing a while to produce a loop.  we could do a for and break but since we are in
					//      a function break might cause unexpected function closure.
					
					$dsv_trefnum = $dsv_results['trefnum'];
					$dsv_amount = $dsv_results['amount'];
					
					if (strlen($dsv_trefnum) < 1 || (float)$dsv_amount < 0.10){
						// we do not have sufficient information to proceed.
						$message = 'Order number ' . $orders_id . ' unable to run capture money function as values to send are: trefnum = ' . $dsv_trefnum . ' amount = ' . $dsv_amount;
						dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}elseif ((int)$dsv_results['realeased'] == 1  || (int)$dsv_results['trans_type'] <> 1){
						
						// already released or not a card transaction
						
						$message = 'Order number ' . $orders_id . ' unable to run capture money function as values to send are: released = ' .$dsv_results['realeased'] . ' trans_type = ' . $dsv_results['trans_type'];
						dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}else{
						
						// we are still here therefore we have everything to do the call.
						
						// start the while
								$dsv_max_attempts = 3; // the maximum amount of times we are going to try and release the money
								$dsv_current_attempt = 1;
								$return_value = 'false'; // automatically set the return value here to false because if we break
														 // out the loop we would not know and therefore could not set it again.
														 // we use reverse logic,  if we break the loop we set it to true.
			
			
								while ($dsv_current_attempt <= $dsv_max_attempts) {
									
								
									$capture_money = dsf_montrada_capture($orders_id, $dsv_trefnum, $dsv_amount);
									
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
						
						
						
					}
			
			
			
			}else{
				// either more than one or no records found for transactions in the montrada transaction database.
				// we need to notify someone of this error.
				$message = 'Order number ' . $orders_id . ' unable to capture money as ' . dsf_db_num_rows($dsv_query) . ' items found in transaction database';
				dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Capture Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
				$return_value = 'false';
			}
	
	


	}else{
		// no order number
		$return_value = 'false';
	}
	
return $return_value;
}



//  CAPTURE CARD DETAILS  (release money from shadow / preauth) ####
// #######################################################################
// #######################################################################

function dsf_montrada_capture($order_id, $dsv_trefnum, $dsv_amount){
   
// IMPORTANT THIS FUNCTION IS NEVER TO BE RUN DIRECTLY.
// RUN IT FROM A SCRIPT OR OTHER FUNCTION WHICH CHECKS THE ANSWER AND DECIDES IF IT IS A COMMUNICATION
// OR TERMINAL PROBLEM SO IT CAN TRY AGAIN.

// The montrada system only has one terminal, this means that there is a good chance the first.
// attempt will not work.   The script calling this function needs to take that into consideration
// and try again.   

// THE CALLING SCRIPT MUST ENSURE WE HAVE THE CORRECT THREE PARAMETERS REQUIRED OTHERWISE
// IT SHOULD NOT ATTEMPT TO RUN THIS FUNCTION.

   
   $return_status = '';
   $return_text = '';
   $return_error ='';
   
    
	// amount needs to be sent without decimals therefore we format accordingly.
	$dsv_amount = number_format(($dsv_amount * 100) , 0 ,'','');
	
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, MODULE_PAYMENT_MONTRADACC_URL);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, MONTRADA_CARD_USER);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'command=capture' . 
										  '&trefnum=' . $dsv_trefnum . 
										  '&amount=' . $dsv_amount);
	$response = curl_exec($ch);
    $curlError = curl_error($ch);
    $curlErno = curl_errno($ch);
    curl_close($ch);
	
	if ($curlErno > 0){
		$return_status = 'failed';
		$return_text = 'Curl Failed error: ' . $curlErno . ' text: ' . $curlError;
		
	}else{
		// we should have something returned,  pass it through the return splitter and contintue
		
	// strip any details in the response and put it into an array
	$response_array = dsf_processMontradaReturn($response);
	
	//now check through the values to make sure we have something.
		
							if (isset($response_array['posherr'])){
									$dsv_Retposherr = $response_array['posherr'];
							}else{
									$dsv_Retposherr = '';
							}
							
							if (isset($response_array['rc'])){
									$dsv_Retrc = $response_array['rc'];
							}else{
									$dsv_Retrc = '';
							}
							
							if (isset($response_array['amount'])){
									$dsv_Retamount = $response_array['amount'];
							}else{
									$dsv_Retamount = '';
							}

							if (isset($response_array['trefnum'])){
									$dsv_Rettrefnum = $response_array['trefnum'];
							}else{
									$dsv_Rettrefnum = '';
							}

							if (isset($response_array['rmsg'])){
									$dsv_Retrmsg = $response_array['rmsg'];
							}else{
									$dsv_Retrmsg = '';
							}

							if (isset($response_array['retrefnr'])){
									$dsv_Retretrefnr = $response_array['retrefnr'];
							}else{
									$dsv_Retretrefnr = '';
							}

							if (isset($response_array['trefnum'])){
									$dsv_Rettrefnum = $response_array['trefnum'];
							}else{
									$dsv_Rettrefnum = '';
							}






						  
		// the two main items we are looking for here is dsv_Retposherr and dsv_Retrc
							if ($dsv_Retposherr == '0' && $dsv_Retrc == '000'){

								// success
								
								// advise the order that the money has been taken.
										$write_notes = dsf_montrada_shop_notes($order_id, "CAPURE MONEY REQUEST SUCCESSFULL\nMESSAGE = " . $dsv_Retrmsg . "\nretrefnr = " . $dsv_Retretrefnr . "\ntrefnum = " . $dsv_Rettrefnum);
								
								// mark the transactions that the money has been taken
										$sql_data_array = array('released_trefnum' => $dsv_Rettrefnum,
																'released' => 1);
										$upt = dsf_db_perform(DS_DB_SHOP . '.montrada_responses' , $sql_data_array , "update" , "trefnum = '" . $dsv_trefnum . "'");
								// advise calling function of success.
										$return_status = 'success';
										
								
								
							}else{
								// we have a failure.   the only important failure that we want to trap
								// is the terminal busy / error ones.   all other failure need to be reported on
								// and require further investigation.
								if ($dsv_Retposherr == '9001' || $dsv_Retposherr == '9901'|| $dsv_Retrc == '096'){
									
									// with this failure we return a specific value in the return_error variable which the
									// calling script can use to decide whether or not to try again.
									
									$return_status = 'failed';
									$return_text = 'Trefnum ' . $dsv_trefnum . ' ERROR ' . dsf_print_array($response_array);
									$return_error = 'terminal failed';
									
									
								}else{
									// there could be lots of reasons why this has not worked. the best thing is to send
									// them to us and we can review and amend programming where necessary to compensate.
									$return_status = 'failed';
									$return_text = 'Trefnum ' . $dsv_trefnum . ' ERROR ' . dsf_print_array($response_array);
									$return_error = 'unknown';
										
									
									
								}
								
								// put small error message into order regardless of which error status was above.
										$write_notes = dsf_montrada_shop_notes($order_id, "CAPURE MONEY FAILED\nMESSAGE = " . $dsv_Retrmsg);
								
						}


	} // end curl error check
	
	
	if ($return_error == 'unknown'){
		
		// fire off an email for manual checking.
		dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Capture Money Error', $return_text, STORE_OWNER, EMAIL_FROM);
	
	}
	
	$return_array = array('status' => $return_status,
						  'text' => $return_text,
						  'error' => $return_error);
	
	
	
	return $return_array;
}










// #######################################################################
// #######################################################################

### PROCESS A REVERSAL
function dsf_reversal($dsv_trefnum){
	
	$url = "https://posh.montrada.de/posh/cmd/posh/tpl/txn_result.tpl";
    $username = "testspecbran";
    $password = "Summer,2011";
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, MONTRADA_CARD_USER);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'command=return
										  &trefno=' . $dsv_trefno);
										  
	$response = curl_exec($ch);
    $curlError = curl_error($ch);
    $curlErno = curl_errno($ch);
	curl_close($ch);
	
	$response_array = dsf_processMontradaReturn($response);
	return $response_array;
}



// #######################################################################
// #######################################################################
// Split the values returned in &value= format to an array.
function dsf_processMontradaReturn($response){
	
	$values = explode('&', $response);
	
	$response_array = array();
	
	foreach($values as $value){
		
		$tempval = explode('=', $value);
		
		$temparray = urldecode($tempval[0]);
		
		$response_array[$temparray] = urldecode($tempval[1]);
		
	}
	
	
	
	return $response_array;
}




// added functions
// #######################################################################
// #######################################################################

// #########################
// write shop notes to order
  function dsf_montrada_shop_notes($order_number, $details ='') {
   
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





// #######################################################################
// #######################################################################

// #############################
function dsf_send_montrada_card_mail($savedorder, $address_confirmations=''){
global $basket, $customer_id,  $payment, $currencies;

				// Send an email notification to the customer.

						
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='3'");
	
// lets start with the email confirmation

						  
						 
										$email_details = dsf_db_fetch_array($email_query);
										$signature_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='1'");
									   $signature_details = dsf_db_fetch_array($signature_query);
									
									  $email_subject = $email_details['subject'];
									  $email_footer = $signature_details['details'];
									
									
									// overwrite subject as per Christian emails 2011-09-28
									  $email_subject = TRANSLATION_EMAIL_YOUR_ORDER . ' ' . CONTENT_COUNTRY . CONTENT_COMPANY . '-' . $savedorder->info['id'];
									
									
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
									  
								
									 $email_order = str_replace("[ORDER_NUMBER]" , CONTENT_COUNTRY . CONTENT_COMPANY . '-' . $savedorder->info['id'], $email_order);
									 $html_order = str_replace("[ORDER_NUMBER]" , CONTENT_COUNTRY . CONTENT_COMPANY . '-' . $savedorder->info['id'], $html_order);
						 
						 
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




} // end email montrada card order to customer.




//  REFUND CARD REQUESTER ####
// #######################################################################
// #######################################################################
function dsf_montrada_refund_request($orders_id=0, $refund_value=0){
	
	if ((int)$orders_id > 0){
			// we have an order number,  get the details to release.
			
			// get the info from the transaction database.
			$dsv_query = dsf_db_query("select released_trefnum, released, trans_type from " . DS_DB_SHOP . ".montrada_responses where orders_id='" . $orders_id . "' and trans_type='1'");
			
			if (dsf_db_num_rows($dsv_query) == 1){
				// we only have one item therefore continue processing.
			
					$dsv_results = dsf_db_fetch_array($dsv_query);
							
			
					// two things to note here.
					
					// 1)   the refund function we are about to use has lots of error reporting in it however, one thing
					//      it does not have is error checking that we are sending the correct information to it in the first
					//      place.  we therefore need to take that into account here.
					
					// 2)   we are doing a while to produce a loop.  we could do a for and break but since we are in
					//      a function break might cause unexpected function closure.
					
					$dsv_trefnum = $dsv_results['released_trefnum'];
					$dsv_amount = $refund_value;
					
					if (strlen($dsv_trefnum) < 1 || (float)$dsv_amount < 0.10){
						// we do not have sufficient information to proceed.
						$message = 'Order number ' . $orders_id . ' unable to run refund money function as values to send are: trefnum = ' . $dsv_trefnum . ' amount = ' . $dsv_amount;
						dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}elseif ((int)$dsv_results['released'] == 0 ){
						
						// already released or not a card transaction
						
						$message = 'Order number ' . $orders_id . ' unable to run refund money as the money has not been taken values to send are: released = ' .$dsv_results['realeased'] . ' trans_type = ' . $dsv_results['trans_type'];
						dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
						$return_value = 'false';
					
					
					}else{
						
						// we are still here therefore we have everything to do the call.
						
						// start the while
								$dsv_max_attempts = 3; // the maximum amount of times we are going to try and release the money
								$dsv_current_attempt = 1;
								$return_value = 'false'; // automatically set the return value here to false because if we break
														 // out the loop we would not know and therefore could not set it again.
														 // we use reverse logic,  if we break the loop we set it to true.
			
			
								while ($dsv_current_attempt <= $dsv_max_attempts) {
									
								
									$refund_money = dsf_montrada_refund($orders_id, $dsv_trefnum, $dsv_amount);
									
									if (isset($refund_money['status']) && $refund_money['status'] == 'success'){
										// we can break out the loop,  we have released the money  (capture)
										
										$return_value = 'true';
										$dsv_current_attempt = $dsv_max_attempts +1;  // create a break point by making current attempt larger than max
									
									} else{
									
										// add on to attempts.
										$dsv_current_attempt ++;
									}
									
								} // end while
						
						// at this point,  we have either managed to make a successfull refund or it hasn't work and we have tried
						// maximum times.  we already set the return value to false before the while so we don't need to do anymore error checking.
						
						
						
					}
			
			
			
			}else{
				// either more than one or no records found for transactions in the montrada transaction database.
				// we need to notify someone of this error.
				$message = 'Order number ' . $orders_id . ' unable to refund money as ' . dsf_db_num_rows($dsv_query) . ' items found in transaction database';
				dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
			
				$return_value = 'false';
			}
	
	


	}else{
		// no order number
				$message = 'No order number passed to credit routine.';
				dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Refund Money Error', $message, STORE_OWNER, EMAIL_FROM);
		$return_value = 'false';
	}
	
return $return_value;
}



//  REFUND CARD DETAILS  (refund a card payment only) ####
// #######################################################################
// #######################################################################

function dsf_montrada_refund($order_id, $dsv_trefnum, $dsv_amount){
   
// IMPORTANT THIS FUNCTION IS NEVER TO BE RUN DIRECTLY.
// RUN IT FROM A SCRIPT OR OTHER FUNCTION WHICH CHECKS THE ANSWER AND DECIDES IF IT IS A COMMUNICATION
// OR TERMINAL PROBLEM SO IT CAN TRY AGAIN.

// The montrada system only has one terminal, this means that there is a good chance the first.
// attempt will not work.   The script calling this function needs to take that into consideration
// and try again.   

// THE CALLING SCRIPT MUST ENSURE WE HAVE THE CORRECT THREE PARAMETERS REQUIRED OTHERWISE
// IT SHOULD NOT ATTEMPT TO RUN THIS FUNCTION.

   
   $return_status = '';
   $return_text = '';
   $return_error ='';
   
    
	// amount needs to be sent without decimals therefore we format accordingly.
	$dsv_amount = number_format(($dsv_amount * 100) , 0 ,'','');
	
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, MODULE_PAYMENT_MONTRADACC_URL);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, MONTRADA_CARD_USER);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'command=return' . 
										  '&trefnum=' . $dsv_trefnum . 
										  '&amount=' . $dsv_amount);
	$response = curl_exec($ch);
    $curlError = curl_error($ch);
    $curlErno = curl_errno($ch);
    curl_close($ch);
	
	if ($curlErno > 0){
		$return_status = 'failed';
		$return_text = 'Curl Failed error: ' . $curlErno . ' text: ' . $curlError;
		
	}else{
		// we should have something returned,  pass it through the return splitter and contintue
		
	// strip any details in the response and put it into an array
	$response_array = dsf_processMontradaReturn($response);
	
	
	
	//now check through the values to make sure we have something.
		
							if (isset($response_array['posherr'])){
									$dsv_Retposherr = $response_array['posherr'];
							}else{
									$dsv_Retposherr = '';
							}
							
							if (isset($response_array['rc'])){
									$dsv_Retrc = $response_array['rc'];
							}else{
									$dsv_Retrc = '';
							}
							
							if (isset($response_array['amount'])){
									$dsv_Retamount = $response_array['amount'];
							}else{
									$dsv_Retamount = '';
							}

							if (isset($response_array['trefnum'])){
									$dsv_Rettrefnum = $response_array['trefnum'];
							}else{
									$dsv_Rettrefnum = '';
							}

							if (isset($response_array['rmsg'])){
									$dsv_Retrmsg = $response_array['rmsg'];
							}else{
									$dsv_Retrmsg = '';
							}

							if (isset($response_array['retrefnr'])){
									$dsv_Retretrefnr = $response_array['retrefnr'];
							}else{
									$dsv_Retretrefnr = '';
							}

							if (isset($response_array['trefnum'])){
									$dsv_Rettrefnum = $response_array['trefnum'];
							}else{
									$dsv_Rettrefnum = '';
							}






						  
		// the two main items we are looking for here is dsv_Retposherr and dsv_Retrc
							if ($dsv_Retposherr == '0' && $dsv_Retrc == '000'){

								// success
								
								// advise the order that the money has been taken.
										$write_notes = dsf_montrada_shop_notes($order_id, "REFUND MONEY REQUEST SUCCESSFULL\nVALLUE = " . $dsv_amount . "\nMESSAGE = " . $dsv_Retrmsg . "\nretrefnr = " . $dsv_Retretrefnr . "\ntrefnum = " . $dsv_Rettrefnum);
								
								// mark the transactions that the money has been refunded
																
										$transaction_sql_array = array('orders_id' => $order_id,
																		'timestamp' =>$response_array['timestamp'],
																		'aid' =>$response_array['aid'],
																		'orderid' =>$response_array['orderid'],
																		'trefnum' =>$dsv_Rettrefnum,
																		'retrefnr' =>$dsv_Retretrefnr,
																		'amount' => number_format(($dsv_Retamount / 100) , '2' ,'.',''),
																		'txntype' =>$response_array['txntype'],
																		'released' => 0,
																		'trans_type' => 3
																		);
																
																
																
										$upt = dsf_db_perform(DS_DB_SHOP . '.montrada_responses' , $transaction_sql_array);
								// advise calling function of success.
										$return_status = 'success';
										
								
								
							}else{
								// we have a failure.   the only important failure that we want to trap
								// is the terminal busy / error ones.   all other failure need to be reported on
								// and require further investigation.
								if ($dsv_Retposherr == '9001' || $dsv_Retposherr == '9901'|| $dsv_Retrc == '096'){
									
									// with this failure we return a specific value in the return_error variable which the
									// calling script can use to decide whether or not to try again.
									
									$return_status = 'failed';
									$return_text = 'Trefnum ' . $dsv_trefnum . ' ERROR ' . dsf_print_array($response_array);
									$return_error = 'terminal failed';
									
									
								}else{
									// there could be lots of reasons why this has not worked. the best thing is to send
									// them to us and we can review and amend programming where necessary to compensate.
									$return_status = 'failed';
									$return_text = 'Trefnum ' . $dsv_trefnum . ' ERROR ' . dsf_print_array($response_array);
									$return_error = 'unknown';
										
									
									
								}
								
								// put small error message into order regardless of which error status was above.
										$write_notes = dsf_montrada_shop_notes($order_id, "REFUND MONEY FAILED\nMESSAGE = " . $dsv_Retrmsg);
								
						}


	} // end curl error check
	
	
	if ($return_error == 'unknown'){
		
		// fire off an email for manual checking.
		dsf_send_email('Montrada Payments', ERROR_REPORT_EMAIL_ADDRESS, 'Montrada Refund Money Error', $return_text, STORE_OWNER, EMAIL_FROM);
	
	}
	
	$return_array = array('status' => $return_status,
						  'text' => $return_text,
						  'error' => $return_error);
	
	
	
	return $return_array;
}





	?>