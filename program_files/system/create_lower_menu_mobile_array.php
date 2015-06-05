<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.

/* Although included in the functions folder - this file is a mixture of function and running code.
   its purpose is to create a cache file for the menu array if the menu array does not exist.
   if the menu array does exist,  it just includes the file.
   
*/
   
function dsf_create_webshop_lower_menu_mobile_array($parent_id=0, $spacer='', $loop='', $array_level = ''){

$line = "" . "\n";

if (strlen($array_level) < 1){
	// never ran before therefore we start the array.
	$array_level = '\$mobile_lower_menu_array';
}


	$query = dsf_db_query("select sm.id, sm.menu_type, sm.item_fields, sm.menu_title, sm.action_type, sm.item_url, sm.item_clickable, sm.item_id, sm.item_class, sm.secure_item, sm.item_one, sm.item_two, sm.new_window, sm.customer_status from " . DS_DB_SHOP . ".menu_system_items_mobile sm where sm.parent_id='" . (int)$parent_id . "' and sm.menu_active='1' and sm.menu_location='2' order by sm.sort_order");

	if (dsf_db_num_rows($query) > 0){
	
			$line .= $spacer . $array_level . ' = array();' . "\n";
			
			
			$ar_counter = 0;
			
			while ($results = dsf_db_fetch_array($query)){
			
			
				$pline = '';
			
					// check for menu_type  (type 2 can have children)
					$id = $results['id'];
					
					$menu_type = $results['menu_type'];
						$item_fields = $results['item_fields'];
						$menu_title = $results['menu_title'];

					$action_type = $results['action_type'];
					$item_url = $results['item_url'];
					$item_clickable = $results['item_clickable'];
					$item_id = $results['item_id'];
					$item_class= $results['item_class'];
					$secure_item = $results['secure_item'];
					$item_one = $results['item_one'];
					$item_two = $results['item_two'];
					$new_window = $results['new_window'];
					$customer_status = $results['customer_status'];
					
					$item_type = '';
					
					
					
					
					
					// get item specifics
					if ((int)$menu_type == 2 || (int)$menu_type == 4){	// dropdown or standard link
					
						if ((int)$menu_type == 2){
							$item_type = 'drop down';
						}else{
							$item_type = 'standard link';
						}
						
						// find out what the details for the item are
						$include_file = 'false';
						
							if (isset($item_fields) && strpos($item_fields, ':') > 0){
									$return_values = dsf_get_subpage_item_data($item_fields);
									
									
									if (isset($return_values['include_file']) && strlen($return_values['include_file']) > 1){
										// we are including therefore we add different variables
										$include_file = 'true';
										$include_file_name = $return_values['include_file'];
										
									}else{
										// do standard routine
										
											if(isset($return_values['title'])){
												$dynamic_name = $return_values['title'];
											}else{
												$dynamic_name = '';
											}
											if(isset($return_values['url'])){
												$dynamic_url = $return_values['url'];
											}else{
												$dynamic_url = '';
											}
									}
									
								
							}else{
								$dynamic_name = '';
								$dynamic_url = '';
							}
					
					
					
					}elseif ((int)$menu_type == 1){ // Basket
					
							$dynamic_name = 'Basket';
							
								$dynamic_url = dsf_href_link('basket.html');

							$item_type = 'Basket';


					
					}elseif ((int)$menu_type == 3){ // Search Box
					
							$dynamic_name = 'Search';
							$dynamic_url = dsf_href_link('search.html');
							
							$item_type = 'search';

							if (isset($item_fields) && strpos($item_fields, ':') > 0){
							
								$line_split = explode("\n", $item_fields);
								
								
								if (isset($line_split[0]) && strpos($line_split[0], ':') > 0){
									$split = explode(':', $line_split[0]);
									$search_all_text = $split[1];
								}else{
									$search_all_text = '';
								}
								
								if (isset($line_split[1]) && strpos($line_split[1], ':') > 0){
									$split = explode(':', $line_split[1]);
									$search_products_text = $split[1];
								}else{
									$search_products_text = '';
								}
								
								
							}else{
									$search_all_text = '';
									$search_products_text = '';
							}
		
							
						}elseif ((int)$menu_type == 5){ // Parts Box
							
							$dynamic_name = 'Parts &amp; Accessories';
							$dynamic_url = '#';
							$item_type = 'parts';
					
					} // end if types
						
			
			
				// now we know what we are, we can start creating the li
				
				
						$pline .= $array_level . "[" . $id . "] = array('item_id' => '" . (isset($item_id) && strlen($item_id)>1 ? $item_id : '') . "',";
						$pline .= "'item_class' => '" . (isset($item_class) && strlen($item_class)>1 ? $item_class : '') . "',";
						$pline .= "'item_type' => '" . $item_type . "',";


						// next url
						

					if (isset($include_file) && $include_file == 'true'){
						
						// we are including an external file therefore thats what we add rather than an item and link
						
						
						$pline .= "'include_file' => '" . $include_file_name . "',";
											
											
						if (strlen($menu_title)>1){
								$pline .= "'title' => '" . $menu_title . "');" . "\n";
						}else{
								$pline .= "'title' => '" . $dynamic_name . "');" . "\n";
						}

					}else{
						// standard link routines
						
						$pline .= "'include_file' => '',";


									if ((int)$item_clickable == 1){
											// disable click
											$pline .= "'disable_click' => 'true',";
											$pline .= "'url' => '',";
											$pline .= "'new_window' => 'false',";
									
									}else{
									
											$pline .= "'disable_click' => 'false',";

											if (strlen($item_url)>1){
													$pline .= "'url' => '" . $item_url . "',";
												if ((int)$new_window == 1){
													$pline .= "'new_window' => 'true',";
												}else{
													$pline .= "'new_window' => 'false',";
												}
											}else{
												// dynamic url
												if ((int)$secure_item == 1){
													$dynamic_url = str_replace('http://' , 'https://' , $dynamic_url);
												}
													$pline .= "'url' => '" . $dynamic_url . "',";
												if ((int)$new_window == 1){
													$pline .= "'new_window' => 'true',";
												}else{
													$pline .= "'new_window' => 'false',";
												}
											}
									
									} // end line clickable
									
									
									
											
											if (strlen($menu_title)>1){
													$pline .= "'title' => '" . $menu_title . "',";
											}else{
													$pline .= "'title' => '" . $dynamic_name . "',";
											}
											
											
						
							if ($menu_type == 3) { // search has a dropdown
										
										
											$subi_array = array();
											$subi_array[1] = '';
											$subi_array[2] = '';
											$subi_array[3] = '';
											$subi_array[4] = '';
											
											if (isset($item_fields) && strpos($item_fields,':') > 0){
											
												$exp = explode("\n", $item_fields);
												foreach ($exp as $item){
												
														if (strpos($item,':') > 0) {
														
															$new_item = explode(':', $item);
															$id = (int)$new_item[0];
															$value = $new_item[1];
															if ((int)$id > 0){
																$subi_array[$id] = $value;
															}
														}
												}
											}
										
											$pline .= "'search_form_field_required' => 'keywords',";
											$pline .= "'search_form_name' => 'quick_find',";
											$pline .= "'search_form_url' => 'search_results.html',";
											$pline .= "'search_form_placement' => '" . $subi_array[4] . "',";
										
			
			
										}elseif ($menu_type == 1) { // basket - we need to add some php code to be executed..
											$pline .= "'basket_include_file' => 'basket_menu_header.php',";

			
										}elseif ($menu_type == 5) { // parts has a dropdown which will change over time.
										
											$subi_array = array();
											$subi_array[1] = '';
											$subi_array[2] = '';
											$subi_array[3] = '';
											$subi_array[4] = '';
											
											if (isset($item_fields) && strpos($item_fields,':') > 0){
											
												$exp = explode("\n", $item_fields);
												foreach ($exp as $item){
												
														if (strpos($item,':') > 0) {
														
															$new_item = explode(':', $item);
															$id = (int)$new_item[0];
															$value = $new_item[1];
															if ((int)$id > 0){
																$subi_array[$id] = $value;
															}
														}
												}
											}
											$pline .= "'parts_title' => '" . $subi_array[1] . "',";
											$pline .= "'parts_url' => 'where_to_buy.html',";
											
										
										}
			
			
// if it is a drop down,  we need to see if it has any of the two featured items.

								if ($menu_type == 2){ 
											
					
										if (isset($item_one) && strpos($item_one, ':') > 0){
											$return_value1 = dsf_get_subpage_item_data($item_one);
										}else{
											$return_value1 = '';
										}
					
										if (isset($item_two) && strpos($item_two, ':') > 0){
											$return_value2 = dsf_get_subpage_item_data($item_two);
										}else{
											$return_value2 = '';
										}
										
										if (is_array($return_value1)){
											// we have information in array 1 which is sufficient to start the box
											
												if (isset($return_value1['menu_image']) && strlen($return_value1['menu_image'])> 3){
													if (isset($return_value1['url']) && strlen($return_value1['url'])> 3){
														$new_url = $return_value1['url'];
													}else{
														$new_url = '#';
													}
												
												// +++++++++++++++++++++++++++++++++++++++++++++++
												$pline .= "'feature_one' => array('title' => '" . $return_value1['title'] . "',
												'url' => '" . $new_url . "',
												'image' => '" . $return_value1['menu_image'] . "',
												'image_height' => '" . MENU_IMAGE_HEIGHT . "',
												'image_width' => '" . MENU_IMAGE_WIDTH . "',
												),";
												// +++++++++++++++++++++++++++++++++++++++++++++++
												
											
												}else{
													
													$pline .= "'feature_one' => '',";
												}
											
										} // end feature array one
										
										
												if (is_array($return_value2)){
													// check for second item (only if the first one existed)
															
																if (isset($return_value2['menu_image']) && strlen($return_value2['menu_image'])> 3){
																	if (isset($return_value2['url']) && strlen($return_value2['url'])> 3){
																		$new_url = $return_value2['url'];
																	}else{
																		$new_url = '#';
																	}
																
												// +++++++++++++++++++++++++++++++++++++++++++++++
												$pline .= "'feature_two' => array('title' => '" . $return_value2['title'] . "',
												'url' => '" . $new_url . "',
												'image' => '" . $return_value2['menu_image'] . "',
												'image_height' => '" . MENU_IMAGE_HEIGHT . "',
												'image_width' => '" . MENU_IMAGE_WIDTH . "',
												),";
												// +++++++++++++++++++++++++++++++++++++++++++++++
															
														}else{
															
															$pline .= "'feature_two' => '',";
														}
												} // end feature array 2
										
										
											
			


										
										} // end drop down type 2

									
									if ($customer_status == 1){ // any user
											$pline .= "'login_requirement' => 'any user');". "\n";
									}elseif ($customer_status == 2){
											$pline .= "'login_requirement' => 'must not be logged in');" . "\n";
										
									}elseif ($customer_status == 3){
											$pline .= "'login_requirement' => 'must be logged in');" . "\n";
									}		
												


										// look for children
												if ((int)$menu_type == 2 ){ // dropdown only
										
													$pline .= dsf_create_webshop_lower_menu_mobile_array($id, $spacer . '   ', 'yes', $array_level . "[" . $id . "]['children']");
												}





									
					} // end whether include
					

						$line .= $pline;
						

			
			} // end topmost while
	
	} // end if any items found


	
	return $line;
} // end function






$tmp_cache_file = strtolower(DS_FS_WEBSHOP . 'cache/' . CONTENT_CACHE_PREFIX . CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX . '_lower_menu_cache_mobile.php');

if (file_exists($tmp_cache_file)) {
		include($tmp_cache_file);
}else{

// create the menu
 $new_menu = dsf_create_webshop_lower_menu_mobile_array(0);
 
 $new_menu_text = "<?php" . "\n" . $new_menu . "?>" . "\n";



	$fp = fopen($tmp_cache_file, "w");
	fputs($fp, str_replace("\\$" , "$", $new_menu_text));
	fclose($fp);

unset($new_menu);
unset($new_menu_text);

		include($tmp_cache_file);
}

?>