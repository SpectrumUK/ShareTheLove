<?php
/* This page posts specific fields back to the system where they will be sent as an email to the address supplied in the CMS for receiving webshop emsils.

Specific variables are:

dsv_dynamic_form_start = the required form header commands.

dsv_dynamic_form_end = the required form footer commands,  usually only </form> but may contain a hidden field for form ID

dsv_dynamic_form_fields = a complete array of all fields required for the form.   we can either work with these manually or use inbuilt function dsf_output_form_array_field to do it for us.

dsv_dynamic_form_action =  if this says success then the form has successfully submitted otherwise we either are on an uncomplete form or validation of fields created an error.

dsv_dynamic_form_error = if a form is submitted and an error has occurred, this variable will be set with a response.

dsv_dynamic_form_action = if a successful transaction has occured this will be populated with success otherwise it will be blank.

dsv_dynamic_form_success_text = if a form is submitted and successful,  this field will contain the text from the CMS to show.



*/




?>
<div id="dsContent">
    <div class="dsMETAleft">
    <h1>PRODUCT RECALL</h1>
        <p>Thank you for visiting this page to select whether you’d prefer a replacement iron or a refund.  To collect this information we may need to retake some information that you have previously supplied, this is so we can cross reference all the information you have supplied us. </p>
        <p>We apologise for any  further inconvenience this may cause and would like to assure you this is the final stage of our product recall.</p>
    <?php
// decide on what to show based on the variable dsv_dynamic_form_action
// if this is set to success then we have sent the form successfully.


// otherwise we are showing the form either from start or with errors.




if ($dsv_dynamic_form_action == 'success'){
	// everything sent show success text
		
		echo $dsv_dynamic_form_success_text;






}else{
	// not sent
?>
<?php
	// show the form.
	echo '<div class="dsREGSection"><div class="dsRCform">';
	echo $dsv_dynamic_form_start;
	?>
    <?php
				 if (isset($dsv_dynamic_form_error) && strlen($dsv_dynamic_form_error)>1){
				 	echo $dsv_dynamic_form_error;
				 }
				 
			  	 
 // echo dsf_print_array($dsv_dynamic_form_fields);
			 	 
				 
				 
foreach($dsv_dynamic_form_fields as $item){
	 echo dsf_output_form_array_complete_item($item) . "\n\n";
}
	?>
    	<div class="clear">&nbsp;</div>
    			<div id="dsREGButton"><?php echo dsf_submit_image('button_submit.gif', TRANSLATION_SUBMIT_BUTTON); ?></div>
	<?php
				 
				 
				 
	
	echo $dsv_dynamic_form_end;
	echo '</div></div>';
} // end of form sent or not.
?>
	  <div class="clear"></div>
    	 
    </div>
    <?php /*<div class="dsMETAright">&nbsp;</div>*/?>
    </div>
    <div class="clear">&nbsp;</div>
</div>
<?php
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>