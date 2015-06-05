<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper(TRANSLATION_SIGNUP); ?></h1>
		 <?php
// decide on what to show based on the variable dsv_contact_sent
// if this is set to true then we have sent the contact details.
// otherwise we are showing the contact form either from start or with errors.

// decide on what to show based on the variable dsv_signup_sent
// if this is set to true then we have sent the details.
// otherwise we are showing the form either from start or with errors.


if ($dsv_signup_sent == 'true'){
	// everything sent show success text
		// ############### ADD SOME TEXT HERE THERE IS NOT AN ADMIN FOR IT ############
	echo '<p>Dekujeme za registraci pro zasílání e-mailu.</p><p> Byl/a jste zarazena do našeho seznamu.</p>';
		// ############################################################################
}else{
	// not sent

	// show the form.
	echo '<div class="dsSUForm">';
	echo $dsv_signup_form_start;
	?>
    <?php
				 if (isset($dsv_signup_error) && strlen($dsv_signup_error)>1){
				 	echo $dsv_signup_error;
				 }
?>
				<div class="dsSignupInput">
					<label for="firstname"><?php echo TRANSLATION_FIRST_NAME;?>: <?php echo ((int)$dsv_form_fields['firstname']['required'] == 1 ? '*' : '');?></label>
				    <?php echo dsf_form_input('firstname',$dsv_firstname, 'size="35"', 'forminput');?>
	      		</div>
			   <div class="dsSignupInput">
			   <label for="lastname"><?php echo TRANSLATION_LAST_NAME;?>: <?php echo ((int)$dsv_form_fields['lastname']['required'] == 1 ? '*' : '');?></label>
				   <?php echo dsf_form_input('lastname',$dsv_lastname, 'size="35"' ,'forminput');?>
			   </div>
               <div class="clear"></div>
			   <div class="dsSignupInput">
				<label for="email"><?php echo TRANSLATION_EMAIL_ADDRESS;?>: <?php echo ((int)$dsv_form_fields['email']['required'] == 1 ? '*' : '');?></label>
				   <?php echo dsf_form_email('email',$dsv_email, 'size="35"' ,'forminput');?>
			   </div>
				<div class="clear"></div>
			   <div class="dsSignupRadio">
				<label><?php echo TRANSLATION_GENDER;?>: </label>
                <div class="clear"></div>
				   <?php 
							// multiple radio boxes
							$cboxes = explode("\n" , $dsv_form_fields['gender']['field_values']);
							if (is_array($cboxes) && sizeof($cboxes)> 0){
								// we have an array therefore lets display them all
								$return_text = '';
								
								$rvalue = $dsv_form_fields['gender']['field_name'];
								
								foreach ($cboxes as $item){
									$item = str_replace(array("\n", "\r" , "\l"),"", $item);
									echo $item . '' . dsf_form_radio($rvalue, $item) . '';
								}
							}
			   
			   ?>			   </div>
               <div class="clear"></div>
			   <div class="dsSignupDrop">
				<label><?php echo TRANSLATION_DOB;?>:</label>
				<div class="clear"></div>
				   <?php 
				   // use the function to generate seperate labels and values
				   echo dsf_output_field($dsv_form_fields['dob']);?>
			   </div>
			   <div class="dsSignupInput"><?php echo $dsv_form_fields['dob']['long_text'];?></div>

				<div class="clear"></div>

				<div class="dsSignupAgree">
                <?php echo dsf_form_checkbox('agree', '1', true, 'class="dsTick"'); ?>
                <label for="confirmation"><?php echo $dsv_form_fields['agree']['long_text'];?></label>
				</div>
				<div class="clear"></div>
				<div id="dsSignupButton"><?php echo dsf_submit_image('button_submit.gif', TRANSLATION_SUBMIT_BUTTON); ?></div>
	
	<?php
	
	echo $dsv_signup_form_end;
	echo '</div>';
} // end of form sent or not.
?>
    </div>
    <div class="dsMETAright">
        <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
        <div class="clear"></div>
        <?php 
		// we need to add address information to the contact pages,  rather than have many different contact forms, we use an include
		// to get the address details,  we use a different tecnique however of using a system variable to prefix the include we want
		// from the same folder.
		include ('custom_modules/contacts/' . strtolower(CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX) . '_contact_address.php');
		?>
    </div>
</div>

