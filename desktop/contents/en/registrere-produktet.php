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
<div id="metaBannerIMG">&nbsp;</div>
<div id="dsContent">
    <div class="dsMETAleft">
    <div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
            <?php /*<div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>*/?>
    		<div class="clear"></div>
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
    		<h1><?php echo $dsv_dynamic_form_name; ?></h1>
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
    			<div id="dsREGButton"><?php echo dsf_submit_image('product_reg_btn.gif', TRANSLATION_WORD_REGISTER); ?></div>
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
?>