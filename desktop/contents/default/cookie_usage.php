<?php
/* cookie text for page is stored in variable $dsv_cookie_page as an array

Available fields

title
text_block_one
text_block_two
allowed_text
problem_text

*/
?>
<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper($dsv_cookie_page['title']); ?></h1>
<?php

		echo $dsv_cookie_page['text_block_one'];



	// change next paragraph depending on whether our function cookie exists
	if (isset($dsv_allow_system_cookie) && $dsv_allow_system_cookie == 'true'){
		// allowed
		
		echo $dsv_cookie_page['allowed_text'];



	}else{
		// not allowing function cookie therefore display error section
      echo $dsv_cookie_page['problem_text'];
	} // end checking for function cookie allowed.


// show main message
	echo $dsv_cookie_page['text_block_two'];

?>
    </div>
    <div class="dsMETAright">
        <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
        <?php include ('custom_modules/default/signup.php');?>
        <div class="clear"></div>
        <?php include ('custom_modules/default/meta_menu.php');?>
    </div>
</div>