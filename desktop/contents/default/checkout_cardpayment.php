<!--content start -->
<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>

<?php 
// echo the start of the checkout form.
echo $dsv_checkout_form_start;

	// echo the current steps images.
	?>
			  <div id="dscheckoutBasketSteps"><?php 
			  echo dsf_image_button('step1_0.gif', 'Step 1').
			  dsf_image_button('step_seperator.gif', 'Next Step').
			   dsf_image_button('step2_1.gif', 'Step 2').
			    dsf_image_button('step_seperator.gif', 'Next Step').
				 dsf_image_button('step3_0.gif', 'Step 3');
				  ?>
				 </div>
				 
				 
				 <?php
				 // echo any error.
				 
				 if (isset($dsv_checkout_error) && strlen($dsv_checkout_error)>1){
				 	echo $dsv_checkout_error;
				 }
				
	?>



<div class="dscheckoutCardSection">
	<div class="dscheckoutTitleHead"><?php echo '<span class="dscheckoutTitleText">Basket Contents</span> <a href="' . dsf_link('basket.html','', 'NONSSL') . '" class="dscheckoutChange">(Change)</a>'; ?></div>

	<div class="dscheckoutSection">
	
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	
	
	
									<?php
									
									  foreach($dsv_basket_products as $product) {

											// show the products in basket.
												?>
													<tr>
													<td class="main" align="right" valign="top" width="30"><?php echo $product['qty'] . '&nbsp;x&nbsp;';?></td>
													<td class="main" valign="top"><?php
														 
														 
													// if warranty show that first.
													if (isset($product['warranty']) && strlen($product['warranty'])>1){
														   echo $product['warranty'] . ' for<br>';
													}
													
													// show products name
													echo $product['products_name'];
													
													// if there are any product options show them here.
													if (isset($product['options']) && strlen($product['options'])>1){
														   echo '<br>' . $product['options'];
													}
		
													// if there is a delivery latency show that.
													if (isset($product['latency']) && strlen($product['latency'])>1){
														   echo '<br><span class="dsLatencyBasketText">Delivery: ' . $product['latency'] . '</span>';
													}
													 
													// if there is a deposit required show that.
													if (isset($product['products_deposit']) && strlen($product['products_deposit'])>1){
														   echo '<br><span class="dsDepositBasketText">Deposit Required: ' . $product['products_deposit'] . '</span>';
													}
 
													?>
													</td>

													<td class="dsbasketQuantitySide">&nbsp;</td>
													<td class="main" align="right" valign="top"><?php echo $product['price'];?></td>
													</tr>
									 <?
									  } // end foreach products
									
										// totals
										
										// subtotal
									
										if (isset($dsv_total_goods) && strlen($dsv_total_goods)>1){
										?>
										<tr>
										 <td colspan="3" class="dsbasketQuantityTopSide">Sub-Total</td>
										 <td class="dscheckoutTopBar" align="right" valign="middle" ><?php echo $dsv_total_goods;?></td>
										</tr>
										<?php
										} // end of subtotal

										// delivery
										if (isset($dsv_total_delivery) && strlen($dsv_total_delivery)>1){
										?>
										<tr>
										 <td colspan="3" class="dsbasketQuantitySideTotal" align="right" valign="middle" ><?php echo $dsv_delivery_title;?></td>
										 <td align="right"><?php echo $dsv_total_delivery;?></td>
										</tr>
										<?php
										} // end of delivery


										// discount
										if (isset($dsv_total_discount) && strlen($dsv_total_discount)>1){
										?>
										<tr class="dscheckoutTotalDiscount">
										 <td colspan="3" class="dsbasketQuantitySideTotal" align="right" valign="middle" ><?php echo $dsv_voucher_number;?></td>
										 <td align="right" valign="middle">- <?php echo $dsv_total_discount;?></td>
										</tr>
										<?php
										} // end of discount


										// total
										if (isset($dsv_total_gross) && strlen($dsv_total_gross)>1){
										?>
										<tr class="dscheckoutTotalValue">
										 <td colspan="3" class="dsbasketQuantitySideTotal" align="right" valign="middle" ><strong>Total</strong></td>
										 <td align="right" valign="middle"><strong><?php echo $dsv_total_gross;?></strong></td>
										</tr>
										<?php
										} // end of total



										// Deposit
										if (isset($dsv_total_deposit_required) && strlen($dsv_total_deposit_required)>1){
										?>
										<tr class="dscheckoutTotalDeposit">
										 <td colspan="3" class="dsbasketQuantitySideTotal" align="right" valign="middle" ><strong>Deposit Required Today</strong></td>
										 <td align="right" valign="middle"><strong><?php echo $dsv_total_deposit_required;?></strong></td>
										</tr>
										<?php
										} // end of deposit

									?>
							
							</table>

  </div>
  </div>
 
 
 
 <div class="dscheckoutCardSection">
	<div class="dscheckoutTitleHead"><?php echo '<span class="dscheckoutTitleText">Address Information</span> <a href="' . dsf_link('checkout_basket.html','', 'SSL') . '" class="dscheckoutChange">(Edit)</a>'; ?></div>

	<div class="dscheckoutSection">

					<?php if($dsv_delivery_address_used == 'true'){
					?>
					
								<div class="dscheckoutAddress">
									<div class="dsAddressTitle"><strong>Customer Address</strong></div>
									<div><?php echo $dsv_billing_address; ?></div>
								</div>
								
									<div class="dsAddressTitle"><strong>Delivery Address</strong> (if different)</div>
									<div><?php echo $dsv_delivery_address; ?></div>
								
					<?php
					}else{
					?>
								<div class="dscheckoutAddress">
									<div class="dsAddressTitle"><strong>Customer Address</strong></div>
									<div><?php echo $dsv_billing_address; ?></div>
								</div>
								
									<div><?php echo $dsv_address_information;?></div>


					
					<?php
					}
					?>



		</div>
	</div>
	
	



	
 <div class="dscheckoutCardSection">
	<div class="dscheckoutTitle">Please Complete Card Information</div>

	<div class="dscheckoutSection">

						<?php
						 // start credit card information

						 ?>
						 <div id="dscheckoutCardInfo">Please enter your card details below and click on the confirm order button. Fields marked with an <span class="dsinputRequirement">*</span> are mandatory</div>
						
							<div class="dscheckoutInput"><label for="cc_number">Card Number <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_input('cc_number','','size="28"','forminput'); ?>
							<span class="dscheckoutNotes">(Enter without spaces)</span>
							</div>
							
							
							<div class="dscheckoutInput"><label for="cc_ctype">Card Type <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_dropdown('cc_ctype', $dsv_cardtypes,$cc_ctype,'','forminput');?>
							</div>
							
							<div class="dscheckoutInput"><label for="cc_owner">Cardholders Name <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_input('cc_owner',$cc_owner,'size="28"','forminput'); ?>
							<span class="dscheckoutNotes">(As it is shown on the card)</span>
							</div>
							
							
							<div class="dscheckoutInput"><label for="cc_start_month">Valid From</label>
							<?php echo '<span class="dscheckoutDates">Month: &nbsp;</span>' . dsf_form_dropdown('cc_start_month', $dsv_expires_month, $cc_start_month,'','forminput') . '<span class="dscheckoutDates">&nbsp;Year: &nbsp;</span>' .  dsf_form_dropdown('cc_start_year', $dsv_start_year, $cc_start_year,'','forminput');?>
							<span class="dscheckoutNotes">(If not present leave blank)</span>
							</div>
							
							
							
							<div class="dscheckoutInput"><label for="cc_expires_month">Expiry Date <span class="dsinputRequirement">*</span></label>
							<?php echo '<span class="dscheckoutDates">Month: &nbsp;</span>' . dsf_form_dropdown('cc_expires_month', $dsv_expires_month, $cc_expires_month,'','forminput') . '<span class="dscheckoutDates">&nbsp;Year: &nbsp;</span>' .  dsf_form_dropdown('cc_expires_year', $dsv_expires_year, $cc_expires_year,'','forminput');?>
							</div>
							
							<div class="dscheckoutInput"><label for="cc_issue_number">Issue Number</label>
							<?php echo dsf_form_input('cc_issue_number',$cc_issue_number,'size="10"','forminput');?>
							<span class="dscheckoutNotes">(Switch / Maestro / Solo Only)</span>
							</div>
							
							
							<div class="dscheckoutInput"><label for="cc_issue_number">Security Code <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_input('cc_ccv_number',$cc_ccv_number,'size="10"','forminput');?>
							<span class="dscheckoutNotes">(The last 3 digits on the reverse of the card)</span>
							</div>
							

		</div>
		</div>
						 
<div id="dsbuttonConfirm"><?php echo dsf_submit_image($dsv_confirm_order_button, 'Make Payment and Confirm Order');?></div>
<?php echo $dsv_checkout_form_end;?>