<?php
// ########### VOUCHER SPECIFIC ITEMS
								// firstly remove any voucher session already loaded.
											tep_session_unregister('voucher_id');
											tep_session_unregister('voucher_valid');
											tep_session_unregister('voucher_error');
											tep_session_unregister('voucher_total');
											tep_session_unregister('voucher_gift');
										
											$voucher_id = '';
											$voucher_valid ='';
											$voucher_gift = '';
											$voucher_error ='';
											$voucher_total = '';
											$voucher_message = '';
											$voucher_spend = '';
											$voucher_title = '';
									
									if (tep_session_is_registered('voucher_request')){
											tep_session_unregister('voucher_number');
										    $voucher_number = $voucher_request;
											tep_session_unregister('voucher_request');
									}
									
								
								
								
								// get the new request from the baskets form post.
								
								if (strlen($voucher_number)>1){ // customer has enterred a number
										tep_session_unregister('voucher_number');
								
											$current_cart_total = $cart->show_total();
												
											// check the voucher against the database
											
											$vcheck_query = tep_db_query("select voucher_id, voucher_title, voucher_number, voucher_gift, voucher_type, voucher_spend, voucher_message, voucher_value from voucher_codes where voucher_status = '1' and voucher_number ='" . $voucher_number . "'");
											
											if (tep_db_num_rows($vcheck_query) >0){ // we have a result.
												$vchecks = tep_db_fetch_array($vcheck_query);
												$voucher_id = $vchecks['voucher_id'];
												$voucher_number = $vchecks['voucher_number'];
												$voucher_gift = $vchecks['voucher_gift'];
												$voucher_spend = $vchecks['voucher_spend'];
												$voucher_value = $vchecks['voucher_value'];
												$voucher_title = $vchecks['voucher_title'];
												
												if ($vchecks['voucher_type'] == '1'){	// percentage
													$voucher_total = $currencies->format_numeric(($current_cart_total / 100) * $voucher_value);
												}else{
													$voucher_total = $voucher_value;
												}
													
												
												$voucher_message = str_replace('[total]' , $currencies->format($voucher_total), $vchecks['voucher_message']);
											
											
												// check to make sure that a minimum spend is in effect.
												
												if ($current_cart_total < $voucher_spend){
													$voucher_valid = 'false';
													$voucher_error = '<strong>ERROR</strong> This voucher can only be used when spending ' . $currencies->format($voucher_spend) . ' or more (excluding delivery charges)';
													tep_session_register('voucher_id');
													tep_session_register('voucher_valid');
													tep_session_register('voucher_error');
													tep_session_register('voucher_number');
												}else{
													// voucher must be goog
													$voucher_valid = 'true';
													tep_session_register('voucher_valid');
													tep_session_register('voucher_id');
													tep_session_register('voucher_number');
													tep_session_register('voucher_total');
													tep_session_register('voucher_gift');
												}
											
											
											
											
											}else{
												$voucher_valid = 'false';
												$voucher_error = '<strong>ERROR</strong> Invalid Voucher Code';
													$voucher_number='';
													tep_session_unregister('voucher_id');
													tep_session_unregister('voucher_error');
													tep_session_unregister('voucher_valid');
													tep_session_unregister('voucher_number');
											}
									}
							  
							  // ####### VOUCHER SPECIFIC CODE


// ############ END VOUCHER SPECIFIC ITEMS


?><!-- body //-->

<!--content start --><div id="content">



<img src="img/basket_h1.gif" alt="Basket" width="70" height="31" />


<div class="submenu"><ul>
			<?php
					 $navigation->set_snapshot();
		  			 echo '<li>' . '<a href="' . tep_href_link(FILENAME_HOME) . '">Home</a></li><li>|</li>' . "\n";
					 echo '<li><a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . 'Basket' . '</a></li>';
		 		 ?>
</ul></div>




<div class="basketContent">
<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product&ppid=' . $ppid . '&ccid=' . $ccid. '&alter=' . $alter),'post'); ?>

<?php
if (($delivery_error) && (REQUEST_DELIVERY_DATE == 'true')){
?>
      <div class="errorBox"><?php echo $delivery_error; ?></div>
<?php
}
?>

<?php
  if ($cart->count_contents() <= 0) {
  
  	// no items in basket
	?>
	<div id="emptyBasket">Your Shopping Basket is empty!</div>
	
	<div class="basketSeperator"><hr class="hide"></div>
	
	<div id="basketBtn">
	<?php
	// NOT REQUIRED FOR MARCO
		if ($alter){
			echo '<a href="' . tep_product_link($alter ,'','ppid=' . $ppid) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>';
		}else{
				if ($ppid && (int)$ppid >1){
					echo '<a href="' . tep_product_link($ppid ,'','ppid=' . $ppid) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>';
				}else{
					echo '<a href="' . tep_href_link(FILENAME_HOME) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>';
				}
		}
	// END OF NOT REQUIRED FOR MARCO	
	//	echo '<a href="../cookware.html">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>';
	
		?>
		</div>
		
		
<?php
}else{

// we have products in the basket.
?>
<div id="basketStart"><table width="100%" cellpadding="6" cellspacing="0" border="0">
							
							  <tr class="basketHeaderItem">
							   <td valign="middle" align="center"><b>Remove</b></td>
							   <td valign="middle" align="left" colspan="2"><b>Product</b></td>
							   <td valign="middle" align="center"><b>Quantity</b></td>
							   <td valign="middle" align="center"><b>Price</b></td>
							   </tr>


				<?php
				 // get the products.
				 $inbasket_array = array();
				 
					$any_out_of_stock = 0;
					$products = $cart->get_products();
					
					for ($i=0, $n=sizeof($products); $i<$n; $i++) {
				// Push all attributes information in an array
					  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
						while (list($option, $value) = each($products[$i]['attributes'])) {
						  echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
						  $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
													  from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
													  where pa.products_id = '" . $products[$i]['id'] . "'
													   and pa.options_id = '" . $option . "'
													   and pa.options_id = popt.products_options_id
													   and pa.options_values_id = '" . $value . "'
													   and pa.options_values_id = poval.products_options_values_id
													   and popt.language_id = '" . $languages_id . "'
													   and poval.language_id = '" . $languages_id . "'");
						  $attributes_values = tep_db_fetch_array($attributes);
				
						  $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
						  $products[$i][$option]['options_values_id'] = $value;
						  $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
						  $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
						  $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
						}
					  }
					}
				
					for ($i=0, $n=sizeof($products); $i<$n; $i++) {
						$item_no_stock = 0;
						
					  $cur_row = sizeof($info_box_contents) - 1;
						
						$inbasket_value = $products[$i]['id'];
						$inbasket_unique = tep_get_prid($products[$i]['id']);
						$inbasket_array[$inbasket_value] = 'true';
				
						
					?>
					<tr>
					<td><?php echo tep_draw_checkbox_field('cart_delete[]', $products[$i]['id'], '', 'onclick="submit()"') . tep_image_submit('trans.gif', 'Shopping Cart'); ?></td>
					
					<?php
							// products name and image;
				
				
									$cars_query = tep_db_query("SELECT warranty_id,warranty_name, products_largeimage FROM " . TABLE_WARRANTIES ." where warranty_id = '". $products[$i]['warranty'] . "'");
										$cars = tep_db_fetch_array($cars_query);
						
									  if ($cars['warranty_id']) {
							
											$inbasket_array[$inbasket_unique] = 'warranty';
								  
									  
												$products_name = '<b>' . $cars['warranty_name'] . '</b><br><span class="main"><i>' . $products[$i]['name'] . '</i></span>';

									}elseif ((int)$products[$i]['lamp'] >0){
											$products_name = '<span class="main"><b>' . $products[$i]['name'] . '</b></span>';
									
									

									}else{
									// marco site difference
									/*		$pdurl = tep_get_external_product_url($products[$i]['id']);
											if (strlen($pdurl)>5){
											    $products_name = '<a href="' . '../' . $pdurl . '"class="main"><b>' . $products[$i]['name'] . '</b></a>';
											}else{
											    $products_name = $products[$i]['name'];
											}
									*/		
											// $products_name = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"class="main"><b>' . $products[$i]['name'] . '</b></a>';
											 $products_name = '<a href="' . tep_product_link($products[$i]['id'],$products[$i]['name']) . '"class="main"><b>' . $products[$i]['name'] . '</b></a>';
									}
									
				
				
								
										// add stock information to the item.  (not on warranties or lamps)
										if (!$products[$i]['warranty'] && !$products[$i]['lamp']){
										  if (STOCK_CHECK == 'true') { // check stock
												if (((STOCK_WARN_NO_STOCK == 'true') && (STOCK_ALLOW_CHECKOUT == 'true')) || (STOCK_ALLOW_CHECKOUT == 'false')){
												
													$stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
										   
														if (tep_not_null($stock_check)) {
														  $any_out_of_stock = 1;
												
														  $products_name .= '<br>' . $stock_check;
														}
												}
										  }
										}



								
								
									  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
										reset($products[$i]['attributes']);
										while (list($option, $value) = each($products[$i]['attributes'])) {
										  $products_name .= '<br><span class="optionsBasketText"> ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</span>';
										}
									  }
								
								
									//$product_image = tep_get_products_image($products[$i]['id']);
									
									  if ($cars['products_largeimage']) {
											$product_image = tep_get_basket_image($cars['warranty_id'],'warranty');
										}else{
											$product_image = tep_get_basket_image($products[$i]['id']);
										}
				
						if ((int)$products[$i]['id'] == 57){
								$products_name .= '<br><span class="optionsBasketText">Please note this toaster may be packaged in a plain white box. Please contact Customer Services if you require further assistance.</span>';
						}
						
				
				?>
				<td align="left"><?php echo $product_image; ?> </td>
				<td align="left"><?php echo $products_name; ?> </td>
				<td align="center" class="basketQuantitySide"><div class="basketQuantity">
				
				<?php echo tep_image_submit('button_plus.gif','Add another','name=butadd' .$products[$i]['id'] . ' align="middle" hspace="10"');?>
				
				<?php echo tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4" onkeyup="submit();"','','','formitemCenter'). tep_draw_hidden_field('products_id[]', $products[$i]['id']) . tep_draw_hidden_field('warranty[]', $products[$i]['warranty']) . tep_draw_hidden_field('lamp[]', $products[$i]['lamp']) . tep_draw_hidden_field('bracket[]', $products[$i]['bracket']);?>
				<?php
						// stock check
										if (!$products[$i]['warranty'] && !$products[$i]['lamp']){ // not warranty or lamps
							
									  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
												$stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
									  }else{
												$stock_check = tep_check_stock(tep_get_prid($products[$i]['id']), $products[$i]['quantity']);
									  }	
										
										
										
										}
				 echo tep_image_submit('button_minus.gif','Deduct One','name=butminus' .$products[$i]['id'] . ' align="middle" hspace="10"');
				 
					if (!tep_not_null($stock_check)) {
						echo '<br><span class="basketInstock">IN STOCK</span>';
					}
 
				 
				 ?>
				 
				</div>
				</td>
				<td align="right" ><?php echo	'<b>' . $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>'; ?></td>
				</tr>
				<?php
					} // end of for
				?>


<?php
/*
				</table>
				</td>
				</tr>
*/?>


					  <tr>
						<td colspan="4" class="basketDeliverySide" height="4"><?php echo tep_draw_separator('pixel_trans.gif', '1', '4'); ?></td>
						<td class="basketDeliverySideValue"><?php echo tep_draw_separator('pixel_trans.gif', '70', '4'); ?></td>
					  </tr>
				
				
					  <tr class="basketDeliveryOptions">
						<td align="left" class="main" valign="top">&nbsp;</td>
					   
					   
	
	<?php
					// create delivery array for postage costs.
					
					
					// exclusions required for certain types of deliveries.
					
					// General Exlusion Array
					$del_exclude_options_array = array();
					
					
					
					if (sizeof($del_exclude_options_array) >0){
						// there are exclusions
						
					
						for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
							  for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
							  
									$check_found = 'false';
										for ($ex=0, $ex2=sizeof($del_exclude_options_array); $ex<$ex2; $ex++) {
								  			if ($quotes[$i]['id'] == $del_exclude_options_array[$ex]['id']) {
												$check_found = 'true';
												break;
											}
										}
										if ($check_found == 'false'){
								  			$delivery_array[] = array('id' => $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'],
																	 'text' => str_replace(' ','&nbsp;',$quotes[$i]['methods'][$j]['title']) .'&nbsp;' . $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))),
																	'title' => str_replace(' ','&nbsp;',$quotes[$i]['methods'][$j]['title']),
															  		'cost' => ($quotes[$i]['methods'][$j]['cost'] >0 ? $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))) : ' FREE')
														 );
							  			}
							  }
						  }



					}else{
						// no exclusions
							for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
							  for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
								  $delivery_array[] = array('id' => $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'],
								  'text' => str_replace(' ','&nbsp;',$quotes[$i]['methods'][$j]['title']) .'&nbsp;' . $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))),
								  'title' => str_replace(' ','&nbsp;',$quotes[$i]['methods'][$j]['title']),
								  'cost' => ($quotes[$i]['methods'][$j]['cost'] >0 ? $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))) : ' FREE')
								  );
							  }
						  }
					} // end of exclusion check.
					

		// ADD FREE DELIVERY IF OFFICE SITE IS IN USE
		/*if (OFFICE_SITE_IN_USE <> 'true'){
										  			$delivery_array[] = array('id' => 'free' . '_' . 'free',
																	 'text' => 'Customer Collection' .'&nbsp;' . $currencies->format('0', '0'),
																	'title' => 'Customer Collection',
															  		'cost' => $currencies->format('0', '0')
																	);
																	
		}
		*/


$total_delivery_options_available = (int)sizeof($delivery_array);

// echo ' TOTAL DELIVERY OPTIONS = ' . $total_delivery_options_available;


				   
					 		if (!tep_session_is_registered('shipping')) tep_session_register('shipping');
				

// attempt to calculate whether or not to show the requested delivery date.
$skip_delivery = 'false';
    $temp_stock_check = $cart->get_products();

// print_r ($temp_stock_check);


    for ($i=0, $n=sizeof($temp_stock_check); $i<$n; $i++) {

						if (!$temp_stock_check[$i]['warranty']){
						  
						  if ($temp_stock_check[$i]['lamp']){ // no dates for lamps
											$skip_delivery = 'true';
											$products_delivery_date='';
						  
						  }else{
						  						  
								  if (STOCK_CHECK == 'true') { // check stock
										if (PREVENT_REQUEST_DELIVERY_DATE=='true'){


										if ( (isset($temp_stock_check[$i]['attributes'])) && (is_array($temp_stock_check[$i]['attributes'])) ) {
											$stock_check = tep_check_stock($temp_stock_check[$i]['id'], $temp_stock_check[$i]['quantity']);
										}else{
											$stock_check = tep_check_stock(tep_get_prid($temp_stock_check[$i]['id']), $temp_stock_check[$i]['quantity']);
										}		
												if (tep_not_null($stock_check)) {
													$skip_delivery = 'true';
													$products_delivery_date='';
												}
										}
								  } // end if stock check
						
						 } // end if lamp
						
						} // end if warranty
	} // end product for
	// end of calculating whether or not to show the requested delivery date.
	
				
				//  print_r($delivery_array);
				
				
				
		
					if ($total_delivery_options_available > 0) {
										?>
												<td colspan="3" class="basketQuantitySide" align="left"><?php echo tep_draw_separator('pixel_trans.gif', '105', '1'); ?><b><?php
															 if ($total_delivery_options_available > 1) {
																echo 'Please Select Your Preferred Delivery Method';
															}else{
																// echo 'This is the Only Delivery Method Available';
																echo 'Delivery';
															}
												  ?></b></td>
												  
												  <td >&nbsp;</td>
											</tr>
											<tr>	  
											
								
							
							<?php
							
							if ($total_delivery_options_available <= 1) { // there is only 1 delivery option no need for buttons.
									?>
									<tr>
									<td>&nbsp;</td>
									 <td colspan="3" class="basketQuantitySide" align="left"><?php echo tep_draw_separator('pixel_trans.gif', '105', '1'); ?><strong><?php echo $delivery_array[0]['title']; ?></strong></td>
									<td  align="right"><strong><?php echo $delivery_array[0]['cost']; ?></strong><?php echo tep_draw_hidden_field('shipping', $delivery_array[0]['id']); ?></td>
								  </tr>
							
							<?php
							}else{
							
							
							// code to product radio buttons rather than dropdown box.
							      $radio_buttons = 0;
								  unset($HTTP_POST_VARS['shipping1']);
								  $shipping1 = '';
								  
							
									  for ($i=0, $n2=sizeof($delivery_array); $i<$n2; $i++) {
							// set the radio button to be checked if it is the method chosen
										$checked = (($delivery_array[$i]['id'] == $shipping['id']) ? true : false);
							
									//	echo '<br>delivery_array ' . $i . ' = ' . $delivery_array[$i]['id'] , ' - shipping = ' . $shipping['id'] . ' - checked = ' . $checked;
										
													if ($checked == true) {
														?>
												<tr>
												<td>&nbsp;</td>
												 <td colspan="2" class="main" align="left"><?php echo tep_draw_separator('pixel_trans.gif', '105', '1'); ?><strong><?php echo $delivery_array[$i]['title']; ?></strong></td>
												<td class="basketQuantitySide" align="right"><strong><?php echo $delivery_array[$i]['cost']; ?></strong>&nbsp;&nbsp;<?php echo tep_draw_radio_field('shipping', $delivery_array[$i]['id'], $checked, 'onClick="submit();"'); ?></td>
												<td align="right"><strong><?php echo $delivery_array[$i]['cost']; ?></strong></td>
											  </tr>
										<?php
										}else{
										?>
												<tr>
												<td>&nbsp;</td>
												 <td colspan="2" class="main" align="left"><?php echo tep_draw_separator('pixel_trans.gif', '105', '1'); ?><?php echo $delivery_array[$i]['title']; ?></td>
												<td class="basketQuantitySide" align="right"><?php echo $delivery_array[$i]['cost']; ?>&nbsp;&nbsp;<?php echo tep_draw_radio_field('shipping', $delivery_array[$i]['id'], $checked, 'onClick="submit();"'); ?></td>
												<td align="right"></td>
											  </tr>
										<?php
													}
											$radio_buttons++;
									  }

								} // end of only 1 delivery option.
								
						}  // end of delivery options
									?>
			
	 			
				
							  <tr>
								<td colspan="4" class="basketDeliverySide"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
								<td class="basketDeliverySideValue"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
							  </tr>
				

						  
				<?php 
				
	  							  // ####### VOUCHER SPECIFIC CODE 
				
				if (isset($voucher_total) && $voucher_valid =='true' && (int)$voucher_total >0 && $voucher_gift =='0'){
									?>
										<tr class="checkoutTotalDiscount">
										  <td colspan="2">&nbsp;</td>
											<td colspan="2" align="right" valign="middle" class="basketQuantitySide"><b><?php echo $voucher_title; ?></b></td>
											<td align="right" valign="middle"><b><?php echo '- ' . $currencies->format($voucher_total); ?></b></td>
										  </tr>
									<?php
				
				
									if (($newshipcost >0) && ($newshiptype)){
									?>
										<tr >
										  <td colspan="2">&nbsp;</td>
											<td colspan="2" align="right" class="basketQuantitySide" valign="middle"><b><?php echo 'Total'; ?></b>&nbsp;&nbsp;</td>
											<td align="right" class="main" valign="middle"><b><?php echo $currencies->format((($cart->show_total()) + $newshipcost) - $voucher_total); ?></b></td>
										  </tr>
									<?php
									}else{
									?>
										<tr >
										  <td colspan="2">&nbsp;</td>
											<td colspan="2" align="right" class="basketQuantitySide" valign="middle"><b><?php echo 'Total'; ?></b>&nbsp;&nbsp;</td>
											<td align="right" class="main" valign="middle"><b><?php echo $currencies->format($cart->show_total() - $voucher_total); ?></b></td>
										  </tr>
									<?php
									}
				}else{
	  			// ####### END VOUCHER SPECIFIC CODE  (REMOVE LAST } as well from this IF)
									if (($newshipcost >0) && ($newshiptype)){
									?>
										<tr>
										  <td colspan="2">&nbsp;</td>
											<td colspan="2" align="right" class="basketQuantitySideTotal" valign="middle"><b><?php echo 'Total'; ?></b>&nbsp;&nbsp;</td>
											<td align="right" class="basketQuantityTotal" valign="middle"><b><?php echo $currencies->format(($cart->show_total()) + $newshipcost); ?></b></td>
										  </tr>
									<?php
									}else{
									?>
										<tr >
										  <td colspan="2">&nbsp;</td>
											<td colspan="2" align="right" class="basketQuantitySideTotal" valign="middle"><b><?php echo 'Total'; ?></b>&nbsp;&nbsp;</td>
											<td align="right" class="basketQuantityTotal" valign="middle"><b><?php echo $currencies->format($cart->show_total()); ?></b></td>
										  </tr>
									<?php
									}
				} // VOUCHER IF }
				?>
						</table>
						


<?php
// ########### VOUCHER SPECIFIC ITEMS
if (ALLOW_VOUCHER_CODES  == 'true'){
?>

<div id="voucherInput">
<div><strong>If you have a voucher code, please enter it here:</strong></div>
<div style="padding-top:10px"><label for="input_voucher_code">Voucher Code:</label>&nbsp;<?php echo tep_draw_input_field('input_voucher_code', $voucher_number,'size="20"') . tep_image_submit('button_validate_voucher.gif', 'Validate Voucher Code', 'name="voucher_validator" align="middle" hspace="5"');?></div>


			<?php
			if ($voucher_valid == 'true'){
			?>
			<div id="voucherValid"><?php echo $voucher_message;?></div>
			<?php
			}elseif ($voucher_valid == 'false' && strlen($voucher_error)>1){
			?>
			<div id="voucherError"><?php echo $voucher_error;?></div>
			<?php
			}
			?>
</div>
						<?php
// END OF VOUCHER SPECIFIC
}
						
						
						
						if ((REQUEST_DELIVERY_DATE  == 'true') && ($skip_delivery <>'true')){
						?>
	<div class="basketSeperator"><hr class="hide"></div>

<div id="deliverychoices">
								  <div id="delDateText"><?php 
											echo tep_draw_hidden_field('previous_selected_delivery', $prev_selected_shipping);?>
											<b>Select a Requested Delivery Date for your Order</b></div>
									<div id="delDateBox"><b><?php echo '<span style="color:#ff0000">Choose Delivery Date</span> '; ?></b><small>(DD-MM-YYYY) </small><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?><script language="javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="dd-MM-yyyy";</script></div>


						<?php
						 // NEW DATE STUFF ADDED FOR GOOGLE CHECKOUT
						   if (!isset($products_delivery_date)){
								   $products_delivery_date = tep_get_date_for_delivery();
							}
								?>

    </div>
	<hr class="hide">
						<?php
						}else{		// NO REQUESTED DELIVERY DATE AVAILABLE
						
						?>
			<?php  echo tep_draw_hidden_field('previous_selected_delivery', $prev_selected_shipping) . tep_draw_hidden_field('skip_delivery', $skip_delivery);?>
										
						<?php
						} // END OF REQUESTED DELIVERY DATE
						
						?>

</div>
<?php
}
?>

	<div class="basketSeperator"><hr class="hide"></div>


					<?php
					       if ($cart->count_contents() > 0) {

					?>
							<?php // check to make sure basket can be checked out.
							if ((STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock ==1)){
							?>
							<div class="checkoutError">There are currently out of stock items in your basket!<br />You will not be able to checkout your basket until the items are removed.</div>
							<?php
							}
							?>

							<div id="basketNav">
					
					
					
					<?php
					
								// NOT NEEDED FOR MARCO SITE
								
								if ($alter){
								echo '<div id="basketButtonLeft"><a href="' . tep_product_link($alter ,'', 'ppid=' . $ppid) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a></div>';
								}else{
									if ($ppid && (int)$ppid >1){
										echo '<div id="basketButtonLeft"><a href="' . tep_product_link($ppid ,'', 'ppid=' . $ppid) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a></div>';
									}else{
										echo '<div id="basketButtonLeft"><a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a></div>';
									}
								}
								
								
								// END OF NOT NEEDED FOR MARCO SITE
								
							//	echo '<div id="basketButtonLeft"><a href="../cookware.html">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a></div>';

								echo '<div id="basketButtonRight">' . tep_image_submit('button_our_checkout.gif', IMAGE_BUTTON_CHECKOUT, 'name="checkout_now"') . '</div>';
								
				?>
				</form>
						</div>
				
				<?php
				
				if (ALLOW_GOOGLE_CHECKOUT == 'true'){
				?>
				
				<div id="basketGoogle"><span style="color:#FF0000; font-size:160%; font-weight:bold">OR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
				<?php
								
								  require_once('gc/library/googlecart.php');
  								  require_once('gc/library/googleitem.php');
								  require_once('gc/library/googleshipping.php');
								  require_once('gc/library/googletax.php');

									// Create a new shopping cart object
								//	$merchant_id = "552252722721741";  // Your Merchant ID
									//$merchant_key = "pazwwvWqywglGrTVfuo-Dg";  // Your Merchant Key
									//$server_type = "sandbox";
									$merchant_id = GOOGLE_MERCHANT_ID;  // Your Merchant ID
									$merchant_key = GOOGLE_MERCHANT_KEY;  // Your Merchant Key
									$server_type = GOOGLE_MERCHANT_TYPE;
									$currency = "GBP";
									$gcart = new GoogleCart($merchant_id, $merchant_key, $server_type, $currency); 
								


		// loop to add products
					$google_profit_value = 0;
					
		
					$products = $cart->get_products();
					
					for ($i=0, $n=sizeof($products); $i<$n; $i++) {
				// Push all attributes information in an array
					  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
						while (list($option, $value) = each($products[$i]['attributes'])) {
						  echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
						  $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
													  from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
													  where pa.products_id = '" . $products[$i]['id'] . "'
													   and pa.options_id = '" . $option . "'
													   and pa.options_id = popt.products_options_id
													   and pa.options_values_id = '" . $value . "'
													   and pa.options_values_id = poval.products_options_values_id
													   and popt.language_id = '" . $languages_id . "'
													   and poval.language_id = '" . $languages_id . "'");
						  $attributes_values = tep_db_fetch_array($attributes);
				
						  $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
						  $products[$i][$option]['options_values_id'] = $value;
						  $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
						  $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
						  $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
						}
					  }
					}
				
					for ($i=0, $n=sizeof($products); $i<$n; $i++) {
						$item_no_stock = 0;
						
					  $cur_row = sizeof($info_box_contents) - 1;
						
						$inbasket_value = $products[$i]['id'];
						$inbasket_unique = tep_get_prid($products[$i]['id']);
						$inbasket_array[$inbasket_value] = 'true';
						
						
						$gproducts_model = tep_get_products_model($products[$i]['id']);
						
							// products name and image;
				
				
									$cars_query = tep_db_query("SELECT warranty_id,warranty_name, products_largeimage FROM " . TABLE_WARRANTIES ." where warranty_id = '". $products[$i]['warranty'] . "'");
										$cars = tep_db_fetch_array($cars_query);
						
									  if ($cars['warranty_id']) {
							
											$inbasket_array[$inbasket_unique] = 'warranty';
												$gproducts_name = $cars['warranty_name'] . ' - <i>' . $products[$i]['name'] . '</i>';

									}else{
											$gproducts_name = $products[$i]['name'];
									}
								
								
									  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
										reset($products[$i]['attributes']);
										while (list($option, $value) = each($products[$i]['attributes'])) {
										  $gproducts_name .= ' - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'];
										}
									  }
								
							$gproducts_quantity = $products[$i]['quantity'];
							$gproducts_price =  $currencies->display_numeric_price($products[$i]['final_price'], '0', '1');

							$supplier_query_raw = tep_db_query("select suppliers_price from products where products_id='" . (int)$products[$i]['id'] . "'");
												$suppliers_query = tep_db_fetch_array($supplier_query_raw);
												$suppliers_price = $suppliers_query['suppliers_price'];


							$google_profit_value += ($gproducts_price - $suppliers_price);
							


									
									// Add items to the cart
									$item = new GoogleItem($gproducts_model, // Item name
															 $gproducts_name, // Item description
															 $gproducts_quantity, // Quantity
															 $gproducts_price); // Unit price
									
									//$item_2 = new GoogleItem("PM UFP-280", 
									//						 "Vesa 200 x 200 Adapter Plate", 
									//						 1 , // Quantity
									//						 12.98); // Unit price
									$item->SetMerchantItemId($products[$i]['id']);
									
									$my_private_item_data = array();
									
									$my_private_item_data ['waranty_id'] = $products[$i]['warranty'];
									$my_private_item_data ['lamp_id'] = $products[$i]['lamp'];
									$my_private_item_data ['bracket_id'] = $products[$i]['bracket'];
									$my_private_item_data ['tax'] = tep_get_tax_rate($products[$i]['tax_class_id']);
									
									// ############# voucher specific ################
									// SEND THE VOUCHER INFO TO PUT BACK INTO ORDER INFO ON RETURN
									
									$my_private_item_data ['voucher_valid'] = $voucher_valid;
									$my_private_item_data ['voucher_id'] = $voucher_id;
									$my_private_item_data ['voucher_number'] = $voucher_number;
									$my_private_item_data ['voucher_total'] = $voucher_total;
									$my_private_item_data ['voucher_gift'] = $voucher_gift;
									// ########## end of voucher specific code ############
									
									$item->SetMerchantPrivateItemData($my_private_item_data);
									
									$gcart->AddItem($item);
									//$gcart->AddItem($item_2);
								


					// END OF LOOP ADDING PRODUCTS
					}


								
									$my_private_data = array();
									$my_private_data['delivery-date'] = $products_delivery_date;
									$my_private_data['cart-id'] = $cart->cartID;
									$my_private_data['sess'] = tep_session_id();
									$my_private_data['shipping_method'] = $shipping['id'];
									$my_private_data['shipping_total'] = tep_add_tax($shipping['cost'],tep_get_tax_rate('1'));
									
								
									$gcart->SetMerchantPrivateData($my_private_data);
								
								
								
									// Add shipping options
									$ship_1 = new GoogleFlatRateShipping($shipping['title'], $shipping['cost']);
								
									$restriction_1 = new GoogleShippingFilters();
									$restriction_1->AddAllowedPostalArea("GB");
									$restriction_1->AddExcludedPostalArea("US");
									$restriction_1->SetAllowUsPoBox(false);
									$ship_1->AddShippingRestrictions($restriction_1);
								
								
									$gcart->AddShipping($ship_1);
								
									// Add tax rules
									if (tep_get_tax_rate('1') > 0){
										$tax_rule = new GoogleDefaultTaxRule(0.175,'true');
									}else{
										$tax_rule = new GoogleDefaultTaxRule(0,'false');
									}
									
									$tax_rule->AddPostalArea("GB");
								   // $tax_rule->AddPostalArea("FR");
								  //  $tax_rule->AddPostalArea("DE");
									$gcart->AddDefaultTaxRules($tax_rule);
								
									// Define rounding policy
									$gcart->AddRoundingPolicy("HALF_UP", "PER_LINE");
								  
								    // Request buyer's phone number
									$gcart->SetRequestBuyerPhone("true");

								
									$gcart->SetAdwordsValue('https://www.googleadservices.com/pagead/conversion/1069305337/?value=' . $google_profit_value . '&label=PURCHASE&script=0');
								
									// Display Google Checkout button
									echo $gcart->CheckoutButtonCode("LARGE");
									
									// Display XML data
								//	 echo "<pre>";
								//	 echo htmlentities($gcart->GetXML());
								 //   echo "</pre>";

						?>
						</div>
					<?php
					
					// END OF GOOGLE 								
						}
				

					// show the basket note
					
							$basket_text_query_raw = tep_db_query("select details from basket_info where id='1'");
							$basket_text_query = tep_db_fetch_array($basket_text_query_raw);

								if (strlen($basket_text_query['details'])>1){
								?>
								  <div id="basketDetails"><?php echo nl2br($basket_text_query['details']); ?></div>
							<?php
								}

							// other products of interest
							
							if ($ccid && $ppid){
								if (RESHOW_ACCESSORIES_AT_BASKET == 'true'){
									 include(DIR_WS_MODULES . 'warranty_and_accessories.php');
								}
							}


				
				} // end of items in basket
				?>

















	</div>
</div>