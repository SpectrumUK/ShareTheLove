<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// objective is to take a voucher number supplied and decide if it is valid or not.
// then if it is,  calculate the values.


function dsf_validate_voucher($voucher_number) {
global $currencies, $basket;

	$return_values = array();
	
			$current_cart_total = $basket->show_total();
				
			// check the voucher against the database
			
			$vcheck_query = dsf_db_query("select voucher_id, voucher_title, voucher_number, voucher_gift, voucher_type, voucher_spend, voucher_message, voucher_value, voucher_products, voucher_system, voucher_single from " . DS_DB_SHOP . ".voucher_codes where voucher_status = '1' and voucher_number ='" . $voucher_number . "'");
			
			if (dsf_db_num_rows($vcheck_query) >0){ // we have a result.
							$vchecks = dsf_db_fetch_array($vcheck_query);
							
						// so far valid,  create values before checking for minimum spend..
						
							$return_values['voucher_id'] = $vchecks['voucher_id'];
							$return_values['voucher_number'] = $vchecks['voucher_number'];
							$return_values['voucher_gift'] = $vchecks['voucher_gift'];
							$return_values['voucher_spend'] = $vchecks['voucher_spend'];
							$return_values['voucher_value'] = $vchecks['voucher_value'];
							$return_values['voucher_title'] = $vchecks['voucher_title'];
						
							$voucher_spend = (float)$vchecks['voucher_spend'];
						
						// ALL THE REST OF THE CHECKS ARE BASED ON THE VALUE IN vchecks['voucher_system'];
						// THIS BEING WHETHER OR NOT ALL PRODUCTS,  SPECIFIC PRODUCTS , FULL PRICE PRODUCTS.
						
						
						// ALL PRODUCTS 
						if ($vchecks['voucher_system'] == 0){
						
									if ($vchecks['voucher_type'] == '1'){	// percentage
										$voucher_total = $currencies->format_numeric(($current_cart_total / 100) * $return_values['voucher_value']);
									}else{
										$voucher_total = $return_values['voucher_value'];
									}
									
									$return_values['voucher_message'] = str_replace('[total]' , $currencies->format($voucher_total), $vchecks['voucher_message']);
									
					
									// check to make sure that a minimum spend is in effect.
									
									if ($current_cart_total < $voucher_spend){
										$return_values['voucher_valid'] = 'false';
										
												$return_values['voucher_error'] = '<strong>ERROR</strong> This voucher can only be used when spending ' . $currencies->format($voucher_spend) . ' or more (excluding delivery charges)';
		
									}else{
										// voucher must be good
										$return_values['voucher_valid'] = 'true';
										$return_values['voucher_total'] = $voucher_total;
									}

					
					} // END OF ALL PRODUCTS 

					
						// FULL PRICE PRODUCTS 
					elseif ($vchecks['voucher_system'] == 2){
						
								// get value of all full price products in the basket.
								$full_price_car_total = 0;
								
										$products = $basket->get_products();
										for ($i=0, $n=sizeof($products); $i<$n; $i++) {
											if (isset($products[$i]['products_full_price']) && (int)$products[$i]['products_full_price'] > 0){
												$full_price_car_total .= $currencies->display_numeric_price($products[$i]['final_price'], dsf_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']);											
											}
										}
								
								
									if ((float)$full_price_car_total > 1){
								
												if ($vchecks['voucher_type'] == '1'){	// percentage
													$voucher_total = $currencies->format_numeric(($full_price_car_total / 100) * $return_values['voucher_value']);
												}else{
													$voucher_total = $return_values['voucher_value'];
												}
												
												$return_values['voucher_message'] = str_replace('[total]' , $currencies->format($voucher_total), $vchecks['voucher_message']);
												
								
												// check to make sure that a minimum spend is in effect.
												
												if ($full_price_car_total < $voucher_spend){
													$return_values['voucher_valid'] = 'false';
													
															$return_values['voucher_error'] = '<strong>ERROR</strong> This voucher can only be used when spending ' . $currencies->format($voucher_spend) . ' or more on full priced items';
					
												}else{
													// voucher must be good
													$return_values['voucher_valid'] = 'true';
													$return_values['voucher_total'] = $voucher_total;
												}
									  }else{
									  	// the current basket contains no full priced items therefore error.
													$return_values['voucher_valid'] = 'false';
													
															$return_values['voucher_error'] = '<strong>ERROR</strong> This voucher can not be used against special offer items';
										
									   }
					
										if ($current_cart_total < $voucher_spend){
													$return_values['voucher_valid'] = 'false';
										
															$return_values['voucher_error'] = '<strong>ERROR</strong> This voucher can not be used against special offer items';
										}

					} // END OF FULL PRICE ONLY.
					
					
						// FULL PRICE PRODUCTS 
					elseif ($vchecks['voucher_system'] == 1){
						
								// specific products are within the field voucher_products as an array;
								
								if (isset($vchecks['voucher_products']) && strlen($vchecks['voucher_products']) >1){
								
									$available_voucher_products = explode(':', $vchecks['voucher_products']);
								}else{
								
									$available_voucher_products = '';
								}
								
								
								
								if (is_array($available_voucher_products) && sizeof($available_voucher_products) >0){
											
												//create a better array which we can work with.
												$spc_products = array();
												
												
												foreach ($available_voucher_products as $item => $value){
														$spc_products[$value] = 'true';
												}
												
								
												// get value of all full price products in the basket.
												$full_price_car_total = 0;
												
														$products = $basket->get_products();
														for ($i=0, $n=sizeof($products)+1; $i<$n; $i++) {
															$prd_checker = $products[$i]['id'];
															if (isset($spc_products[$prd_checker]) && $spc_products[$prd_checker] == 'true'){
																$full_price_car_total += $currencies->display_numeric_price($products[$i]['final_price'], dsf_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']);											
															}
														}
								
												
												
												
													if ((float)$full_price_car_total > 1){
												
																if ($vchecks['voucher_type'] == '1'){	// percentage
																	$voucher_total = $currencies->format_numeric(($full_price_car_total / 100) * $return_values['voucher_value']);
																}else{
																	$voucher_total = $return_values['voucher_value'];
																}
																
																$return_values['voucher_message'] = str_replace('[total]' , $currencies->format($voucher_total), $vchecks['voucher_message']);
																
												
																// no minimum values can be in effect for specific products therefore
																// set the voucher value.
																	// voucher must be good
																	$return_values['voucher_valid'] = 'true';
																	$return_values['voucher_total'] = $voucher_total;
																
													  }else{
														// the current basket contains no full priced items therefore error.
																	$return_values['voucher_valid'] = 'false';
																			$return_values['voucher_error'] = '<strong>ERROR</strong> Thare are no applicable items in your basket for this voucher';
														}
									   }else{
									   
									   		// no array of products so error.
													$return_values['voucher_valid'] = 'false';
													
															$return_values['voucher_error'] = '<strong>ERROR</strong> Thare are no applicable items in your basket for this voucher';
										}
										
										
										
										if ($current_cart_total < $voucher_spend){
													$return_values['voucher_valid'] = 'false';
										
															$return_values['voucher_error'] = '<strong>ERROR</strong> Thare are no applicable items in your basket for this voucher';
										}
					

					} // END OF SPECIFIC PRODUCTS ONLY.
					
			
				
			}else{  // VOUCHER NOT FOUND,  IMMEDIATE ERROR
				$return_values['voucher_valid'] = 'false';
						$return_values['voucher_error'] = '<strong>ERROR</strong> Invalid voucher';
					$return_values['voucher_number']='';
			}

return $return_values;
} 


// end functions
?>