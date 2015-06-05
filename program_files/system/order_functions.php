<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



/* Order functions - to create and recall orders.

Also used for stock deduction called when a valid order is received.

*/


// ### CREATE AN ORDER  ### //   Returns An Order Number
function dsf_create_order($order, $order_totals, $customer_id=0, $gross_deposit_required=0, $trans_notes = '', $order_sts = '90000'){	// default order status to sagepay
global $dsv_voucher_valid, $voucher_total, $voucher_number, $voucher_gift, $currencies;



						  $sql_data_array = array('customers_id' => $customer_id,
												  'customers_name' => $order->customer['name'],
												  'customers_company' => $order->customer['company'],
												  'customers_house' => $order->customer['house'],
												  'customers_street' => $order->customer['street'],
												  'customers_district' => $order->customer['district'],
												  'customers_town' => $order->customer['town'],
												  'customers_county' => $order->customer['county'],
												  'customers_sap_county' => $order->customer['county_code'],
												  'customers_postcode' => $order->customer['postcode'], 
												  'customers_state' => $order->customer['state'], 
												  'customers_country' => $order->customer['country']['title'], 
												  'customers_telephone' => $order->customer['telephone'], 
												  'customers_email_address' => $order->customer['email_address'],
												  'customers_address_format_id' => $order->customer['format_id'], 
												  'delivery_name' => $order->delivery['name'], 
												  'delivery_company' => $order->delivery['company'],
												  'delivery_house' => $order->delivery['house'], 
												  'delivery_street' => $order->delivery['street'], 
												  'delivery_district' => $order->delivery['district'], 
												  'delivery_town' => $order->delivery['town'], 
												  'delivery_county' => $order->delivery['county'], 
												  'delivery_sap_county' => $order->delivery['county_code'], 
												  'delivery_postcode' => $order->delivery['postcode'], 
												  'delivery_state' => $order->delivery['state'], 
												  'delivery_country' => $order->delivery['country'], 
												  'delivery_address_format_id' => $order->delivery['format_id'], 
												  'payment_method' => $order->info['payment_method'], 
												  'date_purchased' => 'now()', 
												  'orders_status' => (int)$order_sts, 
												  'currency' => $order->info['currency'], 
												  'currency_value' => $order->info['currency_value'],
												  'products_delivery_date' => $order->info['products_delivery_date'], 
												  'tracking_number' => $order->info['tracking_number'], 
												  'customers_comments' => $order->info['comments'],
												  'original_value' => $order->info['total'],
												  'ip_number' => dsf_get_ip_address(),
						  						  'deposit_value' => $gross_deposit_required
												   );
						  dsf_db_perform(DS_DB_SHOP . '.orders', $sql_data_array);
						  $insert_id = dsf_db_insert_id();
						 
						  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
							$sql_data_array = array('orders_id' => $insert_id,
													'title' => $order_totals[$i]['title'],
													'text' => $order_totals[$i]['text'],
													'value' => $order_totals[$i]['value'], 
													'class' => $order_totals[$i]['code'], 
													'sort_order' => $order_totals[$i]['sort_order']);
							dsf_db_perform(DS_DB_SHOP . '.orders_total', $sql_data_array);
						  }
						
						
						  $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
						  $sql_data_array = array('orders_id' => $insert_id, 
												  'orders_status_id' => '1', 
												  'date_added' => 'now()', 
												  'customer_notified' => $customer_notification,
												  'comments' => $order->info['comments']);
						  dsf_db_perform(DS_DB_SHOP . '.orders_status_history', $sql_data_array);
						
						
						// ################ VOUCHER SPECIFIC CODE #######################
						
						if ($dsv_voucher_valid == 'true' && (int)$voucher_total >0){
							// we have a valid voucher,  log the transaction
						$sql_data_array = array('order_id' => $insert_id,
												'voucher_code' => $voucher_number,
												'voucher_discount' => $voucher_total,
												'voucher_gift' => $voucher_gift);
						  dsf_db_perform(DS_DB_SHOP . '.voucher_orders', $sql_data_array);
							
							
					
							
								// NEW CODE TO DISABLE A VOUCHER IF USE ONCE.
								$chek_voucher = dsf_db_query("select voucher_single from " . DS_DB_SHOP . ".voucher_codes where voucher_number ='" . $voucher_number . "'");
								$chek_voucher_item = dsf_db_fetch_array($chek_voucher);
								
								if (isset($chek_voucher_item['voucher_single']) && (int)$chek_voucher_item['voucher_single'] == 1){
										// use once voucher.
										$up_vchr = dsf_db_query("update " . DS_DB_SHOP . ".voucher_codes set voucher_status='0' where voucher_number ='" . $voucher_number . "'");
										
										if (dsf_session_is_registered('voucher_number')) dsf_session_unregister('voucher_number');

								}
								// END OF NEW CODE TO DISABLE A VOUCHER IF USE ONCE.
								
												dsf_session_unregister('voucher_id');
												dsf_session_unregister('dsv_voucher_valid');
												dsf_session_unregister('dsv_voucher_error');
												dsf_session_unregister('voucher_total');
												dsf_session_unregister('voucher_gift');
						  
												$voucher_id ='';
												$dsv_voucher_valid ='';
												$dsv_voucher_error ='';
												$voucher_total ='';
												$voucher_gift ='';
						  
						  
						}
						// ############# end of voucher specific code ##############
						
						
						// Now create the products
						
						
						  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
						  // update ads information for every product.
								  if (!$order->products[$i]['warranty']) {
									if ($_GET['cpgn']){
										dsf_add_campaign_result((int)dsf_get_prid($order->products[$i]['id']), '2', (int)$_GET['cpgn']);
									}
								  }
						
						// Stock Update
						   
							if (STOCK_LIMITED == 'true' && MODULE_PAYMENT_PROTXCC_UPDATE_STOCK_BEFORE_PAYMENT=='True') {
							 
								  
								  
								if (isset($order->products[$i]['parts_id']) && (int)$order->products[$i]['parts_id'] > 0){
									$stock_query = dsf_db_query("select products_quantity from " . DS_DB_SHOP . ".products_parts where products_id = '" . dsf_get_prid($order->products[$i]['parts_id']) . "'");
									
								}else{
									$stock_query = dsf_db_query("select products_quantity from " . DS_DB_SHOP . ".products where products_id = '" . dsf_get_prid($order->products[$i]['id']) . "'");
								}
							  
							  
							  
							  
							  
							  if (dsf_db_num_rows($stock_query) > 0) {
								$stock_values = dsf_db_fetch_array($stock_query);
								  $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
								
								// PARTS DIFFERENCE
								
								if (isset($order->products[$i]['parts_id']) && (int)$order->products[$i]['parts_id'] > 0){
											dsf_db_query("update " . DS_DB_SHOP . ".products_parts set products_quantity = '" . $stock_left . "' where products_id = '" . dsf_get_prid($order->products[$i]['parts_id']) . "'");
										if ( ($stock_left < 1) && (STOCK_DISABLE_QUANTITY == 'True') ) {
		
										  dsf_db_query("update " . DS_DB_SHOP . ".products_parts set products_status = '0' where products_id = '" . dsf_get_prid($order->products[$i]['parts_id']) . "'");
										}
								}else{
									// standard routine
											dsf_db_query("update " . DS_DB_SHOP . ".products set products_quantity = '" . $stock_left . "' where products_id = '" . dsf_get_prid($order->products[$i]['id']) . "'");
										if ( ($stock_left < 1) && (STOCK_DISABLE_QUANTITY == 'True') ) {
		
										  dsf_db_query("update " . DS_DB_SHOP . ".products set products_status = '0' where products_id = '" . dsf_get_prid($order->products[$i]['id']) . "'");
										}
								}
								
							  }
							}
						
						// Update products_ordered	
						 
								// PARTS DIFFERENCE
								
								if (isset($order->products[$i]['parts_id']) && (int)$order->products[$i]['parts_id'] > 0){
									dsf_db_query("update " . DS_DB_SHOP . ".products_parts set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . dsf_get_prid($order->products[$i]['parts_id']) . "'");
								}else{
									// standard rountine
									dsf_db_query("update " . DS_DB_SHOP . ".products set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . dsf_get_prid($order->products[$i]['id']) . "'");
								}
						
						
						
							$sql_data_array = array('orders_id' => $insert_id, 
													'products_id' => dsf_get_prid($order->products[$i]['id']), 
													'parts_id' => $order->products[$i]['parts_id'],
													'warranty_id' => $order->products[$i]['warranty'], 
													'products_model' => $order->products[$i]['model'], 
													'products_name' => $order->products[$i]['name'], 
													'products_price' => $order->products[$i]['price'], 
													'final_price' => $order->products[$i]['final_price'], 
													'products_tax' => $order->products[$i]['tax'], 
													'products_quantity' => $order->products[$i]['qty'],
													'products_deposit' => $order->products[$i]['products_deposit'],
													'additional_carriage' => $order->products[$i]['additional_carriage'],
													'shipping_latency' => $order->products[$i]['shipping_latency']
													);
							dsf_db_perform(DS_DB_SHOP . ".orders_products", $sql_data_array);
							$order_products_id = dsf_db_insert_id();
						
						
						//------insert any attibutes to the order --------
							$attributes_exist = '0';
							$products_ordered_attributes = '';
							if (isset($order->products[$i]['attributes'])) {
							  $attributes_exist = '1';
							  for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
								  $attributes = dsf_db_query("select popt.products_options_id, popt.products_options_name, poval.products_options_values_id, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . DS_DB_SHOP . ".products_options popt, " . DS_DB_SHOP . ".products_options_values poval, " . DS_DB_SHOP . ".products_attributes pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id");
								
								$attributes_values = dsf_db_fetch_array($attributes);
						
								$sql_data_array = array('orders_id' => $insert_id, 
														'orders_products_id' => $order_products_id, 
														'option_id' => $attributes_values['products_options_id'],
														'value_id' => $attributes_values['products_options_values_id'],
														'products_options' => $attributes_values['products_options_name'],
														'products_options_values' => $attributes_values['products_options_values_name'], 
														'options_values_price' => $attributes_values['options_values_price'], 
														'price_prefix' => $attributes_values['price_prefix']);
								dsf_db_perform(DS_DB_SHOP . ".orders_products_attributes", $sql_data_array);
							
								$products_ordered_attributes .=  $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'] . ' ';
							  }
							}
						
							$total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
							$total_tax += dsf_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
							$total_cost += $total_products_price;
						
						  } // end of products loop.
						
						
// update transaction details

$write_notes = dsf_update_transaction($insert_id, 'Order Created ' . $trans_notes);

// end of update transaction details



return $insert_id;

} // end function creating order



// function to update stock on an order purchased
function dsf_update_order_stock($savedorder){
global $currencies;
			$orderid = $savedorder->info['id'];
								
								
								
									   for ($i=0, $n=sizeof($savedorder->products); $i<$n; $i++) {
									 
																				 
																						$new_array = '';
																						$newlineitem ='';
									 
									 
																				// Stock Update
																					if (STOCK_LIMITED == 'true') {
																					
																					if ((int)$savedorder->info['stock_deducted'] <> 1){ // not already deducted
																					
																					
																						$products_attributes = $savedorder->products[$i]['attributes'];
																				
																											if(is_array($products_attributes)){
																											
																															$new_array = array();
																															foreach($products_attributes as $key => $value){
																																$new_array[] = '~' . trim($value['option_id']) . ':' . trim($value['value_id']);
																															}
																											
																														if (is_array($new_array)){
																																$arsort = asort($new_array);
																																
																																foreach ($new_array as $key => $value){
																																	$newlineitem .= trim($value);
																																}
																														}
																														
																														if ($newlineitem){
																														// get stock value based on this line;
																															$attribute_stock = dsf_find_attributes_stock(dsf_get_prid($savedorder->products[$i]['id']), $newlineitem);
																														}
																												
																												
																											  } else {
																													if (isset($savedorder->products[$i]['parts_id']) && (int)$savedorder->products[$i]['parts_id'] > 0){
																														$stock_query = dsf_db_query("select products_quantity from " . DS_DB_SHOP . ".products_parts where products_id = '" . dsf_get_prid($savedorder->products[$i]['parts_id']) . "'");
																													}else{
																														// standard rountine
																														$stock_query = dsf_db_query("select products_quantity from " . DS_DB_SHOP . ".products where products_id = '" . dsf_get_prid($savedorder->products[$i]['id']) . "'");
																													}
																											  
																											  
																											  }
																											
																											
																											   // attributes stock section if available
																						
																								
																				
																									if ($newlineitem){
																										 $stock_before_processing = (int)$attribute_stock;
																										 
																										 $stock_left = (int)$attribute_stock - (int)$savedorder->products[$i]['qty'];
																										dsf_update_attributes_stock(dsf_get_prid($savedorder->products[$i]['id']), $newlineitem, $attribute_stock, $stock_left);		
																					
																									}else{
																					
																											  if (dsf_db_num_rows($stock_query) > 0) {
																												$stock_values = dsf_db_fetch_array($stock_query);
																										// do not decrement quantities if products_attributes_filename exists
																														$stock_left = (int)$stock_values['products_quantity'] - (int)$savedorder->products[$i]['qty'];
																												
																												// PARTS DIFFERENCE
																													if (isset($savedorder->products[$i]['parts_id']) && (int)$savedorder->products[$i]['parts_id'] > 0){
																												
																												dsf_db_query("update " . DS_DB_SHOP . ".products_parts set products_quantity = '" . $stock_left . "' where products_id = '" . dsf_get_prid($savedorder->products[$i]['parts_id']) . "'");
																							
																												// create audit trail.
																							
																							
																							
																														if ( ($stock_left < 1) && (STOCK_DISABLE_QUANTITY == 'True') ) {

																														  dsf_db_query("update " . DS_DB_SHOP . ".products_parts set products_status = '0' where products_id = '" . dsf_get_prid($savedorder->products[$i]['parts_id']) . "'");
																														}
																											 
																														if ( ($stock_left < 1) && (LATENCY_CHANGE_NO_STOCK == 'True') ) {
																														
																																// check values of LATENCY_CHANGE_TO_VALUE and DEPOSIT_CHANGE_TO_VALUE
																																$sql_items = 0;
																																$sql_data_array = array();
																																
																																if (LATENCY_CHANGE_TO_VALUE <> 'nochange'){
																																	$sql_items ++;
																																	$sql_data_array['shipping_latency'] = LATENCY_CHANGE_TO_VALUE;
																																}
																																
																																if (DEPOSIT_CHANGE_TO_VALUE <> 'nochange'){
																																	$sql_items ++;
																																	$sql_data_array['products_deposit'] = DEPOSIT_CHANGE_TO_VALUE;
																																}
																														
																															if ((int)$sql_items > 0){
																																dsf_db_perform(DS_DB_SHOP . '.products_parts', $sql_data_array, 'update', "products_id = '" . dsf_get_prid($savedorder->products[$i]['parts_id']) . "'");
																															}
																														}
																												
																												
																												
																												
																												
																												
																													}else{
																														// standard rountine
																														
																												dsf_db_query("update " . DS_DB_SHOP . ".products set products_quantity = '" . $stock_left . "' where products_id = '" . dsf_get_prid($savedorder->products[$i]['id']) . "'");
																							
																												// create audit trail.
																												
																																					$sql_data_array = array('products_id' => dsf_get_prid($savedorder->products[$i]['id']),
																																					'stock_before' => $stock_values['products_quantity'],
																																					'stock_after' => $stock_left,
																																					'stock_process' => 'Order ' . $orderid);
																															
																																dsf_db_perform(DS_DB_SHOP . '.stock_audit', $sql_data_array);
																							
																							
																							
																														if ( ($stock_left < 1) && (STOCK_DISABLE_QUANTITY == 'True') ) {

																														  dsf_db_query("update " . DS_DB_SHOP . ".products set products_status = '0' where products_id = '" . dsf_get_prid($savedorder->products[$i]['id']) . "'");
																														}
																											 
																														if ( ($stock_left < 1) && (LATENCY_CHANGE_NO_STOCK == 'True') ) {
																														
																																// check values of LATENCY_CHANGE_TO_VALUE and DEPOSIT_CHANGE_TO_VALUE
																																$sql_items = 0;
																																$sql_data_array = array();
																																
																																if (LATENCY_CHANGE_TO_VALUE <> 'nochange'){
																																	$sql_items ++;
																																	$sql_data_array['shipping_latency'] = LATENCY_CHANGE_TO_VALUE;
																																}
																																
																																if (DEPOSIT_CHANGE_TO_VALUE <> 'nochange'){
																																	$sql_items ++;
																																	$sql_data_array['products_deposit'] = DEPOSIT_CHANGE_TO_VALUE;
																																}
																														
																															if ((int)$sql_items > 0){
																																dsf_db_perform(DS_DB_SHOP . '.products', $sql_data_array, 'update', "products_id = '" . dsf_get_prid($savedorder->products[$i]['id']) . "'");
																															}
																														}
																														
																														
																													}
																														
																														
																											  }
																					  
																					  } // end of attribute stock or normal stock.
																					  
																						
																						// mark order as stock deducted.
																						$sql_data_array = array('stock_deducted' => '1');
																						dsf_db_perform(DS_DB_SHOP . '.orders',$sql_data_array,'update','orders_id='.$orderid);
																					  
																					  
																					  } // end of stock not already deducted.
																					  
																					} // end of stock update
									
									
									} // end of for each product loop.
 // just for consistancy,  return something.
 return true;
} // end update stock function.





function dsf_order_email_items($savedorder, $add_address='true'){
	// function to take an order and create a html section and plain text section to use in emails.
	global $currencies;
	
	$plain_products = '';
	$html_products = '<table width="400" cellspacing="0">' . "\n";
	
	
	// headers
						$plain_products = ' ' . dsf_format_fixed_length('-','81','right','-') . ' ' . "\n";
						$plain_products .= '| ' . dsf_format_fixed_length(TRANSLATION_BASKET_QUANTITY,'8') . ' | ' . dsf_format_fixed_length(TRANSLATION_BASKET_PRODUCT,'50') . ' | ' . dsf_format_fixed_length(TRANSLATION_BASKET_PRICE,'15','right',' ') . ' | ' . "\n";
						$plain_products .= '| ' . dsf_format_fixed_length('-','8','right','-') . ' | ' . dsf_format_fixed_length('-','50','right','-') . ' | ' . dsf_format_fixed_length('-','15','right','-') . ' | ' . "\n";

						$html_products .= '<tr><td width="50" align="center" class="shaded">' . TRANSLATION_BASKET_QUANTITY . '</td><td width="250" align="left" class="shaded">' . TRANSLATION_BASKET_PRODUCT . '</td><td width="100" align="right" class="shaded">' . TRANSLATION_BASKET_PRICE . '</td></tr>' . "\n";
						




									 for ($i=0, $n=sizeof($savedorder->products); $i<$n; $i++) {
															$products_ordered_attributes = "";
															$html_products_ordered_attributes ='';
						 
														  if (sizeof($savedorder->products[$i]['attributes']) > 0) {
															$attributes_exist = '1';
															$products_ordered_attributes = "";
															$html_products_ordered_attributes ='';
															for ($j = 0, $k = sizeof($savedorder->products[$i]['attributes']); $j < $k; $j++) {
															  $products_ordered_attributes .= $savedorder->products[$i]['attributes'][$j]['option'] . ': ' . $savedorder->products[$i]['attributes'][$j]['value'];
															  if ($savedorder->products[$i]['attributes'][$j]['price'] != '0'){
																	$products_ordered_attributes .= ' (' . $savedorder->products[$i]['attributes'][$j]['prefix'] . $currencies->format($savedorder->products[$i]['attributes'][$j]['price'] * $savedorder->products[$i]['qty'], true, $savedorder->info['currency'], $savedorder->info['currency_value']) . ')' . "\n";
																	$html_products_ordered_attributes .= "<br />" . ' (' . $savedorder->products[$i]['attributes'][$j]['prefix'] . $currencies->format($savedorder->products[$i]['attributes'][$j]['price'] * $savedorder->products[$i]['qty'], true, $savedorder->info['currency'], $savedorder->info['currency_value']) . ')';
															   }
															}
														  }
				
														$prod_name = $savedorder->products[$i]['name'];
				
				
				
								 // plain text product
								 
								  $plain_products .= '| ' . dsf_format_fixed_length($savedorder->products[$i]['qty'],'8','right') . ' | ' . dsf_format_fixed_length($prod_name,'50') . ' | ' . dsf_format_fixed_length($currencies->display_price($savedorder->products[$i]['final_price'], $savedorder->products[$i]['tax'], $savedorder->products[$i]['qty']),'15','right') . ' | ' . "\n";
								  $plain_products .= '| ' . dsf_format_fixed_length(' ','8','right',' ') . ' | ' . dsf_format_fixed_length($savedorder->products[$i]['model'],'50') . ' | ' . dsf_format_fixed_length(' ','15','right',' ') . ' | ' . "\n";
								  
								  
								  if (strlen($products_ordered_attributes)>1){
								  		$plain_products .= '| ' . dsf_format_fixed_length(' ','8','right',' ') . ' | ' . dsf_format_fixed_length($products_ordered_attributes,'50') . ' | ' . dsf_format_fixed_length(' ','15','right',' ') . ' | ' . "\n";
								  }
					
								  $plain_products .= '| ' . dsf_format_fixed_length('-','8','right','-') . ' | ' . dsf_format_fixed_length('-','50','right','-') . ' | ' . dsf_format_fixed_length('-','15','right','-') . ' | ' . "\n";


					
								  // html part
									$html_products .= '<tr><td width="50" align="center" valign="middle">' . $savedorder->products[$i]['qty'] . '</td><td align="left">' . $prod_name . '<br />' . $savedorder->products[$i]['model'];
									
								  		if (strlen($html_products_ordered_attributes)>1){
											$html_products .= $html_products_ordered_attributes;
										}
									
									 $html_products .= '</td><td width="100" align="right" valign="middle">' . $currencies->display_price($savedorder->products[$i]['final_price'], $savedorder->products[$i]['tax'], $savedorder->products[$i]['qty']) . '</td></tr>' . "\n";
									
									
								 
								  $products_ordered_attributes = '';
								  $html_products_ordered_attributes = '';
							}


					// put the totals in.
							$order_total = array();
		
								for ($i=0, $n=sizeof($savedorder->totals)+1; $i<$n; $i++) {
									$totalclass = $savedorder->totals[$i]['class'];
									
									if (strlen($savedorder->totals[$i]['class']) > 1){
									$order_total[$totalclass] = array('title' => $savedorder->totals[$i]['title'],
																	  'text' => $savedorder->totals[$i]['text'],
																	  'value' => $savedorder->totals[$i]['value']
																	  );
									}
								}

								
								
								// subtotal
									$plain_products .= '| ' . dsf_format_fixed_length(' ','8','right',' ') . ' | ' . dsf_format_fixed_length(TRANSLATION_BASKET_SUBTOTAL,'50','left',' ') . ' | ' . dsf_format_fixed_length(strip_tags($order_total['ot_subtotal']['text']),'15','right',' ') . ' | ' . "\n";
									$html_products .= '<tr><td colspan="2" align="right" valign="top">' . TRANSLATION_BASKET_SUBTOTAL . '</td><td align="right">' . strip_tags($order_total['ot_subtotal']['text']) . '</td></tr>' . "\n\n";
								
								// delivery
									$delivery_cost = ((float)$order_total['ot_shipping']['value'] > 0 ? $order_total['ot_shipping']['text'] : TRANSLATION_CHECKOUT_FREE);
									
										$plain_products .= '| ' . dsf_format_fixed_length(' ','8','right',' ') . ' | ' . dsf_format_fixed_length($order_total['ot_shipping']['title'],'50','left',' ') . ' | ' . dsf_format_fixed_length(strip_tags($delivery_cost),'15','right',' ') . ' | ' . "\n";
										$html_products .= '<tr><td colspan="2" align="right" valign="top">' . $order_total['ot_shipping']['title'] . '</td><td align="right">' . strip_tags($delivery_cost) . '</td></tr>' . "\n\n";
								
								
								// discount
								
									if ((float)$order_total['ot_discount']['value'] > 0){
										$plain_products .= '| ' . dsf_format_fixed_length(' ','8','right',' ') . ' | ' . dsf_format_fixed_length($order_total['ot_discount']['title'],'50','left',' ') . ' | ' . dsf_format_fixed_length(strip_tags($order_total['ot_discount']['text']),'15','right',' ') . ' | ' . "\n";
										$html_products .= '<tr><td colspan="2" align="right" valign="top">' . $order_total['ot_discount']['title'] . '</td><td align="right">' . strip_tags($order_total['ot_discount']['text']) . '</td></tr>' . "\n\n";
									}
								
								
								
								
								// total
								
									$plain_products .= '| ' . dsf_format_fixed_length(' ','8','right',' ') . ' | ' . dsf_format_fixed_length(TRANSLATION_BASKET_TOTAL,'50','left',' ') . ' | ' . dsf_format_fixed_length(strip_tags($order_total['ot_total']['text']),'15','right',' ') . ' | ' . "\n";
									$html_products .= '<tr><td colspan="2" align="right" valign="top">' . TRANSLATION_BASKET_TOTAL . '</td><td align="right">' . strip_tags($order_total['ot_total']['text']) . '</td></tr>' . "\n\n";
								
									
									
					
					
					// CLOSE OFF TABLE
					$plain_products .= ' ' . dsf_format_fixed_length('-','81','right','-') . ' ' . "\n";

					$html_products .= '</table>' . "\n\n";



		 if ($add_address == 'true'){
	 			// add the address information as well.
	 
	 
						$plain_products .= "\n" . TRANSLATION_CHECKOUT_BILLING_TITLE . "\n" . 
										EMAIL_SEPARATOR . "\n" .
										dsf_invoice_address_label($savedorder->customer['id'], false) . "\n";
									
						
						$html_products .= "<br /><br /><strong>" . TRANSLATION_CHECKOUT_BILLING_TITLE . "</strong><br />\n" . 
										dsf_invoice_address_label($savedorder->customer['id'], true) . "\n";
						
									
						
						$plain_products .= "\n" . TRANSLATION_CHECKOUT_DELIVERY_MAIL_NAME . "\n" ; 
						$html_products .= "<br /><br /><strong>" . TRANSLATION_CHECKOUT_DELIVERY_MAIL_NAME . "</strong><br />\n"; 
						
						
						 if (isset($savedorder->delivery['name']) && strlen($savedorder->delivery['name']) > 1){
								// delivery name set do delivery address as well.
								$plain_products .= dsf_delivery_address_label($savedorder->customer['id'], false). "\n";
								$html_products .=	dsf_delivery_address_label($savedorder->customer['id'], true). "\n"; 
						 }else{
								$plain_products .= dsf_invoice_address_label($savedorder->customer['id'], false). "\n";
								$html_products .=	dsf_invoice_address_label($savedorder->customer['id'], true). "\n"; 
						 }


	 
	 
 		}

return array('plain' => $plain_products,
			 'html' => $html_products);

}
?>