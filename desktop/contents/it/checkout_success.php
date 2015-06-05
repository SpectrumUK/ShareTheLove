<div id="dsBasketMask" class="dsBasketITS4"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php 
if (isset($dsv_page_title) && strlen($dsv_page_title)>1){
	echo ds_strtoupper($dsv_page_title);
}else{
	echo ds_strtoupper(TRANSLATION_CHECKOUT_ORDER_COMPLETE_TITLE);
}
 ?></h1>
 <?php 
if (isset($dsv_page_text) && strlen($dsv_page_text)>1){
	 echo str_replace('[ORDER_NUMBER]', CONTENT_COUNTRY .CONTENT_COMPANY . '-' .$dsv_order_number , $dsv_page_text);
}else{
	echo '<p>Thank you<br><br>Your order is being processed, we shall contact you soon.</p>';
}
?>
</div>
<div class="dsCHAright">      
<?php /*<div class="dsOverview">
	<table width="282" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" valign="top"><div class="dsBASOverTitle">
							   <?php echo strtoupper ('ORDER REFERENCE')?>
                               </div>
                               <div class="dsBASRef">
                               <?php echo $dsv_order_number; ?>
                               </div></td>
    </tr>
    <tr>
    	<td colspan="2" valign="top"><div class="dsBASOverPro">PRODUCTS</div></td>
    	<td valign="top"><div class="dsBASOverCurrency">&pound;</div></td>
    </tr>
    <?php
									
									  foreach($dsv_basket_products as $product) {

											// show the products in basket.
												?>
  <tr>
    <td valign="top"><?php echo '<div class="dsCBASproQty">' . $product['qty'] . 'x</div>';?></td>
    <td valign="top"><?php echo '<div class="dsCBASproName">' . $product['products_name'] . ' - ' . $product['model'] . '</div>';?>
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
 
													</td> >>>>>>moved from withing side the td<<<<<<<<*/?> 
                                                    
                                                    <?php /*
    <td valign="top"><?php echo'<div class="dsCBASproPRICE">' . $product['price'] . '</div>';?></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><div class="dsBASOverDivider"></div></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><div class="dsCbasketTitleItem"><?php echo TRANSLATION_BASKET_SUBTOTAL;?></div></td>
    <td valign="top"><div class="dsCDELCost"><?php echo $dsv_total_goods;?></div></td>
  </tr>
  <?php
										} // end of subtotal

										// delivery
										if (isset($dsv_total_delivery) && strlen($dsv_total_delivery)>1){
										?>
  <tr>
    <td colspan="2" valign="top"><div class="dsCbasketTitleItem"><?php echo $dsv_delivery_title;?></div></td>
    <td valign="top"><div class="dsCDELCost"><?php echo $dsv_total_delivery;?></div></td>
  </tr>
  <?php
										} // end of delivery


										// discount
										if (isset($dsv_total_discount) && strlen($dsv_total_discount)>1){
										?>
  <tr>
    <td colspan="2" valign="top"><div class="dsCbasketTitleItem"><?php echo TRANSLATION_BASKET_DISCOUNTS; ?></div></td>
    <td valign="top"><div class="dsCDELCost">- <?php echo $dsv_total_discount;?></div></td>
  </tr>
  <?php
										} // end of discount


										// total
										if (isset($dsv_total_gross) && strlen($dsv_total_gross)>1){
										?>
      <tr>
    <td colspan="3" valign="top"><div class="dsBASOTotalDivider"></div></td>
  	</tr>
       <tr>
    <td colspan="2" valign="top"><div class="dsCBASTotalTitle"><?php echo strtoupper(TRANSLATION_BASKET_TOTAL); ?></div></td>
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
										<?php 
										} // end of deposit

									</table>*/?>

  </div>     
</div>


<?php /*<div id="dsBHeader"><?php echo dsf_image('custom/basket_s4_success.jpg', 'Step 4. Order Complete', '980', '153');?></div>

<div id="dsContent">
  <div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
		<div class="dsBASContent">

<h1><?php 
if (isset($dsv_page_title) && strlen($dsv_page_title)>1){
	echo $dsv_page_title;
}else{
	echo 'ORDER COMPLETE';
}
 ?></h1>


<?php 
if (isset($dsv_page_text) && strlen($dsv_page_text)>1){
	echo $dsv_page_text;
}else{
	echo '<p>Thank you<br /><br />Your order is being processed, we shall contact you soon.</p>';
}
?>
<p>Thank you for shopping with us.</p>

<div class="dsBSDivider"></div>
    	<h2><?php echo 'ORDER REFERENCE NO ' .$dsv_order_number; ?></h2>        
        
    <div id="dsbasketOverview">
	
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                               
                               <tr>
							   <td valign="top" align="left" colspan="3"><div class="dsBASDivider">&nbsp;</div></td>
							   </tr>
	
									
									<?php
									
									  foreach($dsv_order_products as $product) {

											// show the products in basket.
												?>
													<tr class="dsCTBPRow">
													<td align="left" valign="top" colspan="2"><?php echo '<div class="dsCBASproNAME"><strong>' . $product['qty'] . '&nbsp;x&nbsp;' . $product['model'] . '</strong>' . ' ' . $product['products_name'] .'</div>';?>
                                                    <?php
													
													// if there are any product options show them here.
													/*if (isset($product['options']) && strlen($product['options'])>1){
														   echo '<br>' . $product['options'];
													}*/
													
													// if warranty show that first.
													/*if (isset($product['warranty']) && strlen($product['warranty'])>1){
														   echo $product['warranty'] . ' for<br>';
													}*/
		
													// if there is a delivery latency show that.
													/*if (isset($product['latency']) && strlen($product['latency'])>1){
														   echo '<span class="dsCLatencyBasketText">Delivery: ' . $product['latency'] . '</span>';
													}*/
													 
													// if there is a deposit required show that.
													/*if (isset($product['products_deposit']) && strlen($product['products_deposit'])>1){
														   echo '<span class="dsCDepositBasketText">Deposit Required: ' . $product['products_deposit'] . '</span>';
													}*/
 
													?>
                      <?php /*                              </td>
													<td align="right" valign="top" class="dsCTBdata"><?php echo'<div class="dsCBASproPRICE">' . $product['price'] . '</div>';?></td>
													</tr>
									 <?
									  } // end foreach products
									
										// totals
										
										// subtotal
									
										if (isset($dsv_total_goods) && strlen($dsv_total_goods)>1){
										?>
										<tr class="dsCBASrow">
                                         <td></td>
										 <td align="left" valign="top"><div class="dsCbasketTitleItem">SUB TOTAL</div></td>
										 <td align="right" valign="top" ><div class="dsCDELCost"><?php echo $dsv_total_goods;?></div></td>
										</tr>
										<?php
										} // end of subtotal

										// delivery
										if (isset($dsv_total_delivery) && strlen($dsv_total_delivery)>1){
										?>
                                        
                                        <tr class="dsCBASrow">
										<td align="left" valign="top"><div class="dsCDELtitle"><?php echo $dsv_delivery_title;?></div></td>
										<td align="left" valign="top"><?php
									// only one method available
									echo '<div class="dsCbasketTitleItem">DELIVERY</div>';
					  ?></td>
                                    <td align="right" valign="top"><div class="dsCDELCost"><?php echo $dsv_total_delivery;?></div></td>
								  </tr>
										<?php
										} // end of delivery


										// discount
										if (isset($dsv_total_discount) && strlen($dsv_total_discount)>1){
										?>
										<tr class="dsCBASrow">
                                         <td align="left" valign="top"><?php echo '<div class="dsCDELtitle">' . $dsv_voucher_number . '</div>';?></td>
										 <td align="left" valign="top" ><div class="dsCbasketTitleItem"><?php echo 'DISCOUNTS'; ?></div></td>
										 <td align="right" valign="top"><div class="dsCBASdiscount">- <?php echo $dsv_total_discount;?></div></td>
										</tr>
										<?php
										} // end of discount


										// total
										if (isset($dsv_total_gross) && strlen($dsv_total_gross)>1){
										?>
										<tr class="dsCBASrow">
                                        <td></td>
										 <td align="left" valign="top" ><div class="dsCbasketTitleItem"><?php echo 'TOTAL'; ?></div></td>
										 <td align="right" valign="top"><div class="dsCBASTotal"><?php echo $dsv_total_gross;?></div></td>
										</tr>
										<?php
										} // end of total



										// Deposit
										if (isset($dsv_total_deposit_required) && strlen($dsv_total_deposit_required)>1){
										?>
										<tr class="dsCBASrow">
										 <td class="dsbasketQuantitySideTotal" align="right" valign="middle" ><strong>Deposit Required Today</strong></td>
										 <td align="right" valign="top"><strong><?php echo $dsv_total_deposit_required;?></strong></td>
										</tr>
										<?php
										} // end of deposit

									?>
							
							</table> 

  </div>

<div class="dsBSDivider"></div>
	
	<div id="dsbasketBtn"><a href="<?php echo $dsv_continue_shopping_url;?>"><?php echo dsf_button_image($dsv_continue_shopping_button, 'Continue Shopping');?></a></div>

<div class="dsBASLogo"></div>
            <div class="basketDShade"></div>
            </div>
	</div> */?>

<!-- Google Analytics added 11/05/2011 -->
<script type="text/javascript">
	
_gaq.push(['_addTrans',
     	   '<?php echo $dsv_order_number;?>',           // order ID - required
	       'RH Ecommerce Site',  // affiliation or store name
		   '<?php echo $dsv_total_net_value;?>',          // total - required
		   '<?php echo $dsv_total_vat_value;?>',           // tax     
		   '<?php echo $dsv_total_delivery_value;?>',              // shipping     
		   '',       // city     
		   '',     // state or province     
		   ''             // country
		   ]);  
	
	<?php
	foreach ($dsv_order_products as $item){
		?>
		
  _gaq.push(['_addItem',     
  			'<?php echo $dsv_order_number;?>',           // order ID - required     
  			'<?php echo $item['id'];?>',           // SKU/code - required     
  			'<?php echo $item['model'];?>',        // product name     
  			'<?php echo $item['products_name'];?>',   // category or variation     
  			'<?php echo $item['price_value'];?>',          // unit price - required     
  			'<?php echo $item['qty'];?>'               // quantity - required   
  			]);
     <?php
	}
	?>
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers 
</script>
<!-- End Analytics tracking -->


<!-- Quisma -->
	<?php
	$quisma_products = '';
	$quisma_seperator = '';
	reset($dsv_order_products);
	
	foreach ($dsv_order_products as $item){
		$quisma_products .= $quisma_seperator . $item['model'];
		$quisma_seperator = ',';
	}
	
		?>

<script type="text/javascript" src="https://t.qservz.com/tr.aspx?campaign=e7d161ac8d8a76529d39d9f5b4249ccb&type=pps&retmode=1&orderid=<?php echo $dsv_order_number;?>&totalprice=<?php echo $dsv_order_total;?>&level=<?php echo $quisma_products;?>">
</script>
<noscript>
<iframe src="https://t.qservz.com/tr.aspx?campaign=e7d161ac8d8a76529d39d9f5b4249ccb&type=pps&retmode=2&orderid=<?php echo $dsv_order_number;?>&totalprice=<?php echo $dsv_order_total;?>&level=<?php echo $quisma_products;?>" border="0" width="1" height="1"></iframe>
</noscript>
<!-- Quisma -->