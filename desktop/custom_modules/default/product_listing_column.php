<!-- START CATEGORY LISTING -->
<?php
		
		$data_to_return = '';
		
			// check we have items to show
			
		if ((int)$dsv_product_items >0){			

				// start with category name with a unique id using the slug field
	
				$total_products = sizeof($dsv_products);
								
									
						
									// create the right column
									
										$data_to_return .='<div id="dsPROlist">';
						
										// create unordered list
											$data_to_return .='<ul>';
										
										
												// loop through the remaining products
													    for ($i=0, $n=$total_products; $i<$n; $i++) {

															$data_to_return .= '<li>';
															
																if (isset($dsv_products[$i]['awards']) && is_array($dsv_products[$i]['awards'])){
																	if (isset($dsv_products[$i]['awards'][0]['small_image'])) { // if we have an item in the array, we just want the first one found as we can not have new and special used together
																			$data_to_return .= dsf_image($dsv_products[$i]['awards'][0]['image'], $dsv_products[$i]['awards'][0]['title'], '','', 'class="dsPROLabel"');
																		}// end if award
																}

																	if (isset($dsv_products[$i]['image']) && strlen($dsv_products[$i]['image'])>1){
																		$data_to_return .= '<div class="dsPROImg"><a href="' . $dsv_products[$i]['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'] .'">' . dsf_image($dsv_products[$i]['image'], TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'], $dsv_products[$i]['width'], $dsv_products[$i]['height']) . '</a>' . "\n";
																	}else{
																		$data_to_return .= '<div class="dsPROImg"><a href="' . $dsv_products[$i]['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'] .'">' . dsf_notavailable_image($dsv_products[$i]['width'], $dsv_products[$i]['height']) . '</a>' . "\n";
																	} 
							
																	$data_to_return .= '<div class="dsPROTitle">' . '<a href="' . $dsv_products[$i]['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'] .'">' . $dsv_products[$i]['name'] . '</a>' . '</div>' . "\n";
																	$data_to_return .= '<div class="dsPROModel">' . '<a href="' . $dsv_products[$i]['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'] .'">' . $dsv_products[$i]['model'] . '</a>' . '</div></div>' . "\n";
							
					if (defined('BAZAAR_ENABLE_REVIEWS') && BAZAAR_ENABLE_REVIEWS == 'true'){
							if (isset($dsv_products[$i]['AverageOverallRating'])){
											
											$data_to_return .= '<div class="dsItemRating">' . dsf_image($dsv_products[$i]['RatingImage'], $dsv_products[$i]['AverageOverallRating']) . '</div>' . "\n";
												
										}	
									}
										// ONLY DO PRICE AND STOCK IF ECOMMERCE IS NOT DISABLED
										if ($dsv_disable_ecommerce == 'false'){
																				$products_price = '';
																	
																	
																	if ($dsv_products[$i]['allow_purchase'] == 'true'){
																		
																			  // look for offer price
																				 if (isset($dsv_products[$i]['offer_price']) && strlen($dsv_products[$i]['offer_price'])>1){
																						$products_price .=  '<div class="dsPROEcom"><div class="dsPROPrice"><span class="dsPROWas">' . $dsv_products[$i]['price'] . '</span>&nbsp;&nbsp;&nbsp;';
																						$products_price .=  '<span class="dsPRONow">' . $dsv_products[$i]['offer_price'] . '</span></div>';
																					}else{
																						if (isset($dsv_products[$i]['price']) && strlen($dsv_products[$i]['price'])>1){
																							$products_price .=  '<div class="dsPROEcom"><div class="dsPROPrice"><div class="dsPRONow">' . $dsv_products[$i]['price'] . '</div></div>';
																						}else{
																							// put a blank line ine.
																							$products_price .=  '<div class="dsPROEcom"><div class="dsPROPrice">&nbsp;</div>';
																						}
																					}
															
															
																						$data_to_return .= $products_price .  "\n";
																					 
								
																						if ((int)$dsv_products[$i]['stock'] >0){
																								// in stock
																									$data_to_return .= '<div class="dsPROStock">' . ds_strtoupper (TRANSLATION_INSTOCK) . '</div>' . "\n";
																						
																						}else{
																								// no stock line for consistancy
																									$data_to_return .= '<div class="dsPRONoStock">' . ds_strtoupper (TRANSLATION_OUTOFSTOCK) . '</div></div>' . "\n";
																						} 
																	}else{
																		
																				// product cannot be purchased,  show RRP if enabled
																				
																					if ($dsv_enable_rrp == 'true'){
																			
																								 if (isset($dsv_products[$i]['rrp_price']) && strlen($dsv_products[$i]['rrp_price'])>1){
																										$data_to_return .=  '<div class="dsPROEcom"><div class="dsPROPrice"><div class="dsPRONow">' . TRANSLATION_RRP . ' ' . $dsv_products[$i]['rrp_price'] . '</div></div>';
																								  }else{
																										// we need a blank row to keep everything formatted correctly.
																										$data_to_return .=  '<div class="dsPROEcom"><div class="dsPROPrice">&nbsp;</div>';
																								 }
																					}else{
																					// we need to put a blank in to make everything format correctly.
																										$data_to_return .=  '<div class="dsPROEcom"><div class="dsPROPrice">&nbsp;</div>';
																					}
																					
																					// put blank stock line in.
																					
																							$data_to_return .= '<div class="dsPROStock">&nbsp;</div></div>' . "\n";
																		
																		
																	}
																		
																		
															
										
										}else{
											// ecommerce is disabled
											
													if ($dsv_enable_rrp == 'true'){
											
																 if (isset($dsv_products[$i]['rrp_price']) && strlen($dsv_products[$i]['rrp_price'])>1){
																		$data_to_return .=  '<div class="dsPROEcom"><div class="dsPROPrice"><div class="dsPRONow">' . TRANSLATION_RRP . ' ' . $dsv_products[$i]['rrp_price'] . '</div></div>';
																  }else{
																		// we need a blank row to keep everything formatted correctly.
																		$data_to_return .=  '<div class="dsPROEcom"><div class="dsPROPrice">&nbsp;</div>';
																 }
													}else{
													// we need to put a blank in to make everything format correctly.
																		$data_to_return .=  '<div class="dsPROEcom"><div class="dsPROPrice">&nbsp;</div>';
													}
													
													// put blank stock line in.
													
															$data_to_return .= '<div class="dsPROStock">&nbsp;</div></div>' . "\n";
													
										}
										// end disabled ecommerce check
										
																								
										// button - check to see if we have a buy url.  if we do we use that providing we have stock
										// - otherwise we use the more info button.
										
										/*if ((isset($dsv_products[$i]['buy_url']) && strlen($dsv_products[$i]['buy_url']) > 5) && (int)$dsv_products[$i]['stock'] >0){
																	
													$data_to_return .= '<a href="' . $dsv_products[$i]['buy_url'] . '" title="' . TRANSLATION_ADD_TO_BASKET_BUTTON . ' ' .$dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'] .'">' . dsf_button_image($dsv_buy_button, TRANSLATION_ADD_TO_BASKET_BUTTON . ' ' . $dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'], '124', '29', 'class="dsPRObut"') . '</a>' . "\n";
										}else{
													$data_to_return .= '<a href="' . $dsv_products[$i]['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'] .'">' . dsf_button_image($dsv_moreinfo_button, TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_products[$i]['model'] . ' ' . $dsv_products[$i]['name'], '124', '29', 'class="dsPRObut"') . '</a>' . "\n";
										}*/

																	$data_to_return .= '</li>';
										
														}
												// end remaining products loop.
						
						
										// close unordered list
											$data_to_return .= '</ul>';
										
									// close the right column
										$data_to_return .= '</div>';
						
						
					}else{ // No products
					
						if ($page_name == 'search_results'){
							// different text for search results
							$data_to_return .= '<div class="dsCATtxt"><p>' . TRANSLATION_NO_RESULT_SEARCH . '</p></div>';
						}else{
							// standard listing
							$data_to_return .= '<div class="dsCATtxt"><p>' . TRANSLATION_NO_RESULT_LISTING . '</p></div>';
						}
					
					} // end if products

				// close the category container
					$data_to_return .= '</div>';

				// fix the shadow
		 		$data_to_return .= '<div class="blankBreak"></div>';
	     		// $data_to_return .= '<div class="shadowBreak"></div>';

							
	
	
		echo $data_to_return;

?>
<!--END OF CATEGORY LISTINGS -->