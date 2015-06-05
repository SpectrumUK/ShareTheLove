<div id="dsContent">
  <?php /*<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>*/?>
		<div class="dsCUContent">
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
	<?php /*<h1><?php echo ds_strtoupper($dsv_dynamic_form_name); ?></h1>*/?>
    <?php
	// show the form.
	echo '<div class="dsSUForm">';
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
    			<div id="dsSignupButton"><?php echo dsf_submit_image('button_submit.gif', TRANSLATION_SUBMIT_BUTTON); ?></div>
	<?php
				 
				 
				 
	
	echo $dsv_dynamic_form_end;
	echo '</div>';
} // end of form sent or not.
?>
</div>
    <?php /*<div class="dsADContent">
    	<h2>BY PHONE</h2>
    	<p>Call our Freephone Helpdesk on <strong>0800 212 438.</strong></p> 
	  <p><strong>Opening hours:</strong><br />9am to 5pm Monday to Thursday<br />9am to 4pm Friday</p>
    	<h2>BY POST</h2>
   	  <p>Remington<br />Spectrum Brands (U.K.) Ltd.<br />Customer Service Department<br />Fir Street<br />Failsworth<br />Manchester<br />M35 0HS</p>
    </div>*/?>
    <div class="clear"></div>
</div>

