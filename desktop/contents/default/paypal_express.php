<!--content start -->
<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>

			  <div id="dscheckoutBasketSteps"><?php 
			  echo dsf_image_button('step1_0.gif', 'Step 1').
			  dsf_image_button('step_seperator.gif', 'Next Step').
			   dsf_image_button('step2_1.gif', 'Step 2').
			    dsf_image_button('step_seperator.gif', 'Next Step').
				 dsf_image_button('step3_0.gif', 'Step 3');
				  ?>
				 </div>


<div id="dspagesHeaderTitle"><?php echo 'Paypal Express Payment Error'; ?></div>
<div>
<p>There has been a transaction problem communicating with Paypal</p>
<p>No Money has been requested for this transaction.</p>
<p style="padding-top:30px;"><a href="<?php echo $dsv_retry_url;?>" >Click Here to Try Again</a></p>
</div>