<div id="dsBasketMask" class="dsBasketS1"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_BASKET_TITLE); ?></h1>
            <?php 
		// display any errors that may exist.
		
//		if (isset($dsv_voucher_error) && strlen($dsv_voucher_error)>1){
//					echo $dsv_voucher_error;
//			}
		
		if (isset($dsv_delivery_error) && strlen($dsv_delivery_error)>1){
					echo $dsv_delivery_error;
			}
		
		if (isset($dsv_paypal_notes) && strlen($dsv_paypal_notes)>1){
					echo $dsv_paypal_notes;
			}
			
		// check for items in the basket that can not be checked out.
			// if it exists then show an error message.
			if (isset($dsv_checkout_disabled) && $dsv_checkout_disabled == 'true'){
			?>
            
			<div class="dscheckoutError"><?php echo TRANSLATION_BASKET_NO_CHECKOUT; ?></div>
			<?php
			}
			
			if (isset($over_qty_error) && $over_qty_error == 'true'){
			// tried to add too many of same SKU to basket
			echo '<div class="dscheckoutError">' . TRANSLATION_BASKET_QUANTITY_ERROR . '</div>';
			
			}

		// end of displaying errors
		
		
		
		// write the pages form.
		
		 echo $dsv_basket_form_start;
		
		
		// check to see if there are any items in the basket, if there are then display the basket form.
		// otherwise display a basket empty page.
		
		if ((int)$dsv_basket_contents == 0){ // there are no items in the basket.
		
		?>
		<div class="dsemptyBasket"><?php echo TRANSLATION_BASKET_EMPTY;?></div>
		<div class="dsbasketBtn"><a href="<?php echo $dsv_continue_shopping_url;?>"><?php echo dsf_image_button($dsv_continue_shopping_button, TRANSLATION_BASKET_CONTINUE_SHOPPING);?></a></div>
		
		<?php
		
		}else{
			// there are 1 or more items in the basket.
			?>
            
            <div id="dsbasketStart">
						
					<table width="100%" cellspacing="0" border="0">
							         
                               <tr>
                               <td valign="middle" align="left" colspan="2" class="dsbasketHeaderItem"><?php echo strtoupper(TRANSLATION_BASKET_PRODUCT); ?></td>
							   <td valign="middle" align="left" class="dsbasketHeaderItem"><?php echo strtoupper(TRANSLATION_BASKET_QUANTITY); ?></td>
							   <td valign="middle" align="left" class="dsbasketHeaderItem"><?php echo strtoupper(TRANSLATION_BASKET_PRICE); ?></td>
                               <td valign="middle" align="left" class="dsbasketHeaderItem"><?php echo strtoupper(TRANSLATION_BASKET_REMOVE); ?></td>
                               </tr>
                               
                               <tr>
							   <td valign="top" align="left" colspan="5"><div class="dsBASDivider">&nbsp;</div></td>
							   </tr>

						
						<?php
						 foreach ($dsv_basket_products as $item){
						?>
						
						<tr class="dsTBPRow">
							
							<td width="110" align="left" valign="top" class="dsTBdata"><?php echo '<div class="dsBASproIMG"><a href="' . $item['url'] . '">' . $item['image'] . '</a></div>'; ?></td>
					    <td width="420" align="left" valign="top" class="dsTBdata"><?php 
											// if warranty show that first.
											if (isset($item['warranty']) && strlen($item['warranty'])>1){
												   echo $item['warranty'] . ' for<br>';
										    }
											
											// show products name
											echo '<div class="dsBASproNAME"><a href="' . $item['url'] . '"><strong>' . $item['products_name'] . '</strong></a>' . '<br />' . $item['model'] .'</div>';
											
											// stock message
								if ($item['stock'] == 'In Stock') {
									echo '<div class="dsbasketInstock">' . TRANSLATION_INSTOCK . '</div>';
								}
									
											// if there are any product options show them here.
											/*if (isset($item['options']) && strlen($item['options'])>1){
												   echo '<br><span clsss="dsoptionsBasketText">' . $item['options'] . '</span>';
										    }

											// if there is a delivery latency show that.
											if (isset($item['latency']) && strlen($item['latency'])>1){
												   echo '<br><span class="dsLatencyBasketText">Delivery: ' . $item['latency'] . '</span>';
										    }*/
											 
											// if there is a deposit required show that.
											/*if (isset($item['products_deposit']) && strlen($item['products_deposit'])>1){
												   echo '<br><span class="dsDepositBasketText">Deposit Required: ' . $item['products_deposit'] . '</span>';
										    }*/
							 	?> </td>

							<td width="158" align="center" valign="top" class="dsTBdata"><div class="dsbasketQuantity">
							
							<?php 
							
							
							// hidden fields (all other products information to pass back on a post.
							echo dsf_form_hidden('products_id[]', $item['id']) . dsf_form_hidden('warranty[]', $item['warranty']). dsf_form_hidden('parts_id[]', $item['parts_id']);
							
							/*echo '<div class="dsMINUSbtn">' . dsf_submit_image('button_minus.gif','Deduct One','name=butminus' . $item['id'] . ' align="middle"') . '</div>';*/
							
							// qty text box
							echo '<div class="dsQuantity">' .  dsf_form_input('cart_quantity[]', $item['qty'], 'size="4" maxlength="2" onkeyup="submit();" class="forminput"') . '</div>';
							
							/*// plus button
							echo '<div class="dsPLUSbtn">' .  dsf_submit_image('button_plus.gif','Add another','name=butadd' .$item['id'] . ' align="middle"') . '</div>';*/
			 
							 ?>
							 
							</div>
							</td>
						  <td width="158" align="right" valign="top" class="dsTBdata"><div class="dsBASproPRICE"><?php echo $item['price']; ?></div></td>
                          <td width="112" align="center" valign="top" class="dsTBdata"><div class="dsBASproX"><?php echo dsf_submit_image('remove_btn.gif','Remove','name=remove' . $item['id']);?></div></td>
							</tr>

<?php
						} // end for each
						
						// all products in the basket have now been output.
						
						// Delivery Options
						
						
						
						?>
                        
                        <?php 
						
						
						if ($dsv_total_delivery_options > 1) { // there is more than one delivery option.


						$fim = 0;
						
						foreach($dsv_delivery_items as $dsv_delivery){
							$fim ++;
							
								// calculate if this method is the current selected item.
								$checked = (($dsv_delivery['id'] == $dsv_selected_delivery) ? true : false);
						
						
								if ($checked == true) {
														
														// highlight the selected method in bold.
														?>
															<tr>
															<td class="dsbasketQuantitySide" align="left" valign="top"><?php
                                                            if ($fim == 1){
																?>
                                                                <div class="dsbasketTitleItem"><?php echo strtoupper(TRANSLATION_BASKET_DELIVERY);?></div>
                                                             <?php
															}else {
																echo '&nbsp;';
															}
															?></td>
                      
                      <td width="420"><span class="dsbasketQuantitySide"><?php echo $dsv_delivery['title']; ?></span></td>
                                                            
															<td class="dsbasketQuantitySide" align="center"><strong><?php echo $dsv_delivery['cost']; ?></strong>&nbsp;<?php echo dsf_form_radio('shipping', $dsv_delivery['id'], $checked, 'onClick="submit();"'); ?></td>
															<td align="right" colspan="2"><div class="dsDELCost"><?php echo $dsv_delivery['cost']; ?></div></td>
														  </tr>
													<?php
													}else{
													// non higlighted item.
													?>
															<tr>
															 <td align="left"><?php
                                                            if ($fim == 1){
																?>
                                                                <div class="dsbasketTitleItem"><?php echo strtoupper(TRANSLATION_BASKET_DELIVERY);?></div>
                                                             <?php
															}else {
																echo '&nbsp;';
															}
															?></td>
                                                             <td width="420"><span class="dsbasketQuantitySide"><?php echo $dsv_delivery['title']; ?></span></td>
															<td class="dsbasketQuantitySide" align="center"><?php echo $dsv_delivery['cost']; ?>&nbsp;<?php echo dsf_form_radio('shipping', $dsv_delivery['id'], $checked, 'onClick="submit();"'); ?></td>
                                                            <td></td>
                                                            <td></td>
														  </tr>
										<?php
													}
						} // end for each
						
						?>
						
                        			
						<?php
						}else{
						 // there is only one delivery option.
						?>
									<tr class="dsBASrow">
									
										<td align="left" valign="top"><?php
									// only one method available
									echo '<div class="dsbasketTitleItem">' . strtoupper(TRANSLATION_BASKET_DELIVERY) . '</div>';
					  ?></td>
										<td colspan="2" align="left" valign="top"><div class="dsDELtitle"><small><?php echo $dsv_delivery_items[0]['title']; ?></small></div></td>
                                    <td align="right" valign="top" colspan="2"><div class="dsDELCost"><?php echo $dsv_delivery_items[0]['cost']; ?><?php echo dsf_form_hidden('shipping', $dsv_delivery_items[0]['id']); ?></div></td>
								  </tr>
						<?php
						}					
						// end of delivery options
						?>
							  <?php /*<tr>
								<td colspan="4" class="dsbasketDeliverySide"><?php echo dsf_blank_image('1', '5'); ?></td>
								<td class="dsbasketDeliverySideValue"><?php echo dsf_blank_image('1', '5'); ?></td>
							  </tr> */?>

			<?php
			// check for a discount value
			
			if (isset($dsv_voucher_discount) && strlen($dsv_voucher_discount)>1){
									?>
										<tr class="dsBASrow">
										  	
											<td align="left" valign="top"><div class="dsbasketTitleItem"><?php echo strtoupper(TRANSLATION_BASKET_DISCOUNTS); ?></div></td>
                                            <td colspan="2" align="left" valign="top"><div class="dsDELtitle"><?php echo TRANSLATION_BASKET_VOUCHER_ACCEPTED; ?></div></td>
											<td colspan="2" align="right" valign="top"><div class="dsBASdiscount"><?php echo '- ' . $dsv_voucher_discount; ?></div></td>
										  </tr>
									<?php
			} // end of discount value
			
			// basket total
			?>
										<tr class="dsBASrow">
										  	<td align="left" valign="top"><div class="dsbasketTitleItem"><?php echo strtoupper(TRANSLATION_BASKET_TOTAL); ?></div></td>
                                             <td colspan="2" align="left" valign="top"><div class="dsDELtitle"><small><?php echo TRANSLATION_CHECKOUT_VAT_MESSAGE; ?></small></div></td>
											<td colspan="2" align="right" valign="top"><div class="dsBASTotal"><?php echo $dsv_basket_total; ?></div></td>
										  </tr>
			
									<?php
									
			// deposit required if applicable.
			
			if (isset($dsv_basket_deposit_required) && strlen($dsv_basket_deposit_required)>1){
									?>
										<tr class="dsBASrow">
											<td colspan="2" align="left" valign="top"><div class="dsDELtitle"><?php echo 'Deposit Required * (inc Delivery)'; ?></div></td>
                                            <td align="left" valign="top"><div class="dsbasketTitleItem"><?php echo 'DEPOSIT'; ?></div></td>
											<td colspan="2" align="right" valign="TOP"><div class="dsDELCost"><?php echo $dsv_basket_deposit_required; ?></div></td>
										  </tr>
									<?php
									}
								?>
			
						</table>
  </div>

			<?php
			
			// thats the end of the table for the baskets contents.
			
			
			// check for the deposit value once again to decide if we are to show the note:
			
			if (isset($dsv_basket_deposit_required) && strlen($dsv_basket_deposit_required)>1){
			 ?>
			 <div class="dscheckoutDepositNote">*To place your order today you only need to pay the deposit</div>
			 <?php
			} // end deposit check.

// CROSS SELL

	// check to see if there are any basket accessories (cross-sell) items to show.

	if (isset($dsv_basket_accessories) && sizeof($dsv_basket_accessories)>0){


?>
					<div id="dsBasketScrHold">
                    <div id="dsBasketScrHead" class="dsbasketHeaderItem"><?php echo TRANSLATION_BASKET_CROSS_SELL;?></div>
<?php



			// find out how many items are in the related items to decide whether or not we show scroll items.
			$total_basket_scroll_items = sizeof($dsv_basket_accessories);
		
			if ((int)$total_basket_scroll_items > 5){
				// show scroll arrows as we have more than 5 items to show.
				
				?>
				<script type="text/javascript">
                    
                    
                function tabBskAc(item_direction){
                
                    if (item_direction == 'left'){
                        BskAc_current -= BskAc_scroll;
                            if (BskAc_current <0){
                                BskAc_current = 0;
                            }else{
                                $('#dsBasketScrItem').animate({"left":"+=190px"},"slow");
                            }
                    }
                
                    if (item_direction == 'right'){
                        BskAc_current += BskAc_scroll;
                            if (BskAc_current > BskAc_width){
                                BskAc_current = BskAc_width;
                            }else{
                                $('#dsBasketScrItem').animate({"left":"-=190px"},"slow");
                            }
                    }
                    $('.dsBasketArrow').blur();
                } // end function
                
                
                // set scroll parameters.
                    
                    var BskAc_width = <?php echo (int)$total_basket_scroll_items -5;?>;
                    var BskAc_current = 0;
                    var BskAc_scroll = 1;
                                                    
                                                    
                </script>

					<div class="dsBasketLArrow"><a href="javascript:void(0);" onclick="tabBskAc('left');" class="dsBasketArrow"><?php echo dsf_image('custom/left_arrow.png', 'Left', '55', '55');?></a></div>
					<div class="dsBasketRArrow"><a href="javascript:void(0);" onclick="tabBskAc('right');" class="dsBasketArrow"><?php echo dsf_image('custom/right_arrow.png', 'Right', '55', '55');?></a></div>
				<?php
			} // end of checking whether or not we need to show show bars.
			
			
			
			
				?>
					<div id="dsBasketScrItem">
					
					<div id="dsBasketItems">
						 <ul>
						 
						 <?php
							foreach($dsv_basket_accessories as $item){
								
								$data_to_return = '';
								
									?>
									<li>
											<?php
																	if (isset($item['listing_image']) && strlen($item['listing_image'])>1){
																		$data_to_return .= '<div class="dsPROImg"><a href="' . $item['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$item['model'] . ' ' . $item['name'] .'">' . dsf_image($item['listing_image'], TRANSLATION_FIND_OUT_MORE . ' ' . $item['model'] . ' ' . $item['name'], $item['listing_width'], $item['listing_height'], 'class="dsProIMG"') . '</a></div>' . "\n";
																	}else{
																		$data_to_return .= '<div class="dsPROImg"><a href="' . $item['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$item['model'] . ' ' . $item['name'] .'">' . dsf_notavailable_image($item['listing_width'], $item['listing_height'], 'class="dsProIMG"') . '</a></div>' . "\n";
																	}
							
																	$data_to_return .= '<div class="dsPROTitle">' . '<a href="' . $item['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$item['model'] . ' ' . $item['name'] .'">' . $item['name'] . '</a>' . '</div>' . "\n";
																	$data_to_return .= '<div class="dsPROModel">' . '<a href="' . $item['url'] . '" title="' . TRANSLATION_FIND_OUT_MORE . ' ' .$item['model'] . ' ' . $item['name'] .'">' . $item['model'] . '</a>' . '</div>' . "\n";
                                        
 
 
 
                                                    if (defined('BAZAAR_ENABLE_REVIEWS') && BAZAAR_ENABLE_REVIEWS == 'true'){
                                                                        if (isset($item['AverageOverallRating'])){
                                                                            
                                                                            $data_to_return .= '<div class="dsItemRating">' . dsf_image($item['RatingImage'], $item['AverageOverallRating']) . '</div>' . "\n";
                                                                                
                                                                        }
                                
                                                    }

																		
																			  // look for offer price
																			  
																			  $products_price = '';
																			  
																				 if (isset($item['offer_price']) && strlen($item['offer_price'])>1){
																						$products_price .=  '<div class="dsPROEcom"><div class="dsPROPrice"><span class="dsPROWas">' . $item['price'] . '</span>&nbsp;&nbsp;&nbsp;';
																						$products_price .=  '<span class="dsPRONow">' . $ditem['offer_price'] . '</span></div>';
																					}else{
																						if (isset($item['price']) && strlen($item['price'])>1){
																							$products_price .=  '<div class="dsPROEcom"><div class="dsPROPrice"><div class="dsPRONow">' . $item['price'] . '</div></div>';
																						}else{
																							// put a blank line ine.
																							$products_price .=  '<div class="dsPROEcom"><div class="dsPROPrice">&nbsp;</div>';
																						}
																					}
															
															
																						$data_to_return .= $products_price .  "\n";
																					 
								
																						if ((int)$item['stock'] >0){
																								// in stock
																									$data_to_return .= '<div class="dsPROStock">' . ds_strtoupper (TRANSLATION_INSTOCK) . '</div>' . "\n";
																						
																						}else{
																								// no stock line for consistancy
																									$data_to_return .= '<div class="dsPRONoStock">' . ds_strtoupper (TRANSLATION_OUTOFSTOCK) . '</div></div>' . "\n";
																						} 
                                        
                                        
                                        


                                        
										
                                        // echo the line
										echo $data_to_return;
                                        ?>
									</li>
									<?php
							}
						 
						?>
						</ul>
					</div>
					</div>
			</div>
		<?php
	} // end we have items.


// END CROSS-SELL


			// voucher code box
			
			if ($dsv_vouchers_allowed  == 'true'){
			 // vouchers allowed
			 
?>
				<div id="dsBASVoucher">
                <div class="dscheckoutDepositNote"><?php echo TRANSLATION_BASKET_CODE_DESCRIPTION; ?></div>
				<div class="dsvoucher">
					<div class="dsVTitle"><?php echo TRANSLATION_BASKET_VOUCHER_CODE; ?> :
					<?php
							if ($dsv_voucher_valid == 'true'){
							?>
							<span class="dsvoucherValid"><?php echo TRANSLATION_BASKET_ACCEPTED;?></span>
							<?php
							}elseif ($dsv_voucher_valid == 'false' && strlen($dsv_voucher_error)>1){
							?>
							<span class="dsvoucherError"><?php echo TRANSLATION_BASKET_INVALID;?></span>
                            
							<?php
							}
							?>
                            </div>
				
                <div><?php echo dsf_form_input('input_voucher_code', $dsv_voucher_number,'size="20"', "forminput") . dsf_submit_image($dsv_voucher_button, TRANSLATION_BASKET_VALIDATE, 'name="dsv_voucher_validator" align="left" vspace="3"');?></div>
				</div>
                </div>
                
						<?php
			 
			 
			
			} // end of voucher codes. 
			
			
			// checkout buttons

			// show buttons
			
			echo '<div class="dsBASbtns"><div class="dsbasketButtonLeft"><a href="' . $dsv_continue_shopping_url . '">' . dsf_image_button($dsv_continue_shopping_button, TRANSLATION_BASKET_CONTINUE_SHOPPING) . '</a></div>';
			echo '<div class="dsbasketButtonRight">' . dsf_submit_image($dsv_checkout_button, TRANSLATION_BASKET_CHECKOUT, 'name="checkout_now"') . '</div></div>';


		} // end of check to see if there are any items in the basket.
		
		// close the pages form.
		echo $dsv_basket_form_end;
		
		
		// Check to see if Paypal express or Google checkout is enabled as they require their own forms
		// if they are required then the whole details are stored in the variables:
		// dsv_paypal_express_form and dsv_google_checkout_form.
		
		// if either of these two variables have content,  then the checks have already been completed and
		// echo'ng the variable will add the necessary code to the html page.
		
		if (isset($dsv_paypal_express_form) && strlen($dsv_paypal_express_form)>1){
			echo $dsv_paypal_express_form;
		}
		
		
		if (isset($dsv_google_checkout_form) && strlen($dsv_google_checkout_form)>1){
			echo $dsv_google_checkout_form;
		}
		
		 ?>
<?php
// check to see if there is any basket text to show.
if (isset($dsv_basket_details_text) && strlen($dsv_basket_details_text)>1){
	echo '<div class="dsbasketDetails">' . $dsv_basket_details_text . '</div>';
}
?>
            <?php /*<div class="dsBASLogo"></div>*/?>

  </div>
<!-- Tag for Activity Group: Remington Sales Pages, Activity Name: Universal Basket Page 1, Activity ID: 887993 -->
<!-- Expected URL: http://uk.remington-europe.com/basket.html -->




<?php

	// we need to add some specifics for this iframes url.
	// these form:
	// u1 to u6 for products
	
	$iframe_text = '';
	
	// loop though products maximum 6. starts at 3
	$counter = 0;
	reset($dsv_basket_products);
	
		foreach ($dsv_basket_products as $item){
			$counter ++;
			if ($counter <=6){
				$iframe_text .= 'u' . ($counter +2) . '=' . $item['model'] . ';';
			}
		}
		
	
	// end of text creation
	?>


<!-- <script type="text/javascript">
var axel = Math.random() + "";
var a = axel * 10000000000000;
document.write('<iframe src="http://fls.doubleclick.net/activityi;src=3325575;type=remin754;cat=unive173;<?php /*echo $iframe_text;*/?>ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
</script>
<noscript>
<iframe src="http://fls.doubleclick.net/activityi;src=3325575;type=remin754;cat=unive173;<?php /*echo $iframe_text;?>ord=<?php echo time();*/?>?" width="1" height="1" frameborder="0" style="display:none"></iframe>
</noscript> -->
 
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->