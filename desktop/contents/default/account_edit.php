<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper(TRANSLATION_ACCOUNTS_MY_ACCOUNT); ?></h1>
        <?php 
	// start the form.
		echo $dsv_account_form_start; 
		
		
				 // echo any error.
				 
				 if (isset($dsv_account_error) && strlen($dsv_account_error)>1){
				 	echo $dsv_account_error;
				 }
				
				?>
        <div class="dsACSection">
        <h2><?php echo strtoupper(TRANSLATION_CHECKOUT_NAME_TITLE); ?></h2>
        <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
        <div class="dsaccountInput"><label for="i_salutation"><?php echo TRANSLATION_CHECKOUT_SALUTATION; ?>:</label>
			<?php echo dsf_form_dropdown('i_salutation', $salutation_array, $salutation, '', 'forminput');?>
			<?php // '&nbsp;Other&nbsp;' . dsf_form_input('i_salutation_other','','size="12"','','','forminput'); ?>
			</div>
			

			<div class="dsaccountInput"><label for="i_firstname"><?php echo TRANSLATION_FIRST_NAME; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('i_firstname',$firstname,'','forminput'); ?>
			</div>
			
			
			<div class="dsaccountInput"><label for="i_lastname"><?php echo TRANSLATION_LAST_NAME; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('i_lastname',$lastname,'','forminput'); ?>
			</div>



		
					
			<?php
			  if ($dsv_require_dob == 'true') {
			?>
				<div class="dsaccountInput"><label for="i_dobday"><?php echo TRANSLATION_DOB; ?>:</label>
				<?php echo TRANSLATION_DAY . '&nbsp;' . dsf_form_input('i_dobday',$dobday,'size="2"'). '&nbsp;' . TRANSLATION_MONTH . '&nbsp;' . dsf_form_input('i_dobmonth',$dobmonth,'size="2"') . '&nbsp;' . TRANSLATION_YEAR . '&nbsp;' . dsf_form_input('i_dobyear',$dobyear,'size="4"'); ?>
				</div>
			<?php
			  }
			?>
									
			<div class="dsaccountInput"><label for="i_email_address"><?php echo TRANSLATION_EMAIL_ADDRESS;?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('i_email_address',$email_address,'size="40"','forminput'); ?>
		</div>
    </div>
    <?php
					  if (isset($dsv_show_company) && $dsv_show_company == 'true') {
					?>
					<div class="dsACSection">
						<h2><?php echo strtoupper('Company Details'); ?></h2>
						<div class="dsaccountInput"><label for="i_invoice_company">Company Name:</label>
						<?php echo dsf_form_input('i_invoice_company',$invoice_company,'size="40"','forminput'); ?>
						</div>
					</div><?php
					  }
					?>

		
					<div class="dsACSection">
                    <h2><?php echo strtoupper(TRANSLATION_CHECKOUT_BILLING_TITLE); ?></h2>
                    <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
                    <div id="dsFutureTxt"><?php echo TRANSLATION_ACCOUNT_FUTURE_ORDERS; ?> </div>

						<div class="dsaccountInput"><label for="i_invoice_house"><?php echo TRANSLATION_CHECKOUT_HOUSE; ?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_house',$invoice_house,'size="20" maxlength="25"','forminput'); ?>
						</div>

						<div class="dsaccountInput"><label for="i_invoice_street"><?php echo TRANSLATION_CHECKOUT_STREET; ?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_street',$invoice_street,'size="30"  maxlength="30"','forminput'); ?>
						</div>
		
						<div class="dsaccountInput"><label for="i_invoice_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT; ?>:</label>
						<?php echo dsf_form_input('i_invoice_district',$invoice_district,'size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dsaccountInput"><label for="i_invoice_town"><?php echo TRANSLATION_CHECKOUT_TOWN; ?>:</label>
						<?php echo dsf_form_input('i_invoice_town',$invoice_town,'size="30"  maxlength="30"','forminput'); ?>
						</div>
		
						<div class="dsaccountInput"><label for="i_invoice_county"><?php echo TRANSLATION_CHECKOUT_COUNTY; ?>:</label>
						<?php echo dsf_form_input('i_invoice_county',$invoice_county,'size="30"  maxlength="30"','forminput'); ?>
						</div>
		
						<div class="dsaccountInput"><label for="i_invoice_postcode"><?php echo TRANSLATION_CHECKOUT_POST_CODE; ?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_postcode', $invoice_postcode,'size="15"  maxlength="9"','forminput'); ?>
						</div>

				  
						<div class="dsaccountInput"><label for="i_invoice_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY; ?>:</label>
						<?php echo dsf_country_list('i_invoice_country','','','forminput',$dsv_master_country_id); ?>
						</div>

					</div>
                    <?php



 if($dsv_allow_delivery_address == 'true'){
 ?>
					<div class="dsACSection">
						<h2><?php echo strtoupper(TRANSLATION_CHECKOUT_DELIVERY_TITLE); ?></h2>
                        <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
                    	<div id="dsDeliveryTxt"><?php echo TRANSLATION_CHECKOUT_BILLING_MESSAGE; ?>
<br /><?php echo TRANSLATION_ACCOUNT_FUTURE_ORDERS; ?></div>
						
						<div class="dsaccountInput"><label for="i_delivery_name"><?php echo TRANSLATION_CHECKOUT_CONTACT_NAME; ?>:</label>
						<?php echo dsf_form_input('i_delivery_name',$delivery_name,'size="30"  maxlength="30"','forminput'); ?>
						</div>


					<?php
					  if (isset($dsv_show_company) && $dsv_show_company == 'true') {
					?>
						<div class="dsaccountInput"><label for="i_delivery_company">Company Name:</label>
						<?php echo dsf_form_input('i_delivery_company',$delivery_company,'size="40"','forminput'); ?>
						</div>
					 <?php
					  }
					?>

						
						<div class="dsaccountInput"><label for="i_delivery_house"><?php echo TRANSLATION_CHECKOUT_HOUSE; ?>:</label>
						<?php echo dsf_form_input('i_delivery_house',$delivery_house,'size="20" maxlength="25"','forminput'); ?>
						</div>

						<div class="dsaccountInput"><label for="i_delivery_street"><?php echo TRANSLATION_CHECKOUT_STREET; ?>:</label>
						<?php echo dsf_form_input('i_delivery_street',$delivery_street,'size="30"  maxlength="30"','forminput'); ?>
						</div>
		
						<div class="dsaccountInput"><label for="i_delivery_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT; ?>:</label>
						<?php echo dsf_form_input('i_delivery_district',$delivery_district,'size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dsaccountInput"><label for="i_delivery_town"><?php echo TRANSLATION_CHECKOUT_TOWN; ?>:</label>
						<?php echo dsf_form_input('i_delivery_town',$delivery_town,'size="30"  maxlength="30"','forminput') . '&nbsp;'; ?>
						</div>
		
						<div class="dsaccountInput"><label for="i_delivery_county"><?php echo TRANSLATION_CHECKOUT_COUNTY; ?>:</label>
						<?php echo dsf_form_input('i_delivery_county',$delivery_county,'size="30"  maxlength="30"','forminput') . '&nbsp;'; ?>
						</div>
		
						<div class="dsaccountInput"><label for="i_delivery_postcode"><?php echo TRANSLATION_CHECKOUT_POST_CODE; ?>:</label>
						<?php echo dsf_form_input('i_delivery_postcode', $delivery_postcode,'size="15"  maxlength="9"','forminput'); ?>
						</div>

				  
						<div class="dsaccountInput"><label for="i_delivery_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY; ?>:</label>
						<?php echo dsf_country_list('i_delivery_country','','','forminput',$dsv_master_country_id); ?>
						</div>
					</div>
 <?php
 }
 ?>
 
		
		
					<div class="dsACSection">
						<h2><?php echo strtoupper(TRANSLATION_CHECKOUT_CONTACT_DETAILS_TITLE); ?></h2>						

						<div class="dsaccountInput"><label for="i_telephone"><?php echo TRANSLATION_CHECKOUT_TELEPHONE; ?>:</label>
						<?php echo dsf_form_input('i_telephone',$telephone,'size="20"','forminput'); ?>
						</div>

						<div class="dsaccountInput"><label for="i_mobile"><?php echo TRANSLATION_CHECKOUT_MOBILE; ?>:</label>
						<?php echo dsf_form_input('i_mobile',$mobile,'size="20"','forminput'); ?>
						</div>
						<?php /*<div class="dsaccountInput"><label for="i_fax">Fax Number:</label>
						<?php echo dsf_form_input('i_fax',$fax,'size="20"','forminput'); ?>
						</div>*/?>
		
				</div>

	
			<div class="dsaccountBtn">
            
			<?php
				echo dsf_submit_image($dsv_update_button, TRANSLATION_WORD_SAVE_CHANGES) . '<a href="' . dsf_link('account.html', '', 'SSL') . '">' . dsf_image_button($dsv_cancel_button, TRANSLATION_WORD_CANCEL) . '</a>';
								 ?>
			</div>
		
<?php
echo $dsv_account_form_end;
?>
                    </div>
    <div class="dsMETAright">
        <?php include ('custom_modules/default/ac_menu.php');?>
    </div>
</div>