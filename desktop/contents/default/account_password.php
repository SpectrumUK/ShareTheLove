<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper(TRANSLATION_ACCOUNT_RESET_PASSWORD); ?></h1>
        <p>You can use this page to change your password to something more rememberable.</p>
		<p>To change your password simply enter your current password and then your new password in the other two boxes.</p>
        
                <?php
				if (isset($dsv_account_error) && strlen($dsv_account_error)>1){
					echo $dsv_account_error;
				}
			?>
            
        <div class="dsACSection">
        <h2><?php echo strtoupper(TRANSLATION_ACCOUNT_CHANGE_PASSWORD); ?></h2>
        <div id="dsRequiredTxt"><span class="dsRequired">*</span> <?php echo TRANSLATION_CHECKOUT_REQUIRED_INFO; ?></div>


			<?php echo $dsv_account_form_start;?>
				<div class="dsaccountInput"><label for="password_current"><?php echo TRANSLATION_ACCOUNT_CURRENT_PASSWORD; ?>: <span class="dsRequired">*</span></label>
				<?php echo dsf_form_password('password_current','','size="25"', 'forminput'); ?>
				</div>
	
				<div class="dsaccountInput"><label for="password_new"><?php echo TRANSLATION_ACCOUNT_NEW_PASSWORD; ?>: <span class="dsRequired">*</span></label>
				<?php echo dsf_form_password('password_new','','size="25"', 'forminput'); ?>
				</div>
	
				<div class="dsaccountInput"><label for="password_confirmation"><?php echo TRANSLATION_ACCOUNT_CONFIRM_NEW_PASSWORD; ?>: <span class="dsRequired">*</span></label>
				<?php echo dsf_form_password('password_confirmation','','size="25"', 'forminput'); ?>
				</div>
				<div class="dsaccountBtn"><?php echo dsf_submit_image($dsv_update_button, TRANSLATION_WORD_SAVE_CHANGES); ?></div>
			<?php echo $dsv_account_form_end;?>
</div>
</div>
    <div class="dsMETAright">
        <?php include ('custom_modules/default/ac_menu.php');?>
    </div>
</div>






