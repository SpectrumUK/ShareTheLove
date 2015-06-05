  <?php
  
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// #########################
// write shop notes to order
  function dsf_cash_shop_notes($order_number, $details ='') {
   
   $new_order_query = dsf_db_query("select orders_id, transaction_details from " . DS_DB_SHOP . ".orders where orders_id='" . (int)$order_number . "'");
	
   $new_order_info = dsf_db_fetch_array($new_order_query);

  // get order number first.
  $our_order_id = $new_order_info['orders_id'];
  
  if ((int)$our_order_id > 1){
					  
			$new_comments = date('Y-m-d H:i:s') . ' :- ' . $details . "\n\n" . $new_order_info['transaction_details'];
 
  		  $sql_data_array = array('transaction_details' => $new_comments);
		  dsf_db_perform(DS_DB_SHOP . '.orders', $sql_data_array, 'update', "orders_id = '" . (int)$our_order_id . "'");
  }
  
  return 'updated_record';
}



// #############################
function dsf_send_cash_mail($savedorder, $address_confirmations=''){
global $cart, $customer_id, $payment, $currencies;

			
				// Send an email notification to the customer.
			
			
						
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='10'");
	
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
									  $html_order .= nl2br($email_details['details']) . "<br /><br />";
									  
									  $html_order .= $products_ordered['html'] . '<br /><br />';
									  $html_order .= nl2br($email_footer);
									  
								
									 $email_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX . $savedorder->info['id'], $email_order);
									 $html_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX . $savedorder->info['id'], $html_order);
						 
						  // end of email.
						 
						 
 
  
					  dsf_send_email($savedorder->customer['name'], $savedorder->customer['email_address'], $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					
					// send emails to other people
					  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_TO, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }

					  if (SEND_EXTRA_ORDER_EMAILS_DUPLICATE != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_DUPLICATE, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }


// just for consistancy.

return true;




} 









// 2013-10-28 amendment for email with FOC voucher.

// #############################
function dsf_send_voucher_mail($savedorder, $address_confirmations=''){
global $cart, $customer_id, $payment, $currencies;

			
				// Send an email notification to the customer.
			
			
						
						$email_query = dsf_db_query("select subject, details from ". DS_DB_SHOP . ".email_templates where id ='13'");
	
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
										
													 
									
									  $email_order .=  $products_ordered['plain'];
													
									  $email_order .= "\n" .EMAIL_SEPARATOR ."\n" . $email_footer;
						 
						 
						 		// html
									  
									  $html_order = TRANSLATION_WORD_DEAR . ' ' . $savedorder->customer['name'] . "<br /><br />";
									  $html_order .= nl2br($email_details['details']) . "<br /><br />";
									  
									  $html_order .= $products_ordered['html'] . '<br /><br />';
									  $html_order .= nl2br($email_footer);
									  
								
									 $email_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX . $savedorder->info['id'], $email_order);
									 $html_order = str_replace("[ORDER_NUMBER]" , SAP_ORDER_PREFIX  . $savedorder->info['id'], $html_order);
						 
						  // end of email.
						 
						 
 
  
					  dsf_send_email($savedorder->customer['name'], $savedorder->customer['email_address'], $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					
					// send emails to other people
					  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_TO, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }

					  if (SEND_EXTRA_ORDER_EMAILS_DUPLICATE != '') {
						dsf_send_email(STORE_OWNER, SEND_EXTRA_ORDER_EMAILS_DUPLICATE, $email_subject, $email_order, STORE_OWNER, EMAIL_FROM,$html_order);
					  }


// just for consistancy.

return true;




} 

	?>