<div id="footerContainer">
	<div class="ftrMenu"><?php include('program_files/system/create_lower_menu_cache.php');?></div>
	<div id="dsFTSignup">
    	<div class="dsFTTitle"><?php echo TRANSLATION_TEXT_SIGNUP ;?></div>
    	<div id="dsFTSignHold">
			<form onsubmit="return emailsub();">
			<div id="dsFTemail"><?php echo dsf_form_email('signupmail','', '' ,'ftrEmail', TRANSLATION_WORD_ENTER_EMAIL) . dsf_form_hidden('signuplocation' , dsf_link('signup.html'));?></div>
			<div id="dsFTsubmit"><?php echo dsf_submit_image('ok_button.png', TRANSLATION_SUBMIT_BUTTON); ?></div>
			<div id="dsFTerror">&nbsp;</div>
			</form>
		</div>
         <?php 
		// we need to add address information to the contact pages,  rather than have many different contact forms, we use an include
		// to get the address details,  we use a different tecnique however of using a system variable to prefix the include we want
		// from the same folder.
		//include ('custom_modules/social/' . strtolower(CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX) . '_social_links.php');
		if (file_exists('custom_modules/social/' . strtolower(CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX) . '_social_links.php')){
		include ('custom_modules/social/' . strtolower(CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX) . '_social_links.php');
		}?>
 	</div>
	<div class="clear"></div>
	<div class="dsFTC">
	  <p><a href="http://www.spectrumbrands.com" title="Spectrum Brands" target="_blank"><?php echo dsf_image('custom/spectrum_brands_logo.png' , "Spectrum Brands", "105", "31");?></a><?php echo TRANSLATION_TEXT_COPYRIGHT;?> <a href="http://www.spectrumbrands.com" title="Spectrum Brands" target="_blank">SPECTRUM BRANDS</a> <?php echo TRANSLATION_TEXT_RESERVED;?></p>
</div>
</div>