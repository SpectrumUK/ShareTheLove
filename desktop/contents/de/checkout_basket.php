<div id="dsBasketMask" class="dsBasketDES2"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_ADDRESS_TITLE); ?></h1>
<?php 
	// start the form.
		echo $dsv_basket_form_start; 
		
		
	// echo the current steps images.
	?>
                


     <?php
				 // echo any error.
				 
				 if (isset($dsv_checkout_error) && strlen($dsv_checkout_error)>1){
				 	echo $dsv_checkout_error;
				 }
				
				?>
<div class="dsACSection">
	<h2><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_NAME_TITLE); ?></h2>
    <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
    
    <?php
								if(isset($dsv_email_text) && strlen($dsv_email_text)>1){
								?>
									  <div id="dsEMAILTxt"><?php echo $dsv_email_text; ?></div>
								<?php
								}
								?>		
			
		
			<div class="dscheckoutInput"><label for="i_salutation"><?php echo TRANSLATION_CHECKOUT_SALUTATION; ?>:</label>
			<?php echo dsf_form_dropdown('i_salutation', $salutation_array, $salutation, '', 'forminput');?>
			<?php // '&nbsp;Other&nbsp;' . dsf_form_input('i_salutation_other','','size="12"','','','forminput'); ?>
			</div>
			

			<div class="dscheckoutInput"><label for="i_firstname"><?php echo TRANSLATION_FIRST_NAME; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('i_firstname',$firstname,'','forminput'); ?>
			</div>
			
			
			<div class="dscheckoutInput"><label for="i_lastname"><?php echo TRANSLATION_LAST_NAME; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('i_lastname',$lastname,'','forminput'); ?>
			</div>



		
					
									<?php
									  if ($dsv_require_dob == 'true') {
									?>
										<div class="checkoutInput"><label for="i_dobday"><?php echo TRANSLATION_DOB; ?>:</label>
										<?php echo TRANSLATION_DAY . '&nbsp;' . dsf_form_input('i_dobday',$dobday,'size="2"'). '&nbsp;' . TRANSLATION_MONTH . '&nbsp;' . dsf_form_input('i_dobmonth',$dobmonth,'size="2"') . '&nbsp;' . TRANSLATION_DAY . '&nbsp;' . dsf_form_input('i_dobyear',$dobyear,'size="4"'); ?>
										</div>
									<?php
									  }
									?>
									
			<div class="dscheckoutInput"><label for="i_email_address"><?php echo TRANSLATION_EMAIL_ADDRESS;?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('i_email_address',$email_address,'size="40"','forminput'); ?>
			</div>
		
		
					
		

								
		</div>




					<?php
					  if (isset($dsv_show_company) && $dsv_show_company == 'true') {
					?>
<div class="dsACSection">
	<h2><?php echo strtoupper('Company Details'); ?></h2>

						<div class="dscheckoutInput"><label for="i_invoice_company">Company Name:</label>
						<?php echo dsf_form_input('i_invoice_company',$invoice_company,'size="40"','forminput'); ?>
						</div>
					</div>
<?php
					  }
					?>

<div class="dsACSection">
	<h2><?php echo strtoupper(TRANSLATION_CHECKOUT_BILLING_TITLE); ?></h2>
    <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
    <div class="addDoctorInst"><?php echo TRANSLATION_CHECKOUT_DELIVERY_SUB_TITLE;?></div>
    <?php /*<div id="dsCardTxt"><?php echo TRANSLATION_CHECKOUT_DELIVERY_SUB_TITLE;?></div> */?>
                        <?php /*
					if(isset($dsv_address_text) && strlen($dsv_address_text)>1){
					?>
						  <div id="dsCardTxt"><?php echo $dsv_address_text; ?></div>
					<?php
					} */
					?>

						<!-- ADDRESS DOCTOR ITEM -->
<script type="text/javascript">


function dsfNumericsOnly(strString) {
// check for valid numeric strings   

var strValidChars = "0123456789";
var strChar;
var blnResult = 'OK';

		if (strString.length == 0) {
			 blnResult = 'ERROR';
		}else{
			
					// test strString consists of valid characters listed above
					for (i = 0; i < strString.length && blnResult == 'OK'; i++) {
								strChar = strString.charAt(i);
								if (strValidChars.indexOf(strChar) == -1) 		{
									blnResult = 'ERROR';
								}
					}
		}

return blnResult;

}




	function dsfAdoc(dsect , addkey){
		
	if (dsect == 'invoice') {	
			var dsd_street = MM_findObj('i_invoice_street');
			var dsd_house = MM_findObj('i_invoice_house');
			var dsd_postcode = MM_findObj('i_invoice_postcode');
	}else{
			var dsd_street = MM_findObj('i_delivery_street');
			var dsd_house = MM_findObj('i_delivery_house');
			var dsd_postcode = MM_findObj('i_delivery_postcode');
	}
	
	// check for values or give error
	var dsd_er = 'false';
	
	if (dsd_street.value.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH;?>){
		alert('<?php echo TRANSLATION_CHECKOUT_ERROR_STREET;?>');
		dsd_er = 'true';
	}
	
	if (dsd_er == 'false'){
			if (dsd_postcode.value.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH;?>){
				alert('<?php echo TRANSLATION_CHECKOUT_ERROR_POSTCODE;?>');
				dsd_er = 'true';
			}
	}
	

	if (dsd_er == 'false'){
			var numanswer = dsfNumericsOnly(dsd_postcode.value);
			if (numanswer == 'ERROR'){
				alert('<?php echo TRANSLATION_CHECKOUT_ERROR_POSTCODE;?>');
				dsd_er = 'true';
			}
	}






			if (dsd_er == 'false'){
			
							$.ajax({
							method: "get",url: "address_doctor_ajax.php",data: "house="+ dsd_house.value + "&street=" + dsd_street.value + "&pcode=" + dsd_postcode.value +"&addkey=" + addkey +"&section=" + dsect +"&job=check",
							success: function(html){ 
							
							if (dsect == 'invoice'){
								$("#inv_sect").html(html);
							}else{
								$("#del_sect").html(html);
							}
							
							}
				 			}); 
			}
	
	
	
	}
	
	
function dsfAdman(dsect , addkey){
	
	if (dsect == 'invoice') {	
			var dsd_street = MM_findObj('i_invoice_street');
			var dsd_house = MM_findObj('i_invoice_house');
			var dsd_postcode = MM_findObj('i_invoice_postcode');
	}else{
			var dsd_street = MM_findObj('i_delivery_street');
			var dsd_house = MM_findObj('i_delivery_house');
			var dsd_postcode = MM_findObj('i_delivery_postcode');
	}



			$.ajax({
			method: "get",url: "address_doctor_ajax.php",data: "house="+ dsd_house.value + "&street=" + dsd_street.value + "&pcode=" + dsd_postcode.value +"&addkey=" + addkey +"&section=" + dsect +"&job=manual",
			success: function(html){ 
			
			if (dsect == 'invoice'){
				$("#inv_sect").html(html);
			}else{
				$("#del_sect").html(html);
			}
			
			}
			}); 

}

function dsfAduse(dsect , addkey){
	
	if (dsect == 'invoice') {	
			var dsd_street = MM_findObj('i_invoice_street');
			var dsd_house = MM_findObj('i_invoice_house');
			var dsd_postcode = MM_findObj('i_invoice_postcode');
	}else{
			var dsd_street = MM_findObj('i_delivery_street');
			var dsd_house = MM_findObj('i_delivery_house');
			var dsd_postcode = MM_findObj('i_delivery_postcode');
	}

	var dsd_selected = MM_findObj('addoc_select');
	var dsd_sel_value = dsd_selected.value;
	

			$.ajax({
			method: "get",url: "address_doctor_ajax.php",data: "item_id=itm" + dsd_sel_value + "&house="+ dsd_house.value + "&street=" + dsd_street.value + "&pcode=" + dsd_postcode.value +"&addkey=" + addkey +"&section=" + dsect +"&job=allocate",
			success: function(html){ 
			
			if (dsect == 'invoice'){
				$("#inv_sect").html(html);
			}else{
				$("#del_sect").html(html);
			}
			
			}
			}); 





}
</script>


<!-- ADDRESS DOCTOR ITEM -->
 
 
 
 
<div id="inv_sect">                        
						<div class="dscheckoutSection">

						<div class="dscheckoutInput"><label for="i_invoice_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_invoice_street',$invoice_street,'size="24"  maxlength="24"','forminput'); ?>
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_invoice_house',$invoice_house,'size="15" maxlength="15"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_invoice_postcode', $invoice_postcode,'size="15"  maxlength="9"','forminput') ; ?>
						</div>


<?php
				 if (isset($dsv_checkout_error) && strlen($dsv_checkout_error)>1){
					 	// we have an error therefore just show the full address details for manual input.
				?>

						<div class="dscheckoutInput"><label for="i_invoice_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_invoice_district',$invoice_district,'size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_invoice_town',$invoice_town,'size="30"  maxlength="30"','forminput').dsf_form_hidden('i_invoice_sap_county',0); ?>
						</div>
		
		

				  
						<div class="dscheckoutInput"><label for="i_invoice_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_invoice_country','','','forminput',$dsv_master_country_id); ?>
						</div>
                        
				<?php
				 }else{
					 // show ajax button to find the address
					?>	
                    <div class="dscheckoutInput"><div class="addDoctorFind"><a href="javascript:void(0)" onclick="dsfAdoc('invoice','i<?php echo time();?>');"><?php echo dsf_image('custom/findaddress_btn.gif', TRANSLATION_FIND_ADDRESS, '130', '32');?></a></div>
                    <?php echo dsf_form_hidden('i_invoice_district' , $invoice_district) . dsf_form_hidden('i_invoice_town' , $invoice_town);?></div>
                    <?php
				 }
				 ?>

					</div>
                    
</div> 

					</div>




<?php



 if($dsv_allow_delivery_address == 'true'){
 ?>					
 					<div class="dsACSection">
	<h2><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_DELIVERY_TITLE); ?></h2>
    <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
						<div id="dsDeliveryTxt"><?php echo TRANSLATION_CHECKOUT_DELIVERY_TITLE;?></div>
                        <?php /*<div id="dsCardTxt"><?php echo TRANSLATION_CHECKOUT_DELIVERY_SUB_TITLE;?></div>*/?>
						
                        <div class="dscheckoutInput"><label for="i_delivery_firstname"><?php echo TRANSLATION_FIRST_NAME;?>: <span class="dsRequired">*</span></label>
                        <?php echo dsf_form_input('i_delivery_firstname',$delivery_firstname,'','forminput'); ?>
                        </div>
                        
                        
                        <div class="dscheckoutInput"><label for="i_delivery_lastname"><?php echo TRANSLATION_LAST_NAME;?>: <span class="dsRequired">*</span></label>
                        <?php echo dsf_form_input('i_delivery_lastname',$delivery_lastname,'','forminput'); ?>
                        </div>


			<?php
			/*
						<div class="dscheckoutInput"><label for="i_delivery_name">Contact Name: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_delivery_name',$delivery_name,'size="30"  maxlength="30"','forminput'); ?>
						</div>

			*/
			?>

					<?php
					  if (isset($dsv_show_company) && $dsv_show_company == 'true') {
					?>
						<div class="dscheckoutInput"><label for="i_delivery_company">Company Name:</label>
						<?php echo dsf_form_input('i_delivery_company',$delivery_company,'size="40"','forminput'); ?>
						</div>
					 <?php
					  }
					?>

						
<div id="del_sect">                        
						<div class="dscheckoutInput"><label for="i_delivery_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_delivery_street',$delivery_street,'size="24"  maxlength="24"','forminput'); ?>
						</div>
		
						<div class="dscheckoutInput"><label for="i_delivery_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_delivery_house',$delivery_house,'size="15" maxlength="15"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_delivery_postcode', $delivery_postcode,'size="15"  maxlength="9"','forminput'); ?>
						</div>

<?php
				 if (isset($dsv_checkout_error) && strlen($dsv_checkout_error)>1){
					 	// we have an error therefore just show the full address details for manual input.
				?>


						<div class="dscheckoutInput"><label for="i_delivery_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_delivery_district',$delivery_district,'size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsinputRequirement">*</span></label>
						<?php echo dsf_form_input('i_delivery_town',$delivery_town,'size="30"  maxlength="30"','forminput') . dsf_form_hidden('i_delivery_sap_county',0); ?>
						</div>
		
				  
						<div class="dscheckoutInput"><label for="i_delivery_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_delivery_country','','','forminput',$dsv_master_country_id); ?>
						</div>
				<?php
				 }else{
					 // show ajax button to find the address
					?>	
                    <div class="dscheckoutInput"><div class="addDoctorFind"><a href="javascript:void(0)" onclick="dsfAdoc('delivery','d<?php echo time();?>');"><?php echo dsf_image('custom/findaddress_btn.gif', TRANSLATION_FIND_ADDRESS, '130', '32');?></a></div>
                    <?php echo dsf_form_hidden('i_delivery_district' , $delivery_district) . dsf_form_hidden('i_delivery_town' , $delivery_town);?></div>
                    <?php
				 }
				 ?>

</div>
</div>
 <?php
 }
 ?>
 
		
<div class="dsACSection">
	<h2><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_CONTACT_DETAILS_TITLE); ?></h2>
                        <?php
					if(isset($dsv_phone_text) && strlen($dsv_phone_text)>1){
					?>
                    <div id="dsTelTxt"><?php echo $dsv_phone_text; ?></div>
					<?php
					}
					?>

						<div class="dscheckoutInput"><label for="i_telephone"><?php echo TRANSLATION_TELEPHONE;?>:</label>
						<?php echo dsf_form_input('i_telephone',$telephone,'size="20"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_mobile"><?php echo TRANSLATION_CHECKOUT_MOBILE;?>:</label>
						<?php echo dsf_form_input('i_mobile',$mobile,'size="20"','forminput'); ?>
						</div>		
			</div>

								<?php if (is_array($dsv_payment_array) && sizeof($dsv_payment_array) >1){
										// there is more than one payment option therefore show radio buttons.
										
															?>
						<div class="dsACSection">
						<h2><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_PAYMENT_METHOD); ?></h2>
							
															  <?php
																	
																  for ($i=0, $n2=sizeof($dsv_payment_array); $i<$n2; $i++) {
																			?>
																	<div class="dspaymentnput"><label for="payment"><?php echo $dsv_payment_array[$i]['text']; ?>:</label>
																	<?php echo dsf_form_radio('payment', $dsv_payment_array[$i]['id'], $dsv_payment_array[$i]['checked']); ?>
																	</div>
																	<?php
																  }
															 // end of payment options
																?>	  
																	  
														</div>
										  
								<?php
								}else{	// there is only one payment method, but we stll need to pass it to the next form.
										echo dsf_form_hidden('payment', $payment_array[0]['id']);
								}
								?>


		
					 
						<div class="dsACSection">
						<h2><?php echo ds_strtoupper(TRANSLATION_CHECKOUT_OTHER_INFO); ?></h2>
                 <?php
				 // removal of comments box 2011-04-06
				 /*
				        <div class="dscheckoutMessages"><?php echo 'Use this box for any comments or instructions concerning this order.'; ?></div>
						<div class="dscheckoutSection">
										
										
						<div class="dscheckoutInput"><label for="comments">Comments:</label>
						<?php echo dsf_form_text('comments', $comments, 'soft', '50', '6','','forminput'); ?>
						</div>

				*/
				// replaced with this code instead
				?>
						<?php echo dsf_form_hidden('comments' , '');?>
                        <?php echo dsf_form_hidden('i_fax' , '');?>
                <?php
				// end of replacement text.		
				?>


						<div class="dscheckoutInput"><label for="i_source_id"><?php echo TRANSLATION_CHECKOUT_HERE; ?></label>
						<?php echo dsf_form_dropdown('i_source_id', $advert_array, $source_id,'','forminput'); ?>
						</div>
						<div class="clear"></div>
						<div class="dscheckoutTick">
                        <?php echo dsf_form_checkbox('i_newsletter', '1', false, 'class="dsTick"'); ?>
                        <label for="i_newsletter"><?php echo TRANSLATION_CHECKOUT_RECEIVE_EMAILS; ?></label>
                        <div class="clear">&nbsp;</div>
						</div>
				</div>
                <div class="dsACTSection">
                <div class="dsChkHldTick">
                         	<?php echo dsf_form_checkbox('i_agreedterms', '1', (isset($_POST['i_agreedterms']) ? true : ''), 'class="dsChkHTick"'); ?>
                            <div class="dsChkHTickTxt"><?php echo TRANSLATION_CHECKOUT_TERMS_TWO;?></div>
                        	<label for="i_agreedterms"><?php echo TRANSLATION_CHECKOUT_TERMS_ONE;?></label>
                   			
                        </div>
                        
                    	<div class="dsChkHldTick">
                         	<?php echo dsf_form_checkbox('i_agreedprivacy', '1', (isset($_POST['i_agreedprivacy']) ? true : ''), 'class="dsChkHTick"'); ?>
                            <div class="dsChkHTickTxt"><?php echo TRANSLATION_CHECKOUT_PRIVACY_TWO;?></div>
                        	<label for="i_agreedprivacy"><?php echo TRANSLATION_CHECKOUT_PRIVACY_ONE;?></label>
                   			
                        </div>
                        
                     	<div class="dsChkHldTick"><a href="<?php echo 'agb-onlineshop.html'; ?>" target = "_blank" ><?php echo TRANSLATION_CUSTOM_TEXT_SIX;?></a><br /><a href="<?php echo $dsv_privacy_url; ?>" target = "_blank" ><?php echo TRANSLATION_PAGE_PRIVACY;?></a></div>
                        <div class="dsbasketButtonRight"><?php echo dsf_submit_image($dsv_continue_button, TRANSLATION_CHECKOUT_CONTINUE_TO_PAYMENT); ?></div>
				<?php /*<div class="dscheckoutTick">
				<?php echo dsf_form_checkbox('i_agreedterms', '1', '', 'class="dsTick"'); ?>
                <div class="dscheckoutTerms">All sales on our account are in accordance with our <a href="<?php echo $dsv_conditions_url; ?>" target = "_blank" >Terms and Conditions</a>,<br />Please confirm you have read and agreed to our terms</div>
				<div class="dsbasketButtonRight"><?php echo dsf_submit_image($dsv_continue_button, 'Continue'); ?></div>
</div>*/?>
				</div>		
</div>


<div class="dsCHAright">      
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
		
		// GERMAN LAW SPECIFIC
		// special function to create a very small image for the little basket on the right side of page.
		// we need to check for parts id to ensure we get the correct image.
		
			if (isset ($product['part_id']) && $product['part_id'] >0) {
			echo dsf_get_basket_parts_image($product['part_id'], 39, 45);
		}else{
			echo dsf_get_basket_image($product['id'], 39, 45);
		}
			
		echo '</a></div>'; ?></td>
    <td valign="top" ><?php echo '<div class="dsCBASproQty">' . $product['qty'] . 'x</div>';?></td>
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












<?php
echo $dsv_basket_form_end;
?>
</div>
