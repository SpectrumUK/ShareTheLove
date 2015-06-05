
<div id="dsContent">
    <div class="dsMETAleft">

           
    		<div class="clear"></div><br />
<br />
<br />
<br />
<br />


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
    <div class="dsMETAright">
        <?php include ('../default/custom_modules/default/meta_menu.php');?>
    </div>
    <div class="clear">&nbsp;</div>
</div>
<?php
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>