	<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb">
        	<ul>
				<li><a href="<?php echo dsf_link('index.html');?>"><?php echo TRANSLATION_HOME;?></a></li>
            	<li><a href="<?php echo dsf_link('your-six-year-guarantee.html');?>"><?php echo 'About Your 6 Year Guarantee';?></a></li>
			</ul>
        </div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper ('Your Guarantee'); ?></h1>
        <?php
				 if (isset($dsv_signup_error) && strlen($dsv_signup_error)>1){
				 	echo $dsv_signup_error;
				 }
			?>
            
        <?php
if (isset($dsv_signup_sent) && $dsv_signup_sent == 'true'){
	// we have sucessfully saved the data,   the serial number for this is within the field dsv_serial_generated

	?><h1>Thank You</h1>
      <p>Thank you for registering your 6 year guarantee<br />
		Your unique registration code is: <strong><?php echo $dsv_serial_generated;?></strong>
      </p>

      <h2>Guarantee details</h2>
      <p>Please print a copy of these details and keep them safe with your proof of purchase, as you will need these in the event of a claim.</p>
      <p><strong>Registration code:</strong> <?php echo $dsv_serial_generated;?><br />
	  	 <strong>Model Number:</strong> <?php echo $dsv_Model;?><br />
		 <strong>Date of Purchase:</strong> <?php echo $dsv_Purchase_Date;?><br />
	     <strong>Guarantee Duration:</strong> <?php echo $dsv_guarantee_duration;?><br /><br /></p>

       <h2>Contact Us</h2>
       <p>If you have any queries or wish to make a claim please contact us on our Helpline <strong>0845 658 9700</strong>. <br />
The Russell Hobbs Helpline is open Monday to Thursday 08:00 - 17:00, Friday 08:00 - 16:00.</p>
       <p>Find out more information about <a href="http://uk.russellhobbs.com/your-six-year-guarantee.html" title="Your 6 year guarantee" target="_blank">your 6 year guarantee</a>.</p>

<?php
}else{
	// start the form process
	
	echo '<p>It&acute;s quick and easy to register your product online. Simply fill out your details below.</p>';
		   
	echo $dsv_form_start;

			
					
			foreach ($dsv_form_small as $key =>$element){
					
					foreach ($element as $key => $piece){
						
						if ($key == 'pre_formatted'){
							echo $piece;
								
						}
							
					}
			
			}
			/*include('categories_dropdown.php');*/
			
			?>
			<div id="dsSignupButton"><?php echo dsf_submit_image('button_submit.gif', 'Submit'); ?></div>
			
			<?php
			if (strlen($_POST['main_select']) > 0){
			?>
			<script>getMenu();</script>
            
			<?php
			}
			echo '<p>By submitting this form you agree to the terms of our <a href="http://uk.russellhobbs.com/privacy.html" title="Privacy Policy" target="_blank">privacy policy</a></p><p>Find out more information about <a href="http://uk.russellhobbs.com/your-six-year-guarantee.html" title="Your 6 year guarantee" target="_blank">your 6 year guarantee</a><br />
**Registration must be completed within 28 days of purchase. Registration code and proof of purchase must be provided in the event of a claim.</p>';
			echo $dsv_form_end;
			echo $dsv_form_js;
}

?>
    </div>
    <div class="dsMETAright">
        <div class="addthis"><?php include ('custom_modules/addthis.php');?></div>
        <?php include ('custom_modules/signup.php');?>
        <div class="clear"></div>
        <?php include ('custom_modules/meta_menu.php');?>
    </div>
</div>
