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
        <p>As part of our ongoing quality monitoring program, we&rsquo;ve identified an issue with a small number of our irons, that may carry a risk  that the flex may fail.</p>
<p><strong>Only the following model numbers are affected.</strong><br />
  15081, 18651, 18720, 18741, 18742, 18743, 19220, 19221, 19222, 19400, 19840, 20260, 20280, 20550-10, 20560-10</p>
<p>This model number can be found on the underside of the heel of the iron, where you will find a rectangular shaped label which contains a five digit code.</p>
		<div class="clear"></div>
        <div><img src="http://uk.russellhobbs.com/images/at_recall-rating-label_update.png" alt="Product Recall" title=" Product Recall " width="505" height="284" /></div>
        <div class="clear"></div>
        <p>If you have one of the Iron models listed above, you will also need to check the batch code, which is shown in the diagram above</p>
      <h2>AFFECTED BATCH CODES</h2>
<p>If the batch code starts with 045 through to 365 and&nbsp;ends with 12 or starts with 001 through to 195 and ends&nbsp;with 13, then you have an affected Iron.</p>
<p><u>Irons with any other number sequence are not affected.</u></p>
<p>Any Irons with a 4 digit batch code are not affected by this recall.</p>
<p>Any Irons with codes ending 10, 11 and 14 are  not affected by this recall. </p>
<p>If you do have an affected iron, please stop using it immediately. Please telephone our customer service department on Freephone <strong>0800 307 7616</strong> or if you are calling from a mobile <strong>0333 103 9663</strong>, who will advise you of how to return your iron for a replacement or full refund of the purchase price.</p>
<p>We would like to thank you for your co-operation and apologise for any inconvenience.</p>
<p>No other Russell Hobbs products or irons outside of the above codes are affected by this recall.</p>
    <?php /*<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>*/?>
            <?php /*<div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>*/?>
	  <div class="clear"></div>
    	 
    </div>
    <div class="dsMETAright">
        <h2>BY PHONE</h2>
    	<p>Call our Helpdesk on<br>
   	    Freephone: <strong>0800 307 7616</strong><br>
   	    Mobile: 
    	<strong>0333 103 9663</strong></p> 
	  <p><strong>Opening hours:</strong><br />
	  8am to 11pm Monday - Friday<br />
	  9am to 5pm Saturday &amp; Sunday</p>
		
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
	echo '<div class="dsRCform">';
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
	echo '</div>';
} // end of form sent or not.
?>
    </div>
    <div class="clear">&nbsp;</div>
</div>
<?php
if (isset($ex_script_text)){
	echo $ex_script_text;
}

echo '<div style="color:#ffffff;">' . dsf_print_array($dsv_dynamic_form_fields) . '<br>
<br>
<br>
<br>' . dsf_print_array($dsv_dynamic_form_start) . '<br>
<br>
<br>
'. dsf_print_array($dsv_dynamic_form_end) . '<br>
<br>
<br>
<br>
</div>'
?>