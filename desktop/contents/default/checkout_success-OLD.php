<!-- body //-->
	<div class="baskHeader" id="contentDiv">
		<div id="contentHeader" class="baskImg">
        	<div id="stepImg"><?php echo dsf_image('custom/basket_s4.jpg', 'Step 4. Order Complete', '415', '76');?></div>
          <div id="securImg"><?php echo dsf_image('custom/secure_logo.gif', 'Secure Checkout', '280', '56');?></div>
        </div>
    </div>    
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
			<div id="rightContent">
            <div class="pagTitles">

<?php /*
	// echo the current steps images.
	?>
			  <div id="dscheckoutBasketSteps"><?php 
			  echo dsf_image_button('step1_0.gif', 'Step 1').
			  dsf_image_button('step_seperator.gif', 'Next Step').
			   dsf_image_button('step2_0.gif', 'Step 2').
			    dsf_image_button('step_seperator.gif', 'Next Step').
				 dsf_image_button('step3_1.gif', 'Step 3');
				  */?>



<h1><?php 
if (isset($dsv_page_title) && strlen($dsv_page_title)>1){
	echo $dsv_page_title;
}else{
	echo 'Checkout Process Complete';
}
 ?></h1></div>


<?php 
if (isset($dsv_page_text) && strlen($dsv_page_text)>1){
	echo $dsv_page_text;
}else{
	echo '<p>Thank you<br><br>Your order is being processed, we shall contact you soon.</p>';
}
?>

<p>Thank you for shopping with us. Please leave your feedback to help others choose this site by clicking on the link below<br><br><?php echo '<a href="' . dsf_link('customers_feedback_write.html') . '">' . dsf_image_button($dsv_feedback_button, 'Let us know your feedback') . '</a>'; ?></p>

<img src="https://tsw0.com/7171/?aid=2&value=<?php echo $dsv_order_total;?>&cur=GBP&ordid=<?php echo $dsv_order_number;?>&pdesc=product description&group=your group" height="1" width="1" border="0" />


	<!-- Google Code for Sale Complete Conversion Page -->
	<script type="text/javascript">
	<!--

		var google_conversion_id = 1028972501;

		var google_conversion_language = "en_GB";

		var google_conversion_format = "3";

		var google_conversion_color = "ffffff";

		var google_conversion_label = "brMUCJ2GmQEQ1b_T6gM";

		var google_conversion_value = 0;

	//-->

	</script>

	<script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script>

	<noscript><div style="display:inline;">
    	<img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1028972501/?label=brMUCJ2GmQEQ1b_T6gM&amp;guid=ON&amp;script=0"/>
    </div></noscript>

            </div>
	</div>