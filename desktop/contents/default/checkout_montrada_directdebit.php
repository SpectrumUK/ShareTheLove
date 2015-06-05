<!-- body //-->
	<div class="baskHeader" id="contentDiv">
		<div id="contentHeader" class="baskImg">
        	<div id="stepImg"><?php echo dsf_image('custom/basket_s3.jpg', 'Step 3. Payment Details', '415', '76');?></div>
        </div>
    </div>  
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
			<div id="rightContent">
            <div class="pagTitles">
            <h1><?php echo TRANSLATION_CHECKOUT_PAYMENT_TITLE ?></h1>
          	</div>


<?php 
// echo the start of the checkout form.
echo $dsv_checkout_form_start;


	// echo the current steps images.
	?>
			  <div id="dscheckoutBasketSteps"><?php /*
			  echo dsf_image_button('step1_0.gif', 'Step 1').
			  dsf_image_button('step_seperator.gif', 'Next Step').
			   dsf_image_button('step2_1.gif', 'Step 2').
			    dsf_image_button('step_seperator.gif', 'Next Step').
				 dsf_image_button('step3_0.gif', 'Step 3');
				  */?>
				 </div>
				 
				 
				 <?php
				 // echo any error.
				 
				 if (isset($dsv_checkout_error) && strlen($dsv_checkout_error)>1){
				 	echo $dsv_checkout_error;
				 }
				
	?>



<div class="dscheckoutCardSection">
	<div class="dscheckoutTitleHead"><?php echo '<span class="dscheckoutTitleText">' . TRANSLATION_CHECKOUT_BASKET_CONTENT . '</span> <a href="' . dsf_link('basket.html','', 'NONSSL') . '" class="dscheckoutChange">(' . TRANSLATION_CHECKOUT_CHANGE . ')</a>'; ?></div>

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
											//			   echo '<br><span class="dsLatencyBasketText">Delivery: ' . $product['latency'] . '</span>';
													}
													 
													// if there is a deposit required show that.
													if (isset($product['products_deposit']) && strlen($product['products_deposit'])>1){
											//			   echo '<br><span class="dsDepositBasketText">Deposit Required: ' . $product['products_deposit'] . '</span>';
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
										 <td colspan="3" class="dsbasketQuantityTopSide"><?php echo TRANSLATION_BASKET_SUBTOTAL;?></td>
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
										 <td colspan="3" class="dsbasketQuantitySideTotal" align="right" valign="middle" ><strong><?php echo TRANSLATION_BASKET_TOTAL; ?></strong></td>
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
 
 
 
 <div class="dscheckoutCardSections">
	<div class="dscheckoutTitleHead"><?php echo '<span class="dscheckoutTitleText">' . TRANSLATION_CHECKOUT_ADDRESS_SUB_TITLE . '</span> <a href="' . dsf_link('checkout_basket.html','', 'SSL') . '" class="dscheckoutChange">(' . TRANSLATION_CHECKOUT_CHANGE . ')</a>'; ?></div>

	<div class="dscheckoutSection">

					<?php if($dsv_delivery_address_used == 'true'){
					?>
					
								<div class="dscheckoutAddress">
									<div class="dsAddressTitle"><strong><?php echo TRANSLATION_CHECKOUT_BILLING_TITLE;?></strong></div>
									<div><?php echo $dsv_billing_address; ?></div>
								</div>
								
									<div class="dsAddressTitle"><strong><?php echo TRANSLATION_CHECKOUT_DELIVERY_TITLE;?></strong></div>
									<div><?php echo $dsv_delivery_address; ?></div>
								
					<?php
					}else{
					?>
								<div class="dscheckoutAddress">
									<div class="dsAddressTitle"><strong><?php echo TRANSLATION_CHECKOUT_BILLING_TITLE;?></strong></div>
									<div><?php echo $dsv_billing_address; ?></div>
								</div>
								
					<?php
					/*				<div><?php echo $dsv_address_information;?></div>
					*/
					?>

					
					<?php
					}
					?>



		</div>
	</div>
	
	



	
 <div class="dscheckoutCardSections">
	<div class="dscheckoutTitle"><?php echo TRANSLATION_CHECKOUT_DIRECTDEBIT_TITLE;?></div>
	<div id="dscheckoutRequired">* <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO;?></div>
	
    <div class="dscheckoutSection">
			<div class="checkoutDirectLogo"><?php echo dsf_image('custom/ec-zeichen.png', 'Electronic Cash', '150', '177');?></div>
						<?php
						 // start credit card information

						 ?>


 							<div class="dscheckoutInput"><label for="dd_sortcode"><?php echo TRANSLATION_CHECKOUT_DIRECTDEBIT_SORTCODE;?> <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_input('dd_sortcode',$dd_sortcode,'size="10"','forminput');?>
							</div>



							<div class="dscheckoutInput"><label for="dd_number"><?php echo TRANSLATION_CHECKOUT_DIRECTDEBIT_NUMBER;?> <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_input('dd_number',$dd_number,'size="10"','forminput');?>
                            </div>
							
							
							<div class="dscheckoutInput"><label for="dd_name"><?php echo TRANSLATION_CHECKOUT_DIRECTDEBIT_NAME;?> <span class="dsinputRequirement">*</span></label>
							<?php echo dsf_form_input('dd_name',$dd_name,'size="28"','forminput');?>
							</div>





							

		</div>
		</div>
						 
<div id="dsDDbuttonConfirm"><?php echo dsf_submit_image($dsv_confirm_order_button, TRANSLATION_CHECKOUT_CONFIRM_ORDER);?></div>
<?php echo $dsv_checkout_form_end;?>

</div>
	</div>