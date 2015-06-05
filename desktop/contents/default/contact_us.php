<?php
/* This page posts specific fields back to the system where they will be sent as an email to the address supplied in the CMS for receiving webshop emsils.

Specific fields are:

firstname
lastname
email
enquiry
phone
custom_one
custom_two
custom_three

returned values (on submission failure have the prefix dsv_ added to them so the form can be re-populated)

additionally,  the field futureoffers can be added as a check box with the value of 1 in it.
This will then add the customer to the subscriptions table.

*/
?>


<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
        <div class="dsCIMG">
   		  	<div class="dsIMGLeftCorner"><?php echo dsf_image('custom/article_left_cover.png', '', '100', '87');?></div>
            <div class="dsIMGRightCorner"><?php echo dsf_image('custom/contact_right_cover.png', '', '100', '87');?></div>
			<?php echo dsf_image('custom/contact_lifestyle_img.jpg', 'Contact Us', '505', '284');?>
        </div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_PAGE_CONTACT); ?></h1>
		 <?php
// decide on what to show based on the variable dsv_contact_sent
// if this is set to true then we have sent the contact details.
// otherwise we are showing the contact form either from start or with errors.

if ($dsv_contact_sent == 'true'){
	// everything sent show success text from admin
	echo $dsv_contact_text;

}else{
	// not sent, show contact text from admin
	echo $dsv_contact_text;

	// show the form.
	echo $dsv_contact_form_start;
	echo '<div class="dsCUForm">';
	?>
    <?php
				 if (isset($dsv_contact_error) && strlen($dsv_contact_error)>1){
				 	echo $dsv_contact_error;
				 }
?>

				<div class="dscontactInput">
					<label for="firstname"><?php echo TRANSLATION_FIRST_NAME;?>: <span class="dsRequired">*</span></label>
				    <?php echo dsf_form_input('firstname',$dsv_firstname, 'size="35"', 'forminput');?>
	      		</div>
			   <div class="dscontactInput">
			   <label for="lastname"><?php echo TRANSLATION_LAST_NAME;?>: <span class="dsRequired">*</span></label>
				   <?php echo dsf_form_input('lastname',$dsv_lastname, 'size="35"' ,'forminput');?>
			   </div>
			   <div class="dscontactInput">
				<label for="email"><?php echo TRANSLATION_EMAIL_ADDRESS;?>: <span class="dsRequired">*</span></label>
				   <?php echo dsf_form_email('email',$dsv_email, 'size="35"' ,'forminput');?>
			   </div>
			   <div class="dscontactInput">
				<label for="phone"><?php echo TRANSLATION_TELEPHONE;?>:</label>
				   <?php echo dsf_form_input('phone',$dsv_phone, 'size="35"', 'forminput');?>
			   </div>
			   <div class="dscontactInput">
				<label for="enquiry"><?php echo TRANSLATION_ENQUIRY;?>: <span class="dsRequired">*</span></label>
				   <?php echo dsf_form_text('enquiry', $dsv_enquiry, '80', '8', '' , 'forminput'); ?>
			   </div>
	
				<div class="dscontactTick">
                <?php echo dsf_form_checkbox('futureoffers', '1', false, 'class="dsTick"'); ?>
                <label for="futureoffers"><?php echo TRANSLATION_FUTURE_OFFERS;?></label>
				</div>
				<div class="clear"></div>
				<div id="dsContactButton"><?php echo dsf_submit_image('button_submit.gif', TRANSLATION_SUBMIT_BUTTON); ?></div>
	
	
	<?php
	
	echo $dsv_contact_form_end;
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
<?php
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>