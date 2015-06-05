<?php
/* This page echo's the html text as created in the admin.
	It will also echo the image to the right if one has been added.
*/

?>

<!-- body //-->
	<div class="details" id="contentDiv">
<?php

/* three posibilites for the competition page.

1) no competition selected therefore we can show some text and links to the competitions.

2) Competition selected and either the form has not been submitted or has errors.

3) Competition selected and entry accepted therefore show a thank you text.

the field $dsv_competition_status lets us know what to show, this is one of the following values:

list				( no competition selected )
competition			( competition selected including entry error )
compete				( competition entry successful )

in addition if there is any submit entry, the variable $dsv_competition_error will contain the reason.

The text box fields  must be named as follows:  (resubmit values in brackets)

firstname			(dsv_firstname)
surname				(dsv_surname)
email_address		(dsv_email)
address				(dsv_address)
postcode			(dsv_postcode)
competition_answer	(dsv_answer)


Not all fields have to be used,  the only three compulsory ones are the surname, email_address and answer

*/

// OPTION 1  no competition selected.
		if (isset($dsv_competition_status) && $dsv_competition_status == 'list'){
		?>
         <div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
            <div id="rightContent">
            <div class="pagTitles">
    		<h1><?php echo 'Competitions'; ?></h1>
            <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>
		 <p>Get switched on for your chance to win some fantastic prizes with Russell Hobbs. Simply click the link below to have a chance to win! Even if you don’t, by signing up to our newsletter you will still get the opportunity to receive online discounts, so sign up or enter today! No purchase necessary</p>
         
         <div class="lineBreak"></div>
	
		<?php


// OPTION 2  show input page and any text etc....
}elseif (isset($dsv_competition_status) && $dsv_competition_status == 'competition'){
?>
	

 
<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
            <div id="rightContent">


              	
		<?php 
		//echo current competition page text if it exists
		

		if (isset($dsv_competition_details['title_text']) && strlen($dsv_competition_details['title_text'])>1){
			echo '<div class="pagTitles"><h1>' . $dsv_competition_details['title_text'] . '</h1><div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>';
		}
		
		if (isset($dsv_competition_details['competition_text']) && strlen($dsv_competition_details['competition_text'])>1){
		
			echo '<div class="txtlink">';
			if (isset($dsv_competition_details['image']) && strlen($dsv_competition_details['image'])>1){
				echo dsf_image($dsv_competition_details['image'],'','','','align="right", hspace="15"');
			}
			echo $dsv_competition_details['competition_text'];
			
		}

		// show any posting error if it exists.
		if (isset($dsv_competition_error) && strlen($dsv_competition_error) >1){
			echo '<div>' . $dsv_competition_error . '</div>';
		}
		
	// form start
		echo '<div id="dsCompetition">';
			echo $dsv_competition_form_start;
		
			
			 // show question if it exists, there are other available items as well see documentation
					
			if (isset($dsv_competition_details['competition_question'])){
				echo '<div>' . $dsv_competition_details['competition_question'] . '</div>';
			}

			// check if it is multiple choice or single answer and show it accordingly.
			
			if ( $dsv_competition_details['competition_answer_type'] == 'multiple'){
			
					// drop back to html to format easier.
				?>
					  <div><ul class="compul">
					  <?php
					  
					  // get possible answers into an array
					  $poss_answers = explode("\n" , $dsv_competition_details['competition_choices']);
					  
					  // create a radio button for each answer with a submit on clicked action
					  foreach ($poss_answers as $value){
						echo '  <li>'. dsf_form_radio('competition_answer', $value , ($dsv_answer == $value ? true : false)) .'&nbsp;&nbsp;'. $dsv_answer . '<label>' . $value . '</label></li>';
					  }
					  ?>
					  </ul><div>
<?php
			}else { // single answer box required
				echo '  <div><label for="competition_answer">Answer:</label>' . dsf_form_input('competition_answer', $dsv_answer) . '</div>';
			}

		
		// drop to html to make it easier to create a form.?>

			   <div class="dscompInput">
				<label for="firstname">First Name:</label>
				   <?php echo dsf_form_input('firstname',$dsv_firstname, 'size="30"', 'forminput');?>
			   </div>
			   <div class="dscompInput">
				<label for="lastname">Last Name:</label>
				   <?php echo dsf_form_input('surname',$dsv_surname, 'size="30"' ,'forminput');?>
			   </div>
			   <div class="dscompInput">
				<label for="email">Email address:</label>
				   <?php echo dsf_form_input('email_address',$dsv_email, 'size="30"' ,'forminput');?>
			   </div>
			   <div class="dscompInput">
				<label for="enquiry">Your Address:</label>
				   <?php echo dsf_form_text('address', $dsv_address, 'soft', '30', '4', '' , 'forminput'); ?>
			   </div>
			   <div class="dscompInput">
				<label for="email">Postcode:</label>
				   <?php echo dsf_form_input('postcode',$dsv_postcode, 'size="30"' ,'forminput');?>
			   </div>
			   
				<div class="dscontactTick"><?php echo dsf_form_checkbox('futureoffers', '1', 'class="dsTick"', true); ?><label for="futureoffers">Please tick to agree compeitions terms &amp; conditions. By entering the competition we reserve the right to inform you of any Russell Hobbs promotional</label></div>
		
				<div id="dsCompButton"><?php echo dsf_submit_image('button_submit.gif', 'Send'); ?></div>


		<?php
	// form end
			echo $dsv_category_survey_form_end;	
		echo '</div>';


// OPTION 3  show a thank you for taking part message etc....
}elseif (isset($dsv_competition_status) && $dsv_competition_status == 'complete'){
		
		?>
        
        <div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
            <div id="rightContent">
            <div class="pagTitles">
    		<h1><?php echo 'Good Luck!'; ?></h1>
            <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>
		<?php 
		//echo current competition page text if it exists
		echo '<div>';
			if (isset($dsv_competition_details['image']) && strlen($dsv_competition_details['image'])>1){
				echo dsf_image($dsv_competition_details['image'],'','','','align="right", ');
			}
		
			echo  '<p>Thank you for taking part in our competition to "' . $dsv_competition_details['title_text'] . '".</p><p>All correct entries will go through to a prize draw where one lucky person will be selected at random.</p><p>The winner will be notified after the closing date. <strong>Good Luck!</strong></p>' ;
			
		?>
		
		<?php
		
} // end the choices


















// look to see if there is a list of other pages
	if ((int)$dsv_competition_details['current_id']  < 2){

		if (isset($dsv_competition_menu) && is_array($dsv_competition_menu)){
			echo '<div id="listComp"><ul>';
			foreach($dsv_competition_menu as $item){
			if ($item['id'] == 1) {
                                    // do nothing
			}else{
								
				if ((int)$dsv_competition_details['current_id'] == (int)$item['id']){
					// current select item
					echo '<li><a href="' . $item['url'] . '" class="active">' . dsf_image($item['header_image'], $item['title']) . '<h3>' . $item['title'] . '</h3></a></li>' . "\n";
				}else{
					echo '<li><a href="' . $item['url'] . '">' . dsf_image($item['header_image'], $item['title']) . '<h3>' . $item['title'] . '</h3></a></li>' . "\n";
				}
			}
			}
			
			echo '</ul></div>';
		}
		}	
?>
</div>
</div>
</div>
</div>
</div>