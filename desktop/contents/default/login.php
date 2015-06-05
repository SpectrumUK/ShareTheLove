<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContent">
    <div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="clear"></div>
    <h1><?php echo strtoupper(TRANSLATION_WORD_CUSTOMER_ACCOUNT); ?></h1>
    <div class="dsLOGLeft">
    		<div class="dsLOGSection">
            <h2><?php echo strtoupper(TRANSLATION_LOGIN); ?></h2>
            <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
            <?php
				if (isset($dsv_login_error) && strlen($dsv_login_error)>1){
					echo $dsv_login_error;
				}
			?>
			<?php echo $dsv_login_form_start;?>
			<div class="dsLOGInput"><label for="email_address"><?php echo TRANSLATION_CHECKOUT_EMAIL_ADDRESS; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('email_address','','size="25"'); ?>
			</div>
	
			<div class="dsLOGInput"><label for="password"><?php echo TRANSLATION_WORD_PASSWORD; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_password('password','','size="25"'); ?>
			</div>
	
			<div class="dsLOGBtn"><?php echo dsf_submit_image($dsv_login_button, TRANSLATION_LOGIN); ?></div>
			<?php echo $dsv_login_form_end;?>
            </div>
        <div class="dsFLOGSection">
            <h2><?php echo strtoupper(TRANSLATION_ACCOUNTS_FORGOT_PASSWORD); ?></h2>
            <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
            <?php // check to see if reminder was valid and email has been sent.
		if (isset($dsv_reminder_sent) && $dsv_reminder_sent =='true'){ // password reset - email sent to user
		?>
			<p>Thank you, we have reset your password and sent you an email giving details.<br /><br />Please use this new password to login</p>
		<?php
}else{
		// no reminder sent therefore show standard page.
?>
			<?php echo $dsv_reminder_form_start;?>
			<p><?php echo TRANSLATION_ACCOUNTS_PASSWORD_INFO;?></p>
			<div class="dsLOGInput"><label for="email_reminder"><?php echo TRANSLATION_CHECKOUT_EMAIL_ADDRESS; ?>: <span class="dsRequired">*</span></label>
			<?php echo dsf_form_input('email_reminder','','size="22"'); ?>
			</div>
   
			<div class="dsFLOGBtn"><?php echo dsf_submit_image('button_send.gif', TRANSLATION_SUBMIT_BUTTON); ?></div>
			<?php echo $dsv_reminder_form_end;?>
<?php
}
?>
        </div>	
	</div>
    <div class="dsLOGRight">
    <h2><?php echo strtoupper(TRANSLATION_WORD_REGISTER); ?></h2>
    <div id="dsRequiredWTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>
    <?php
	// decide whether the regist form has been sent (and validated or not)
	if ($dsv_register_sent == 'true'){
				// registration process has competed successfully
				?>
				<p>Thank you, we have created an account in your name</p>
				<p>You can log into our website at any time using the email address and password you have just provided.</p>
			
	<?php
	}else{
	 // show register form.
	 ?>
	 
	<p>Keep up to date with all the latest products, news, offers and more... </p>
    
				<?php echo $dsv_register_form_start;?>
							<div class="dsREGInput"><label for="i_salutation"><?php echo TRANSLATION_CHECKOUT_SALUTATION; ?>: <span class="dsRequired">*</span></label>
                                        <?php echo dsf_form_dropdown('i_salutation', $salutation_array, $salutation, '', 'forminput'); ?>
                                        <?php // '&nbsp;Other&nbsp;' . tep_draw_input_field('i_salutation_other','','size="12"','','','forminput'); ?>
                                        </div>
                                        
                                        <div class="dsREGInput"><label for="i_firstname"><?php echo TRANSLATION_FIRST_NAME; ?>: <span class="dsRequired">*</span></label>
                                        <?php echo dsf_form_input('i_firstname',$firstname,'','forminput'); ?>
                                        </div>
                                        
                                        
                                        <div class="dsREGInput"><label for="i_lastname"><?php echo TRANSLATION_LAST_NAME; ?>: <span class="dsRequired">*</span></label>
                                        <?php echo dsf_form_input('i_lastname',$lastname,'','forminput') ; ?>
                                        </div>
                
           <?php
		   /*
		                                <div class="dsregisterInput"><label for="i_invoice_house">House Number / Name:</label>
                                        <?php echo dsf_form_input('i_invoice_house',$invoice_house,'size="20" maxlength="25"','forminput') . '&nbsp;<span class="dsinputRequirement">*</span>'; ?>
                                        </div>
                
                                        <div class="dsregisterInput"><label for="i_invoice_street">Street:</label>
                                        <?php echo dsf_form_input('i_invoice_street',$invoice_street,'size="30"  maxlength="30"','forminput') . '&nbsp;<span class="dsinputRequirement">*</span>'; ?>
                                        </div>
                        
                                        <div class="dsregisterInput"><label for="i_invoice_district">District:</label>
                                        <?php echo dsf_form_input('i_invoice_district',$invoice_district,'size="30"  maxlength="30"','forminput') . '&nbsp;'; ?>
                                        </div>
                
                                        <div class="dsregisterInput"><label for="i_invoice_town">Town:</label>
                                        <?php echo dsf_form_input('i_invoice_town',$invoice_town,'size="30"  maxlength="30"','forminput') . '&nbsp;'; ?>
                                        </div>
                        
                                        <div class="dsregisterInput"><label for="i_invoice_county">County:</label>
                                        <?php echo dsf_form_input('i_invoice_county',$invoice_county,'size="30"  maxlength="30"','forminput') . '&nbsp;'; ?>
                                        </div>
                        
                                        <div class="dsregisterInput"><label for="i_invoice_postcode">Post Code:</label>
                                        <?php echo dsf_form_input('i_invoice_postcode', $invoice_postcode,'size="15"  maxlength="9"','forminput') . '&nbsp;<span class="dsinputRequirement">*</span>'; ?>
                                        </div>
                
                                  
                                        <div class="dsregisterInput"><label for="i_invoice_country">Country:</label>
                                        <?php echo dsf_country_list('i_invoice_country','','','forminput'); ?>
                                        </div>
            */
			?>    
                                        <div class="dsREGInput"><label for="r_email_address"><?php echo TRANSLATION_CHECKOUT_EMAIL_ADDRESS; ?>: <span class="dsRequired">*</span></label>
                                        <?php echo dsf_form_input('r_email_address','','size="25"','forminput'); ?>
                                        </div>
                            
                                        <div class="dsREGInput"><label for="password"><?php echo TRANSLATION_WORD_PASSWORD; ?>: <span class="dsRequired">*</span></label>
                                        <?php echo dsf_form_password('r_password','','size="25"','forminput'); ?>
                                        </div>
                            
                                        <div class="dsREGInput"><label for="r_retype"><?php echo TRANSLATION_WORD_CONFIRM_PASSWORD; ?>: <span class="dsRequired">*</span></label>
                                        <?php echo dsf_form_password('r_retype','','size="25"','forminput'); ?>
                                        </div>
                
                
                
                                        <div class="dsREGTick"><?php echo dsf_form_checkbox('i_agreedterms','1','','class="forminput"'); ?>
                                        <label for="i_agreedterms">I have read and agreed to the <a href="<?php echo dsf_link('conditions.html','','SSL');?>" target="_blank">Terms &amp; Conditions</a></label>
                                        </div>
                						<div class="clear"></div>
                                        <div class="dsREGTick"><?php echo dsf_form_checkbox('i_marketing','1','','class="forminput"'); ?>
                                        <label for="i_marketing">I would like to receive news and offer from Russell Hobbs</label>
                                        </div>
                				<div class="clear"></div>
                                <div class="dsREGBtn"><?php echo dsf_submit_image($dsv_register_button, TRANSLATION_WORD_REGISTER); ?></div>
                            <?php echo $dsv_register_form_end;?>
	<?php
	} // end if register form processed
	?>
</div>
</div>
