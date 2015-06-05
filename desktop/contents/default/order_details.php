<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper(TRANSLATION_ACCOUNT_ORDER_REFERENCE); ?></h1>
		
        <div class="dsACSection">
			<?php echo '<strong>' . TRANSLATION_CHECKOUT_ORDER_REFERENCE . ':</strong>&nbsp;&nbsp;' .$dsv_order_number; ?><br />
			<?php echo '<strong>' . TRANSLATION_ACCOUNT_ORDER_DATE . ':</strong>' . '&nbsp;&nbsp;' . $dsv_order_date; ?><br />
			<?php echo '<strong>' . TRANSLATION_ACCOUNT_ORDER_STATUS . ':</strong>&nbsp;&nbsp;' . $dsv_order_status; ?>
		</div>
        <div class="dsACSection">
        <h2><?php echo '<strong>' . TRANSLATION_ACCOUNT_ADDRESS_INFO . '</strong>'; ?></h2>
			<?php if($dsv_delivery_address_used == 'true'){
					?>
					
								<div class="dsorderAddress">
									<div class="dsAddressTitle"><strong><?php echo TRANSLATION_ACCOUNT_CUSTOMER_ADDRESS; ?></strong></div>
									<div><?php echo $dsv_billing_address; ?></div>
								</div>
								
									<div class="AddressTitle"><strong><?php echo TRANSLATION_ACCOUNT_DELIVERY_MAIL_NAME; ?></strong></div>
									<div><?php echo $dsv_delivery_address; ?></div>
								
					<?php
					}else{
					?>
								<div class="dsorderAddress">
									<div class="dsAddressTitle"><strong><?php echo TRANSLATION_ACCOUNT_CUSTOMER_ADDRESS; ?></strong></div>
									<div><?php echo $dsv_billing_address; ?></div>
								</div>
								
									<div>This is the delivery address specified when placing the order. If you have changed your address details since, the new details will apply to any future orders.</div>


					
					<?php
					}
					?>
		</div>
        <div class="dsACSection">
			<h2><?php echo TRANSLATION_ACCOUNT_DELIVERY_METHOD; ?></h2>
			<?php echo $dsv_delivery_method; ?>
		</div>
        <div class="dsACSection">
        <h2><?php echo TRANSLATION_ORDER_DETAILS; ?></h2>
        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	
	
	
									<?php
									
									  foreach($dsv_order_products as $product) {

											// show the products in basket.
												?>
													<tr>
													<td class="main" align="right" valign="top" width="30"><?php echo $product['qty'] . '&nbsp;x&nbsp;';?></td>
													<td class="main" valign="top"><?php
														 
														 
													
													// show products name
													echo $product['products_name'];
													
													// if there are any product options show them here.
													if (isset($product['options']) && strlen($product['options'])>1){
														   echo '<br />' . $product['options'];
													}
		
 
													?>
													</td>

													<td class="dsorderQuantitySide">&nbsp;</td>
													<td class="main" align="right" valign="top"><?php echo $product['price'];?></td>
													</tr>
									 <?
									  } // end foreach products
									
									
									
									
										// totals
										
										// subtotal
									
										if (isset($dsv_total_goods) && strlen($dsv_total_goods)>1){
										?>
										<tr>
										 <td colspan="3" class="dsorderQuantityTopSide"><?php echo TRANSLATION_BASKET_SUBTOTAL;?></td>
										 <td class="dsorderTopBar" align="right"><?php echo $dsv_total_goods;?></td>
										</tr>
										<?php
										} // end of subtotal

										// delivery
										if (isset($dsv_total_delivery) && strlen($dsv_total_delivery)>1){
										?>
										<tr>
										 <td colspan="3" class="dsorderQuantitySide"><?php echo $dsv_delivery_title;?></td>
										 <td align="right"><?php echo $dsv_total_delivery;?></td>
										</tr>
										<?php
										} // end of delivery


										// discount
										if (isset($dsv_total_discount) && strlen($dsv_total_discount)>1){
										?>
										<tr>
										 <td colspan="3" class="dsorderQuantitySide"><?php echo $dsv_voucher_number;?></td>
										 <td class="dsaccountTotalDiscount" align="right">- <?php echo $dsv_total_discount;?></td>
										</tr>
										<?php
										} // end of discount


										// total
										if (isset($dsv_total_gross) && strlen($dsv_total_gross)>1){
										?>
										<tr>
										 <td colspan="3" class="dsorderQuantitySide"><?php echo TRANSLATION_BASKET_TOTAL;?></td>
										 <td class="dsaccountTotalGross" align="right"><?php echo $dsv_total_gross;?></td>
										</tr>
										<?php
										} // end of total


									?>
							
							</table>
        </div>
        <?php echo '<a href="' . dsf_link('account_history.html','', 'SSL') . '">' . dsf_image_button($dsv_history_button, TRANSLATION_ACCOUNT_RETURN_TO_HISTORY) . '</a>'; ?>
        
    </div>
    <div class="dsMETAright">
        <?php include ('custom_modules/default/ac_menu.php');?>
    </div>
</div>