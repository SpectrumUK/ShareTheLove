<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


function dsf_create_webshop_lower_menu_cache($parent_id=0, $spacer='', $loop=''){

$line = '';

	// get all upper menu items from database
	
	

	$query = dsf_db_query("select sm.id, sm.menu_type, sm.item_fields, sm.menu_title, sm.action_type, sm.item_url, sm.item_clickable, sm.item_id, sm.item_class, sm.secure_item, sm.item_one, sm.item_two, sm.new_window, sm.customer_status from " . DS_DB_SHOP . ".menu_system_items sm where sm.parent_id='" . (int)$parent_id . "' and sm.menu_active='1' and sm.menu_location='2' order by sm.sort_order");

	
	if (dsf_db_num_rows($query) > 0){
	
			$line = $spacer . '<ul>' . "\n";
			
			
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
					
					
					
					
					
					
					// get item specifics
					if ((int)$menu_type == 2 || (int)$menu_type == 4){	// dropdown or standard link
					
						
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
					
					}elseif ((int)$menu_type == 3){ // Search Box
					
							$dynamic_name = 'Search';
							$dynamic_url = dsf_href_link('search.html');
							
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
					
					} // end if types
						
			
			
				// now we know what we are, we can start creating the li
				
				
						$pline .= $spacer . '  <li';
						if (isset($item_id) && strlen($item_id)>1){
							$pline .=' id="' . $item_id . '"';
						}
						
						if (isset($item_class) && strlen($item_class)>1){
							$pline .=' class="' . $item_class . '"';
						}
			
						$pline .= '>';
						
						// next url
						

					if (isset($include_file) && $include_file == 'true'){
						
						// we are including an external file therefore thats what we add rather than an item and link
						
										$line .= $pline;
										$line .= "<?php \n";
										$line .= 'include("' . $include_file_name . '")';
										$line .= "?>" . "\n";
										$line .='</li>';

					}else{
						// standard link routines
						


									if ((int)$item_clickable == 1){
											// disable click
											$pline .= '<a href="#">';
									}else{
									
											if (strlen($item_url)>1){
												$pline .='<a href="' . $item_url . '"';
												if ((int)$new_window == 1){
													$pline .=' target="_blank"';
												}
											}else{
												// dynamic url
												if ((int)$secure_item == 1){
													$dynamic_url = str_replace('http://' , 'https://' , $dynamic_url);
												}
												$pline .='<a href="' . $dynamic_url . '"';
												if ((int)$new_window == 1){
													$pline .=' target="_blank"';
												}
											}
											$pline.= '>';
									
									} // end line clickable
											
											if (strlen($menu_title)>1){
												$pline .= $menu_title;
											}else{
												$pline .= $dynamic_name;
											}
											
											$pline .= '</a>';
											
						
										// decide if there are any siblings to do here:
										
										if ($menu_type == 2 || $loop == 'yes'){ // we are a dropdown, we can therefore go down upto two levels
											
											if ((int)$menu_type == 2 ){ // dropdown only first box
												$pline .= "<ul> \n <li> \n";
											}
											
											$pline .= dsf_create_webshop_lower_menu_cache($id, $spacer . '   ', 'yes');
											
											// then two specific boxes if they exist
					
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
											$pline .='<div class="dsRemBox">';
											$pline .= '<div class="dsRemBoxItem">';
											
												if (isset($return_value1['menu_image']) && strlen($return_value1['menu_image'])> 3){
													if (isset($return_value1['url']) && strlen($return_value1['url'])> 3){
														$new_url = $return_value1['url'];
													}else{
														$new_url = '#';
													}
												
													$pline .= '<a href="' . $new_url . '">' . dsf_image($return_value1['menu_image'], $return_value1['title'] , MENU_IMAGE_WIDTH, MENU_IMAGE_HEIGHT,'','','YES') . '</a>';
											
												}
											$pline .= '</div>' . "\n";
											
												
												if (is_array($return_value2)){
													// check for second item (only if the first one existed)
															$pline .= '<div class="dsRemBoxItem">';
															
																if (isset($return_value2['menu_image']) && strlen($return_value2['menu_image'])> 3){
																	if (isset($return_value2['url']) && strlen($return_value2['url'])> 3){
																		$new_url = $return_value2['url'];
																	}else{
																		$new_url = '#';
																	}
																
																	$pline .= '<a href="' . $new_url . '">' . dsf_image($return_value2['menu_image'], $return_value2['title'] , MENU_IMAGE_WIDTH, MENU_IMAGE_HEIGHT,'','','YES') . '</a>';
															
																}
															$pline .= '</div>' . "\n";
												}
										
										
											$pline.= '</div>' . "\n";
											
			
										} // end if is array return value 1
										
												if ((int)$menu_type == 2 ){ // dropdown only first box
													$pline .= "</li> \n </ul> \n";
												}
										
										}elseif ($menu_type == 3) { // search has a dropdown
										
										
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
										
										
											$pline .= $spacer . '  <ul>';
											$pline .= $spacer . '     <li><div id="dsSearchBox">';
											$pline .= $spacer . '     <div id="dsSearchTitle">' .$subi_array[1] .'</div>';
											
											$pline .= dsf_form_create('quick_find', dsf_href_link('search_results.html') ,'get');
											$pline .= '<div id="sdSearchField">' . dsf_form_search('keywords', (strlen($keywords) >3 ? $keywords : ''), 'size="40" maxlength="255"','dsSearchItem',$subi_array[4]) . '</div>';
											$pline .= '<div id="dsSearchButton">' . dsf_submit_image('button_search.gif', TRANSLATION_SEARCH_BUTTON,'','YES') . '</div>';
											$pline .= dsf_hide_session_id() . '</form>';
											$pline .= '</div>';
											$pline .='</li>';
											$pline .= $spacer . '  </ul>';
										
			
			
										}elseif ($menu_type == 1) { // basket - we need to add some php code to be executed..
											$pline .= "<?php ";
											 $pline .= "if (isset($\dsv_disable_ecommerce) && $\dsv_disable_ecommerce =='false'){" . "\n";
											 $pline .= "include('custom_modules/default/basket_menu_header.php');";
											 $pline .= "}?>";
			
			
			
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
											$pline .= $spacer . '  <ul>';
											$pline .= $spacer . '     <li><div id="dsPaABox">';
											$pline .= $spacer . '     <div id="dsPaATitle">' .$subi_array[1] .'</div>';
											
											
											// get the data from the distributors table for the list of items.
											$dis_query = dsf_db_query("select * from " . DS_DB_SHOP . ".distributors order by sort_order");
											$total_dist = dsf_db_num_rows($dis_query);
											
											$dist_counter = 0;
											
											while ($dis_results = dsf_db_fetch_array($dis_query)){
												$dist_counter ++;
												
												if ($dist_counter < $total_dist){
													$pline .= $spacer .'      <div class="dsPaAItem"';
												}else{
													$pline .= $spacer .'      <div class="dsPaAItemNS"';
												}	
													
													if (isset($dis_results['distributor_url']) && strlen($dis_results['distributor_url']) > 1){
														$pline .= ' onclick="window.open(\'' . $dis_results['distributor_url'] . '\');"  style="CURSOR:pointer"';
													}
													
													$pline .= '>';
													
													$pline .='<div class="dsPaAName">' . $dis_results['distributor_name'] . '</div>';
													
													$pline .='<div class="dsPaAPhone">' . $dis_results['distributor_phone'] . '</div>';
											
													$pline .='</div>' . "\n";
											} // end while
											
											// button to page where to buy
											
											
											$pline .='<div id="dsPaAButton"><a href="' . dsf_href_link('where_to_buy.html') . '">' . dsf_image('custom/acMenu_moredetails_button.gif' , TRANSLATION_MORE_INFORMATION,'','','','','YES') . '</a></div>';
										
											
											
											$pline .= '</div>';
											$pline .='</li>';
											$pline .= $spacer . '  </ul>';
										
										}
			
			
										
										// close of the upper li
										
										$pline .= $spacer . '  </li>' . "\n";
												
									
									if ($customer_status == 1){ // any user
										$line .= $pline;
									}elseif ($customer_status == 2){
										$line .= "<?php \n";
										$line .= "if (isset($\dsv_disable_ecommerce) && $\dsv_disable_ecommerce =='false'){" . "\n";
										$line .= "   if (isset($\dsv_customer_id) && (int)$\dsv_customer_id > 0){" . "\n";
										$line .= "   // do nothing there is a user logged in \n";
										$line .= "   }else{ // show item \n";
										$line .= "?>" . "\n";
										$line .= $pline .  "\n";
										$line .= "<?php \n";
										$line .= "   } \n";
										$line .= "} \n";
										$line .= "?>" . "\n";
										
									}elseif ($customer_status == 3){
										$line .= "<?php \n";
										$line .= "if (isset($\dsv_disable_ecommerce) && $\dsv_disable_ecommerce =='false'){" . "\n";
										$line .= "   if (isset($\dsv_customer_id) && (int)$\dsv_customer_id > 0){" . "\n";
										$line .= "   // only show when there is a user logged in \n";
										$line .= "?>" . "\n";
										$line .= $pline .  "\n";
										$line .= "<?php \n";
										$line .= "   } \n";
										$line .= "} \n";
										$line .= "?>" . "\n";
									}		
												
									
					} // end whether include
					
			
			} // end topmost while
	$line .= $spacer . '  </ul>' . "\n";
	
	} // end if any items found
	
	return $line;
} // end function






//$tmp_cache_file = strtolower(DS_FS_WEBSHOP . 'cache/' . CONTENT_CACHE_PREFIX . CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX . '_lower_menu_cache.php');

$tmp_cache_file  = "cache/gb_en_lower_menu_cache.php";


if (file_exists($tmp_cache_file)) {
		include($tmp_cache_file);
}else{

// create the menu
 $new_menu = dsf_create_webshop_lower_menu_cache(0);

	$fp = fopen($tmp_cache_file, "w");
	fputs($fp, str_replace("$\\" , "$", $new_menu));
	fclose($fp);

		include($tmp_cache_file);
}

?>