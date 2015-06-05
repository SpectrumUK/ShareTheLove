<div id="dsBasketMask" class="dsBasketS4"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php 
if (isset($dsv_page_title) && strlen($dsv_page_title)>1){
	echo $dsv_page_title;
}else{
	echo strtoupper('Order Complete');
}
 ?></h1>
 <?php 
if (isset($dsv_page_text) && strlen($dsv_page_text)>1){
	echo '<p>' . $dsv_page_text . '</p>';
}else{
	echo '<p>Thank you<br />Your order is being processed, we shall contact you soon.</p>';
}
?>
<p>Thank you for shopping with us.</p>
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
	
	<div id="dsbasketBtn"><a href="<?php echo $dsv_continue_shopping_url;?>"><?php echo dsf_image_button($dsv_continue_shopping_button, 'Continue Shopping');?></a></div>

<div class="dsBASLogo"></div>
            <div class="basketDShade"></div>
            </div>
	</div> */?>

	<!-- Google Code for Sale Complete Conversion Page -->
	<script type="text/javascript">
	<!--

		var google_conversion_id = 1028972501;

		var google_conversion_language = "en_GB";

		var google_conversion_format = "3";

		var google_conversion_color = "ffffff";

		var google_conversion_label = "brMUCJ2GmQEQ1b_T6gM";

		var google_conversion_value = 0;

	//-->

	</script>

	<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script>

	<noscript><div style="display:inline;">
    	<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1028972501/?label=brMUCJ2GmQEQ1b_T6gM&amp;guid=ON&amp;script=0"/>
    </div></noscript>

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
	reset($dsv_order_products);
	?>
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers 
</script>
<!-- End Analytics tracking -->
<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: Russel Hobbs Confirmation page
URL of the webpage where the tag is expected to be placed: https://uk.russellhobbs.com/checkout_success.html
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 10/07/2014
-->

<?php
	// we need to add some specifics for this iframes url.
	// these form:
	// cost= revenue
	// u1 to u6 for products
	// order id.
	
	$iframe_text = 'cost=' . $dsv_order_total . ';';
	
	// loop though products maximum 6 starts at 3
	$counter = 0;
		foreach ($dsv_order_products as $item){
			$counter ++;
			if ($counter <=6){
				$iframe_text .= 'u' . ($counter +2) . '=' . $item['model'] . ';';
					// check for supplier
						$sup_query = dsf_query("select s.suppliers_name from " . DS_DB_SHOP . ".suppliers s left join " . DS_DB_SHOP .".products p on (s.suppliers_id = p.suppliers_id) where p.products_id='" . (int)$item['id'] . "'");
						$sup_results = dsf_array($sup_query);
						if (isset($sup_results['suppliers_name']) && strlen($sup_results['suppliers_name']) > 1){
							$iframe_text .= 'u' . ($counter +8) . '=' . $sup_results['suppliers_name'] . ';';
						}else{
							$iframe_text .= 'u' . ($counter +8) . '=' . 'none' . ';';
						}
				
			}
		}
		
	// lastly order number
	$iframe_text .= 'ord=' . $dsv_order_number . ';';
	
	// end of text creation
	?>

<iframe src="http://3074717.fls.doubleclick.net/activityi;src=3074717;type=russe109;cat=russe069;qty=1;<?php echo $iframe_text;?>?" width="1" height="1" frameborder="0" style="display:none"></iframe>
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->


