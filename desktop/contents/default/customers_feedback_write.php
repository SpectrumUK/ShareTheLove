<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
           	<div id="rightContent">
            <div class="pagTitles">
            <h1><?php echo 'Your Feedback'; ?></h1>
             <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>
            <p>We are continually updating and improving our website to give our customers the best possible service. We recognise the importance of our customer's opinions and ideas and value any feedback received whether 
            possitive or negative.</p>
			<p>These pages show some of the comments that previous customers have written about us, we would appreciate if you could take the time to advise us of your experience with our service.</p>
<div class="lineBreak"></div>
          <?php

// if the form has been submitted and everything is ok, we will have the result
// $action = success

// therefore we can show the success page.


if ($action =='success'){
	 echo '<div class="dsFbSuccess">' . nl2br($dsv_feedback_success_text) . '</div>';
 
}else{

		// start of allowing customer to give their feedback.
	  
	  // any errors are held within the variable $dsv_feedback_error
	  // if there is anything in this variable therefore the form has been submitted and there are errors.
	  
	  if (strlen($dsv_feedback_error)>1){
		echo '<div>' . $dsv_feedback_error . '</div>';
	  }
	  
		echo $dsv_feedback_form_start;	// echo the html code to create the form.
	
		?>
		<div class="dsFBHead">Please enter your name.</div>
		<div class="dsFbWRow"><?php echo dsf_form_input('customer_name', $dsv_customer_name, 'size="30"');?></div>
		
		
		<div class="dsFBHead">Q: Please Rate your overall shopping experience with ourselves.</div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('rating', '5') . 'Excellent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '4') . 'Good &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '3') . 'Average &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '2') . 'Below Average &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '1') . 'Poor'; ?></div>
	
		<div class="dsFBHead">Q: How easy did you find our navigation to finding products.</div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('navresult', '5') . 'Very Easy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('navresult', '4') . 'Easy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('navresult', '3') . 'Average &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('navresult', '2') . 'A little Difficult &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('navresult', '1') . 'Very Difficult'; ?></div>
	
		<div class="dsFBHead">Q: How do you rate the amount of information / details we show per product.</div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('inforesult', '5') . 'Extensive &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('inforesult', '4') . 'Good &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('inforesult', '3') . 'Acceptable &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('inforesult', '2') . 'Poor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('inforesult', '1') . 'Unacceptable'; ?></div>
	
		<div class="dsFBHead">Q: Did you find the product you were looking for?</div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('productresult', 'Yes') . 'Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('productresult', 'No') . 'No'; ?></div>
		
		<div class="dsFBHead">Q: If No, what product were you looking for?</div>
		<div class="dsFbWRow"><?php echo dsf_form_input('productlook', $dsv_product_look, 'size="50"'); ?></div>
	
		<div class="dsFBHead">Q: How do you rate the quality and design of our website compared to other sites you visit?</div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('othersresult', '5') . 'Excellent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('othersresult', '4') . 'Good &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('othersresult', '3') . 'Average &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('othersresult', '2') . 'Poor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('othersresult', '1') . 'Don&acute;t Know'; ?></div>
	
		<div class="dsFBHead">Q: Would you recommend us to others?</div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('recomend', 'Yes') . 'Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('recomend', 'No') . 'No'; ?></div>
	
		<div class="dsFBHead">Q: How did you hear about us?</div>
		<div class="dsFbWRow"><?php echo dsf_form_dropdown('source_id', $dsv_source_array, $dsv_source_id); ?></div>
	
		<div class="dsFBHead">Your Comments.</div>
		<div class="dsFbWRow"><?php echo dsf_form_text('comments', $dsv_comments, 'soft', 60, 10); ?></div>
	
		<div class="sumbitButton"><?php echo dsf_submit_image($dsv_submit_button, 'Send'); ?></div>
	
	<?php
		echo $dsv_feedback_form_end;	// echo the html code to close the form.
		
} // end if success or request
?>  
<!-- Content End //-->
	</div>
</div>
</div>
