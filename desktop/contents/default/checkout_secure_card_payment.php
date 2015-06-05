<div id="dsBasketMask" class="dsBasketS3"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper(TRANSLATION_CHECKOUT_BASKET); ?></h1>
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
	<h2><?php echo strtoupper(TRANSLATION_CHECKOUT_CARD_TITLE); ?></h2>
    <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>

						<?php
						 // start credit card information

						 ?>
						
							<div class="dspaymentInput"><label for="cc_number"><?php echo TRANSLATION_CHECKOUT_CARD_NUMBER; ?>: <span class="dsRequired">*</span></label>
							<?php echo dsf_form_input('cc_number','','size="28"','forminput'); ?><div id="dsPNCardNumber"><?php echo TRANSLATION_CHECKOUT_CARD_NO_SPACE; ?></div>
                            </div>
							
							<div class="dsCardsICO">
                            	<div class="dsCardMC">&nbsp;</div>
                                <div class="dsCardMS">&nbsp;</div>
                                <div class="dsCardVISA">&nbsp;</div>
                                <div class="dsCardSOLO">&nbsp;</div>
                            </div>
                            
							<div class="dscheckoutInput"><label for="cc_ctype"><?php echo TRANSLATION_CHECKOUT_CARD_TYPE; ?>: <span class="dsRequired">*</span></label>
							<?php echo dsf_form_dropdown('cc_ctype', $dsv_cardtypes,$cc_ctype,'','forminput');?>
							</div>
							
							<div class="dspaymentInput"><label for="cc_owner"><?php echo TRANSLATION_CHECKOUT_CARD_HOLDER; ?>: <span class="dsRequired">*</span></label>
							<?php echo dsf_form_input('cc_owner',$cc_owner,'size="28"','forminput'); ?>
							<div id="dsPNCardName"><?php echo TRANSLATION_CHECKOUT_AS_ON_CARD; ?></div>
							</div>
							
                            <div class="clear"></div>
							
							<div class="dspaymentInput"><label for="cc_start_month"><strong><?php echo TRANSLATION_CHECKOUT_CARD_VALID; ?></strong></label>
                            <div class="clear"></div>
							<?php echo '<span class="dscheckoutDates">' . TRANSLATION_MONTH . '</span>' . dsf_form_dropdown('cc_start_month', $dsv_expires_month, $cc_start_month,'','forminput') . '<span class="dscheckoutDates">' . TRANSLATION_YEAR . '</span>' .  dsf_form_dropdown('cc_start_year', $dsv_start_year, $cc_start_year,'','forminput');?>
							<div id="dsPNCardValid"><?php echo TRANSLATION_CHECKOUT_LEAVE_BLANK; ?></div>
							</div>
							
							<div class="clear"></div>
							
							<div class="dspaymentInput"><label for="cc_expires_month"><strong><?php echo TRANSLATION_CHECKOUT_CARD_EXPIRY; ?></strong> <span class="dsRequired">*</span></label>
                            <div class="clear"></div>
							<?php echo '<span class="dscheckoutDates">' . TRANSLATION_MONTH . '</span>' . dsf_form_dropdown('cc_expires_month', $dsv_expires_month, $cc_expires_month,'','forminput') . '<span class="dscheckoutDates">' . TRANSLATION_YEAR . '</span>' .  dsf_form_dropdown('cc_expires_year', $dsv_expires_year, $cc_expires_year,'','forminput');?>
							</div>
                            
                            <div class="clear"></div>
							
							<div class="dspaymentInput"><label for="IssueNumber"><?php echo TRANSLATION_CHECKOUT_CARD_ISSUE_NUMBER; ?></label>
							<?php echo dsf_form_input('IssueNumber',$IssueNumber,'size="10"','forminput');?>
							<div id="dsPNCardIssue"><?php echo TRANSLATION_CHECKOUT_CARDS_ISSUE_NUMBER; ?></div>
							</div>
							
							<div class="clear"></div>
                            
							<div class="dspaymentInput"><label for="CV2"><?php echo TRANSLATION_CHECKOUT_CARD_SECURITY_CODE; ?>: <span class="dsRequired">*</span></label>
							<?php echo dsf_form_input('CV2',$CV2,'size="10"','forminput');?>
							<div id="dsPNCardCV2"><?php echo TRANSLATION_CHECKOUT_CARDS_REVERSE; ?></div>
							</div>
							
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
					
									<div class="dsAddressTitle"><?php echo TRANSLATION_ACCOUNT_CUSTOMER_ADDRESS; ?></div>
									<div class="dsAddressDetails"><?php echo $dsv_billing_address; ?></div>
									<div class="dsBASAddDivider"></div>
									<div class="dsDELAddressTitle"><?php echo strtoupper (TRANSLATION_CHECKOUT_DELIVERY_TITLE);?></div><div class="dsAddressDIF"><?php echo '(if different)';?></div>
                                    <div class="clear"></div>
									<div class="dsAddressDetails"><?php echo $dsv_delivery_address; ?></div>
								
					<?php
					}else{
					?>
									<div class="dsAddressTitle"><?php echo TRANSLATION_ACCOUNT_CUSTOMER_ADDRESS; ?></div>
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
    <td colspan="3" valign="top"><div class="dsBASOverTitle">
							   <?php echo strtoupper(TRANSLATION_CHECKOUT_BASKET_CONTENT); ?>
                               </div>
                               <div class="dsBASOverLink">
                               <?php echo '<a href="' . dsf_link('basket.html','', 'NONSSL') . '">' . TRANSLATION_CHECKOUT_CHANGE . '</a>' ;?>
                               </div></td>
    </tr>
    <tr>
    	<td colspan="2" valign="top"><div class="dsBASOverPro"><?php echo strtoupper(TRANSLATION_TEXT_PRODUCTS); ?></div></td>
    	<td valign="top"><div class="dsBASOverCurrency"><?php echo $dsv_default_currency;?></div></td>
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
 
													*/?></td>
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
										<?php */
										} // end of deposit

									?></table>

  </div>     
</div>
</div>
<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: RH Universal Checkout Payment Page 3
URL of the webpage where the tag is expected to be placed: https://www.tbc.co.uk
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 05/06/2011
-->
<script type="text/javascript">
var axel = Math.random() + "";
var a = axel * 10000000000000;
document.write('<iframe src="https://fls.doubleclick.net/activityi;src=3074717;type=russe780;cat=rhuni183;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
</script>
<noscript>
<iframe src="https://fls.doubleclick.net/activityi;src=3074717;type=russe780;cat=rhuni183;ord=<?php echo time();?>" width="1" height="1" frameborder="0" style="display:none"></iframe>
</noscript>

<!-- End of DoubleClick Floodlight Tag: Please do not remove -->


