<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


$Vendor = MODULE_PAYMENT_PROTXCC_ID;
$DefaultDescription="Goods Purchased";
$DefaultCurrency="GBP";
$DefaultRefundDescription="[Your default refund description]";
$ExternalIPAddress = MODULE_PAYMENT_PROTXCC_IPNUM;
$InternalIPAddress = MODULE_PAYMENT_PROTXCC_IPNUM;

$DefaultFilePath = '';
$eoln = chr(13) . chr(10);
$ProtocolVersion = "2.23";



	/** 
	 Information and URLs for the simulator site
	 **/
	if (MODULE_PAYMENT_PROTXCC_TEST_MODE == 'Simulator'){
	  $Verify=false;
	  $PurchaseURL="https://test.sagepay.com/Simulator/VSPDirectGateway.asp";
	  $RefundURL="https://ukvpstest.protx.com/VSPSimulator/VSPServerGateway.asp?Service=VendorRefundTx";
	  $ReleaseURL="https://ukvpstest.protx.com/VSPSimulator/VSPServerGateway.asp?Service=VendorReleaseTx";
	  $RepeatURL="https://ukvpstest.protx.com/VSPSimulator/VSPServerGateway.asp?Service=VendorRepeatTx";
	  $VoidURL="https://ukvpstest.protx.com/VSPSimulator/VSPServerGateway.asp?Service=VendorVoidTx";
	  $AbortURL="https://ukvpstest.protx.com/VSPSimulator/VSPServerGateway.asp?Service=VendorAbortTx";
	  $CallBackURL="https://test.sagepay.com/Simulator/VSPDirectCallback.asp";
	  
	}
	
	/** 
	 Information and URLs for the test site
	 **/
	if (MODULE_PAYMENT_PROTXCC_TEST_MODE == 'Test'){
	  $Verify=false;
	  $PurchaseURL="https://test.sagepay.com/gateway/service/vspdirect-register.vsp";
	  $RefundURL="https://test.sagepay.com/gateway/service/refund.vsp";
	  $ReleaseURL="https://test.sagepay.com/gateway/service/release.vsp";
	  $RepeatURL="https://test.sagepay.com/gateway/service/repeat.vsp";
	  $VoidURL="https://test.sagepay.com/gateway/service/void.vsp";
	  $AbortURL="https://test.sagepay.com/gateway/service/abort.vsp";
	  $CallBackURL="https://test.sagepay.com/gateway/service/direct3dcallback.vsp";
	}
	
	/** 
	 Information and URLs for the Live site
	 **/
	if (MODULE_PAYMENT_PROTXCC_TEST_MODE == 'Live'){
	  $Verify=true;
	  $PurchaseURL="https://live.sagepay.com/gateway/service/vspdirect-register.vsp";
	  $RefundURL="https://live.sagepay.com/gateway/service/refund.vsp";
	  $ReleaseURL="https://live.sagepay.com/gateway/service/release.vsp";
	  $RepeatURL="https://live.sagepay.com/gateway/service/repeat.vsp";
	  $VoidURL="https://live.sagepay.com/gateway/service/void.vsp";
	  $AbortURL="https://live.sagepay.com/gateway/service/abort.vsp";
	  $CallBackURL="https://live.sagepay.com/gateway/service/direct3dcallback.vsp";
	}



// FUNCTIONS ##########################

function displayAssociativeArray( $data )
{
  $result = "";
  foreach ( $data as $key => $value )
  {
    $result .= $key . " => " . $value . "<br/>";
  }
  return $result;
}

function requestPost($url, $data){

	set_time_limit(120); // was 60
	$output = array();
	$curlSession = curl_init();

	// Set the URL
	curl_setopt ($curlSession, CURLOPT_URL, $url);
	curl_setopt ($curlSession, CURLOPT_HEADER, 0);
	curl_setopt ($curlSession, CURLOPT_POST, 1);
	curl_setopt ($curlSession, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER,1); 
	curl_setopt($curlSession, CURLOPT_TIMEOUT,120); // was 60
    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 1);



	//Send the request and store the result in an array
	$response = split(chr(10),curl_exec ($curlSession));

	// Check that a connection was made
	if (curl_error($curlSession)){
		$output['Status'] = "FAIL";
		$output['StatusDetail'] = curl_error($curlSession);
	}

	// Close the cURL session
	curl_close ($curlSession);

// Tokenise the response
	for ($i=0; $i<count($response); $i++){
		// Find position of first "=" character
		$splitAt = strpos($response[$i], "=");
		// Create an associative (hash) array with key/value pairs ('trim' strips excess whitespace)
		$output[trim(substr($response[$i], 0, $splitAt))] = trim(substr($response[$i], ($splitAt+1)));
	} 

	// Return the output
	return $output;

} // END function requestPost(){


function formatData($data){

	// Initialise output variable
	$output = "";

	// Step through the fields
	foreach($data as $key => $value){
		$output .= "&" . $key . "=". urlencode($value);
	} 

	$output = substr($output,1);

	// Return the output
	return $output;


} 

function addOptionalFields( $source, $target, $fields )
{
  $result = $target;
  foreach ( $fields as $field )
  {
    if ( trim( $source[ $field ] ) != '' )
    {
      $result[ $field ] = $source[ $field ];
    }
  }
  return $result;
} 



// change order status
  function dsf_protx_shop_notes($order_number, $details ='') {
   
   $new_order_query = dsf_db_query("select orders_id, transaction_details from " . DS_DB_SHOP . ".orders where orders_id='" . (int)$order_number . "'");
 	$total_records_found = dsf_db_num_rows ($new_order_query);
	
	$new_order_info = dsf_db_fetch_array($new_order_query);

  // get order number first.
  $our_order_id = $new_order_info['orders_id'];
  
  if ((int)$our_order_id > 1){


			$new_comments = date('Y-m-d H:i:s') . ' :- ' . utf8_encode($details) . "\n\n" . $new_order_info['transaction_details'];

 
  		  $sql_data_array = array('transaction_details' => dsf_db_prepare_input($new_comments));
		  dsf_db_perform(DS_DB_SHOP . '.orders', $sql_data_array, 'update', "orders_id = '" . (int)$our_order_id . "'");
  }
  
  return 'updated_record';
}


// RELEASE A PROTX DIRECT PAYMENT ####################
function dsf_protx_release_order($order_number){

global $ReleaseURL, $Verify, $ProtocolVersion;


// validate a protx direct item.
 $protx_query = dsf_db_query("select orders_id, vendortxcode, vpstxid, securitykey, txauthno from " . DS_DB_SHOP . ".protx_direct_responses where orders_id='" . (int)$order_number . "'");
 
 if (dsf_db_num_rows($protx_query) == 0){
 
 	$problem_text = 'Order number ' . $order_number . ' has been marked as released however its' . "\n";
	$problem_text .= 'transaction details can not be found within the protx direct transaction logs' . "\n\n";
	$problem_text .= 'If this is a valid protx direct payment order, please release the item manually';
	
	mail_protx_problem($problem_text);
	return 'Protx Item not Found';
	break;
	
 	// not a protx order
 }elseif (dsf_db_num_rows($protx_query) > 1){
 	// more than one item is listed - this is an error.
 	$problem_text = 'Order number ' . $order_number . ' has been marked as released however there are' . "\n";
	$problem_text .= 'more than one transaction item found within the protx direct transaction logs' . "\n\n";
	$problem_text .= 'Please release the item manually and check the logs to see why there is more' . "\n";
	$problem_text .= 'than one transaction item.' . "\n";
	
	
	mail_protx_problem($problem_text);
	return 'More than one protx item found';
	break;
 }
 	

	$protx_user_account_number = MODULE_PAYMENT_PROTXCC_ID;

// #########################





 // we must have a valid transaction item if we are here,  get the array of items.
 
 $protx_items = dsf_db_fetch_array($protx_query);
 
$TargetURL = $ReleaseURL;
$VerifyServer = $Verify;

// echo 'URL = ' . $TargetURL;
$data = array (
		'VPSProtocol' => $ProtocolVersion, 							// Protocol version (specified in init-includes.php)
		'TxType' => 'RELEASE',													// Transaction type 
		'Vendor' => $protx_user_account_number,									// Vendor name (specified in init-protx.php)
		'VendorTxCode' => $protx_items['vendortxcode'],					// Unique refund transaction code (generated by vendor)
		'VPSTxId' => $protx_items['vpstxid'],										// VPSTxId of order
		'SecurityKey' => $protx_items['securitykey'],						// Security Key
		'TxAuthNo' => $protx_items['txauthno']									// Transaction authorisation number
	);

// Format values as url-encoded key=value pairs
$data = formatData($data);

$response ='';

$response = requestPost($TargetURL, $data);

$baseStatus = array_shift(split(" ",$response["Status"]));

switch($baseStatus) {

	case 'OK':
	
	// payment has been released witin protx.
		
		// update the orders status
						
		$sql_data_array = array('orders_status' => '13');
		dsf_db_perform(DS_DB_SHOP . ".orders",$sql_data_array,'update','orders_id=' . $order_number);


	// update status history.
		  $sql_data_array = array('orders_id' => $order_number, 
								  'orders_status_id' => '13', 
								  'date_added' => 'now()');
		  dsf_db_perform(DS_DB_SHOP . ".orders_status_history", $sql_data_array);

	// log the reply.
		
		$write_notes = dsf_protx_shop_notes($order_number, "RELEASE STATUS = OK\n");

		return 'Complete';
		break;
	
	
	
	// all other cases
	case 'MALFORMED':
	case 'INVALID':
	case 'ERROR':
	
	$problem_text = 'Order number ' . $order_number . ' has been marked as released however a problem' . "\n";
	$problem_text .= 'has been returned from Protx,  the error is:' . "\n\n";
	$problem_text .= $response['StatusDetail'] . "\n";
	
	mail_protx_problem($problem_text);

	$write_notes = dsf_protx_shop_notes($order_number, "RELEASE STATUS = FAILED\n");

	return 'Failed';
	break;


	case 'FAIL':
	
	$problem_text = 'Order number ' . $order_number . ' has been marked as ' . $TxType . ' however a problem' . "\n";
	$problem_text .= 'with communication from Protx has occured,  the error (if available) is:' . "\n\n";
	$problem_text .= $response['StatusDetail'] . "\n";
	
	mail_protx_problem($problem_text);

	$write_notes = dsf_protx_shop_notes($order_number, $TxType . " STATUS = FAILED\n");

	return 'Failed';
	break;


	} // end of switch.

return $response;
}


// DECLINE A PROTX DIRECT PAYMENT ####################

// there are two options for declining a payment depending on whether or not the
// item has been changed in the first place.

// 1) if not charged, then the operation is ABORT

// 2) if it has been charged, then the operation is VOID


function dsf_protx_decline_order($order_number){

global $VoidURL, $AbortURL, $Verify, $ProtocolVersion;

// validate a protx direct item.
 $protx_query = dsf_db_query("select orders_id, vendortxcode, vpstxid, securitykey, txauthno from " . DS_DB_SHOP . ".protx_direct_responses where orders_id='" . (int)$order_number . "'");
 
 if (dsf_db_num_rows($protx_query) == 0){
 
 	$problem_text = 'Order number ' . $order_number . ' has been marked as declined however its' . "\n";
	$problem_text .= 'transaction details can not be found within the protx direct transaction logs' . "\n\n";
	$problem_text .= 'If this is a valid protx direct payment order, please decline the item manually';
	
	mail_protx_problem($problem_text);
	return 'invalid protx item';
	break;
	
 	// not a protx order
 }elseif (dsf_db_num_rows($protx_query) > 1){
 	// more than one item is listed - this is an error.
 	$problem_text = 'Order number ' . $order_number . ' has been marked as declined however there are' . "\n";
	$problem_text .= 'more than one transaction item found within the protx direct transaction logs' . "\n\n";
	$problem_text .= 'Please decline the item manually and check the logs to see why there is more' . "\n";
	$problem_text .= 'than one transaction item.' . "\n";
	
	
	mail_protx_problem($problem_text);
	return 'more than one protx item found';
	break;
 }
 	

 // we must have a valid transaction item if we are here.
 
 // we therefore need to check our logs to see if the item has been previously charged.
 
 $check_history_query = dsf_db_query("select orders_id, orders_status_id from " . DS_DB_SHOP . ".orders_status_history where orders_id='" . $order_number . "' and orders_status_id='90006'");
 
 if (dsf_db_num_rows($check_history_query)==0){
 	$TargetURL = $AbortURL; // never charged.
	$TxType = 'ABORT';
 }else{
 	$TargetURL = $VoidURL; // has been charged
	$TxType = 'VOID';
 }
 
 
 
 $protx_items = dsf_db_fetch_array($protx_query);
 
$VerifyServer = $Verify;

	$protx_user_account_number = MODULE_PAYMENT_PROTXCC_ID;

// #########################




$data = array (
		'VPSProtocol' => $ProtocolVersion, 							// Protocol version (specified in init-includes.php)
		'TxType' => $TxType,													// Transaction type 
		'Vendor' => $protx_user_account_number,														// Vendor name (specified in init-protx.php)
		'VendorTxCode' => $protx_items['vendortxcode'],					// Unique refund transaction code (generated by vendor)
		'VPSTxId' => $protx_items['vpstxid'],										// VPSTxId of order
		'SecurityKey' => $protx_items['securitykey'],						// Security Key
		'TxAuthNo' => $protx_items['txauthno']									// Transaction authorisation number
	);

// Format values as url-encoded key=value pairs
$data = formatData($data);

$response = requestPost($TargetURL, $data);

$baseStatus = array_shift(split(" ",$response["Status"]));

switch($baseStatus) {

	case 'OK':
	
	// payment has been voided / aborted witin protx.


		// update the orders status
						
		$sql_data_array = array('orders_status' => '50005');
		dsf_db_perform(DS_DB_SHOP . ".orders",$sql_data_array,'update','orders_id=' . $order_number);


	// update status history.
		  $sql_data_array = array('orders_id' => $order_number, 
								  'orders_status_id' => '50005', 
								  'date_added' => 'now()');
		  dsf_db_perform(DS_DB_SHOP . ".orders_status_history", $sql_data_array);

		
	// log the reply.
		
		$write_notes = dsf_protx_shop_notes($order_number, $TxType . " STATUS = OK\n");

		return 'Complete';
		break;
	
	
	
	// all other cases except failed
	case 'MALFORMED':
	case 'INVALID':
	case 'ERROR':
	
	$problem_text = 'Order number ' . $order_number . ' has been marked as ' . $TxType . ' however a problem' . "\n";
	$problem_text .= 'has been returned from Protx,  the error is:' . "\n\n";
	$problem_text .= $response['StatusDetail'] . "\n";
	
	mail_protx_problem($problem_text);

	$write_notes = dsf_protx_shop_notes($order_number, $TxType . " STATUS = FAILED\n");

	return 'Failed';
	break;

	case 'FAIL':
	
	$problem_text = 'Order number ' . $order_number . ' has been marked as ' . $TxType . ' however a problem' . "\n";
	$problem_text .= 'with communication from Protx has occured,  the error (if available) is:' . "\n\n";
	$problem_text .= $response['StatusDetail'] . "\n";
	
	mail_protx_problem($problem_text);

	$write_notes = dsf_protx_shop_notes($order_number, $TxType . " STATUS = FAILED\n");

	return 'Failed';
	break;


	} // end of switch.

return 'error';
}

// OEF


// ### PROTX DIRECT MAIL ERROR FUNCTION ###########
//
function mail_protx_problem($problem_text){
    
				$time_now = time();
					$mail_message = 'Protx Direct error:<br><br>';
					$mail_message .= $problem_text;
					
					 dsf_send_email(STORE_OWNER, ERROR_REPORT_EMAIL_ADDRESS, 'Protx Direct Functions Error', $mail_message, STORE_OWNER, EMAIL_FROM);

return 'complete';
}





// Process the card payment to sagepay and an array of results should be returned.
// This is then sent back to the calling script for further action.
function dsf_process_sagepay($savedorder){

global $protx_order,$GiftAidPayment, $ApplyAVSCV2, $CAVV, $XID, $ECI, $ClientNumber, $cc_issue_number, $cc_ccv_number, $cc_owner, $cc_number, $cc_start_month, $cc_start_year, $cc_expires_month, $cc_expires_year, $cc_ctype, $protx_attempts, $currencies, $ProtocolVersion, $DefaultCurrency,$PurchaseURL,$Verify, $VendorTxCode;

    					$protx_ipn_currency = MODULE_PAYMENT_PROTXCC_DEFAULT_CURRENCY;

						  // ORDER VALUE
						  $strip_values_array = array("£",",");
						  
						  if ($savedorder->info['deposit_value'] > 0){ // deposit value required
						  		$protx_ipn_order_amount = str_replace($strip_values_array,'',$savedorder->info['deposit_value']);
						  }else{ // full order value
						  		$protx_ipn_order_amount = str_replace($strip_values_array,'',$savedorder->info['total_value']);
						  }
						 
						 $protx_ipn_order_amount = number_format($protx_ipn_order_amount , 2,'.','');
						 
						 
						// CREATE ALL values to be passed through to Protx.
						$VendorTxCode= SAP_ORDER_PREFIX . $savedorder->info['id'] . '--' . date('YmdHis');
						$Amount= $protx_ipn_order_amount;
						$Currency= $protx_ipn_currency;
						$Description= 'Basket ID ' . $savedorder->info['id'] . ' - ' . dsf_get_ip_address();
						
						if ( strtoupper($savedorder->customer['email_address']) <> strtoupper(TELEPHONE_ORDER)){
							$CustomerEMail= $savedorder->customer['email_address'];
						}else{
							$CustomerEMail='';
						}
						
						
						if (($savedorder->customer['telephone']) && (strlen($savedorder->customer['telephone']) >5)){
						$ContactNumber= substr($savedorder->customer['telephone'],20);
						}else{
						$ContactNumber= substr(dsf_lookup_mobile($savedorder->customer['id']),20);
						}
						
						
						// BILLING INFORMATION
						
						$BillingSurname= substr($savedorder->customer['lastname'],0,200);
						$BillingFirstnames= substr($savedorder->customer['firstname'],0,200);

						 if (isset($savedorder->customer['house']) && strlen($savedorder->customer['house']) > 0){
						 	 $BillingAddress1 = $savedorder->customer['house'] . ', ';
						 }else{
						 	$BillingAddress1 = '';
						 }	
							
						$BillingAddress1 .=  $savedorder->customer['street'];
						
						if (isset($savedorder->customer['district']) && strlen($savedorder->customer['district']) > 1){
							$BillingAddress2 = $savedorder->customer['district'];
						}
						
						$BillingCity = '';
						
						
						if (isset($savedorder->customer['town']) && strlen($savedorder->customer['town']) > 1){
							$BillingCity .= $savedorder->customer['town'];
						}else{	
							$BillingCity .=  $savedorder->customer['county'];
						}

						// put somthing in billing city if nothing supplied.
						if (strlen($BillingCity) < 1){
							$BillingCity = 'Not Supplied';
						}
						
						$BillingPostCode= $savedorder->customer['postcode'];


						if ($savedorder->customer['country'] == 'United Kingdom'){
							$BillingCountry = 'GB';
						}else{
							// No alternative more the minute
							$BillingCountry = 'GB';
						}
						
						// DELIVERY INFO - if no delivery address has been supplied, then we need to populate the variables
						// with the same values as billing.
						
						
						if (isset($savedorder->delivery['postcode']) && strlen($savedorder->delivery['postcode'])>4){ // delivery address exists
							
										// get customers name and split it into firstname, lastname
										
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
												
												
												$Delivery_Surname = $splits[$first_split];
												$Delivery_Firstnames = $splits[$second_split];
												
										}else{
											// no breaks,  ensure something is there
											
												$Delivery_Surname = $savedorder->customer['name'];
												$Delivery_Firstnames = $savedorder->customer['name'];
										}
										
									
									 if (isset($savedorder->delivery['house']) && strlen($savedorder->delivery['house']) > 0){
										 $DeliveryAddress1 = $savedorder->delivery['house'] . ', ';
									 }else{
										$DeliveryAddress1 = '';
									 }	
										
									$DeliveryAddress1 .=  $savedorder->delivery['street'];
									
									if (isset($savedorder->delivery['district']) && strlen($savedorder->delivery['district']) > 1){
										$DeliveryAddress2 = $savedorder->delivery['district'];
									}
									
									$DeliveryCity = '';
									
									
									if (isset($savedorder->delivery['town']) && strlen($savedorder->delivery['town']) > 1){
										$DeliveryCity .= $savedorder->delivery['town'];
									}else{	
										$DeliveryCity .=  $savedorder->delivery['county'];
									}
			
									// put somthing in billing city if nothing supplied.
									if (strlen($DeliveryCity) < 1){
										$DeliveryCity = 'Not Supplied';
									}
			
									$DeliveryPostCode= $savedorder->delivery['postcode'];

									if ($savedorder->delivery['country'] == 'United Kingdom'){
										$DeliveryCountry = 'GB';
									}else{
										// No alternative more the minute
										$DeliveryCountry = 'GB';
									}
						
						
						} else { // we havent got a delivery address so we need to duplicate the billing information.
						
												$DeliverySurname = $BillingSurname;
												$DeliveryFirstnames = $BillingFirstnames;
												$DeliveryAddress1 = $BillingAddress1;
												$DeliveryAddress2 = $BillingAddress2;
												$DeliveryCity = $BillingCity;
												$DeliveryPostCode = $BillingPostCode;
												$DeliveryCountry = $BillingCountry;
												
						}
						
						
						
					
									
									   $pagerows = (sizeof($savedorder->products));
									   
									   $prod_basket = '';
									   $tot_basket = '';
									   
											for ($i=0, $n=($pagerows+1); $i<$n; $i++) {
												if($savedorder->products[$i]['price']){ // there are records
									
											// products options code added 09-may-2006
													$products_ordered_attributes = "";
													  if (sizeof($savedorder->products[$i]['attributes']) > 0) {
															$attributes_exist = '1';
															$products_ordered_attributes = " (";
															for ($j = 0, $k = sizeof($savedorder->products[$i]['attributes']); $j < $k; $j++) {
															  $products_ordered_attributes .= '  '. $savedorder->products[$i]['attributes'][$j]['option'] . '-> ' . $savedorder->products[$i]['attributes'][$j]['value'];
															}
															$products_ordered_attributes .= " )";
														}
											// end of products options section.
												
													$prod_basket .= ':' . str_replace(':', ' ', $savedorder->products[$i]['model'] . ' - ' . $savedorder->products[$i]['name'] . ' ' . $products_ordered_attributes); // name
													$prod_basket .= ':' . $savedorder->products[$i]['qty']; // quantity
													$prod_basket .= ':'; // item value
													$prod_basket .= ':'; // item tax
													$prod_basket .= ':' . $currencies->format(dsf_add_tax($savedorder->products[$i]['final_price'], $savedorder->products[$i]['tax']), true, $savedorder->info['currency'], $savedorder->info['currency_value']); // item total
													$prod_basket .= ':' . $currencies->format(dsf_add_tax($savedorder->products[$i]['final_price'] * $savedorder->products[$i]['qty'], $savedorder->products[$i]['tax']), true, $savedorder->info['currency'], $savedorder->info['currency_value']); // line total
												}
											}
									
									
									
												for ($i=0, $n=sizeof($savedorder->totals)+1; $i<$n; $i++) {
													$totalclass = $savedorder->totals[$i]['class'];
													
													if (strlen($savedorder->totals[$i]['class']) > 1){
													$order_total[$totalclass] = array('title' => $savedorder->totals[$i]['title'],
																					  'text' => $savedorder->totals[$i]['text'],
																					  'value' => $savedorder->totals[$i]['value']
																					  );
													}
												}
									
									// discount if necessary
									
												if ($order_total['ot_discount']['value'] > 0){
													$pagerows ++;
													$tot_basket .= ':' . str_replace(':', ' ', $order_total['ot_discount']['title']); // name
													$tot_basket .= ':'; // quantity
													$tot_basket .= ':'; // item value
													$tot_basket .= ':'; // item tax
													$tot_basket .= ':'; // item total
													$tot_basket .= ':-' . $order_total['ot_discount']['value']; // line total
												}
									
									
									 // delivery charge (0.00 if necessary);
												if ($order_total['ot_shipping']['value'] > 0){
													$pagerows ++;
													$tot_basket .= ':' . str_replace(':', ' ', $order_total['ot_shipping']['title']); // name
													$tot_basket .= ':'; // quantity
													$tot_basket .= ':'; // item value
													$tot_basket .= ':'; // item tax
													$tot_basket .= ':'; // item total
													$tot_basket .= ':' . $order_total['ot_shipping']['value']; // line total
												}
									
								  if ($savedorder->info['deposit_value'] > 0){ // deposit value required
													$pagerows ++;
													$tot_basket .= ':' . 'Deposit Required'; // name
													$tot_basket .= ':'; // quantity
													$tot_basket .= ':'; // item value
													$tot_basket .= ':'; // item tax
													$tot_basket .= ':'; // item total
													$tot_basket .= ':' . $savedorder->info['deposit_value']; // line total
									}
								
								
								// make new basket
									
									   $basket = $pagerows . $prod_basket . $tot_basket;
										
									
						// end of basket creation details.
						
						
		// register this order so we don't create an other one if this fails.
		
			$protx_order = $savedorder->info['id'];
			dsf_session_register('protx_order');
  			
			// register the txCode created - we use this to allocate the payment to order
			dsf_session_register('VendorTxCode');
		


// submit the information to SagePay

					// Set some variables
					$TargetURL = $PurchaseURL;													// Specified in init-includes.php
					$VerifyServer = $Verify;														// Specified in init-includes.php
					
					if ($Description){
						$Description = substr($Description,0,100);
					} else {
						$Description = $DefaultDescription;								//  Specified in init-protx.php
					}
					
					
					
					// Create an array of values to send
					$required = array (
							'VPSProtocol' => $ProtocolVersion, 							// Protocol version (specified in init-includes.php)
							'TxType' => MODULE_PAYMENT_PROTXCC_TXTYPE,											// Transaction type
							'Vendor' => MODULE_PAYMENT_PROTXCC_ID,														// Vendor name (specified in init-protx.php)
							'VendorTxCode' => $VendorTxCode,					// Unique transaction code (generated by vendor)
							'Amount' => $Amount,											// Value of order (supplied by vendor)
							'Currency' => $DefaultCurrency,									// Currency of order (default specified in init-protx.php)
							'Description' => $Description,									// Description of order 
							 'BillingSurname' => $BillingSurname,
							 'BillingFirstnames' => $BillingFirstnames,
							 'BillingAddress1' => $BillingAddress1,
							 'BillingAddress2' => $BillingAddress2,
							 'BillingCity' => $BillingCity,
							 'BillingPostCode' => $BillingPostCode,
							 'BillingCountry' => $BillingCountry,
							 'DeliverySurname' => $DeliverySurname,
							 'DeliveryFirstnames' => $DeliveryFirstnames,
							 'DeliveryAddress1' => $DeliveryAddress1,
							 'DeliveryAddress2' => $DeliveryAddress2,
							 'DeliveryCity' => $DeliveryCity,
							 'DeliveryPostCode' => $DeliveryPostCode,
							 'DeliveryCountry' => $DeliveryCountry
							
						);
					
					
					
					// add optional fields to the data array only if they've been set
					
					$optional_fields = array('ContactNumber' => $ContactNumber,
											 'ContactFax' => $ContactFax,
											 'CustomerEMail' => $CustomerEMail,
											 'GiftAidPayment' => $GiftAidPayment,
											 'ApplyAVSCV2' => $ApplyAVSCV2,
											 'CAVV' => $CAVV,
											 'XID' => $XID,
											 'ECI' => $ECI,
											 '3DSecureStatus' => '',
											 'Basket' => $Basket,
											 'ClientNumber' => $ClientNumber,
											 'IssueNumber' => $cc_issue_number,
											 'CV2' => $cc_ccv_number
											 );
											 
					// add the optional fields to the required array only if there are values set.
					$data = addOptionalFields( $optional_fields, $required, array ( 
					  'ContactNumber',
					  'ContactFax',
					  'CustomerEMail',
					  'GiftAidPayment',
					  'ApplyAVSCV2',
					  'ClientIPAddress',
					  'CAVV',
					  'XID',
					  'ECI',
					  '3DSecureStatus',
					  'Basket',
					  'ClientNumber', 
					  'IssueNumber', 
					  'CV2', 
					) );
					
					$data['CardHolder'] =	$cc_owner;
					$data['CardNumber'] = 	$cc_number;
					
					
					// Check if start date is supplied
					if($cc_start_month){
						// If so, add start date to data array to be appended to POST
						$data['StartDate'] = $cc_start_month . $cc_start_year;
					}	
					
					// Add expiry date
					$data['ExpiryDate'] = $cc_expires_month . $cc_expires_year;
					
					// Add card type
					$data['CardType'] = $cc_ctype;


					$ipnum = dsf_get_ip_address();

						$data['Apply3DSecure'] = '0';
					
					$posted_data = $data;
					
					$data = formatData($data);
					
					
					$sage_response = requestPost($TargetURL, $data);	



					// (1) add 1 to attempts counter
					
						$protx_attempts ++;
						dsf_session_unregister('protx_attempts');
						dsf_session_register('protx_attempts');





	// return the response back to the calling script.
		return $sage_response;
		


} // end processing sagepay request




// send an email to the customer based on the results of the results supplied

function dsf_send_sagepay_mail($savedorder, $address_confirmations=''){
global $basket, $customer_id,  $payment, $currencies;

					$good_mail_id = '3';
					$bad_mail_id = '6';


					if ($address_confirmations == 'OK'){ // status OK and addresses OK
						
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='" . $good_mail_id ."'");
					 }elseif (MODULE_PAYMENT_PROTXCC_CHECK_ADDRESS == 'false'){
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='" . $good_mail_id ."'");
					}elseif ($address_confirmations == 'ALLOW'){ // status OK Adress failed under threshold.
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='" . $good_mail_id ."'");
					 }else{
					  $email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='" . $bad_mail_id ."'");
					
					}
	
// lets start with the email confirmation

						 
										$email_details = dsf_db_fetch_array($email_query);
										$signature_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='1'");
									   $signature_details = dsf_db_fetch_array($signature_query);
									
									  $email_subject = $email_details['subject'];
									  $email_footer = $signature_details['details'];
									
									
									// overwrite subject as per Christian emails 2011-09-28
									  $email_subject = TRANSLATION_EMAIL_YOUR_ORDER . ' ' . SAP_ORDER_PREFIX . $savedorder->info['id'];
						 
									
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




} // end email sagepay order to customer.







// END OF FUNCTIONS ######################################
?>