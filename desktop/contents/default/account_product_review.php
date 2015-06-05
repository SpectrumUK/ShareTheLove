<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
			<div id="rightContent">
    	<h1><?php echo TRANSLATION_ACCOUNTS_PRODUCT_REVIEW; ?></h1>
    	<p>Wir arbeiten kontinuierlich an unserer Webseite, um Ihnen den besten Service bieten zu k&ouml;nnen. 
Ihr Feedback, positiv oder negativ, ist uns sehr wichtig. Es hilft uns, unsere Produkte und Services stetig zu verbessern.</p>
			<p>Bitte sagen Sie uns, was sie von <stong><?php echo $dsv_product_details['name'];?></strong>  halten</p>
            <div class="lineBreak"></div>
             <?php

	// show a small snipit of the product from the dsv_product_details array
	?>
	
	
	
	<?php
	
// if the form has been submitted and everything is ok, we will have the result
// $action = success

// therefore we can show the success page.

if ($action =='success'){
	 ?>
	<div class="dsFBHead"><h2><?php echo TRANSLATION_ACCOUNTS_REVIEW_THANKYOU;?></h2></div>
	 <?php
}else{

		// start of allowing customer to give their review.
	  
	  // any errors are held within the variable $dsv_review_error
	  // if there is anything in this variable therefore the form has been submitted and there are errors.
	  
	  if (strlen($dsv_review_error)>1){
		echo '<div>' . $dsv_review_error . '</div>';
	  }
	  
		echo $dsv_review_form_start;	// echo the html code to create the form.
	
		?>
        <div class="dsFBHead"><h2><?php echo $dsv_product_details['name'];?></h2></div>
        <div id="dsppMainImage">
	<?php
					if (isset($dsv_product_details['image_1']) && strlen($dsv_product_details['image_1'])>1){
							echo dsf_image($dsv_product_details['image_1'], $dsv_product_details['model'], $dsv_product_details['image_width'],$dsv_product_details['image_height'],'name="mainpic"');
					}
	?></div>
        <div id="reviewForm">
		<div class="dsFBHead"><h5><?php echo TRANSLATION_WORD_NAME;?></h5></div>
		<div class="dsFbWRow"><?php echo dsf_form_input('customer_name', $dsv_customer_name, 'size="30"');?></div>
		
		<div class="dsFBHead"><h5><?php echo TRANSLATION_ACCOUNTS_PRODUCT_RATING;?></h5></div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('rating', '5') . TRANSLATION_WORD_EXCELLENT . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '4') . TRANSLATION_WORD_GOOD . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '3') . TRANSLATION_WORD_AVERAGE . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '2') . TRANSLATION_WORD_BELOW_AVERAGE . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('rating', '1') . TRANSLATION_WORD_POOR; ?></div>
	
		<div class="dsFBHead"><h5><?php echo TRANSLATION_ACCOUNTS_RECOMMEND;?></h5></div>
		<div class="dsFbWRow"><?php echo dsf_form_radio('recomend', 'Yes') . TRANSLATION_WORD_YES . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . dsf_form_radio('recomend', 'No') . TRANSLATION_WORD_NO; ?></div>
	
		<div class="dsFBHead"><h5><?php echo TRANSLATION_ACCOUNTS_COMMENTS;?></h5></div>
		<div class="dsFbWRow"><?php echo dsf_form_text('comments', $dsv_comments, 'soft', 50, 10); ?>
        <div class="dsFbSubmit"><?php echo dsf_submit_image($dsv_submit_button, TRANSLATION_SUBMIT_BUTTON); ?></div>
        </div>
        </div>
	
	<?php
		echo $dsv_review_form_end;	// echo the html code to close the form.
		
} // end if success or request
?>  
            </div>
	</div>
</div>

