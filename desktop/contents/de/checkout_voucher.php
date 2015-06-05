<div id="dsBasketMask" class="dsBasketDES3"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_PAYMENT_TITLE); ?></h1>
<?php 
// echo the start of the checkout form.
echo $dsv_checkout_form_start;


	// echo the current steps images.
	?>
    
    
    <?php
				 // echo any error.
				 
				 if (isset($dsv_checkout_error) && strlen($dsv_checkout_error)>1){
				 	echo $dsv_checkout_error;
				 }
				
	?>
    
<div class="dsACSection">
	<h2><?php echo ds_strtoupper($dsv_page_title);?></h2>
	<?php echo str_replace('[ORDER_NUMBER]', 'Order Number' , $dsv_page_text);?>
							
</div>
	<div class="dsORDERbtn">
    	<div class="dsbasketButtonRight">
			<?php echo dsf_submit_image($dsv_confirm_order_button, TRANSLATION_CHECKOUT_CONFIRM_ORDER);?>
    	</div>
     </div>					 

<?php echo $dsv_checkout_form_end;?>

		</div>
        <div class="dsCHAright">
        <div class="dsOverview">
	<?php echo '<div class="dsBASOverTitle">' . strtoupper(TRANSLATION_CHECKOUT_ADDRESS_SUB_TITLE) . '</div><div class="dsBASOverLink"><a href="' . dsf_link('checkout_basket.html','', 'SSL') . '">' . TRANSLATION_CHECKOUT_CHANGE . '</a></div>'; ?>
	<div class="clear"></div>

					<?php if($dsv_delivery_address_used == 'true'){
					?>
					
									<div class="dsAddressTitle"><?php echo ds_strtoupper (TRANSLATION_CHECKOUT_BILLING_TITLE);?></div>
									<div class="dsAddressDetails"><?php echo $dsv_billing_address; ?></div>
									<div class="dsBASAddDivider"></div>
									<div class="dsDELAddressTitle"><?php echo strtoupper (TRANSLATION_CHECKOUT_DELIVERY_TITLE);?></div><div class="dsAddressDIF"><?php /*echo '(if different)' ;*/?></div>
                                    <div class="clear"></div>
									<div class="dsAddressDetails"><?php echo $dsv_delivery_address; ?></div>
								
					<?php
					}else{
					?>
									<div class="dsAddressTitle"><?php echo ds_strtoupper (TRANSLATION_CHECKOUT_BILLING_TITLE);?></div>
									<div class="dsAddressDetails"><?php echo $dsv_billing_address; ?></div>
                                    <div class="dsBASAddDivider"></div>
									<div class="dsAddressDetails"><?php echo $dsv_address_information;?></div>


					
					<?php
					}
					?>



		</div>   
<div class="dsOverview">
	<table width="282" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" valign="top"><div class="dsBASOverTitle">
							   <?php echo strtoupper(TRANSLATION_CHECKOUT_BASKET_CONTENT); ?>
                               </div>
                               <div class="dsBASOverLink">
                               <?php echo '<a href="' . dsf_link('basket.html','', 'NONSSL') . '">' . TRANSLATION_CHECKOUT_CHANGE . '</a>' ;?>
                               </div></td>
    </tr>
    <tr>
    	<td colspan="3" valign="top"><div class="dsBASOverPro"><?php echo ds_strtoupper(TRANSLATION_TEXT_PRODUCTS);?></div></td>
    	<td valign="top"><div class="dsBASOverCurrency"><?php echo $dsv_default_currency;?></div></td>
    </tr>
    <?php
									
									  foreach($dsv_basket_products as $product) {

											// show the products in basket.

												?>
  <tr>
  	<td valign="top">
	<?php echo '<div class="dsOVproIMG"><a href="' . $product['url'] . '">' ;
		if (isset ($product['part_id']) && $product['part_id'] >0) {
			echo dsf_get_basket_parts_image($product['part_id'], 39, 45);
		}else{
			echo dsf_get_basket_image($product['id'], 39, 45);
		}
			
		echo '</a></div>'; ?></td>
    <td valign="top" clospan="2"><?php echo '<div class="dsCBASproQty">' . $product['qty'] . 'x</div>';?></td>
    <td valign="top"><?php echo '<div class="dsCBASproName">' . $product['products_name'] . ' <br /> ' . $product['model'] . '</div>';?>
                                                    <?php
													
													// if there are any product options show them here.
													/*if (isset($product['options']) && strlen($product['options'])>1){
														   echo '<br>' . $product['options'];
													}
													
													// if warranty show that first.
													if (isset($product['warranty']) && strlen($product['warranty'])>1){
														   echo $product['warranty'] . ' for<br>';
													}
		
													// if there is a delivery latency show that.
													if (isset($product['latency']) && strlen($product['latency'])>1){
														   echo '<span class="dsCLatencyBasketText">Delivery: ' . $product['latency'] . '</span>';
													}
													 
													// if there is a deposit required show that.
													if (isset($product['products_deposit']) && strlen($product['products_deposit'])>1){
														   echo '<span class="dsCDepositBasketText">Deposit Required: ' . $product['products_deposit'] . '</span>';
													}
 
													*/?></td>
    <td valign="top"><?php echo'<div class="dsCBASproPRICE">' . $product['price'] . '</div>';?></td>
  </tr>
  <tr>
    <td colspan="4" valign="top"><div class="dsBASOverDivider"></div></td>
  </tr>
  <?php
										} // end of subtotal
?>

  <tr>
    <td colspan="3" valign="top"><div class="dsCbasketTitleItem"><?php echo TRANSLATION_BASKET_SUBTOTAL;?></div></td>
    <td valign="top"><div class="dsCDELCost"><?php echo $dsv_total_goods;?></div></td>
  </tr>
					<?php 		// delivery
										if (isset($dsv_total_delivery) && strlen($dsv_total_delivery)>1){
										?>
  <tr>
    <td colspan="3" valign="top"><div class="dsCbasketTitleItem"><?php echo $dsv_delivery_title;?></div></td>
    <td valign="top"><div class="dsCDELCost"><?php echo $dsv_total_delivery;?></div></td>
  </tr>
  <?php
										} // end of delivery


										// discount
										if (isset($dsv_total_discount) && strlen($dsv_total_discount)>1){
										?>
  <tr>
    <td colspan="3" valign="top"><div class="dsCbasketTitleItem"><?php echo TRANSLATION_BASKET_DISCOUNTS; ?></div></td>
    <td valign="top"><div class="dsCDELCost">- <?php echo $dsv_total_discount;?></div></td>
  </tr>
  <?php
										} // end of discount


										// total
										if (isset($dsv_total_gross) && strlen($dsv_total_gross)>1){
										?>
      <tr>
    <td colspan="4" valign="top"><div class="dsBASOTotalDivider"></div></td>
  	</tr>
    <tr>
         <td colspan="4" align="left" valign="top"><div class="dsBASTotalMsg"><?php echo TRANSLATION_CHECKOUT_VAT_MESSAGE; ?></div></td>
       </tr>
       <tr>
    <td colspan="3" valign="top"><div class="dsCBASTotalTitle"><?php echo strtoupper(TRANSLATION_BASKET_TOTAL); ?></div></td>
    <td valign="top"><div class="dsCBASTotal"><?php echo $dsv_total_gross;?></div></td>
										</tr>
       
										 <?php
										} // end of total



										// Deposit

										if (isset($dsv_total_deposit_required) && strlen($dsv_total_deposit_required)>1){
										/*?>
    
   
										<tr class="dsCBASrow">
										 <td class="dsbasketQuantitySideTotal" align="right" valign="middle" ><strong>Deposit Required Today</strong></td>
										 <td align="right" valign="top"><strong><?php echo $dsv_total_deposit_required;?></strong></td>
										</tr>
										<?php */
										} // end of deposit

									?></table>

  </div>     
</div>
</div>